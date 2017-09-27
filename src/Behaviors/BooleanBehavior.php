<?php

namespace Horat1us\Yii\Behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * Class BooleanBehavior
 * @package Horat1us\Yii\Behaviors
 */
class BooleanBehavior extends Behavior
{
    const RETURN_TYPE_INT = 'int';
    const RETURN_TYPE_BOOL = 'bool';

    /** @var  string|string[] */
    public $attributes;

    /** @var  string */
    public $returnType;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'process',
            ActiveRecord::EVENT_BEFORE_INSERT => 'process',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'process',
        ];
    }

    /**
     * @return void
     */
    public function process()
    {
        foreach ((array)$this->attributes as $attribute) {
            if (is_null($this->owner->{$attribute})) {
                continue;
            }

            $this->owner->{$attribute} = $this->makeReturnValue(
                $this->map($this->owner->{$attribute})
            );
        }
    }

    /**
     * @param string|int|bool $value
     * @return bool|mixed
     */
    protected function map($value) {
        if (is_numeric($value)) {
            return (bool)$value;
        }

        if (is_string($value)) {
            return $value === 'true';
        }

        return $value;
    }

    /**
     * @param bool|mixed $value
     * @return bool|int|mixed
     * @throws InvalidConfigException
     */
    protected function makeReturnValue($value)
    {
        if (!is_bool($value)) {
            return $value;
        }

        if (!in_array($this->returnType, [static::RETURN_TYPE_BOOL, static::RETURN_TYPE_INT,])) {
            throw new InvalidConfigException("Invalid return type {$this->returnType}");
        }
        return $this->returnType === static::RETURN_TYPE_BOOL ? $value : (int)$value;
    }
}