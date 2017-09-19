<?php

namespace Horat1us\Yii\Behaviors;

use Carbon\Carbon;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class FlexibleTimestampBehavior
 * @package Horat1us\Yii\Behaviors
 */
class FlexibleTimestampBehavior extends Behavior
{
    /** @var  string[] */
    public $attributes;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'map',
        ];
    }

    /**
     * @return void
     */
    public function map()
    {
        foreach ($this->attributes as $attribute) {
            if (!is_numeric($this->owner->{$attribute})) {
                continue;
            }

            $this->owner->{$attribute} = Carbon::createFromTimestamp($this->owner->{$attribute})->toDateString();
        }
    }
}