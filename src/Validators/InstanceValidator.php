<?php
/**
 * Created by PhpStorm.
 * User: horat1us
 * Date: 7/31/17
 * Time: 4:01 PM
 */

namespace Horat1us\Yii\Validators;

use yii\base\Model;
use yii\validators\Validator;

/**
 * Class InstanceValidator
 * @package common\validators
 */
class InstanceValidator extends Validator
{
    /**
     * Full path to class (with namespace)
     *
     * @var string
     */
    public $className;

    /**
     * @param Model $model
     * @param string $attribute
     * @return bool
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->{$attribute};

        if (!$value instanceof $this->className) {
            $model->addError($attribute, "$attribute must be instance of {$this->className}");
            return false;
        }

        return true;
    }
}
