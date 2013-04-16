<?php
    include_once 'PageParser.php';
    include_once 'TVmaoSite.php';
    include_once 'Channel.php';
    include_once 'SiteFormatConst.php';
    include_once 'Platform.php';
    include_once 'TextUtil.php';
    
    class Station
    {
        private $name;
        private $url;
        private $channelList;
        
        public function __construct($name, $url)
        {
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
        
        public function syncData($rootDir, &$keyMap)
        {
            $nameHash = getHash($this->name);
            $dir = $rootDir.PATH_DIVIDER.$nameHash;
            $keyMap[$this->name] = $dir;
            
            if (!is_dir($dir))
                mkdir($dir);
            
            $fp = fopen($dir.INDEX_FILE, 'w');
            
            $channelList = $this->getChannelList();
            foreach ($channelList as $channel)
            {
                fwrite($fp, $channel->getName().LINE_BREAK);
                $channel->syncData($dir, $keyMap);
            }
            
            fclose($fp);
        }
        
        public function getName()
        {
            return $this->name;
        }
        
        private function parseChannelListNode($channelListNode)
        {
            $tempList = $channelListNode->getElementsByTagName(TAG_CURRENT_CHANNEL);
            $currentChannelNode = $tempList->item(0);
            $currentChannelName = $currentChannelNode->nodeValue;
            $currentChannel = new Channel($currentChannelName, $this->url);
            array_push($this->channelList, $currentChannel);
            
            $channels = $channelListNode->getElementsByTagName(TAG_CHANNEL);
            foreach ($channels as $channelNode)
            {
                $channelName = $channelNode->nodeValue;
                $channelURL = $channelNode->getAttribute(ATTR_URL);
                $url = TVmaoSite::getFullURL($channelURL);
                $channel = new Channel($channelName, $url);
                
                array_push($this->channelList, $channel);
            }
        }
    }
?>