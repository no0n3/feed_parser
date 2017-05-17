<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class BaseModel extends Model
{
    const DEFAULT_PAGE_SIZE = 20;

    /**
     * Gets the table name of the current model.
     * @return string the table name
     */
    public static function getTableName()
    {
        return (new static())->table;
    }

    public static function getByIds(array $ids, $select = null, $indexById = true)
    {
        $query = static::query();

        if (!empty($select)) {
            $query->select($select);
        }

        $result = $query
            ->whereIn('id', $ids)
            ->get();

        if ($indexById) {
            $a = [];
            foreach ($result as $i) {
                $a[$i->id] = $i;
            }
            $result = $a;
        }

        return $result;
    }

}
