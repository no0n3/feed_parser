<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class RssFeedSource extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rss_feed_source';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'link',
        'rss_link',
        'last_build_time'
    ];

    public static function getOneByUrl($url)
    {
        $result = static::where('rss_link', $url)->first();

        return $result;
    }

}
