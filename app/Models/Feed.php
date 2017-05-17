<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class Feed extends BaseModel
{

    public static function getPagiated($page = 1, $perPage = BaseModel::DEFAULT_PAGE_SIZE)
    {
        if (!is_numeric($page) || 0 >= $page) {
            $page = 1;
        }
        if (!is_numeric($perPage) || 0 >= $perPage) {
            $perPage = static::DEFAULT_PAGE_SIZE;
        }
        $total = ceil( (RssFeed::query()->count() + TwitterFeed::query()->count()) / $perPage );

        $q1 = RssFeed::query()
            ->select([
                'id',
                'publish_time',
                \DB::raw(sprintf("'%s' AS type", FeedSource::TYPE_RSS))
            ]);
        $query = TwitterFeed::query()
            ->select([
                'id',
                'publish_time',
                \DB::raw(sprintf("'%s' AS type", FeedSource::TYPE_TWITTER))
            ])
            ->union($q1);

        $ids = $query
            ->orderBy('publish_time', 'desc')
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

        $feedResult = static::getFeedResult([
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

    public static function getFeedResult(array $ids, $withSource = true)
    {
        $rssIds     = isset($ids['rss']) ? $ids['rss'] : [];
        $twitterIds = isset($ids['twitter']) ? $ids['twitter'] : [];

        $resultRss = RssFeed::getByIds(
            $rssIds,
            [
                'id',
                'source_id',
                'title',
                'link',
                'publish_time',
                'created_at',
                'updated_at'
            ],
            false
        );

        $resultTwitter = TwitterFeed::getByIds(
            $twitterIds,
            [
                'id',
                'source_id',
                'tweet_id',
                'author_id',
                'author_name',
                'publish_time',
                'created_at',
                'updated_at'
            ],
            false
        );

        if (true === $withSource) {
            $rssSources     = [];
            $twitterSources = [];

            if (!empty($resultRss)) {
                $rssSourceIds = [];

                foreach ($resultRss as $item) {
                    $rssSourceIds[$item->source_id] = $item->source_id;
                }

                $rssSources = RssFeedSource::getByIds(
                    array_keys($rssSourceIds),
                    [
                        'id'
                    ]
                );
            }
            if (!empty($resultTwitter)) {
                $twitterSourceIds = [];

                foreach ($resultTwitter as $item) {
                    $twitterSourceIds[$item->source_id] = $item->source_id;
                }

                $twitterSources = TwitterFeedSource::getByIds(
                    array_keys($twitterSourceIds),
                    [
                        'id'
                    ]
                );
            }
        }

        $result = [
            'rss'     => $resultRss,
            'twitter' => $resultTwitter,
        ];

        if (isset($rssSources)) {
            $result['rss_sources'] = $rssSources;
        }
        if (isset($rssSources)) {
            $result['twitter_sources'] = $twitterSources;
        }

        return $result;
    }

    private static function formatResult($data)
    {
        $result = [];

        $resultRss     = isset($data['rss']) ? $data['rss'] : [];
        $resultTwitter = isset($data['twitter']) ? $data['twitter'] : [];

        $rssSources     = isset($data['rss_sources']) ? $data['rss_sources'] : [];
        $twitterSources = isset($data['twitter_sources']) ? $data['twitter_sources'] : [];

        foreach ($resultRss as $item) {
            $result[] = [
                'type'         => FeedSource::TYPE_RSS,
                'id'           => $item->id,
                'title'        => $item->title,
                'link'         => $item->link,
                'publish_time' => $item->publish_time ?
                    static::getFormatedDateFromTimestamp(strtotime($item->publish_time)) :
                    null,
                'created_at'   => static::getFormatedDateFromTimestamp($item->created_at->timestamp),
                'updated_at'   => static::getFormatedDateFromTimestamp($item->updated_at->timestamp),
                'source'       => isset($rssSources[$item->source_id]) ?
                    $rssSources[$item->source_id] :
                    null
            ];
        }
        foreach ($resultTwitter as $item) {
            $result[] = [
                'type'         => FeedSource::TYPE_TWITTER,
                'id'           => $item->id,
                'tweet_id'     => $item->tweet_id,
                'author_id'    => $item->author_id,
                'author_name'  => $item->author_name,
                'publish_time' => $item->publish_time ?
                    static::getFormatedDateFromTimestamp(strtotime($item->publish_time)) :
                    null,
                'created_at'   => static::getFormatedDateFromTimestamp($item->created_at->timestamp),
                'updated_at'   => static::getFormatedDateFromTimestamp($item->updated_at->timestamp),
                'source'       => isset($twitterSources[$item->source_id]) ?
                    $twitterSources[$item->source_id] :
                    null
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
