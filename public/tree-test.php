<?php
require_once('../includes/SeedI.class.php');
require_once('../includes/Seed.class.php');
require_once('../includes/Tree.class.php');
$tree = new Tree(new Seed,'a');
$tree->grow();