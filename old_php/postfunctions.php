<?php

function getPostFilenames() {

	if ($handle = opendir('posts/')) {
		while (false !== ($file = readdir($handle))) {
			//run through each file in the directory
			if (substr($file, 0, 1) != '.') { //don't include hidden files
			//create an array of filenames
				$filearray[] = trim($file);
			}
		}
		closedir($handle);
		if (count($filearray) < 1) {
			return false;
		}
		natcasesort($filearray);  //sort filenames
		return $filearray;
	}
}

function getRawPost($postid) {
	$fh = fopen('posts/'.$postid, 'r');
	fgets($fh);
	fgets($fh);
	$rawtext = fread($fh, filesize('posts/'.$postid));
	return $rawtext;
}

function getMarkupPost($postid) {
	require_once('./textile/classTextile.php');
	$fh = fopen('posts/'.$postid, 'r');
	fgets($fh);
	fgets($fh);
        $post = fread($fh, filesize('posts/'.$postid));
        //cause the body of the post to be textile-ified
        $textile = new Textile();
        $post = $textile->TextileThis($post);
        //make the date (more) human-readable
        $prettydate = substr($postid,4,2).'/'.substr($postid,6,2).'/'.substr($postid,0,4).' at '.
        substr($postid,-6,2).':'.substr($postid,-4,2).':'.substr($postid,-2);
        $posts = "\n".'<h3 class="time">'.$prettydate.'</h3>'."\n".'<div id="'.$postid.'_body" class="thebody">'.
        "\n".$post."\n".'</div>'."\n".'</div>'."\n";
	fclose($fh);
        return $posts;
}


function getPostSubject($postid) {
	$fh = fopen('posts/'.$postid, 'r');
	$title = fgets($fh);
	$title = substr($title, 0, -1);
	fclose($fh);
	return $title;
}


function markupPosts() {

	$filearray = getPostFilenames();
        if (!($filearray)) { return '<div id="content"><h3>Nothing to see here.</h3></div>'; }
	foreach ($filearray as $file){
	//add markup to posts and put them together with the newest post on top
			$posts= getMarkupPost($file) . $posts;
			$posts = '<div class="post" id="'.$file.'">'."\n".'<h2 id = "'.$file.'_title" class="thesubject">'. getPostSubject($file) .'</h2>'.$posts;
	}
	$posts = '<span class="createnew"> + </span>'.$posts;
	$posts = '<div id="content">'."\n".$posts;
	$posts.="\n".'</div>';
	return $posts;
}

function createIndexFile() {

	$indexpage = getHeader();
	$indexpage .= markupPosts();
	$indexpage .= getFooter();

	$out = fopen('index.html', "w");
	if (!$out)
	{
		print("OMG");
		exit;
	}
	fwrite($out, $indexpage);
	fclose($out);
}

function getHeader() {
	$fh = fopen('./theme/'.'header.php', 'r');
	$headertext = fread($fh, filesize('./theme/'.'header.php'));
	return $headertext;
}

function getFooter() {
	$fh = fopen('./theme/'.'footer.php', 'r');
	$footertext = fread($fh, filesize('./theme/'.'footer.php'));
	return $footertext;
}

function markupRSS() {

	require_once('./textile/classTextile.php');

	$filearray = getPostFilenames();

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

			$posts = "\n".'<description>'."\n".$post."\n".'</div>'."\n".'</div>'."\n".$posts;
			$posts = '<item><title>'."\n".$prettydate.' - '.$title.'</title>'.'<link>http://paulbersch.com/</link>'.$posts;
	}
	$posts = '<?xml version="1.0" ?>'."\n"."<rss version=\"2.0\">"."\n"."<channel>"."\n".
	"<title>Blog Title Goes Here</title>"."\n"."<link>http://paulbersch.com</link>"."\n"."<description>I describe this feed very well.</description>".$posts;
	$posts.="\n".'</rss>';
	return $posts;
}



?>
