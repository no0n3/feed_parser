<?php

namespace App\Components\Feed;

use PDO;
use fp\DBConnection;
use \TwitterAPIExchange;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class TwitterFeedHandler extends FeedHandler
{

    const WORLDWIDE_TRENDS = 1;

    private $twitter;

    public function __construct()
    {
        $settings = [
            'oauth_access_token'        => config('api.twitter.oauth_access_token', null),
            'oauth_access_token_secret' => config('api.twitter.oauth_access_token_secret', null),
            'consumer_key'              => config('api.twitter.consumer_key', null),
            'consumer_secret'           => config('api.twitter.consumer_secret', null)
        ];

        $this->twitter = new TwitterAPIExchange($settings);
    }

    /**
     * @param type $data
     * @return array
     */
    public function loadFeed($data = [])
    {
        var_dump($data);
        if (!is_array($data)) {
            $data = ['woids' => [self::WORLDWIDE_TRENDS]];
        }
        if (!isset($data['woids']) || !is_array($data['woids'])) {
            $data['woids'] = [self::WORLDWIDE_TRENDS];
        }

        $feed = [];
        $trends = [];

        foreach ($data['woids'] as $woid) {
            $trends[$woid] = $this->getPopularTrends($woid)[0]->trends;
        }
//        echo 'xx<pre>';
//        print_r($trends);
//        die;

        foreach ($trends as $woid => $woidTrends) {
            foreach ($woidTrends as $trend) {
                $trendingTweets = $this->getTrendingTweets($trend);

                foreach ($trendingTweets->statuses as $status) {
                    $tweetData = $this->getTweetData($status);
                    $tweetData['woid'] = $woid;
                    $feed[$tweetData['tweeter_id']] = $tweetData;
                }
            }
        }

        return $feed;
    }

    public function persistFeed(array $feed)
    {
        $tweetIds = array_keys($feed);

        $woids = [];
        foreach ($feed as $item) {
            if (is_numeric($item['woid'])) {
                $woids[] = $item['woid'];
            }
        }

        if (!empty($woids)) {
            $woids = array_unique($woids);

            $query = "SELECT `woid` FROM `twitter_trend_feed_source` WHERE `woid` IN (" . implode(',', $woids) . ')';
            $stmt = DBConnection::get()->query($query);

            $result = $stmt->fetchAll(PDO::FETCH_NUM);

            $toAdd = [];
            if (!empty($result)) {
                $addedWoids = [];

                foreach ($result as $i) {
                    $addedWoids[] = $i[0];
                }

                foreach ($woids as $woid) {
                    if (!in_array($woid, $addedWoids)) {
                        $toAdd[] = $woid;
                    }
                }
            } else {
                $toAdd = $woids;
            }

            if (!empty($toAdd)) {
                $stmt = DBConnection::get()->prepare('INSERT INTO `twitter_trend_feed_source` (`woid`, `created_at`) VALUES (:woid, :created_at)');
                foreach ($toAdd as $woid) {
                    $stmt->execute([
                        ':woid' => $woid,
                        ':created_at' => time(),
                    ]);
                }
            }

            $tweetToAdd = [];

            $query = "SELECT `tweet_id` FROM `twitter_feed` WHERE `tweet_id` IN (" . implode(',', $tweetIds) . ')';
            $stmt = DBConnection::get()->query($query);

            $result = $stmt->fetchAll(PDO::FETCH_NUM);

            if (!empty($result)) {
                $addedTweets = [];

                foreach ($result as $i) {
                    $addedTweets[] = $i[0];
                }

                foreach ($tweetIds as $tweetId) {
                    if (!in_array($tweetId, $addedTweets)) {
                        $tweetToAdd[] = $tweetId;
                    }
                }
            } else {
                $tweetToAdd = $tweetIds;
            }

            if (!empty($tweetToAdd)) {
                $stmt = DBConnection::get()->prepare('INSERT INTO `twitter_feed` (`source_id`, `tweet_id`, `author_id`, `author_name`, `text`) VALUES (:source_id, :tweet_id, :author_id, :author_name, :text)');
                foreach ($tweetToAdd as $tweetId) {
                    $tweetData = $feed[$tweetId];

                    $stmt->execute([
                        ':source_id' => $tweetData['woid'],
                        ':tweet_id' => $tweetId,
                        ':author_id' => $tweetData['author_id'],
                        ':author_name' => $tweetData['author_name'],
                        ':text' => $tweetData['text'],
                    ]);
                }
            }
        }
    }

    public function getPopularTrends($woid)
    {
//        return (require __DIR__ . '/../../popular_trends_sample.php');

        $url = 'https://api.twitter.com/1.1/trends/place.json';
        $requestMethod = "GET";
        $getfield = '?id=' . $woid;

        $result = $this->twitter
            ->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest(true, [
                CURLOPT_SSL_VERIFYPEER => false
            ]);

        return json_decode($result);
    }

    public function getTrendingTweets($trend)
    {
//        echo '<pre>';
//        var_dump($trend);
//        die;
//        return json_decode(file_get_contents(__DIR__ . '/../../trending_tweets_sample.txt'));

        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $requestMethod = "GET";
        $getfield = '?result_type=recent&q=' . $trend->query;

        $result = $this->twitter
            ->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest(true, [
                CURLOPT_SSL_VERIFYPEER => false
            ]);

        return json_decode($result);
    }

    private function getTweetData($status)
    {
        $result = [];
        $result['tweeter_id']  = $status->id_str;
        $result['text']        = $status->text;
        $result['author_id']   = $status->user->id_str;
        $result['author_name'] = $status->user->name;

        return $result;
    }

}
