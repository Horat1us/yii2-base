<?php

namespace Horat1us\Yii\Validators;

use Yii;
use yii\helpers\StringHelper;
use yii\validators\Validator;

/**
 * NumberValidator validates that the attribute value is a number.
 *
 * The format of the number must match the regular expression specified in [[integerPattern]] or [[numberPattern]].
 * Optionally, you may configure the [[max]] and [[min]] properties to ensure the number
 * is within certain range.
 *
 * Difference from original yii2 number validator is possibility to set min and max as callables
 *
 * @author Alexander Letnikow <reclamme@gmail.com>
 * @since 2.0
 */
class NumberValidator extends Validator
{
    /**
     * @var bool whether the attribute value can only be an integer. Defaults to false.
     */
    public $integerOnly = false;
    /**
     * @var int|float|callable upper limit of the number. Defaults to null, meaning no upper limit.
     * @see tooBig for the customized message used when the number is too big.
     */
    public $max;
    /**
     * @var int|float|callable lower limit of the number. Defaults to null, meaning no lower limit.
     * @see tooSmall for the customized message used when the number is too small.
     */
    public $min;
    /**
     * @var string user-defined error message used when the value is bigger than [[max]].
     */
    public $tooBig;
    /**
     * @var string user-defined error message used when the value is smaller than [[min]].
     */
    public $tooSmall;
    /**
     * @var string the regular expression for matching integers.
     */
    public $integerPattern = '/^\s*[+-]?\d+\s*$/';
    /**
     * @var string the regular expression for matching numbers. It defaults to a pattern
     * that matches floating numbers with optional exponential part (e.g. -1.23e-10).
     */
    public $numberPattern = '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = $this->integerOnly ? Yii::t('yii', '{attribute} must be an integer.')
                : Yii::t('yii', '{attribute} must be a number.');
        }
        if ($this->min !== null && $this->tooSmall === null) {
            $this->tooSmall = Yii::t('yii', '{attribute} must be no less than {min}.');
        }
        if ($this->max !== null && $this->tooBig === null) {
            $this->tooBig = Yii::t('yii', '{attribute} must be no greater than {max}.');
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (is_array($value) || (is_object($value) && !method_exists($value, '__toString'))) {
            $this->addError($model, $attribute, $this->message);
            return;
        }
        $pattern = $this->integerOnly ? $this->integerPattern : $this->numberPattern;

        if (!preg_match($pattern, StringHelper::normalizeNumber($value))) {
            $this->addError($model, $attribute, $this->message);
        }

        $min = is_callable($this->min) ? call_user_func($this->min) : $this->min;
        if ($min !== null && $value < $min) {
            $this->addError($model, $attribute, $this->tooSmall, ['min' => $min]);
        }

        $max = is_callable($this->max) ? call_user_func($this->max) : $this->max;
        if ($max !== null && $value > $max) {
            $this->addError($model, $attribute, $this->tooBig, ['max' => $max]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (is_array($value) || is_object($value)) {
            return [Yii::t('yii', '{attribute} is invalid.'), []];
        }
        $pattern = $this->integerOnly ? $this->integerPattern : $this->numberPattern;
        if (!preg_match($pattern, StringHelper::normalizeNumber($value))) {
            return [$this->message, []];
        } elseif (
            $this->min !== null
            && $value < ($min = (is_callable($this->min) ? call_user_func($this->min) : $this->min))
        ) {
            return [$this->tooSmall, ['min' => $min]];
        } elseif (
            $this->max !== null
            && $value > ($max = (is_callable($this->max) ? call_user_func($this->max) : $this->max))
        ) {
            return [$this->tooBig, ['max' => $max]];
        }

        return null;
    }
}
