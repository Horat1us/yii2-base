<?php

namespace Horat1us\Yii\Exceptions;

use Horat1us\Yii\Interfaces\ModelExceptionInterface;
use Horat1us\Yii\Validation;

/**
 * Class ModelException
 * @package Horat1us\Yii\Exceptions
 * @deprecated
 * @see Validation\Exception
 */
class ModelException extends Validation\Exception implements ModelExceptionInterface
{
}
