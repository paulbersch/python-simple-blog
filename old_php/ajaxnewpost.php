<input type="text" name="input_title" id="input_title">
<br />
<textarea name="input_body" rows="10" cols="80" id="input_body"></textarea>
<br />
<form action="submit.php" method="post" name="postForm">
	<input type="hidden" name="input_title" id="post_title">
	<input type="hidden" name="input_body" id="post_body">
	<input type="button" value="Submit Post" onclick="
	  function() {
	    var postID = <?php echo date(YmdHis); ?>;
	    $('.hidden').attr('id', postid);
	    fill_form_and_escape(postID);
	    setClickable();
    };">
	<input type="button" value="Cancel" onclick="$('.hidden').remove(); cancelEditing();">
</form>
