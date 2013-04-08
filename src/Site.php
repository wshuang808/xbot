<?php
    include_once 'SiteFormatConst.php';
    include_once 'PageParser.php';
    
    class Site
    {
        private $url;
        private $regionList;
        
        public function __construct($url)
        {
            $this->url = $url;
            
            $regionData = PageParser::getNodeByProto($url, PROTOTYPE_REGION);
            $regionList = array();
            $this->parseRegionData($regionData);
        }
        
        /**
         * Return an array of region
         */
        public function geRegionList()
        {
            return $regionList;
        }
        
        /**
         * Parse data to get an array of region
         * @param unknown $regionData the raw html for region
         */
        private function parseRegionData($regionData)
        {
            $doc = PageParser::getDocFromXML($regionData);
            
            if (isset($doc))
            {
                $regionItems = $doc->getElementsByTagName(TAG_REGION);
                foreach ($regionItems as $regionNode)
                {
                    if(isException($regionNode)) continue;
                    
                    $regionName = $regionNode->nodeValue;
                    $relativeURL = $regionNode->getAttribute(ATTR_REGION_URL);
                    $url = $this->getFullURL($relativeURL);
                    $region = new Region($name, $link);
                    array_push($this->regionList, $region);
                }
            }
        }
        
        /**
         * Check if target region is an exception 
         * @param unknown $region
         * @return boolean
         */
        private function isException($region)
        {
            return FALSE;
        }
        
        private function getFullURL($relativeURL)
        {
            // TODO:
        }
    }
?>