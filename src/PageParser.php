<?php    
    include_once 'Channel.php';
    define('CHANNEL_GROUP_CLASS_NAME', 'chlsnav');
    define('CHANNEL_GROUP_TAG_NAME', 'div');
    define('CHANNEL_LIST_TAG_NAME', 'ul');
    define('CHANNEL_LIST_CLASS_NAME', 'r');
    define('CHANNEL_LIST_LINK_TAG', 'a');
    
    class PageParser
    {   
        private $doc;
        
        public function __construct($html)
        {
            try{
                $this->doc = DOMDocument::loadHTML($html);
            }
            catch (Exception $e)
            {
                echo 'Create DOMDocument failed';
            } 
        }
        
        public function getOtherGroupItems()
        {
            $otherGroups = array();
        
            if (isset($this->doc))
            {
                $otherGroupNodes = $this->getOtherGroupNodes();
                foreach ($otherGroupNodes as $node)
                {
                    $groupHTML = $this->doc->saveHTML($node);
                    array_push($otherGroups, $groupHTML);
                }
            }
        
            return $otherGroups;
        }        
        
        public function getChannelItems()
        {
            $currentGroup = $this->getCurrentGroupNode();
            $channelNodes = $this->getChannelListInGroup($currentGroup);
            
            $channels = array();
            if (isset($this->doc))
            {
                foreach($channelNodes as $channelNode)
                {
                    $channelHTML = $this->doc->saveHTML($channelNode);
                    $channel = Channel::createChannel($channelHTML);
                    array_push($channels, $channelHTML);
                }
            }
            
            return $channels;
        }

        ////////////////////////////////////////////////////////////////////////////////
        
        private function getChannelGroupsNode()
        {
            if (isset($this->doc))
            {
                $possibleNodes = $this->doc->getElementsByTagName(CHANNEL_GROUP_TAG_NAME);
                foreach ($possibleNodes as $node)
                {
                    if ($this->isChannelGroupNode($node))
                    {
                        $channelGroupNode = $node;
                        break;
                    }
                }
            }

            return $channelGroupNode;
        } 

        private function getCurrentGroupNode()
        {
            $channelGroupsNode = $this->getChannelGroupsNode();
            
            if (isset($channelGroupsNode) && $channelGroupsNode->hasChildNodes())
            {
                foreach ($channelGroupsNode->childNodes as $node)
                {
                    if ($this->isChannelListNode($node))
                    {
                        $currentGroupNode = $node;
                        break;
                    }
                }
            }
            
            return $currentGroupNode;
        }
        
        private function getOtherGroupNodes()
        {
            $resultNodes = array();
        
            $channelGroupsNode = $this->getChannelGroupsNode();
        
            if (isset($channelGroupsNode) && $channelGroupsNode->hasChildNodes())
            {
                foreach ($channelGroupsNode->childNodes as $node)
                {
                    if ($this->isChannelGroupLink($node))
                    {
                        array_push($resultNodes, $node);
                    }
                }
            }
        
            return $resultNodes;
        }    

        private function getChannelListInGroup($goupNode)
        {
            $channels = array();
        
            if ($node->hasChildNodes())
            {
                foreach ($node->childNodes as $channelNode)
                {
                    array_push($channels, $channel);
                }
            }
        
            return $channels;
        } 
        
        private function isChannelGroupNode($node)
        {
            return CHANNEL_GROUP_CLASS_NAME == $node->getAttribute('class');
        }  

        private function isChannelGroupLink($node)
        {
            return CHANNEL_LIST_LINK_TAG == $node->nodeName;
        }
        
        private function isChannelListNode($node)
        {
            
        }
        
    }
?>