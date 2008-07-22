<?php

require_once('postfunctions.php');
$postID = $_POST["id"];

$postTitle = getPostSubject($postID);
$rawText = getMarkupPost($postID);

$filledPost = 
'<h2 id = "' . $postID . '_title" class="thesubject">' .
$postTitle . '</h2>' .
$rawText;

echo $filledPost;

?>

