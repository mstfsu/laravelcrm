/*=========================================================================================
	File Name: page-account-setting.js
	Description: Account setting.
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
    'use strict';
    var csrf=$('#_token').attr('content');
    // variables
    var passwordform = $('.password-form'),
        generalform=$('.general-form'),
        flat_picker = $('.flatpickr'),
        accountUploadImg = $('#account-upload-img'),
        accountUploadBtn = $('#account-upload');

    // Update user photo on click of button
    if (accountUploadBtn) {
        accountUploadBtn.on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (accountUploadImg) {
                    accountUploadImg.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });
    }

    // flatpickr init
    if (flat_picker.length) {
        flat_picker.flatpickr({
            onReady: function (selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).attr('step', null);
                }
            }
        });
    }

    // jQuery Validation
    // --------------------------------------------------------------------
    if (passwordform.length) {
        passwordform.each(function () {
            var $this = $(this);

            $this.validate({
                rules: {

                    password: {
                        required: true,
                        remote: {  // value of 'username' field is sent by default
                            type: 'get',
                            url: '/Admin/checkpassword',
                        }
                    },

                    'new-password': {
                        required: true,
                        minlength: 6
                    },
                    'confirm-new-password': {
                        required: true,
                        minlength: 6,
                        equalTo: '#account-new-password'
                    }

                }
            });
            $this.on('submit', function (e) {
                e.preventDefault();
                var isValid = passwordform.valid();
                var oldpassword=$('#account-old-password').val();
                var newpassword=$('#account-new-password').val();
                if(isValid) {
                    $.ajax({
                        dataType: 'json',
                        type: 'get',
                        url: '/Admin/changePassword',
                        data: {
                            oldpassword: oldpassword,
                            newpassword: newpassword,

                        },
                        contentType: 'application/json; charset=utf-8',
                        success: OnSuccess,
                        error: OnError
                    })

                    function OnSuccess(data) {

                        if (data.success == 'true') {
                            toastr["success"](data.msg);

                        } else {

                            toastr["error"]("ERROR ! Please Try Again Later");
                        }

                    }

                    function OnError(data) {

                        if (data.success == 'true') {
                            toastr["success"](data.msg);

                        } else {

                            toastr["error"]("ERROR ! Please Try Again Later");
                        }

                    }
                }
            });

        });
    }
    ///////////////////////////////////General Form///////////////

    if (generalform.length) {
        generalform.each(function () {
            var $this = $(this);

            $this.validate({
                rules: {

                    email: {
                        required: true,
                        remote: {  // value of 'username' field is sent by default
                            type: 'get',
                            url: '/Admin/checkemail',
                        }
                    },

                    'name': {
                        required: true,

                    },
                    'phone':{
                        required: true
                    }


                }
            });
            $this.on('submit', function (e) {
                e.preventDefault();
                var isValid = generalform.valid();
                var email=$('#account-e-mail').val();
                var name=$('#account-name').val();
                var phone=$('#account-phone').val();
                if(isValid) {
                    $.ajax({
                        dataType: 'json',
                        type: 'get',
                        url: '/Admin/changegeneral',
                        data: {
                            email: email,
                            name: name,
                            phone: phone

                        },
                        contentType: 'application/json; charset=utf-8',
                        success: OnSuccess,
                        error: OnError
                    })

                    function OnSuccess(data) {

                        if (data.success == 'true') {
                            toastr["success"](data.msg);

                        } else {

                            toastr["error"]("ERROR ! Please Try Again Later");
                        }

                    }

                    function OnError(data) {

                        if (data.success == 'true') {
                            toastr["success"](data.msg);

                        } else {

                            toastr["error"]("ERROR ! Please Try Again Later");
                        }

                    }
                }
            });

        });
    }
    $("#account-upload").on("change", function (e) {
        var file = $(this)[0].files[0];
        var upload = new Upload(file);
        var type=upload.getType();
         var allowedtype=['image/png','image/jpg','image/jpeg']
        if(allowedtype.includes(type))
          upload.doUpload();
        else
            toastr["error"]("ERROR !not allowed file");
    });

    var Upload = function (file) {
        this.file = file;
    };

    Upload.prototype.getType = function() {
        return this.file.type;
    };
    Upload.prototype.getSize = function() {
        return this.file.size;
    };
    Upload.prototype.getName = function() {
        return this.file.name;
    };
    Upload.prototype.doUpload = function () {
        var that = this;
        var formData = new FormData();

        // add assoc key values, this will be posts values
        formData.append("file", this.file, this.getName());


        $.ajax({
            type: "POST",
            url: "/Admin/Upload_avatar",
            headers: {
                'X-CSRF-TOKEN': csrf

            },
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', that.progressHandling, false);
                }
                return myXhr;
            },
            success: function (data) {
                // your callback here
            },
            error: function (error) {
                // handle error
            },
            async: true,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 60000
        });
    };

    Upload.prototype.progressHandling = function (event) {
        var percent = 0;
        var position = event.loaded || event.position;
        var total = event.total;
        var progress_bar_id = "#progress-wrp";
        if (event.lengthComputable) {
            percent = Math.ceil(position / total * 100);
        }
        // update progressbars classes so it fits your code
        $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
        $(progress_bar_id + " .status").text(percent + "%");
    };
});


