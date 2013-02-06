<?php
    include_once 'wsss/LIB_parse.php';
    class Channel
    {
        private $isSelected;
        private $name;
        private $link;
        
        /**
         * Construct channel object from raw data
         * @param unknown $channelData
         */
        public function __construct($channelData)
        {
            $this->parseName($channelData);
            $this->parseSelectState($channelData);
            $this->parseLink($channelData);
            
            if ($this->name == '' ||
                !$this->isSelected && $this->link == '')
            {
                throw new InvalidArgumentException('Invalid channel');
            }
        }
        
        /**
         * @return True if selected, false otherwise
         */
        public function is_selected()
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
        
        private function parseName($channelData)
        {
            $name = return_between($channelData, '<b>', '</b>', EXCL);
            if (!$name)
            {
                $name = return_between($channelData, '">', '</a>', EXCL);
            }
            $this->name = $name;
        }
        
        private function parseSelectState($channelData)
        {
            $this->isSelected = (bool)return_between($channelData, '<b>', '</b>', EXCL);
        }
        
        private function parseLink($channelData)
        {
            $this->link = return_between($channelData, 'ef="', '"', EXCL);
        }
    }
?>