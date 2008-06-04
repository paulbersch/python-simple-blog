<?php
/*
 *      index.php
 *      
 *      Copyright 2007 Paul <Paul@localhost>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>untitled</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.12svn" />
	<link rel="stylesheet" type="text/css" href="theme/style.css">
</head>

<body>

<h1>The early prototype blog!!!  You are of the chosen few!!!</h1>

<a href = "http://www.wellstyled.com/tools/colorscheme2/index-en.html?triad;21;0;220;-1;-1;1;-0.7;0.25;1;0.5;1;-1;-1;1;-0.7;0.25;1;0.5;1;-1;-1;1;-0.7;0.25;1;0.5;1;-1;-1;1;-0.7;0.25;1;0.5;1;0">Colors</a>

<?php
/*magical script to parse directory of text files into magical posts!*/
require_once('./textile/classTextile.php');

if ($handle = opendir('posts/')) {
	while (false !== ($file = readdir($handle))) {
        //run through each file in the directory
		if ($file != "." && $file != "..") {
		//create an array of filenames
			$filearray[] = trim($file);
		}
	}
	natcasesort($filearray);  //sort filenames

	foreach ($filearray as $file){
	//add markup to posts and put them together with the newest post on top
			$fh = fopen('posts/'.$file, 'r');
			$title = fgets($fh);
			$title = substr($title, 0, -1);
			$post = fread($fh, filesize('posts/'.$file));
			$post = substr($post, 1);
			//cause the body of the post to be textile-ified
			$textile = new Textile();
                        $post = $textile->TextileThis($post);
			//make the date (more) human-readable
			$prettydate = substr($file,4,2).'/'.substr($file,6,2).'/'.substr($file,0,4).' at '.
			substr($file,-6,2).':'.substr($file,-4,2).':'.substr($file,-2);
			$posts = "\n".'<h3 class="time">'.$prettydate.'</h3>'."\n".'<div id="'.$file.'" class="thebody">'.
			"\n".$post."\n".'</div>'."\n".'</div>'."\n".$posts;
			$posts = '<div class="thepost">'."\n".'<h2 id = "'.$file.'_title" class="thesubject">'.$title.'</h2>'.$posts;
	}
	$posts = '<div id="posts">'."\n".$posts;
	$posts.="\n".'</div>';
  closedir($handle);
  }
echo $posts;
?>

<p style = "font-size: 22pt;">footer text here</p>

</body>
</html>
