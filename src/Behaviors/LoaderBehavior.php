<?php

namespace Horat1us\Yii\Behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\Model;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;

/**
 * Class LoaderBehavior
 * @package Horat1us\Yii\Behaviors
 *
 * @todo tests
 */
class LoaderBehavior extends Behavior
{
    /**
     * Callback, returns identifier value (will be used in filtering)
     * @see targetAttribute
     * @see queryFilter
     *
     * ```php
     * <?php
     * $id = function(): string {
     *  return \Yii::$app->request->post('some-post-value');
     * };
     * ```
     *
     * Or string - name of get parameter
     *
     * @var string|callable
     */
    public $id = 'id';

    /**
     * ActiveRecord class
     * will be used for creating query
     *
     * @var string
     */
    public $targetClass;

    /**
     * ActiveRecord attribute that will be used for auto filtering
     * @var string
     */
    public $targetAttribute = 'id';

    /**
     * Custom query filter.
     * Receives query as first argument and id value as second
     * Have to return ActiveQuery:
     *
     * ```php
     * <?php
     * $queryFilter = function(\yii\db\ActiveQuery $query, string $id) {
     *  return $query->andWhere(['=', 'some_attribute', $id + 1]);
     * };
     * ```
     *
     * @var callable
     */
    public $queryFilter;

    /**
     * Model attribute to load record to
     * Default value will be counted from targetClass::tableName method
     *
     * For example: if your active record table name is `post_comment_author`
     * this value will be set to `postCommentAuthor`
     *
     * @see ActiveRecord::tableName()
     * @see Inflector::camelize()
     *
     * @var string
     */
    public $attribute = 'dependency';

    /**
     * Callable that receives record if it found
     *
     * ```php
     * <?php
     * $load = function(\yii\db\ActiveRecord $record) use($model) {
     *  $model->dependency = $record;
     * };
     * ```
     *
     * @var callable
     */
    public $load;

    /** @var callable */
    public $notFoundCallback;

    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => [$this, 'load'],
        ];
    }

    public function init()
    {
        parent::init();
        if (!empty($this->targetClass) && empty($this->attribute)) {
            /** @see ActiveRecord::tableName() */
            $this->attribute = lcfirst(Inflector::camelize(call_user_func([$this->targetClass, 'tableName'])));
        }
    }

    /**
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public function load(): void
    {
        $id = null;

        if (is_string($this->id)) {
            $id = \Yii::$app->request->get($this->id);
        } elseif (is_callable($this->id)) {
            $id = call_user_func($this->id, $this);
        }

        if (empty($id)) {
            $this->notFound($id);
        }

        /** @var ActiveQuery $query */
        $query = call_user_func([$this->targetClass, 'find']);
        if (is_callable($this->queryFilter)) {
            $query = call_user_func($this->queryFilter, $query, $id);
        } elseif (!empty($this->targetAttribute)) {
            $query->andWhere(['=', $this->targetAttribute, $id]);
        } else {
            throw new InvalidConfigException("Query filter or target attribute have to be configured.");
        }

        $record = $query->one();
        if (!$record instanceof $this->targetClass) {
            $this->notFound();
        }

        if (is_callable($this->load)) {
            call_user_func($this->load, $record);
        } elseif (!empty($this->attribute)) {
            $closure = function (ActiveRecord $value, string $attribute) {
                $this->{$attribute} = $value;
            };
            $closure->call($this->owner, $record, $this->attribute);
        }
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     */
    protected function notFound(int $id = null): void
    {
        if (is_callable($this->notFoundCallback)) {
            call_user_func($this->notFoundCallback, $this);
        }

        throw new NotFoundHttpException($id ? "Resource {$id} not found" : "Resource id was not specified.");
    }
}
