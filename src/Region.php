<?php
    include_once 'SiteFormatConst.php';
    include_once 'PageParser.php';
    include_once 'TVmaoSite.php';
    include_once 'Station.php';
    
    class Region
    {
        private $name;
        private $url;
        private $stationList;
        
        public function __construct($name, $url)
        {
            $this->name = $name;
            $this->url = $url;
        }

        public function getStationList()
        {
            if (!isset($this->sationList))
            {
                $this->stationList = array();

                $currentStationNode = PageParser::getNodeByProto($this->url, PROTOTYPE_CURRENT_STATION);
                $currentStationName = $currentStationNode->firstChild->nodeValue;
                $currentStation = new Station($currentStationName, $this->url);
                array_push($this->stationList, $currentStation);
                
                $stationListNode = PageParser::getNodeByProto($this->url, PROTOTYPE_STATION);                
                if (isset($stationListNode))
                    $this->parseStationListNode($stationListNode);
            }
            
            return $this->stationList;
        }
        
        private function parseStationListNode($stationListNode)
        {
            $childNodes = $stationListNode->childNodes;
            foreach ($childNodes as $childNode)
            {
                if ($this->isStationNode($childNode))
                {
                    $stationName = $childNode->nodeValue;
                    $stationURL = $childNode->getAttribute(ATTR_URL);
                    $url = TVmaoSite::getFullURL($stationURL);
                    $station = new Station($stationName, $url);
                    array_push($this->stationList, $station);
                }
            }
        }
        
        private function isStationNode($node)
        {
            return $node->nodeName == TAG_STATION;
        }
    }
?>