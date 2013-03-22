<?php
    include_once 'wsss/LIB_parse.php';
    class Channel
    {
        private $isSelected;
        private $name;
        private $link;
        
        /**
         * Construct channel object from raw data
         */
        public static function createChannel($channelData, $selectedChannelURL)
        {
            if (Channel::isValidChannel($channelData))
            {
                $name = Channel::parseName($channelData);
                $isSelected = Channel::parseSelectState($channelData);
                
                if ($isSelected)
                    $link = $selectedChannelURL;
                else
                    $link = Channel::parseLink($channelData, $selectedChannelURL);
                
                return new Channel($name, $link, $isSelected);
            }
            else
            {
                return NULL;
            }
        }
        
        private static function parseName($channelData)
        {
            $name = return_between($channelData, '<b>', '</b>', EXCL);
            if (!$name)
            {
                $name = return_between($channelData, '">', '</a>', EXCL);
            }
            return $name;
        }
        
        private static function parseSelectState($channelData)
        {
            return (bool)return_between($channelData, '<b>', '</b>', EXCL);
        }
        
        private static function parseLink($channelData, $baseURL)
        {
            $urlData = parse_url($baseURL);
            $path = return_between($channelData, 'ef="', '"', EXCL);
            return 'http://'.$urlData['host'].$path;
        }
        
        private static function isValidChannel($channelData)
        {
            return FALSE !== strpos($channelData, '<li>');
        }
        
        public function __construct($name, $link, $isSelected)
        {
            $this->name = $name;
            $this->link = $link;
            $this->isSelected = $isSelected;
        }
        
        /**
         * @return True if selected, false otherwise
         */
        public function isSelected()
        {
            return $this->isSelected;
        }
        
        /**
         * @return channel's name
         */
        public function getName()
        {
            return $this->name;
        }
        
        /**
         * @return link to page which contains program data of this channel
         */
        public function getLink()
        {
            return $this->link;
        }
    }
?>