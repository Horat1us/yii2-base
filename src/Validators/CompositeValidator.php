<?php

/**
 * Copied from
 * Author: paulzi
 *
 * https://gist.github.com/paulzi/ad27c4689475ca442a2ea5880d659ff3
 */

namespace Horat1us\Yii\Validators;

use yii\base\InvalidConfigException;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;

class CompositeValidator extends Validator
{
    /**
     * @var array
     */
    public $rules = [];
    /**
     * @var boolean
     */
    public $allowMessageFromRule = true;
    /**
     * @var Validator[]
     */
    private $_validators = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} is invalid.');
        }
    }

    /**
     * @param integer $index
     * @param Model|null $model
     * @return Validator
     */
    private function getValidator($index, $model = null)
    {
        if (!isset($this->_validators[$index])) {
            $this->_validators[$index] = $this->createEmbeddedValidator($this->rules[$index], $model);
        }
        return $this->_validators[$index];
    }

    /**
     * @param array $rule
     * @param Model|null $model
     * @throws \yii\base\InvalidConfigException
     * @return Validator validator instance
     */
    private function createEmbeddedValidator($rule, $model)
    {
        if ($rule instanceof Validator) {
            return $rule;
        } elseif (is_array($rule) && isset($rule[0]) && isset($rule[1])) {
            if (!is_object($model)) {
                $model = new Model(); // mock up context model
            }
            return Validator::createValidator($rule[1], $model, $this->attributes, array_slice($rule, 2));
        } else {
            throw new InvalidConfigException('Invalid validation rule: a rule must be an array specifying validator type.');
        }
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @param Validator $validator
     * @param array $originalErrors
     * @param array $value
     * @param string $target
     */
    private function validateInternal(&$model, &$attribute, &$validator, &$originalErrors, &$value, $target)
    {
        $current = explode('[]', $target, 2);
        if (count($current) > 1) {
            $items = ArrayHelper::getValue($value, $current[0]);
            if ($items) {
                foreach ($items as $i => $item) {
                    $this->validateInternal($model, $attribute, $validator, $originalErrors, $value, "{$current[0]}.{$i}{$current[1]}");
                }
            }
        } else {
            $v = $model->$attribute = ArrayHelper::getValue($value, $target);
            if (!$validator->skipOnEmpty || !$validator->isEmpty($v)) {
                $validator->validateAttribute($model, $attribute);
            }
            ArrayHelper::setValue($value, $target, $model->$attribute);
            if ($model->hasErrors($attribute)) {
                $validationErrors = $model->getErrors($attribute);
                $model->clearErrors($attribute);
                if (!empty($originalErrors)) {
                    $model->addErrors([$attribute => $originalErrors]);
                }
                if ($this->allowMessageFromRule) {
                    $name = "{$attribute}.{$target}";
                    $name = preg_replace('/\.(\w+)/', '[\\1]', $name);
                    $model->addErrors([$name => $validationErrors]);
                } else {
                    $this->addError($model, $attribute, $this->message, ['value' => $v]);
                }
            }
            $model->$attribute = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        foreach ($this->rules as $index => $rule) {
            $validator = $this->getValidator($index, $model);
            $originalErrors = $model->getErrors($attribute);
            $targets = (array)$rule[0];
            foreach ($targets as $target) {
                $this->validateInternal($model, $attribute, $validator, $originalErrors, $value, $target);
            }
            $model->$attribute = $value;
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        foreach ($this->rules as $index => $rule) {
            $validator = $this->getValidator($index);
            $targets = (array)$rule[0];
            foreach ($targets as $target) {
                $v = ArrayHelper::getValue($value, $target);
                if ($validator->skipOnEmpty && $validator->isEmpty($v)) {
                    continue;
                }
                $result = $validator->validateValue($v);
                if ($result !== null) {
                    if ($this->allowMessageFromRule) {
                        $result[1]['value'] = $v;
                        return $result;
                    } else {
                        return [$this->message, ['value' => $v]];
                    }
                }
            }
        }
        return null;
    }
}
