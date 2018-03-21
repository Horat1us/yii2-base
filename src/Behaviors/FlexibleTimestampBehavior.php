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

    public $format = 'Y-m-d';

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
        foreach ($this->attributes as $attribute) {
            $value = $this->owner->{$attribute};

            $date = null;
            preg_replace_callback_array(
                [
                    '/^\d{4}\-\d{2}\-\d{2}$/' => function ($match) use (&$date) {
                        $date = Carbon::createFromFormat('Y-m-d', $match[0]);
                    },
                    '/^\d{2}\.\d{2}\.\d{4}$/' => function ($match) use (&$date) {
                        $date = Carbon::createFromFormat('d.m.Y', $match[0]);
                    },
                    '/^\d{2}\.\d{2}\.\d{2}$/' => function ($match) use (&$date) {
                        $date = Carbon::createFromFormat('d.m.y', $match[0]);
                    },
                    '/^\d+$/' => function ($match) use (&$date) {
                        $date = Carbon::createFromTimestamp($match[0]);
                    }
                ],
                $value
            );

            if (!$date instanceof Carbon) {
                continue;
            }

            $this->owner->{$attribute} = $date->format($this->format);
        }
    }
}
