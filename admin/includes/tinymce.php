<script type="text/javascript" src="js/tinymce/4.1.9/tinymce.min.js" ></script>
<script type="text/javascript">
function tinymceinit() {
    if ( $('.mce').length > 0 ) {

    tinyMCE.init({
            mode : "textareas",
            theme: "modern",
            skin: 'light',
            menubar:false,
            statusbar: false,
            plugins : "table spellchecker insertdatetime preview jbimages link image responsivefilemanager code paste fullscreen hr",
            editor_selector : "mce",
            // Theme options - button# indicated the row# only
            toolbar : ["bold italic underline | alignleft aligncenter alignright alignjustify  formatselect " ,
                        "cut copy paste | bullist numlist | outdent indent | undo redo | link unlink | code removeformat | sub sup" ,
                         "image  | inserttable table responsivefilemanager |  hr | fullscreen"] ,
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,
              relative_urls: false,
              image_advtab: true,
              paste_as_text: true,
              document_base_url: '/',
              external_filemanager_path: "<?php echo SITEURL;?>admin/includes/filemanager/",
             filemanager_title:"File Manager" ,
             external_plugins: { "filemanager" : "../../../includes/filemanager/plugin.min.js"},
             extended_valid_elements : "iframe[src|width|height|name|align]"

            <?php if ( file_exists( '../css/tinymce.css' ) ) { ?>
             , content_css : '<?php echo SITEURL; ?>/css/tinymce.css'
             <?php } ?>
              /*
            link_class_list: [
                {title: 'Ninguna', value: ''},
                {title: 'Colorbox', value: 'colorbox'}
            ],
            */

    });

    }
 


    if ( $('.mcesimple').length > 0 ) {

    tinyMCE.init({
            mode : "textareas",
            theme: "modern",
            skin: 'light',
            menubar:false,
            statusbar: false,
            paste_as_text: true,
            plugins : "paste code",
            editor_selector : "mcesimple",
            // Theme options - button# indicated the row# only
            toolbar : ["bold italic underline | alignleft aligncenter alignright | undo redo | removeformat code" ,
                        "" ,
                         ""] ,
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : false,
            theme_advanced_resizing : true,
              relative_urls: false,
              force_br_newlines : true,
        force_p_newlines : false,
              forced_root_block : ''
               <?php if ( file_exists( '../css/tinymce.css' ) ) { ?>
             , content_css : '<?php echo SITEURL; ?>/css/tinymce.css'
             <?php } ?>
              /*
            link_class_list: [
                {title: 'Ninguna', value: ''},
                {title: 'Colorbox', value: 'colorbox'}
            ],
            */

    });

    }

}



tinymceinit();
</script>
