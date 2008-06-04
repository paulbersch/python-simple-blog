<?php

$indexpage = null;

require_once('./postfunctions.php');

createIndexFile();

header('Location: index.html');
?>