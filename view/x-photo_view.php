<!-- Fine Uploader DOM Element
    ====================================================================== -->
    <div id="fine-uploader-manual-trigger"></div>

    <!-- Your code to create an instance of Fine Uploader and bind to the DOM/template
    ====================================================================== -->
    <script>
        var manualUploader = new qq.FineUploader({
            element: document.getElementById('fine-uploader-manual-trigger'),
            template: 'qq-template-manual-trigger',
			debug: true,
            request: {
                endpoint: '../images'
            },
            thumbnails: {
                placeholders: {
                    waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                    notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                }
            },
            autoUpload: false,
            debug: true
        });

        qq(document.getElementById("trigger-upload")).attach("click", function() {
            manualUploader.uploadStoredFiles();
        });
    </script>