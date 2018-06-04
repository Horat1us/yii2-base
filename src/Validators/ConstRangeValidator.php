<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 7/31/17
 * Time: 4:02 PM
 */

namespace Horat1us\Yii\Validators;

use yii\validators\RangeValidator;


/**
 * Class ConstRangeValidator
 * @package common\validators
 */
class ConstRangeValidator extends RangeValidator
{
    /**
     * Prefix for constants (default $attribute) will be used
     *
     * @var
     */
    public $prefix;

    /**
     * @var bool
     */
    public $strict = true;

    /**
     * @var string Class with const range (model class will be used by default)
     */
    public $targetClass;

    /**
     * @var callable
     */
    public $filter;

    public static $ranges = [];

    /**
     * @return void
     */
    public function init()
    {
        $this->range = $this->getClosure();
        parent::init();
    }

    /**
     * @return \Closure
     */
    public function getClosure(): \Closure
    {
        return function ($model, $attribute) {
            $prefix = $this->prefix ?? strtoupper($attribute) . '_';
            $class = $this->targetClass ?? get_class($model);

            $cache = ConstRangeValidator::$ranges[$class][$prefix] ?? null;
            if ($cache instanceof \Traversable) {
                return $cache;
            }

            $reflection = new \ReflectionClass($class);
            $cache[$class][$prefix] = [];

            foreach ($reflection->getConstants() as $name => $v) {
                if ($prefix === '' || strpos($name, $prefix) === 0) {
                    $cache[$class][$prefix][] = $v;
                }
            }

            return $cache[$class][$prefix];
        };
    }

    /**
     * @param mixed $value
     * @return array|null
     */
    protected function validateValue($value)
    {
        if (is_callable($this->filter)) {
            $value = call_user_func($this->filter, $value);
        }
        return parent::validateValue($value);
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);
        $this->range = $this->getClosure();
    }
}