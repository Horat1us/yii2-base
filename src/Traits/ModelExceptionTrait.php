<?php

namespace Horat1us\Yii\Traits;

use Horat1us\Yii\Interfaces\ModelExceptionInterface;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;

/**
 * Class ModelExceptionTrait
 * @package Horat1us\Yii\Traits
 *
 * @see ModelExceptionInterface
 * @see \Exception
 *
 * You should use this trait and implement ModelExceptionInterface
 */
trait ModelExceptionTrait
{
    /** @var Model */
    protected $model;

    public function __construct(Model $model, int $code = 0, \Throwable $previous = null)
    {
        $message = get_class($model) . " validation errors";
        parent::__construct($message, $code, $previous);

        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     * @param array|null $attributeNames
     * @param bool $cleanErrors
     * @return Model
     * @throws ModelExceptionInterface
     */
    public static function validateOrThrow(Model $model, array $attributeNames = null, bool $cleanErrors = true): Model
    {
        if (!$model->validate($attributeNames, $cleanErrors)) {
            throw new static($model);
        }
        return $model;
    }

    /**
     * @param ActiveRecordInterface $record
     * @param array|null $attributeNames
     * @return ActiveRecordInterface|ActiveRecord
     * @throws ModelExceptionInterface
     */
    public static function saveOrThrow(ActiveRecordInterface $record, array $attributeNames = null): ActiveRecordInterface
    {
        if (!$record->save(true, $attributeNames) && $record instanceof Model) {
            throw new static($record);
        }
        return $record;
    }

    /**
     * @param string $attribute
     * @param string $error
     * @param Model $model
     * @throws ModelExceptionInterface
     */
    public static function addAndThrow(string $attribute, string $error, Model $model)
    {
        $model->addError($attribute, $error);
        throw new static($model);
    }
}
