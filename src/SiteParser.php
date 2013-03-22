<?php
    include_once 'wsss/LIB_http.php';
    include_once 'Channel.php';
    include_once 'PageParser.php';
    class SiteParser
    {
        private $url;
        private $host;
        private $channelList;

        public function __construct($url)
        {
            $this->url = $url;
            $urlData = parse_url($url);
            $this->host = $urlData['host'];
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
            $startParser = $this->getPageParser($this->url);

            $groupList = array();
            
            // add current url as the first element in group list
            array_push($groupList, $this->url);
            
            // add other group url
            $otherGroups = $startParser->getOtherGroupItems();
            foreach ($otherGroups as $groupItem)
            {
                array_push($groupList, $this->getGroupURL($groupItem));
            }
            
            // parse group list
            $this->parseGroupList($groupList);
        }
        
        private function parseGroupList($groupURLList)
        {
            foreach ($groupURLList as $groupURL)
            {
                $pageParser = $this->getPageParser($groupURL);
                $channelItems = $pageParser->getChannelItems();
                $currentChannelURL = $groupURL;
                $this->addChannels($channelItems, $currentChannelURL);
            }
        }
        
        private function addChannels($channelItems, $currentChannelURL)
        {
            foreach ($channelItems as $channelHTML)
            {
                $channel = Channel::createChannel($channelHTML, $currentChannelURL);
                
                array_push($this->channelList, $channel);
            }
        }
        
        private function getPageParser($url)
        {
            $data = http_get($url, 'http://www.google.com');
            $resultParser = new PageParser($data['FILE']);
            
            return $resultParser;
        }
        
        private function getGroupURL($groupItem)
        {
            $path = return_between($groupItem, 'href="','">', EXCL);
            return 'http://'.$this->host.$path;
        }
       
    }
?>