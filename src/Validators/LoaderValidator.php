<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 7/31/17
 * Time: 4:07 PM
 */

namespace Horat1us\Yii\Validators;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\validators\Validator;

/**
 * Class LoaderValidator
 * @package common\validators
 */
class LoaderValidator extends Validator
{
    /**
     * Class to be loaded (instance of ActiveRecord)
     *
     * @var string
     */
    public $targetClass;

    /**
     * ActiveQuery to targetClass or function which returns ActiveQuery
     *
     * @var ActiveQuery|callable
     */
    public $targetQuery;

    /**
     * Attribute of targetClass which will be compared with current attribute
     *
     * @var string
     */
    public $targetAttribute = 'id';

    /**
     * Attribute where object of targetClass will be loaded
     *
     * @var string
     */
    public $attribute;

    /**
     * @var bool
     */
    public $skipOnError = true;

    /**
     * @var bool
     */
    public $skipOnEmpty = true;

    /**
     * @var bool
     */
    public $required = true;

    /** @var string */
    public $operator = '=';


    /**
     * @param Model $model
     * @param string $attribute
     * @return void
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->{$attribute};

        /** @var ActiveQuery $query */
        /** @uses ActiveRecord::find() */
        $query = $this->getQuery()->andWhere([$this->operator, $this->targetAttribute, $value]);

        $closure = function ($value, $attribute) {
            $this->{$attribute} = $value;
            return $value;
        };

        if (!$closure->call($model, $query->one(), $this->attribute) instanceof $this->targetClass && $this->required) {
            $model->addError($attribute, \Yii::t('yii', '{attribute} is invalid.', [
                'attribute' => $attribute,
            ]));
        }
    }

    /**
     * @throws InvalidConfigException
     * @return ActiveQuery
     */
    protected function getQuery(): ActiveQuery
    {
        if ($this->targetQuery) {
            if (is_callable($this->targetQuery)) {
                return call_user_func($this->targetQuery);
            }
            return $this->targetQuery;
        }

        if (!$this->targetClass) {
            throw new InvalidConfigException("targetClass or targetQuery must be set");
        }
        return call_user_func([$this->targetClass, 'find']);
    }
}