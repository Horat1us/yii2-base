<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Faker\Factory;
use Horat1us\Yii\Tests\AbstractTestCase;
use Horat1us\Yii\Tests\Mocks\FileLoaderBehaviorMock;
use yii\web\UploadedFile;

class FileLoaderBehaviorTest extends AbstractTestCase
{
    public function setUp()
    {
        $faker = Factory::create();
        $file = $faker->image();
        $_FILES = [
            'FileLoaderBehaviorMock' => [
                'name' => [
                    'file' => $faker->name,
                ],
                'type' => [
                    'file' => 'application/octet-stream',
                ],
                'tmp_name' => [
                    'file' => $file,
                ],
                'error' => [
                    'file' => 0,
                ],
                'size' => [
                    'file' => filesize($file),
                ],
            ],
        ];
        return parent::setUp();
    }

    public function testLoadingSingleFile()
    {
        $model = new FileLoaderBehaviorMock();

        $model->validate();
        $this->assertInstanceOf(UploadedFile::class, $model->file);
    }

    public function testLoadingMultipleFiles()
    {
        $model = new FileLoaderBehaviorMock(['multiple' => true,]);
        $model->validate();
        $this->assertNotEmpty($model->file);
        $this->assertTrue(is_array($model->file));
        $this->assertGreaterThanOrEqual(1, count($model->file));
    }
}
