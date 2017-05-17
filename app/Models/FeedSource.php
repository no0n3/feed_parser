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

    public static function getOne($id, $type)
    {
        if (!is_numeric($id)) {
            return null;
        }

        $result = null;

        if (FeedSource::TYPE_RSS === $type) {
            $result = RssFeedSource::query()
                ->where('id', $id)
                ->get();
        } else if (FeedSource::TYPE_TWITTER === $type) {
            $result = TwitterFeedSource::query()
                ->where('id', $id)
                ->get();
        }

        return $result;
    }

    public static function getPagiated($page = 1, $perPage = BaseModel::DEFAULT_PAGE_SIZE)
    {
        if (!is_numeric($page) || 0 >= $page) {
            $page = 1;
        }
        if (!is_numeric($perPage) || 0 >= $perPage) {
            $perPage = static::DEFAULT_PAGE_SIZE;
        }
        $total = ceil( (RssFeedSource::query()->count() + TwitterFeedSource::query()->count()) / $perPage );

        $q1 = RssFeedSource::query()
            ->select([
                'id',
                'created_at',
                \DB::raw(sprintf("'%s' AS type", FeedSource::TYPE_RSS))
            ]);
        $query = TwitterFeedSource::query()
            ->select([
                'id',
                'created_at',
                \DB::raw(sprintf("'%s' AS type", FeedSource::TYPE_TWITTER))
            ])
            ->union($q1);

        $ids = $query
            ->orderBy('created_at', 'desc')
            ->limit($perPage)
            ->offset($perPage * ($page - 1))
            ->get();

        $rssIds     = [];
        $twitterIds = [];

        foreach ($ids as $item) {
            if (FeedSource::TYPE_RSS === $item->type) {
                $rssIds[] = $item->id;
            } else if (FeedSource::TYPE_TWITTER === $item->type) {
                $twitterIds[] = $item->id;
            }
        }

        $feedResult = static::getFeedSourceResult([
            'rss'     => $rssIds,
            'twitter' => $twitterIds
        ]);

        $result = static::formatResult($feedResult);

        return [
            'page'        => $page,
            'total_pages' => $total,
            'items'       => $result
        ];
    }

    private static function getFeedSourceResult($data)
    {
        $rssIds     = isset($data['rss']) ? $data['rss'] : [];
        $twitterIds = isset($data['twitter']) ? $data['twitter'] : [];

        $resultRss = RssFeedSource::getByIds(
            $rssIds,
            [
                'title',
                'link',
                'created_at',
                'updated_at'
            ],
            false
        );

        $resultTwitter = TwitterFeedSource::getByIds(
            $twitterIds,
            [
                'woid',
                'created_at',
                'updated_at'
            ],
            false
        );

        return [
            'rss'     => $resultRss,
            'twitter' => $resultTwitter
        ];
    }

    private static function formatResult($data)
    {
        $resultRss     = isset($data['rss']) ? $data['rss'] : [];
        $resultTwitter = isset($data['twitter']) ? $data['twitter'] : [];

        $result = [];

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
