<?php
define("MUTATIONS_NUMBER",4);
define("MUTATION_RATE",0.5);

class Tree{
    /**
     * @var SeedI a seed
     * @access private
     */
    private $seed;
    
    /**
     * @var image resource identifier
     * @access private
     */
    private $canvas = false;
    
    /**
     * @var array the location of the end of the current branch
     * @access private
     */
    private $end_pos = array('x'=>0,'y'=>0);
    
    /**
     * @param SeedI $seed a seed
     * @param image reasourse identifer $canvas an image identifier
     */
    public function __construct (SeedI $seed, $canvas=false){
        $this->seed = $seed;
        $this->canvas = $canvas;
    }
    
    public function grow(){
        /*
         * this method will do the actual drawing
         */
        $this->paint();
        
        /*
         * stop condition
         */
        if ($this->seed->getHeight()==0) return;
        
        /*
         * Calculating new Level's Colors
         */
        $colors = $this->seed->getColors();
        foreach ($this->seed->getColorDiff() as $c=>$v){
            $colors[$c] +=$v;
            if ($colors[$c]>255) $colors[$c] = 255 - $colors[$c];
            if ($colors[$c]<0) $colors[$c] = $colors[$c] * -1;
        }
        
        /**
         * Getting next level's branch length
         */
        $new_length = $this->seed->getLength() * $this->seed->getRatio();
        
        /*
         * substracting one level from the height (so we don't get infinite levels)
         */
        $new_height = $this->seed->getHeight()-1;
        
        /*
         * 1st branch stating angle
         */
        $angle = $this->seed->getAngle() + $this->seed->getAngleChange();
        /*
         * this will be defiened in the paint method
         */
        $position = $this->end_pos;
        
        /*
         * create branches
         */
        for ($i=0,$l=$this->seed->getBranchNumber();$i<$l;$i++){
            /*
             * we pass the branch a new seed with a set of modified DNA.
             */
            $branch = new Tree(
                $this->seed->createNewSeed(
                    array(
                        'colors' => $colors
                        , 'color-diff' => $this->seed->getColorDiff()
                        , 'length' => $new_length
                        , 'ratio'  => $this->seed->getRatio()
                        , 'height' => $new_height
                        , 'angle'  => $angle
                        , 'angle-change' => $this->seed->getAngleChange()
                        , 'position' => $position
                        , 'branches' => $this->seed->getBranchNumber()
                    )
                )
                , $this->canvas
            );
            $branch->grow();
            
            $angle += $this->seed->getAngleChange();
            if ($angle>359) $angle -= 359;
            if ($angle<0) $angle = $angle*-1;
        }
    }
    
    private function paint(){
        $ang = deg2rad($this->seed->getAngle());
        $s_pos = $this->seed->getStartPosition();
        $len = $this->seed->getLength();
        $color = $this->seed->getColors();
        
        $this->end_pos = array(
            'y' => $s_pos['y'] + sin($ang)*$len
            ,'x' => $s_pos['x'] + cos($ang)*$len
        );
        if (!$this->canvas) return;
        
        $color = imagecolorallocate ($this->canvas, $color['r'], $color['g'], $color['b']);
        imageline ($this->canvas,$s_pos['x'],$s_pos['y'],$this->end_pos['x'],$this->end_pos['y'],$color);
    }
    
    public function giveSeed(){
        /*
         * a list of possible mutations and their getter functions
         */
        $props = array(
            'colors' => 'getColors'
            , 'color-diff' => 'getColorDiff'
            , 'length' => 'getLength'
            , 'ratio'  => 'getRatio'
            , 'height' => 'getHeight'
            , 'angle'  => 'getAngle'
            , 'angle-change' => 'getAngleChange'
            , 'position' => 'getStartPosition'
            , 'branches' => 'getBranchNumber'
        );
        
        $prop_names = array_keys($props);
        $mutation_keys = array();
        $new_dna = array();
        
        /*
         * decide randomly which keys will mutate
         */
        for ($i=0;$i<MUTATIONS_NUMBER;$i++){
            $num = rand(0,count($prop_names)-1);
            $mutation_keys[]=$prop_names[$num];
        }
        
        foreach ($mutation_keys as $prop){
            /*
             * each prop type's mutation will be different, so we need to create a special case for each
             */
            switch ($prop){
                case 'colors':
                    $colors = $this->seed->getColors();
                    
                    /*
                     * correctColor simply makes sure the colors are withing a legal range - 0-255
                     */
                    foreach ($colors as $c=>$v){
                        $colors[$c] = $v+rand(0,255*MUTATION_RATE);
                        if ($colors[$c] > 255) $colors[$c]-=255;
                        if ($colors[$c] < 0) $color = $colors[$c] * -1;
                    }
                    
                    $new_dna[$prop] = $colors;
                break;
                case 'color-diff':
                    $color_diff = $this->seed->getColorDiff();
                    
                    /*
                     * i want to allow a negative change as well as a positive one
                     */
                    foreach ($color_diff as $c=>$v){
                        $color_diff[$c] += rand(-1*(50*MUTATION_RATE),50*MUTATION_RATE);
                    }
                    
                    $new_dna[$prop] = $color_diff;
                break;
                
                case 'length':
                    $diff = MUTATION_RATE * 100;
                    $num = rand(1,$diff);
                    $num = $num /100;
                    $length = (int)($this->seed->getLength() * $num);
                    $new_dna[$prop] = $length;
                break;
                case 'ratio':
                    $diff = MUTATION_RATE * 100;
                    $num = rand(-1*($diff),$diff);
                    $ratio = $this->seed->getRatio()*100;
                    $ratio +=$diff;
                    $new_dna[$prop] = $ratio/100;
                break;
                case 'height':
                    $diff = MUTATION_RATE * 100;
                    $num = rand(-1*($diff),$diff);
                    $num = (int)($num/10);
                    $new_dna[$prop] = $this->seed->getHeight()+$num;
                break;
                case 'angle':
                    $diff = MUTATION_RATE * 100;
                    $num = rand(-1*($diff),$diff);
                    $angle = $this->seed->getAngle()+$num;
                    if ($angle>359) $angle -= 359;
                    if ($angle<0) $angle = $angle*-1;
                    
                    $new_dna[$prop] = $angle;
                break;
                case 'angle-change':
                    $diff = (int)(MUTATION_RATE * 50);
                    $num = rand(-1*($diff),$diff);
                    $angle_diff = $this->seed->getAngleChange()+$num;
                    
                    $new_dna[$prop] = $angle_diff;
                break;
                case 'position':
                    $diff = (int)(MUTATION_RATE * 50);
                    $num = rand(-1*($diff),$diff);
                    $pos = $this->seed->getStartPosition();
                    foreach($pos as $a=>$v){
                        $pos[$a] += $diff;
                        if ($pos[$a]>299) $pos[$a]-=299;
                        if ($pos[$a]<0) $pos[$a] = $pos[$a] * -1;
                    }
                    $new_dna[$prop] = $pos;
                break;
                case 'branches':
                    $diff = (int)(MUTATION_RATE * 10);
                    $num = rand(-1*($diff),$diff);
                    
                    $branches = $this->seed->getBranchNumber()+$num;
                    if ($branches<0) $branches = 0;
                    
                    $new_dna[$prop] = $branches;
                break;
            }
        }
        foreach ($prop_names as $prop){
            if (!array_key_exists($prop,$new_dna)) $new_dna[$prop] = $this->seed->$props[$prop]();
        }
        return $this->seed->createNewSeed($new_dna);
    }
}