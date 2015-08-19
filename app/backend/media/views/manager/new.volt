{% extends "../../index.volt" %}
{% block content %}
    <div class="content">
        <form id="uploadFile" action="{{ _baseUri }}{{ router.getRewriteUri() }}" class="dropzone" enctype="multipart/form-data"></form>
    </div>
    <script src="{{ _baseUri }}/plugins/dropzonejs/dropzone.js"></script>
    <link rel="stylesheet" href="{{ _baseUri }}/plugins/dropzonejs/dropzone.css">

    <script>
        var errorUpload = [];
        var imageCount = 0;
        Dropzone.options.uploadFile = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: {{ max_file_upload }}, // MB,
            acceptedFiles: 'image/*,application/pdf,video/*',
            dictDefaultMessage: 'Drop or click to upload files!<br /><span style="font-size: 16px">Max file upload size {{ max_file_upload }}Mb</span>',
//            previewTemplate : '<div></div>',
//            success: function (file, response, e) {
//                imageCount++;
//                if (file) {
//                    console.log('yyy');
//                } else {
//                    console.log('xxxx');
//                    errorUpload.push(imageCount);
//                }
//            }
        };
    </script>
{% endblock %}
