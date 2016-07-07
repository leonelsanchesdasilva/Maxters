<?php

namespace Maxters\Models;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

class User extends Entity
{
    protected static $table = 'users';

    public static function fields()
    {
        return [
            'id'    => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'name'  => ['type' => 'string', 'required' => true],
            'email' => ['type' => 'text', 'required' => true],
        ];
    }

    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            // 'tags' => $mapper->hasManyThrough($entity, 'Entity\Tag', 'Entity\PostTag', 'tag_id', 'post_id'),
            // 'comments' => $mapper->hasMany($entity, 'Entity\Post\Comment', 'post_id')->order(['date_created' => 'ASC']),
            // 'author' => $mapper->belongsTo($entity, 'Entity\Author', 'author_id')
        ];
    }
}
