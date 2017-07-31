<?php

namespace Horat1us\Yii\Helpers;

/**
 * Class TransactionHelper
 * @package common\helpers
 */
class TransactionHelper
{

    /**
     * @param callable $closure
     * @param array ...$args
     * @return mixed
     * @throws \Throwable
     */
    public static function within(callable $closure, ...$args)
    {
        $transaction = \Yii::$app->db->getTransaction();
        if (!$transaction || !$transaction->getIsActive()) {
            $transaction = \Yii::$app->db->beginTransaction();
        } else {
            $transaction = null;
        }

        try {
            $result = $closure(...$args);
            $transaction && $transaction->commit();

            return $result;
        } catch (\Throwable $ex) {
            $transaction && $transaction->rollBack();

            throw $ex;
        }
    }

    /**
     * @param callable $closure
     * @param array $array
     * @param array ...$args
     * @return array
     */
    public static function forEach (callable $closure, array $array, ...$args)
    {
        return array_map(
            function ($item) use ($closure, $args) {
                return static::within($closure, $item, ...$args);
            },
            $array
        );
    }
}