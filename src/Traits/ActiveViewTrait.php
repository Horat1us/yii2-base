<?php

namespace Horat1us\Yii\Traits;

use yii\base\InvalidCallException;

/**
 * Class ActiveViewTrait
 * @package Horat1us\Traits
 */
trait ActiveViewTrait
{
    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @see ActiveRecord::save()
     */
    public function save($runValidation = true, $attributeNames = NULL)
    {
        throw new InvalidCallException("ActiveView cannot be saved!");
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @see ActiveRecord::update()
     */
    public function update($runValidation = true, $attributeNames = NULL)
    {
        throw new InvalidCallException("ActiveView cannot be updated!");
    }
}
