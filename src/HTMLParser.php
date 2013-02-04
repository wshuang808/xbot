<?php
    class HTMLParser
    {
        /**
         * Get channel list from raw html
         * @param unknown $subject raw html text
         * $return channel list object
         */
        public static function get_channel_list($subject)
        {
            // TODO: should include all channels under <div class="chlsnav">,
            // for now only include<ul class="r">
            preg_match('/<ul class="r".+<\/ul>/', $subject, $channelList);
        
            //var_dump($channelList[0]);
            //$listString = $channelList[0];
        }
        
        public static function retrive_programs($channel)
        {
            // TODO:
            // if channel is under view, get programs from current page
            // otherwise open html page follow the link of the channel
            // then get programs.
        }
    }
?>