<?php

namespace Horat1us\Yii\Behaviors;

use yii\base\Behavior;
use yii\base\Model;
use yii\web\UploadedFile;

class FileLoaderBehavior extends Behavior
{
    /** @var string */
    public $attribute;

    /** @var bool */
    public $multiple = false;

    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'load',
        ];
    }

    public function load()
    {
        $this->owner->{$this->attribute} = $this->multiple
            ? UploadedFile::getInstances($this->owner, $this->attribute)
            : UploadedFile::getInstance($this->owner, $this->attribute);
    }
}