<?php
require_once('../includes/SeedI.class.php');
require_once('../includes/Seed.class.php');
require_once('../includes/Tree.class.php');
if (isset($_GET['t'])) $t = $_GET['t'];
else $t = false;

$tree = new Tree(new Seed($t));
?>
<table>
    <tr>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
    </tr>
    <tr>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
        <td>
            <img src='paint-tree.php?t=<?php echo $t?>' width='300' height='300' alt='' />
        </td>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
    
    </tr>
    <tr>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
        <td>
            <?php $seed = $tree->giveSeed();?>
            <a href='index.php?t=<?php echo $seed->serialize()?>'>
                <img src='paint-tree.php?t=<?php echo $seed->serialize()?>' width='300' height='300' alt='' /></a>
        </td>
    </tr>
</table>