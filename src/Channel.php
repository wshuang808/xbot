<?php
    include_once 'PageParser.php';
    include_once 'SiteFormatConst.php';
    include_once 'Program.php';
    
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