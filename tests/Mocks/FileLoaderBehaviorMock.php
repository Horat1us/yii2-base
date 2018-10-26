<?php

namespace Horat1us\Yii\Tests\Mocks;

use Horat1us\Yii\Behaviors\FileLoaderBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class FileLoaderBehaviorMock extends ActiveRecord
{
    /** @var bool */
    public $multiple = false;

    /** @var UploadedFile|UploadedFile[] */
    public $file;

    public function behaviors()
    {
        return [
            'file' => [
                'class' => FileLoaderBehavior::class,
                'attribute' => 'file',
                'multiple' => $this->multiple,
            ],
        ];
    }
}
