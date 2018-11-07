var imagetarget;
function responsive_filemanager_callback(field_id){
	$.colorbox.close();
}

$(document).ready(function () {


	$('#wrapper').on('click','.selectlink', function(e) {
		console.log('click');
		linktarget = $(this);
		$.colorbox({href:SITEURL+"/admin/includes/urlmanager.php", iframe: true, width: '100%', height: '100%', close: '<i class="fa fa-times"></i>'});
		e.preventDefault();
	});

	
	$('#wrapper').on('click','.gal', function(e) {
		console.log('click');
		imagetarget = $(this);
		$.colorbox({href:SITEURL+"/admin/includes/gallery.php", iframe: true, width: '100%', height: '100%', close: '<i class="fa fa-times"></i>'});
		e.preventDefault();
	});


	$('#wrapper').on('click','.editimage', function(e) {
		var p = $(this).closest('.field');
		var image = $( 'input',p ).val();
		console.log(image);
		$.colorbox({href:SITEURL+"/admin/includes/editimage.php?image="+image, iframe: true, width: '100%', height: '100%', close: '<i class="fa fa-times"></i>'});
		e.preventDefault();
	});


	$('#wrapper').on('click','.deleteimage', function(e) {
		var c = $( this ).closest('.field');
		$('.filename',c).val('');
		$('.preview',c).remove();
		e.preventDefault();
	});

	$('.field.image input').each(function() {
		if ($(this).val() != '') {
			previewsize = $(this).data('previewsize');
			if (previewsize)
				$('<img src="../photos/'+previewsize+$(this).val()+'" class="preview" />').insertAfter(this);
			else if (previewsize=='')
				$('<img src="../photos/'+$(this).val()+'" class="preview" />').insertAfter(this);
			else
				$('<img src="../photos/200_200_'+$(this).val()+'" class="preview" />').insertAfter(this);
		}
	});

	
	//IMAGE UPLOAD
	var uploader;
	$('#wrapper').on('click',' .upload', function(e) {
		if (uploader) uploader.destroy();

		var target = $(this).closest('.field');
		var button = $(this).prev()[0];
		
		uploader = new plupload.Uploader({
			runtimes : 'html5,html4',
			browse_button: button,
			max_file_size : '10mb',
			url : 'includes/upload.php',
	        multi_selection: false,
			filters : [
				{title : "Image files", extensions : "jpg,gif,png,svg"}
			],
			resize : {width : 2500, height : 2000, quality : 90},
	                multipart_params : {
	                    "id" : "",
	                    "tipo" : ""
	                }
		});
		uploader.init();

		uploader.bind('UploadProgress', function(up, file) {
			$('.prog',target).html(' - Uploading: '+file.percent+'%');
			console.log( $('.prog',target) );
		});

		uploader.bind('FilesAdded', function(up, files) {
			uploader.start();
		});
		uploader.bind('FileUploaded', function(up, file,info) {

			if ( $('.filename',target).data('previewsize') != '' )
				size = $('.filename',target).data('previewsize');
			else if ( $('.filename',target).data('previewsize') == '' )
				size = "";
			else
				size = "200_200";
			
			$('.prog',target).html('');
			$('.filename',target).val(info.response);
			if ( $('.filename',target).next().hasClass('preview')) $('.filename',target).next().remove();
			$('<img src="../photos/'+size+info.response+'" class="preview" />').insertAfter( $('.filename',target) );
			
		});

		
		setTimeout(function() {
			$(button).click();	
		},300);
		
		

		e.preventDefault();
	});


	//FILE UPLOAD
	var target ;
	$('#wrapper').on('click',' .fileupload .uploadbutton', function(e) {
		e.preventDefault();
		target = $(this).parent();
		fileid = $('input',target).attr('id');
		console.log( fileid );
		$.colorbox({
			'href' : 'includes/filemanager/dialog.php?type=2&relative_url=1&field_id='+fileid,
			'close': '<i class="fa fa-times" aria-hidden="true"></i>',
			'width': '90%',
			'height': '90%',
			'transition': 'fade',
			'iframe': true
		});
	});

	



	//REMOVE SCROLL WHEN THE MODAL IS OPEN
	$(document).bind('cbox_open', function() {
	    $('body').css( 'overflow', 'hidden' );
	}).bind('cbox_closed', function() {
	    $('body').css( 'overflow', '' );
	});


	$('.datepicker').datepicker({
		inline: true,
		dateFormat: 'dd-mm-yy'
	});


	$('.datepickertime').datetimepicker({
		inline: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:ss',
		stepHour: 1,
		stepMinute: 5,
		stepSecond: 10
	});




	/***** FLEXIBLE FIELDS *********/
	$('.repeater .item').each(function() {
		$(this).prepend('<a href="#" class="up button tiny"><i class="fa fa-chevron-up"></i></a>\
		<a href="#" class="down button tiny"><i class="fa fa-chevron-down"></i></a>\
		<a href="#" class="del button tiny alert"><i class="fa fa-trash-o"></i></a>');
	});

	$('.flexiblecontent').on('click',' .repeater .del', function(e) {
	  $(this).closest('.item').remove();
	  e.preventDefault();
	});

	$('.flexiblecontent').on('click',' .repeater .up', function(e) {
	  item = $(this).closest('.item');
	  before = item.prev();
	  item.insertBefore(before);
	  e.preventDefault();
	});

	$('.flexiblecontent').on('click',' .repeater .down', function(e) {
	  item = $(this).closest('.item');
	  after = item.next();
	  item.insertAfter(after);
	  e.preventDefault();
	});

	$('.flexiblecontent').on('click',' .repeater-column-add', function(e) {
	  repeater = $(this).closest('.repeater');

	  $('.item',repeater).each(function() {
	  		var newitem = $('td:last-child',this).clone();
	  		$('input, textarea',newitem).val('');
	  		$(newitem).appendTo(this);
	  });

	  e.preventDefault();
	});



	$('.flexiblecontent').on('click',' .flex_buttons .del', function(e) {
	  $(this).closest('.panel').remove();
	  e.preventDefault();
	});

	$('.flexiblecontent').on('click',' .flex_buttons .up', function(e) {
	  item = $(this).closest('.panel');
	  $('.mce-tinymce',item).remove();
	  $('textarea',item).show();
	  before = item.prev();
	  item.insertBefore(before);
	  e.preventDefault();
	  tinymceinit();
	});

	$('.flexiblecontent').on('click',' .flex_buttons .down', function(e) {
	  item = $(this).closest('.panel');
	  $('.mce-tinymce',item).remove();
	  $('textarea',item).show();
	  after = item.next();
	  item.insertAfter(after);
	  e.preventDefault();
	  tinymceinit();
	});

	$('.flexiblecontent').on('click',' .repeater-add', function(e) {
	  repeater = $(this).closest('.repeater');
	  item = $('>.items',repeater);
	  //console.log($('.item::last-child',item));
	  var newitem = $('>.item:last-child',item).clone();
	  $('input, textarea',newitem).val('');
	  $('.preview',newitem).remove();

	  $('.item',newitem).not(':first-child').remove();

	  repeaterinsiderepeater = 0;
	  if ( $(this).parents('.repeater').length == 2 ) repeaterinsiderepeater = 1;

	  $('input, textarea, select',newitem).each(function() {
	  	console.log(this);
	  	if ($(this).attr('name')) {
		  	var name = $(this).attr('name');

		  	console.log(name);

		  	name = name.split('][');
	 	  	if ( repeaterinsiderepeater == 1 ){ //repeater inside repeater
	 	  		name[4] ++;
		  	} else {
		  		name[2] ++;
		  		if ( name[4] ) name[4] = 0;
		  	}
		  	
		  	name = name.join('][');
		  	$(this).attr('name',name);
	  	}

	  	if ($(this).attr('id')) {
	  		var n = Math.floor((Math.random() * 100) + 1);
	  		$(this).attr('id',  $(this).attr('id') + n );
	  	}
	  });

	  $(newitem).appendTo(item);
	  //$('.item:eq(0)',item).clone().reset().appendTo(item);
	  e.preventDefault();
	});



});