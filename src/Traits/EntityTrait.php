<?php


namespace Horat1us\Yii\Traits;

use Horat1us\Yii\Helpers\TransactionHelper;
use Horat1us\Yii\Interfaces\TransactionInterface;
use yii\db\ActiveRecordInterface;


/**
 * Trait EntityTrait
 * @package Horat1us\Yii\Traits
 */
trait EntityTrait
{
    /** @var  ActiveRecordInterface */
    protected $activeRecord;

    /** @var  TransactionHelper */
    protected $transaction;

    public function __construct(ActiveRecordInterface $activeRecord, TransactionInterface $transaction)
    {
        $this->activeRecord = $activeRecord;
        $this->transaction = $transaction;
    }
}