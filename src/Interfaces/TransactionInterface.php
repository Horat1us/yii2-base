<?php


namespace Horat1us\Yii\Interfaces;


/**
 * Interface TransactionInterface
 * @package Horat1us\Yii\Interfaces
 */
interface TransactionInterface
{
    /**
     * @param callable $callable
     * @param array ...$args
     * @throws \Throwable
     * @return mixed
     */
    public function call(callable $callable, ...$args);
}