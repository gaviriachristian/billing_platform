<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ url('css/dropzone.css') }}">
    <style>
        .dropzone {
            background: #f1f3ff;
            border-radius: 13px;
            width: 220px !important;
            max-width: 550px;
            text-align: center !important;
            margin-left: auto;
            margin-right: auto;
            border: 2px dotted #1833FF !important;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div id="dropzone">
        <form action="{{ route('dropzoneFileUpload') }}" class="dropzone" id="uploader" enctype="multipart/form-data">
            @csrf
            <div class="dz-message">
                Click Here or Drag & Drop to Upload File(s)<br>
            </div>
        </form>
    </div>

    <div id="dropzoneItemTemplate" style="display: none;" class="table table-striped" class="files" id="previews">
        <div id="template" class="file-row">
            <p>
                <div class="name" data-dz-name></div>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div id="progressbar" class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress>Success</div>
                </div>
            </p>
        </div>
    </div>

    <script src="{{ asset('js/scripts/dropzone.js') }}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var uploader = document.querySelector('#uploader');
            var dropzone = new Dropzone(uploader, {
                parallelUploads: 1,
                maxFilesize: 20,
                //maxFiles: 4,
                //acceptedFiles: "application/vnd.ms-excel,text/plain,.csv",
                previewTemplate: document.getElementById('dropzoneItemTemplate').innerHTML,
                init: function() {
                    this.on("success", function(file, response) {
                        var objResponse = JSON.parse(response);
                        // if (objResponse.status == 'success') {
                        //     $("#progressbar").html("<span style='color:red'>Success</span>"); 
                        // }
                        if (objResponse.status == 'error') {
                            $("#progressbar").text("Failed");
                            $("#progressbar").toggleClass("progress-bar-danger");
                        }
                        setTimeout(function(){ 
                            $(location).attr('href','/pm/funded/report'); 
                        }, 4000);
                    });
                    // this.on("error", function(file, response) {
                    //     $(".file-row").html('<div id="messagesText" style="color:red;padding-top:30px">'+response+'</div>');
                    //     //$("#messagesText").fadeOut(2000);
                    // });
                }
            });
        });
    </script>

</body>

</html>