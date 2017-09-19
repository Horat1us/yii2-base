<?php

namespace Horat1us\Yii\Behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class PhoneBehavior
 * @package Horat1us\Yii\Behaviors
 */
class NumberBehavior extends Behavior
{
    /** @var string|string[] */
    public $attributes = [];

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'map',
            ActiveRecord::EVENT_BEFORE_INSERT => 'map',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'map',
        ];
    }

    /**
     * @return void
     */
    public function map()
    {
        foreach ((array)$this->attributes as $attribute) {
            $this->owner->{$attribute} = $this->format($this->owner->{$attribute});
        }
    }

    /**
     * @param $value
     * @return mixed
     */
    private function format($value)
    {
        return preg_replace("/\D/", '', $value);
    }
}