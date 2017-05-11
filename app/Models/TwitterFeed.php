<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class TwitterFeed extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'twitter_feed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tweet_id',
        'author_id',
        'author_name',
        'text',
        'publish_time'
    ];

    /**
     * Gets all feeds by the given tweet ids.
     * @param array $tweetIds
     * @return array
     */
    public static function getByTweetIds(array $tweetIds)
    {
        $result = static::whereIn('tweet_id', $tweetIds)
            ->get();

        $indexedResult = [];

        foreach ($result as $item) {
            $indexedResult[$item->tweet_id] = $item;
        }

        return $indexedResult;
    }

}
