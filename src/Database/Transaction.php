<?php


namespace Horat1us\Yii\Database;

use Horat1us\Yii\Interfaces\TransactionInterface;

use yii\db\Connection;


/**
 * Class Transaction
 * @package Horat1us\Yii\Database
 */
class Transaction implements TransactionInterface
{
    /** @var  Connection */
    protected $connection;

    /**
     * Transaction constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param callable $callable
     * @param array ...$args
     * @return mixed
     * @throws \Throwable
     */
    public function call(callable $callable, ...$args)
    {
        if ($this->connection->transaction && $this->connection->transaction->isActive) {
            return call_user_func_array($callable, $args);
        }

        $transaction = $this->connection->beginTransaction();
        try {
            $result = call_user_func_array($callable, $args);

            $transaction->commit();

            return $result;
        } catch (\Throwable $exception) {
            $transaction->rollBack();

            throw $exception;
        }
    }
}