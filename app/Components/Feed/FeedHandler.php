<?php

namespace App\Components\Feed;

abstract class FeedHandler {

    public function syncFeedFromSource($data) {
        $feed = $this->loadFeed($data);
        $this->persistFeed($feed);
    }

    /**
      Loads the feed data from the external source (e.g. Rss Feed, Twitter Trending Tweets)
     */
    public abstract function loadFeed($data);

    public abstract function persistFeed(array $feed);

    protected function handleText($text) {
        
    }

}
