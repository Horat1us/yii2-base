<?php

namespace Horat1us\Yii\Validators;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class FileValidator
 * @package common\validators
 */
class FileValidator extends \yii\validators\FileValidator
{
    /**
     * @var callable|int the maximum file count the given attribute can hold.
     * Defaults to null, meaning no limits for uploading file. By defining a higher number,
     * multiple uploads become possible. Setting it to `0` means that validator will always fail.
     *
     * > Note: The maximum number of files allowed to be uploaded simultaneously is
     * also limited with PHP directive `max_file_uploads`, which defaults to 20.
     *
     * If callable provided it will be called in each validation
     *
     * @see http://php.net/manual/en/ini.core.php#ini.max-file-uploads
     * @see tooMany for the customized message when too many files are uploaded.
     * @see validateLimits()
     */
    public $maxFiles = null;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $this->filterFiles($model, $attribute);

        $this->validateFiles($model, $attribute)
        && $this->validateLimits($model, $attribute)
        && $this->validateValues($model, $attribute);
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @return UploadedFile[]
     */
    public function filterFiles(Model $model, string $attribute)
    {
        return $model->{$attribute} = array_values(array_filter((array)$model->{$attribute}, function ($file) {
            return $file instanceof UploadedFile && $file->error != UPLOAD_ERR_NO_FILE;
        }));
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @return bool
     */
    public function validateFiles(Model $model, string $attribute): bool
    {
        $files = $model->$attribute;
        if (!is_array($files) && !$files instanceof UploadedFile) {
            $this->addError($model, $attribute, $this->uploadRequired);
            return false;
        }
        return true;
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @return bool
     */
    public function validateLimits(Model $model, string $attribute): bool
    {
        $files = $model->{$attribute};

        if (empty($files)) {
            $this->addError($model, $attribute, $this->uploadRequired);
            return false;
        }

        $maxFiles = is_callable($this->maxFiles)
            ? call_user_func($this->maxFiles, $model, $attribute)
            : $this->maxFiles;

        if (is_null($maxFiles)) {
            return true;
        }

        if (count($files) <= $maxFiles) {
            return true;
        }

        $this->addError($model, $attribute, $this->tooMany, ['limit' => $maxFiles]);

        return false;
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @return bool
     */
    public function validateValues(Model $model, string $attribute): bool
    {
        $files = $model->{$attribute};

        return array_reduce(
            $files,
            function (bool $carry, UploadedFile $file) use ($model, $attribute) {
                if (!$carry) {
                    return false;
                }
                $result = $this->validateValue($file);
                if (!empty($result)) {
                    $this->addError($model, $attribute, $result[0], $result[1]);
                    return false;
                }
                return true;
            },
            true
        );
    }
}
