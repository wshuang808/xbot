<?php
    class SiteParser
    {
        private $scheme;
        private $host;
        private $path;
        
        private $channelList;
        public function __construct($url)
        {
            $urlData = parse_url($url);
            $this->scheme = $urlData['scheme'];
            $this->host = $urlData['host'];
            $this->path = $urlData['path'];
            
            $this->channelList = array();
        }
        
        public function getChannels()
        {
            return $this->channelList;
        }
        
        // TODO: for now parseSite() only take care of channel group
        // in the future, it will parse size based on city
        public function parseSite()
        {
            $groupList = array();
            $url = $this->getSiteURL();
            $startPage = http_get($url);
            $startParser = new PageParser($startPage['FILE']);

            // add current url as the first element in group list
            array_push($groupList, $url);
            $groupItems = array_merge($groupList, $startParser->getOtherGroupItems());
            
            $this->parseGroupList($groupItems);
        }
        
        private function parseGroupList($groupItems)
        {
            foreach ($groupURLList as $groupItem)
            {
                $groupURL = $this->getGroupURL($groupItem);
                $pageData = http_get($groupURL);
                $pageParser = new pageParser($pageData['FILE']);

                $channelItems = $pageParser->getChannelItems();
                $this->addChannels($channelItems);
            }
        }
        
        private function addChannels($channelItems)
        {
            foreach ($channelItems as $channelItem)
            {
                array_push($this->channelList, Channel::createChannel($channelItems));
            }
        }
        
        private function getGroupURL($groupItem)
        {
            // TODO:
        }
        
        private function getSiteURL()
        {
            return $url = $this->scheme + '://' + $this->host + $this->path;
        }
    }
?>