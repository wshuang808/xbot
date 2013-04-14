<?php
    include_once 'PageParser.php';
    include_once 'TVmaoSite.php';
    include_once 'Channel.php';
    include_once 'SiteFormatConst.php';
    
    class Station
    {
        private $site;
        private $name;
        private $url;
        private $channelList;
        
        public function __construct($site, $name, $url)
        {
            $this->site = $site;
            $this->name = $name;
            $this->url = $url;
        }
        
        public function getChannelList()
        {
            if (!isset($this->channelList))
            {
                $this->channelList = array();
            
                $channelListNode = PageParser::getNodeByProto($this->url, PROTOTYPE_CHANNEL);
                if (isset($channelListNode))
                    $this->parseChannelListNode($channelListNode);
            }
            
            return $this->channelList;
        }
        
        private function parseChannelListNode($channelListNode)
        {
            $tempList = $channelListNode->getElementsByTagName(TAG_CURRENT_CHANNEL);
            $currentChannelNode = $tempList->item(0);
            $currentChannelName = $currentChannelNode->nodeValue;
            $currentChannel = new Channel($currentChannelName, $this->url, TRUE);
            array_push($this->channelList, $currentChannel);
            
            $channels = $channelListNode->getElementsByTagName(TAG_CHANNEL);
            foreach ($channels as $channelNode)
            {
                $channelName = $channelNode->nodeValue;
                $channelURL = $channelNode->getAttribute(ATTR_URL);
                $url = $this->site->getFullURL($channelURL);
                $channel = new Channel($channelName, $url, FALSE);
                
                array_push($this->channelList, $channel);
            }
        }
    }
?>