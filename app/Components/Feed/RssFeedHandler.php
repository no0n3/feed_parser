<?php

namespace App\Components\Feed;

use PDO;
use fp\DBConnection;

/**
 * @author Velizar Ivanov <zivanof@gmail.com>
 */
class RssFeedHandler extends FeedHandler
{

    public function loadFeed($data) {
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
      <code>
      [
      [

      ]
      ]
      </code>
     */
    public function persistFeed(array $feed) {
        foreach ($feed as $blogUrl => $blogData) {
            $this->syncBlog($blogUrl, $blogData);
        }
    }

    /**
     * Gets the parsed feed data from an url.
     * @param string $url the blog feed url
     * @return array|null Return the parsed blog feed or NULL if someting went wrong
     */
    public function loadFromUrl($url) {
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
    private function getContents($url) {
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
    private function getFeedData($channel) {
        $data = [
            'title'         => (string) $channel->title,
            'description'   => (string) $channel->description,
            'link'          => (string) $channel->link,
            'lastBuildDate' => (string) $channel->lastBuildDate,
            'lastBuildTime' => strtotime($channel->lastBuildDate),
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
                'publish_time' => $item->pubDate,
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

}
