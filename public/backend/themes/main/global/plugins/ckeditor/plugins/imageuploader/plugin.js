// Copyright (c) 2015, Fujana Solutions - Moritz Maleck. All rights reserved.
// For licensing, see LICENSE.md
CKEDITOR.plugins.add( 'imageuploader', {

    init: function( editor ) {
        editor.config.filebrowserBrowseUrl = '../../../public/backend/themes/main/global/plugins/ckeditor/plugins/imageuploader/imgbrowser.php';
        editor.config.filebrowserUploadUrl =  '../../../public/backend/themes/main/global/plugins/ckeditor/plugins/imageuploader/imgupload.php';
    }
});
