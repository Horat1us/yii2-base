<?php


namespace Horat1us\Yii\Database;

use yii\db\Connection;


/**
 * Class Transaction
 * @package Horat1us\Yii\Database
 */
class Transaction
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
     * @param callable $closure
     * @param array ...$args
     * @return mixed
     * @throws \Throwable
     */
    public function call(callable $closure, ...$args)
    {
        if ($this->connection->transaction && $this->connection->transaction->isActive) {
            return call_user_func_array($closure, $args);
        }

        $transaction = $this->connection->beginTransaction();
        try {
            $result = call_user_func_array($closure, $args);

            $transaction->commit();

            return $result;
        } catch (\Throwable $exception) {
            $transaction->rollBack();

            throw $exception;
        }
    }
}