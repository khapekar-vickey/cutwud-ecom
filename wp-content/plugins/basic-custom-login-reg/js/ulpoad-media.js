jQuery(document).ready( function($) {
  	var noImageUrl = '../wp-content/plugins/upload_media/noimage.png';

		// Uploading files
		var mediaUploader = null;
		var file_frame;
		jQuery("#wpumimage-preview-wrapper").delegate("#wpumupload_image_button","click", function(e){			
					 e.preventDefault();
					//var id = jQuery(this).attr('id');
					// If the uploader object has already been created, reopen the dialog
					if (mediaUploader) 
					{
						mediaUploader.open();
						return;
					}

     mediaUploader = wp.media({
      title: 'Select Image from Gallery!',
      button: {
      text: 'Choose Image'
    }, multiple: false });

      mediaUploader.on('select', function() {
        var attachment = mediaUploader.state().get('selection').first().toJSON();

       var imgtype = attachment.mime;
       if(jQuery.inArray(imgtype, imgtypearr)!='-1')
               {
                        var height = attachment.height;
                        var width = attachment.width;
                
                        /*if ( height > LayeredH || width > LayeredW || height < LayeredH || width < LayeredW ) */

                        if ( height > LayeredH || width > LayeredW) 
                        {
                            alert("Please upload image containing size of Height <="+LayeredH+"px and Width <="+LayeredW+"px.");
                            $('#wpumimage-preview-wrapper #wpum_imagepreview').attr('src', noImageUrl).width(80).height(80);
                            //$('.background_image').attr('src',noImageUrl).width(50).height(50);
                            return false;
                        }else{
                             $('#wpumimage-preview-wrapper #wpum_imagepreview').attr('src',  attachment.url).width(80).height(80);
                             $('#wpumimage-preview-wrapper #wpum_thumbnail_id').val(attachment.id);
                             $('#wpumimage-preview-wrapper #wpum_thumbnail_url').val(attachment.url);
                             $("a.Removewpumicon").show();

                             return true;

                          }

                  }// end if imgtype
                  else
                  {
                      
                      $('#wpumimage-preview-wrapper #wpum_imagepreview').attr('src', noImageUrl).width(80).height(80);
                      //alert("Sorry! Only .PNG ,.JPEG or .JPG images are allowed.");
                      alert("Sorry! Please note,upload only "+imgtype+" type of images.");
                  }
      
    });
// Open the uploader dialog
    mediaUploader.open();

});
/*
*----------------------------------------------Remove Thumbnail
*/
jQuery("#wpumimage-preview-wrapper").delegate("a.Removewpumicon","click", function(e)
  {			
  	e.preventDefault();
        /*var id = jQuery(this).attr('id');
        var key =  jQuery(this).data('key');
       alert(rpid +'|'+ id +'/'+ key);*/
       
        if(confirm("Are you sure you want to delete?"))
          {

                      $('#wpumimage-preview-wrapper #wpum_imagepreview').attr('src',noImageUrl);
                       $("a.Removewpumicon").hide();
                      $('#wpumimage-preview-wrapper #wpum_thumbnail_id').val();
                      $('#wpumimage-preview-wrapper #wpum_thumbnail_url').val();
                             
                      return true;             
        }

  });
  //wpumimage-preview-wrapper

   var wpum_thumbnail_id = $('#wpumimage-preview-wrapper #wpum_thumbnail_id').val();
      if(wpum_thumbnail_id!=""){
       jQuery("a.Removewpumicon").show();
    }else{
      jQuery("a.Removewpumicon").hide();
    }

  ///////////////////////////////////////////////end
  });