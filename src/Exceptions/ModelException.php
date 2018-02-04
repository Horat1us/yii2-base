<?php

namespace Horat1us\Yii\Exceptions;

use Horat1us\Yii\Traits\ModelExceptionTrait;

/**
 * Class ModelException
 * @package Horat1us\Yii\Exceptions
 */
class ModelException extends \Exception
{
    use ModelExceptionTrait;
}
