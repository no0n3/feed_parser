<?php

namespace App\Components\Feed;

use App\Models\RssFeed;
use App\Models\RssFeedSource;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class RssFeedHandler extends FeedHandler
{

    public function loadFeed($data)
    {
        if (!is_array($data)) {
            $data = ['blog_url' => []];
        }
        if (!isset($data['blog_url']) || !is_array($data['blog_url'])) {
            $data['blog_url'] = [];
        }
        $data['blog_url'] = array_unique($data['blog_url']);

        $feedData = [];

        foreach ($data['blog_url'] as $url) {
            $feedData[$url] = $this->loadFromUrl($url);
        }

        return $feedData;
    }

    /**
      param $feed
     */
    public function persistFeed(array $feed)
    {
        foreach ($feed as $blogUrl => $blogData) {
            $this->syncBlog($blogUrl, $blogData);
        }
    }

    public function syncBlog($blogUrl, $blogData)
    {
        $lastBuildTime = null;
        $sourceId = null;

        if ($this->isValidUrl($blogUrl)) {
            $result = RssFeedSource::getOneByUrl($blogUrl);

            if ($result) {
                $lastBuildTime = $result->last_build_time;
                $sourceId = $result->id;
            }
        } else {
            return;
        }

        $addFeed = false;

        if (null === $lastBuildTime) {
            $data = [
                'title'           => $blogData['title'],
                'description'     => $blogData['description'],
                'link'            => $blogData['link'],
                'rss_link'        => $blogUrl,
                'last_build_time' => $blogData['lastBuildTime'],
            ];

            $result = RssFeedSource::create($data);

            $addFeed = true;
            $sourceId = $result->id;
        } else if (strtotime($lastBuildTime) < strtotime($blogData['lastBuildTime'])) {
            // update feed
            $rssFeedSource = RssFeedSource::getOneByUrl($blogUrl);

            if ($rssFeedSource) {
                $rssFeedSource->title           = $blogData['title'];
                $rssFeedSource->description     = $blogData['description'];
                $rssFeedSource->link            = $blogData['link'];
                $rssFeedSource->last_build_time = $blogData['lastBuildTime'];

                $rssFeedSource->save();
            }

            $addFeed = true;
        }

        if ($addFeed && is_numeric($sourceId)) {
            $itemLinks = [];
            foreach ($blogData['items'] as $item) {
                $itemLinks[] = $item['link'];
            }

            $addedFeedLinks = [];

            if (!empty($itemLinks)) {
                $addedItems = RssFeed::getByUrls($itemLinks);

                foreach ($addedItems as $item) {
                    $addedFeedLinks[] = $item->link;
                }
            } else {
                $addedItems = [];
            }

            foreach ($blogData['items'] as $item) {
                if (in_array($item['link'], $addedFeedLinks)) {
                    // feed is already added - sync the feed
                    if (isset($addedItems[$item['title']])) {
                        $addedItems[$item['title']]->link         = $item['link'];
                        $addedItems[$item['title']]->description  = $item['description'];
                        $addedItems[$item['title']]->publish_time = $item['publish_time'];

                        $addedItems[$item['title']]->save();
                    }
                } else {
                    $data = [
                        'source_id'    => $sourceId,
                        'title'        => $item['title'],
                        'description'  => $item['description'],
                        'link'         => $item['link'],
                        'publish_time' => $item['publish_time'],
                    ];

                    RssFeed::create($data);
                }
            }
        }
    }

    /**
     * Gets the parsed feed data from an url.
     * @param string $url the blog feed url
     * @return array|null Return the parsed blog feed or NULL if someting went wrong
     */
    public function loadFromUrl($url)
    {
        if (false === $this->isValidUrl($url)) {
            return null;
        }

        $contents = $this->getContents($url);
        $xml = $contents ? simplexml_load_string($contents) : false;

        if ($xml) {
            $feedData = $this->getFeedData($xml->channel);

            return $feedData;
        }

        return null;
    }

    /**
     * Gets the content of the target webpage url.
     * @param string $url the target webpage url
     * @return string the webpage contents
     */
    private function getContents($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * 
     * @param object $channel
     * @return array 
     */
    private function getFeedData($channel)
    {
        $data = [
            'title'         => (string) $channel->title,
            'description'   => (string) $channel->description,
            'link'          => (string) $channel->link,
            'lastBuildDate' => (string) $channel->lastBuildDate,
            'lastBuildTime' => $this->generateValidTimeFormat($channel->lastBuildDate),
            'items'         => $this->getItemsData($channel->item)
        ];

        return $data;
    }

    private function getItemsData($items)
    {
        $result = [];

        foreach ($items as $k => $item) {
            $result [] = [
                'title'        => (string) $item->title,
                'description'  => (string) $item->description,
                'link'         => (string) $item->link,
                'publish_time' => $this->generateValidTimeFormat($item->pubDate),
            ];
        }

        return $result;
    }

    /**
     * Checks if the given url is valid.
     * @param string $url the target url
     * @return boolean TRUE if the url is valid FALSE otherwise
     */
    private function isValidUrl($url)
    {
        return false === !filter_var($url, FILTER_VALIDATE_URL);
    }

    private function generateValidTimeFormat($dateStr)
    {
        $result = date('Y-m-d H:i:s', strtotime($dateStr));

        return $result;
    }

}
