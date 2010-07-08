<?php
require_once('../includes/SeedI.class.php');
require_once('../includes/Seed.class.php');
require_once('../includes/Tree.class.php');
require_once('../includes/Garden.class.php');
if (isset($_GET['t'])) $t = $_GET['t'];
else $t = false;
$garden = new Garden(new Seed($t));
$garden->grow();
?>