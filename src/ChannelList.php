<?php
    include_once 'wsss/LIB_parse.php';
    class ChannelList
    {   
        private $selectedIndex;
        private $channels;
        
        /**
         * Construct this object through raw data
         * @param unknown $listData html text contains channel list
         */
        public static function createChannelList($listData)
        {
            $channelDataList = parse_array($listData, '<li>', '</li>');
            $channels = array();
            $selectIndex = -1;
            $selectCount = 0;
            foreach($channelDataList as $i => $channelData)
            {
                $channel = Channel::createChannel($channelData);
                if (!is_null($channel))
                {
                    $channels[] = $channel;
                    if ($chanel->isSelected())
                    {
                        $selectIndex = count($channels)-1;
                        ++$selectCount;
                    }
                }
            }
            
            if ($selectCount != 1)
            {
                $channels = array();
                $selectIndex = -1;
                
                //TODO: log error for invalid list data
                echo 'Error: Invaid channel list data';
            }
            
            return new ChannelList($channels, $selectIndex);
        }

        public function __construct($channels, $selectIndex)
        {
            $this->channels = $channels;
            $this->selectedIndex = $selectIndex;
        }
        
        public function getNextChannel()
        {
            //TODO
        }
    }
?>