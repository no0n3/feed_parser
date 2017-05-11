<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class TwitterFeedSource extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'twitter_trend_feed_source';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'woid',
        'last_build_time'
    ];

    /**
     * Gets all feed sources by the given woids.
     * @param array $woids
     * @return array
     */
    public static function getByWoids(array $woids)
    {
        $result = static::whereIn('woid', $woids)
            ->get();

        $indexedResult = [];

        foreach ($result as $item) {
            $indexedResult[$item->woid] = $item;
        }

        return $indexedResult;
    }

}
