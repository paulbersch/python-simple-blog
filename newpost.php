<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>New Post Maker</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.10.2" />
        <script type="text/javascript" src="js/jquery-1.2.1.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
</head>

<body>

<input type="text" name="input_title" id="input_title">
<br />
<textarea name="input_body" rows="10" cols="80" id="input_body"></textarea>
<br />
<form action="submit.php" method="post" name="postForm">
	<input type="hidden" name="input_title" id="post_title">
	<input type="hidden" name="input_body" id="post_body">
	<input type="button" value="Submit Post" onclick="fill_form_and_escape('<?php echo date(YmdHis); ?>'); setTimeout('location.href=\'newpost.php\'',1250);">
</form>

</body>
</html>
