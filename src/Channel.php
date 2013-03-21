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
        public static function createChannel($channelData)
        {
            $name = Channel::parseName($channelData);
            $isSelected = Channel::parseSelectState($channelData);
            $link = Channel::parseLink($channelData);
            
            if ($name == '' ||
                !$isSelected && $link == '')
            {
                //TODO: log error for invalid channel data
                echo 'Error: Invalid channel data';
                return NULL;
            }
            
            return new Channel($name, $link, $isSelected);
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
        
        private static function parseLink($channelData)
        {
            return return_between($channelData, 'ef="', '"', EXCL);
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