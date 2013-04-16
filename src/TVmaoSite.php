<?php
    include_once 'SiteFormatConst.php';
    include_once 'PageParser.php';
    include_once 'Region.php';
    include_once 'Platform.php';
    
    class TVmaoSite
    {
        private static $baseURL = 'http://tvmao.com';
        private $regionList;
        
        private $exceptionList;
        
        public function __construct()
        {
            $this->exceptionList = array('湖南卫视','江苏卫视','东方卫视','浙江卫视','北京卫视','安徽卫视');
        }
        
        public static function getFullURL($relativeURL)
        {
            return self::$baseURL.$relativeURL;
        }
        
        public function getRegionList()
        {
            
            if (!isset($this->regionList))
            {
                $regionListNode = PageParser::getNodeByProto(self::$baseURL, PROTOTYPE_REGION);
                $this->regionList = array();
                
                if (isset($regionListNode))
                    $this->parseRegionListNode($regionListNode);
            }

            return $this->regionList;
        }
        
        public function syncData()
        {
            if (!is_dir(ROOT_FOLDER_LOCATION))
                mkdir(ROOT_FOLDER_LOCATION);
            
            $fp = fopen(ROOT_FOLDER_LOCATION.INDEX_FILE, 'w');
            
            $keyMap = array();
            $regionList = $this->getRegionList();
            
            foreach ($regionList as $region)
            {
                fwrite($fp, $region->getName().LINE_BREAK);
                $region->syncData($keyMap);
            }
            
            fclose($fp);
            
            $fp = fopen(ROOT_FOLDER_LOCATION.MAPPING_FILE, 'w');
            fwrite($fp, serialize($keyMap));
            fclose($fp);
        }
        
        /**
         * Parse data to get an array of region
         * @param unknown $regionListNode the raw html for region
         */
        private function parseRegionListNode($regionListNode)
        {
            $regionItems = $regionListNode->getElementsByTagName(TAG_REGION);
            foreach ($regionItems as $regionNode)
            {
                if($this->isException($regionNode)) continue;
                
                $regionName = $regionNode->nodeValue;
                $relativeURL = $regionNode->getAttribute(ATTR_URL);
                $url = $this->getFullURL($relativeURL);
                $region = new Region($regionName, $url);
                array_push($this->regionList, $region);
            }
        }
        
        /**
         * Check if target region is an exception 
         * @param unknown $region
         * @return boolean
         */
        private function isException($region)
        {
            $regionName = $region->nodeValue;
            
            $result = FALSE;
            foreach($this->exceptionList as $exceptionName)
            {
                if ($exceptionName == $regionName)
                {
                    $result = TRUE;
                }
            }
            
            return $result;
        }
    }
?>