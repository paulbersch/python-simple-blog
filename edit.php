<?php

require_once('postfunctions.php');
$title = urldecode($_POST["post_title"]);
$body = urldecode($_POST["post_body"]);
$postedtime = $_POST["post_date"];

$out = fopen('posts/'.$postedtime, "w");
if (!$out)
{
	echo false;
	exit;
}
fwrite($out, $title."\n");
fwrite($out, "\n".$body."\n");
fclose($out);
createIndexFile();
//echo "header('Location: index.html');";
//echo '<script type="text/javascript"> cancelEditing(); </script>';
echo 'Post Saved';
?>
