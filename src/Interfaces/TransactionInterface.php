<?php


namespace Horat1us\Yii\Interfaces;


/**
 * Interface TransactionInterface
 * @package Horat1us\Yii\Interfaces
 *
 * @deprecated Use Connection::transaction() instead
 * @see Connection::transaction()
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