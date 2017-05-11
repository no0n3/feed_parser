<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class BaseModel extends Model
{
    public static function getTableName()
    {
        return (new static())->table;
    }
}
