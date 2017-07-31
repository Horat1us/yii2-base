<?php

namespace Horat1us\Yii\Tests\Helpers;

use Horat1us\Yii\Helpers\QueryHelper;
use PHPUnit\Framework\TestCase;
use yii\db\Expression;

class QueryHelperTest extends TestCase
{
    public function testCoalesce()
    {
        $expression = QueryHelper::coalesce('a','b');

        $this->assertEquals('COALESCE((a), (b))', $expression);
    }

    public function testCustomSqlFunction()
    {
        $expression = QueryHelper::sqlCall('MIN', 1, 2, new Expression('3'));

        $this->assertEquals('MIN((1), (2), (3))', $expression);
    }
}