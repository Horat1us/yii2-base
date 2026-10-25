<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Faker\Factory;
use Horat1us\Yii\Tests\AbstractTestCase;
use Horat1us\Yii\Tests\Mocks\FileLoaderBehaviorMock;
use yii\web\UploadedFile;

class FileLoaderBehaviorTest extends AbstractTestCase
{
    private string $file;

    public function setUp(): void
    {
        $faker = Factory::create();
        $file = $this->file = tempnam(sys_get_temp_dir(), 'yii2-base-test');
        file_put_contents($file, random_bytes(64));
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
        parent::setUp();
    }

    public function tearDown(): void
    {
        unlink($this->file);
        parent::tearDown();
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
