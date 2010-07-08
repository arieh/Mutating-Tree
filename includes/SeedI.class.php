<?php
interface SeedI{
    /**
     * @param mixed $dna if a string will assume it is a serialized version of the DNA. If an array will try to use it to set it's properties
     * @note if not supplied the seed will use it's default settings
     */
    public function __construct($dna=false);
    
    /**
     * serialized the seed's DNA
     * @return string
     */
    public function serialize();
    
    /*
     * Getters:
     */
     
    /**
     * @return array array('r'=>0,'g'=>0,'b'=>)
     */
    public function getColors();
    
    /**
     * @return array array('r'=>0,'g'=>0,'b'=>)
     */
    public function getColorDiff();
    
    public function getLength();
    
    /**
     * @return float 1 will be considered 100% ratio. can be smaller or bigger than one.
     */
    public function getRatio();
    
    public function getHeight();
    
    public function getAngle();
    
    public function getAngleChange();
    
    /**
     * @return array array("x"=>0,"y"=>0)
     */
    public function getStartPosition();
    
    public function getBranchNumber();
    
    /**
     * @param mixed $dna if a string will assume it is a serialized version of the DNA. If an array will try to use it to set it's properties
     * @note if not supplied the seed will use it's default settings
     */
    public function createNewSeed($dna = false);
}