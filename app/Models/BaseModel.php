<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class BaseModel extends Model
{
    /**
     * Gets the table name of the current model.
     * @return string the table name
     */
    public static function getTableName()
    {
        return (new static())->table;
    }
}
