<?php
class Garden{
    private $tree;
    private $seed;
    private $cols = 3;
    private $rows = 3;
    
    public function __construct(SeedI $seed,$rows=3, $cols = 3){
        $this->cols = $cols;
        $this->rows = $rows;
        $this->seed = $seed;
        $this->tree = new Tree($seed);
    }
    
    public function grow(){
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="<?php echo $this->cols?>">
                        <img src='tree.php?t=<?php echo $this->seed->serialize();?>' height='300' width='300' alt='main tree' />
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php for ($i=0;$i<$this->cols;$i++):?>
                <tr>
                <?php for ($j=0;$j<$this->rows;$j++):?>
                    <td>
                        <?php $seed =$this->tree->giveSeed(); ?>
                        <a href='garden.php?t=<?php echo $seed->serialize();?>'>
                            <img src='tree.php?t=<?php echo $seed->serialize();?>' height='300' width='300' at='plant' /></a>
                    </td>
                <?php endfor;?>
                </tr>
            <?php endfor?>
            </tbody>
        </table>
        <?php
    }
}