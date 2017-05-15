<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class FeedSource extends BaseModel
{
    const TYPE_RSS = 'type_rss';
    const TYPE_TWITTER = 'type_twitter';

    public static function create(array $data)
    {
        $result = null;

        if (isset($data['type'])) {
            if (static::TYPE_RSS === $data['type']) {
                $result = RssFeedSource::create([
                    'title'    => '-',
                    'rss_link' => $data['rss_link']
                ]);
            } else if (static::TYPE_TWITTER === $data['type']) {
                $result = TwitterFeedSource::create([
                    'woid' => $data['woid']
                ]);
            }
        }

        return $result;
    }

    public static function getAll()
    {
        $result = [];

        $resultRss = RssFeedSource::query()
            ->select('*')
            ->get();

        $resultTwitter = TwitterFeedSource::query()
            ->select('*')
            ->get();

        foreach ($resultRss as $item) {
            $result[] = [
                'type'       => static::TYPE_RSS,
                'title'      => $item->title,
                'link'       => $item->link,
                'created_at' => static::getFormatedDateFromTimestamp($item->created_at->timestamp),
                'updated_at' => static::getFormatedDateFromTimestamp($item->updated_at->timestamp)
            ];
        }
        foreach ($resultTwitter as $item) {
            $result[] = [
                'type'       => static::TYPE_TWITTER,
                'woid'       => $item->woid,
                'created_at' => static::getFormatedDateFromTimestamp($item->created_at->timestamp),
                'updated_at' => static::getFormatedDateFromTimestamp($item->updated_at->timestamp)
            ];
        }

        return $result;
    }

    private static function getFormatedDateFromTimestamp($timestamp)
    {
        if (is_numeric($timestamp)) {
            $result = date('Y-m-d H:i:s', $timestamp);

            return $result;
        } else {
            return '-';
        }
    }
}
