<?php 
    class SearchResultsProvider {
        private $con,  $username; 

        public function __construct($con, $username){
            $this->con = $con;
            $this->username =$username;
        }

        public function getResults($inputText){
            $entities = EntityProvider::getSearchEntities($this->con, $inputText);

            //call  below function and wrap html in other class

            $html = "<div class='previewCategories noScroll'>";

            $html .= $this->getResultHtml($entities);

            return $html . "</div>";
        }

        private function getResultHtml($entities){
            if(sizeof($entities) == 0) {//check if there is an entity
                return;
            }
    
            $entitiesHtml = "";//if there is an entity searched gives a PreviewProvider square box and outputs html
            $previewProvider = new PreviewProvider($this->con, $this->username);
            foreach($entities as $entity) {
                $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
            }
    
            return "<div class='category'>
    
                        <div class='entities'>
                            $entitiesHtml
                        </div>
                    </div>";
        }
    }
?>