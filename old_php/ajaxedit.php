<?php

require_once('postfunctions.php');
$postID = $_POST["id"];
$width = $_POST["width"];
$width = $width - 10;
$height = $_POST["height"];

$postTitle = getPostSubject($postID);
$rawText = getRawPost($postID);

$filledTextarea = '<input type="text" name="input_title" id="input_title" value="'.$postTitle.'">  <br />'.'<textarea id="input_body" style = "width:'.$width.'px; height:'.$height.'px;">'.$rawText.'</textarea>'.
' <br />  <form action="edit.php" method="post" name="postForm" id="postForm">  <input type="hidden" name="post_title" id="post_title">'.
' <input type="hidden" name="post_body" id="post_body">'.
' <input type="hidden" name="post_date" id="post_date" value="'.$postID.'">'.
' <input type="button" value="Submit Post" onclick="fill_form_and_escape('.$postID.')">'.
' <input type="button" value = "Cancel" onclick = "cancelEditing()"> </form>';

echo $filledTextarea;

?>

