<?php
class Seed implements SeedI{
    
    protected $dna = array(
        'colors' => array('r'=>50,'g'=>50,'b'=>50)
        , 'color-diff' => array('r'=>50,'g'=>50,'b'=>50)
        , 'length' => 15
        , 'ratio'  => 0.8
        , 'height' => 3
        , 'angle'  => 270
        , 'angle-change' => 45
        , 'position' => array('x'=>150,'y'=>100)
        , 'branches' => 2
    );
    
    /**
     * @param mixed $dna if a string will assume it is a serialized version of the DNA. If an array will try to use it to set it's properties
     * @note if not supplied the seed will use it's default settings
     */
    public function __construct($dna=false){
        if (is_string($dna)) $dna = $this->deserialize($dna);
        if ($dna) foreach ($dna as $gene => $value){
            if (array_key_exists($gene,$this->dna)) $this->dna[$gene] = $value;
        }
    }
    
    /*
     * serialized the seed's DNA
     * @return string
     */
    public function serialize(){
        return serialize($this->dna);
    }
    
    /*
     * Getters:
     */
     
    /*
     * @return array array('r'=>0,'g'=>0,'b'=>)
     */
    public function getColors(){ return $this->dna['colors'];}
    
    public function getColorDiff(){return $this->dna['color-diff'];}
    
    public function getLength(){ return $this->dna['length'];}
    
    /*
     * @return float 1 will be considered 100% ratio. can be smaller or bigger than one.
     */
    public function getRatio(){return $this->dna['ratio'];}
    
    public function getHeight(){return $this->dna['height'];}
    
    public function getAngle(){ return $this->dna['angle'];}
    
    public function getAngleChange(){ return $this->dna['angle-change'];}
    
    /*
     * @return array array("x"=>0,"y"=>0);
     */
    public function getStartPosition(){ return $this->dna['position'];}
    
    public function getBranchNumber(){return $this->dna['branches'];}
    
    /*
     * @param mixed $dna if a string will assume it is a serialized version of the DNA. If an array will try to use it to set it's properties
     * @note if not supplied the seed will use it's default settings
     */
    public function createNewSeed($dna = false){
        return new Seed($dna);
    }
    
    protected function deserialize($dna){
        return unserialize($dna);
    }
}