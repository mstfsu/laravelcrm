
$(function () {
    'use strict';
    var csrf =  $('meta[name="csrf-token"]').attr('content');

    var  userform=$('.save_user_settings');








    if (userform.length) {
        userform.each(function () {
            var $this = $(this);

$('body').on('click',"#save_general_btn",function(e){


                e.preventDefault();
                 var user_email=$('#user_email').is(':checked');
                var user_full_name=$('#user_full_name').is(':checked');
                var user_phone=$('#user_phone').is(':checked');
                var user_pincode=$('#user_pincode').is(':checked');
                var user_state=$('#user_state').is(':checked');
                var user_city=$('#user_city').is(':checked');
                var user_address=$('#user_address').is(':checked');
                var user_longitude=$('#user_longitude').is(':checked');
                var user_latitude=$('#user_latitude').is(':checked');



                var data = $(userform).serialize();

                $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: '/Settings/save_notification',
                    data:  {user_latitude:user_latitude,user_longitude:user_longitude,user_address:user_address,user_email:user_email,user_full_name:user_full_name,user_phone:user_phone,user_pincode:user_pincode,user_state:user_state,user_city:user_city},
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

            });

        });
    }














});