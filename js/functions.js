var ajax = false;

if (window.XMLHttpRequest) {
	ajax = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
	try {
		ajax = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e1) {
		try {
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
	catch(e2) {}
	}
}

if (!ajax) {
	alert('Ajax object could not be created.  Please use a less sucky browser.');
}


function fill_form_and_escape(postID) {

	var con = document.getElementById('input_body').value;
	var tit = document.getElementById('input_title').value;

	var titleID = postID + "_title";
        var contentID = postID + "_body";

	con = escape(con); //fixes escaped
	tit = escape(tit); //apostrophe problem
	var data = "post_title=" + tit + "&post_body=" + con + "&post_date=" + postID;

	ajax.open('POST', 'edit', true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(data);
        $('.hidden').ajaxSuccess(updatePost(postID));
}

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

    $('#editTextarea').load("ajaxedit", {"id": postID, "width": postWidth, "height": postHeight }, function() {
      $('#editTextarea').show();
      $(self).slideUp("fast");
    });
  })
};

function newPostSetClickable() {
  $('.createnew').click(function() {
    cancelEditing();
    var newElement = document.createElement('div');
    newElement.setAttribute('class', 'editing');
    newElement.setAttribute('id', "editTextarea");
    newElement.setAttribute('style', 'display: none');
    var newPost = document.createElement('div');
    newPost.setAttribute('class', 'post hidden');
    newPost.setAttribute('style', 'display: none');
    $(this).after(newPost);
    $(this).after(newElement);

    $('#editTextarea').load("ajaxnewpost", {"width": 1, "height": 2 }, function() {
      $('#editTextarea').show("fast");
    });

  })
}

function updatePost(postID) {
  $('#editTextarea').remove();
  //var newElement = document.createElement('div');
  //newElement.setAttribute('class', 'post');
  //newElement.setAttribute('id', postID);
  //$('.hidden').after(newElement);
  //$('.hidden').remove();

  $('.hidden').load("ajaxget", {"id": postID});
  $('.hidden').show("fast");
  $('.hidden').removeClass("hidden");

//    var newElement = document.createElement('div');
//    newElement.setAttribute('class', 'post newelement');
//    newElement.setAttribute('style', 'display: none');
//    $('.hidden').after(newelement);
//    $('.hidden').replaceWith(newElement);
//    $('.hidden').load("ajaxget", {"id": postID});
//    $('.hidden').show("fast");
//    $('.hidden').removeClass("hidden");

}

function cancelEditing() {
  $('#editTextarea').hide("fast", function() { $(this).remove(); });
  //$('#editTextarea').remove();
  $('.hidden').show("fast");
  $('.hidden').removeClass("hidden");
}

