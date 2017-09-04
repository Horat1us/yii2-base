<?php

namespace Horat1us\Yii\Tests\Helpers;

use Horat1us\Yii\Helpers\QueryHelper;
use PHPUnit\Framework\TestCase;
use yii\db\Expression;

class QueryHelperTest extends TestCase
{
    public function testCoalesce()
    {
        $expression = QueryHelper::coalesce('a', 'b');

        $this->assertEquals('COALESCE((a), (b))', $expression);
    }

    public function testCustomSqlFunction()
    {
        $expression = QueryHelper::sqlCall('MIN', 1, 2, new Expression('3'));

        $this->assertEquals('MIN((1), (2), (3))', $expression);
    }

    public function testSingleParam()
    {
        $command = 'SELECT CURRENT_DATE';
        $function = 'EXISTS';
        $expression = QueryHelper::sqlCall($function, $command);

        $this->assertEquals("{$function}(({$command}))", $expression);
    }

    public function testCaseWithoutElse()
    {
        $condition = 'date = 01.01.1970';
        $statement = '1234';

        $expression = QueryHelper::caseWhen([
            $condition => $statement,
        ]);

        $this->assertEquals("CASE  WHEN {$condition} THEN {$statement} END", $expression);
    }

    public function testCaseWithElse()
    {
        $condition = 'true = false';
        $statement = '1234';
        $else = '4321';

        $expression = QueryHelper::caseWhen(
            [
                $condition => $statement,
            ],
            '',
            $else
        );

        $this->assertEquals("CASE  WHEN {$condition} THEN {$statement} ELSE {$else} END", $expression);
    }

    public function testCaseWithValue()
    {
        $value = 'variable';
        $condition = "{$value} > 0";
        $statement = '1';

        $expression = QueryHelper::caseWhen(
            [
                $condition => $statement
            ],
            $value
        );

        $this->assertEquals("CASE {$value} WHEN {$condition} THEN {$statement} END", $expression);
    }
}