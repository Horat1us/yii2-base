<?php

namespace Horat1us\Yii\Interfaces;

use yii\base\Model;

interface ModelExceptionInterface extends \Throwable
{
    public function getModel(): Model;
}
