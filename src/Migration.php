<?php

namespace Horat1us\Yii;

use yii\db;

/**
 * Class Migration
 * @package Horat1us\Yii
 */
class Migration extends db\Migration
{
    public function notNullTimestamp(): db\ColumnSchemaBuilder
    {
        if ($this->db->driverName === 'mysql') {
            return $this->timestamp()->notNull()->defaultExpression('now()');
        }

        return $this->timestamp()->notNull();
    }
}
