<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>untitled</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.12svn" />
	<link rel="stylesheet" type="text/css" href="theme/style.css">
	<script type="text/javascript" src="js/jquery-1.2.1.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<!-- <script type="text/javascript" src="js/jquery.form.js"></script> -->

	<script type="text/javascript">
		$(document).ready(function(){
			setClickable();
		});

		function setClickable() {
			$('.thepost').dblclick(function() {
				cancelEditing();
				var self = this;
				var currentHTML = $(this).html();
				var postID = $(this).attr("id");
				var postWidth = $(this).width();
				var postHeight = $(this).height();
				var newElement = document.createElement('div');
				newElement.setAttribute('class', 'editing');
				newElement.setAttribute('id', "editTextarea");
				newElement.setAttribute('style', 'display: none');
				$(this).after(newElement);
				$(this).addClass("hidden");
				
				$('#editTextarea').load("ajaxedit.php", {"id": postID, "width": postWidth, "height": postHeight }, function() {
					$('#editTextarea').show();
					$(self).slideUp("fast");
				});
			})
		};
		
		function cancelEditing() {
			$('#editTextarea').remove();
			$('.hidden').show("fast");
			$('.hidden').removeClass("hidden");
		}
</script>

</head>

<body>

<h1>The early prototype blog!!!  You are of the chosen few!!!</h1>

<a href = "http://www.wellstyled.com/tools/colorscheme2/index-en.html?triad;21;0;220;-1;-1;1;-0.7;0.25;1;0.5;1;-1;-1;1;-0.7;0.25;1;0.5;1;-1;-1;1;-0.7;0.25;1;0.5;1;-1;-1;1;-0.7;0.25;1;0.5;1;0">Colors</a>
