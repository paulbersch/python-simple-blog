<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
        <title>untitled</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="theme/main.css">
        <script type="text/javascript" src="js/jquery-1.2.1.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>
        <!-- <script type="text/javascript" src="js/jquery.form.js"></script> -->

        <script type="text/javascript">
                $(document).ready(function(){
                        setClickable();
                });

                function setClickable() {
                        $('.post').dblclick(function() {
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
<div id="wrap">
  <div id="header">
    <div id="main_title">
      <h1>The Title of the page!</h1>

      <h2>A subtitle!  Hey!</h2>
    </div>
    <div id="navigation">
       <ul>
         <li>Home</li>
         <li>About</li>
         <li>A page about cheese!</li>
       </ul>
    </div>
  </div>
  <div id="sidebar">
    <h1>The Sidebar</h1>
    <h2>A list within the Sidebar</h2>
    <ul>
      <li>A link to a blog?</li>
      <li>A link to something else?</li>
    </ul>
  </div>
