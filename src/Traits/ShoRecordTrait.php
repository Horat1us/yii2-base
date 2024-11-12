<?php

namespace Horat1us\Yii\Traits;

use yii\db\ActiveRecord;

/**
 * Trait for extension Active Records
 * @package common\models
 *
 * @mixin ActiveRecord
 */
trait ShoRecordTrait
{
    /**
     * @param string $field
     * @param string|null $tableAlias
     * @return string
     */
    public static function fieldName(string $field, string $tableAlias = null): string
    {
        $tableAlias = $tableAlias ?? static::tableName();

        $tableAlias = preg_replace('/[^\w]/', '', $tableAlias);

        return "{{%$tableAlias}}.$field";
    }
}
