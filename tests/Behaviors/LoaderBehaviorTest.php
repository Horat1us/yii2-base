<?php

namespace Horat1us\Yii\Tests\Behaviors;

use Horat1us\Yii\Behaviors\LoaderBehavior;
use Horat1us\Yii\Tests\AbstractTestCase;
use yii\base\Component;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class LoaderBehaviorTest
 * @package Horat1us\Yii\Tests\Behaviors
 *
 * @internal
 */
class LoaderBehaviorTest extends AbstractTestCase
{
    /** @var Component */
    protected $owner;

    /** @var LoaderBehavior */
    protected $behavior;

    public function setUp()
    {
        parent::setUp();

        $this->owner = new class extends Component
        {
            /** @var ActiveRecord */
            public $dependency;
        };

        $this->behavior = new LoaderBehavior();
        $this->behavior->attach($this->owner);
    }

    /**
     * @expectedException \yii\web\NotFoundHttpException
     * @expectedExceptionMessage Resource id was not specified.
     */
    public function testNotFound()
    {
        $this->owner->trigger(Model::EVENT_BEFORE_VALIDATE);
    }

}
