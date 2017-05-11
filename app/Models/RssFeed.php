<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class RssFeed extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rss_feed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'title',
        'description',
        'link',
        'publish_time'
    ];

    public static function getByUrls(array $urls)
    {
        $result = static::whereIn('link', $urls)
            ->get();

        $indexedResult = [];

        foreach ($result as $item) {
            $indexedResult[$item->title] = $item;
        }

        return $indexedResult;
    }
}
