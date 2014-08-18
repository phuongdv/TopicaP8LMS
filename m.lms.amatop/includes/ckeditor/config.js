/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here:
	 var domain = window.location.protocol + "//" + window.location.host+'/';
	 config.language = 'vi';
	 config.filebrowserBrowseUrl = domain+'/dialogs/ckfinder.html?type=Images'; 
     config.filebrowserUploadUrl = domain+'/dialogs/ckfinder.html?type=Images';
	 config.filebrowserImageBrowseUrl = domain+'/dialogs/ckfinder.html?type=Images';
	 config.filebrowserImageUploadUrl = domain+'/dialogs/ckfinder.html?type=files';
	 
	 
	 
	 
};