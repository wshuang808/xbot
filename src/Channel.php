<?php
    include_once 'PageParser.php';
    include_once 'SiteFormatConst.php';
    include_once 'Program.php';
    include_once 'Platform.php';
    include_once 'TextUtil.php';
    
    class Channel
    {
        private $name;
        private $url;
        private $programList;

        public function __construct($name, $url)
        {
            $this->name = $name;
            $this->url = $url;
        }

        public function getProgramList()
        {
            if (!isset($this->programList))
            {
                $this->programList = array();
            
                $programListNode = PageParser::getNodeByProto($this->url, PROTOTYPE_PROGRAM);
                if (isset($programListNode))
                    $this->parseProgramListNode($programListNode);
            }
            
            return $this->programList;
        }
        
        public function getName()
        {
            return $this->name;
        }
        
        public function syncData($rootDir, &$keyMap)
        {
            $nameHash = getHash($this->name);
            
            $fileLocation = $rootDir.PATH_DIVIDER.$nameHash.'.txt';
            $fp = fopen($fileLocation, 'w');
            $keyMap[$this->name] = $fileLocation;
            
            $programList = $this->getProgramList();
            foreach ($programList as $program)
            {
                fwrite($fp, $program->getFormatData().LINE_BREAK);
            }
            
            fclose($fp);
        }
        
        private function parseProgramListNode($programListNode)
        {
            $childNodes = $programListNode->childNodes;
            foreach ($childNodes as $childNode)
            {
                if ($this->isProgramNode($childNode))
                {
                    $program = new Program($childNode);
                    array_push($this->programList, $program);
                }
            }
        }
        
        private function isProgramNode($node)
        {
            return $node->nodeName == TAG_PROGRAM && 
                    !$node->hasAttribute(ATTR_ID);
        }
    }
?>