<?php
header("Content-type: image/png");
$im = imagecreatetruecolor(300, 300);
$white = imagecolorallocate($im, 255, 255, 255);

imagefilledrectangle($im, 0, 0, 299, 299, $white);
require_once('../includes/SeedI.class.php');
require_once('../includes/Seed.class.php');
require_once('../includes/Tree.class.php');
if (isset($_GET['t'])) $t = $_GET['t'];
else $t = false;
$tree = new Tree(new Seed($t),$im);
$tree->grow();

ImagePng($im);