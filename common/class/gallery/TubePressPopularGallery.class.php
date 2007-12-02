<?php
class TubePressPopularGallery extends TubePressGallery {
    
    public function __construct() {
        $this->setName(TubePressGallery::popular);
        $this->setTitle("Most-viewed videos from...");
        $this->setValue(new TubePressTimeValue(TubePressGallery::popular));
    }
    
    protected final function getRequestURL() {
        return "http://gdata.youtube.com/feeds/api/standardfeeds/most_viewed?time=" . $this->getValue()->getCurrentValue();
    }
    
    public function printForOptionsPage() {
        
    }
    
    public function updateFromOptionsPage(array $postVars) {
        
    }
    
    public function updateManually($newValue) {
        
    }
}
?>