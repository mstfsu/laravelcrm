
var AddUser=function(){
    var csrf=$('#_token').attr('content');
    Dropzone.autoDiscover = false;
    var handleDropzone = function () {



        var myDropzoneOptions = {
            maxFilesize: 1,
            acceptedFiles: '.png,.jpeg',
            addRemoveLinks: true,
            clickable: true,
            headers: {
                'X-CSRF-TOKEN': $('#_token').attr('content')

            }
        };
        var myDropzone = new Dropzone('#m-dropzone-idcard', myDropzoneOptions);
        var ADressDropzone = new Dropzone('#m-dropzone-address', myDropzoneOptions);


        myDropzone.on('success', function (file) {

        });



    }
    var handleCheckbox=function(){
        $("#ipswitch").on('change', function() {
            if ($(this).is(':checked')) {
                $('#ipdiv').show()
               // To verify
                $("#ip_field").rules("add", {
                  //  required: true,

                });
                $("#mac").rules("add", {
                    MAC: true,
                 //   required: true
                });
            }
            else {
                $('#ipdiv').hide()
                $("#ip_field").rules('remove');
                $("#mac")  .rules('remove');
            }
        });
        $("#addressswitch").on('change', function() {
            if ($(this).is(':checked')) {
                $('#addressdiv').show()
                // To verify
                $("#addressbill").rules("add", {
                    required: true
                });
                $("#countrybill").rules("add", {
                    required: true
                });
                $("#pincodebill").rules("add", {
                    required: true
                });
                $("#citybill").rules("add", {
                    required: true
                });
            }
            else {
                $('#addressdiv').hide()
                $("#addressbill").rules('remove');
                $("#countrybill")  .rules('remove');
                $("#pincodebill")  .rules('remove');
                $("#city")  .rules('remove');
            }
        });


  }


  var handleInsertUser= function(){











  }

  var handleLocationchange=function(){
      $('#select_state').on('change', function () {
          var state_id = $(this).val();
          var ownerId = $('#owner').val();
          $.ajax({
              url: "/Location/get_city_by_state",
              type: 'POST',
              dataType: 'json',
              headers: {
                  'X-CSRF-TOKEN':csrf
              },
              data: {
                  'stateid': state_id,
                  'ownerId': ownerId,

              },
              success: function (res) {
                  var select = $('#select_city');
                  select.find('option').remove();
                  if (res.length > 0) {
                      select.attr('disabled', false);
                      select.append('<option value="">Select City </option>'); // return empty
                      $.each(res, function (k, v) {
                          select.append('<option value=' + v.id + '>' + v.city_name + '</option>'); // return empty
                      });
                  } else {
                      select.attr('disabled', true);
                      select.append('<option value="">Select City</option>'); // return empty
                  }
              }
          });
      });

      $('#select_city').on('change', function () {
          var city_id = $(this).val();
          var ownerId = $('#owner').val();
          $.ajax({
              url: "/Location/get_thana_by_city",
              type: 'POST',
              dataType: 'json',
              headers: {
                  'X-CSRF-TOKEN':csrf
              },
              data: {
                  'cityId': city_id,
                  'ownerId': ownerId,

              },
              success: function (res) {
                  var select = $('#select_thana');
                  select.find('option').remove();
                  if (res.length > 0) {
                      select.attr('disabled', false);
                      select.append('<option value="">Select Thana </option>'); // return empty
                      $.each(res, function (k, v) {
                          select.append('<option value=' + v.id + '>' + v.thana_name + '</option>'); // return empty
                      });
                  } else {
                      select.attr('disabled', true);
                      select.append('<option value="">Select Thana</option>'); // return empty
                  }
              }
          });
      });
      $('#select_thana').on('change', function () {
          var thana_id = $(this).val();
          var ownerId = $('#owner').val();

          $.ajax({
              url: "/Location/get_area_by_thana",
              type: 'POST',
              headers: {
                  'X-CSRF-TOKEN':csrf
              },
              dataType: 'json',
              data: {
                  'thanaId': thana_id,
                  'ownerId': ownerId,

              },
              success: function (res) {
                  var select = $('#select_area');
                  select.find('option').remove();
                  if (res.length > 0) {
                      select.attr('disabled', false);
                      select.append('<option value="">Select Area </option>'); // return empty
                      $.each(res, function (k, v) {
                          select.append('<option value=' + v.id + '>' + v.area_name + '</option>'); // return empty
                      });
                  } else {
                      select.attr('disabled', true);
                      select.append('<option value="">Select Area</option>'); // return empty
                  }
              }
          });
      });

  }
var handleWizard=function(){
    'use strict';

    var bsStepper = document.querySelectorAll('.bs-stepper'),
        select = $('.select2'),
        horizontalWizard = document.querySelector('.horizontal-wizard-example');

    // Adds crossed class
    if (typeof bsStepper !== undefined && bsStepper !== null) {
        for (var el = 0; el < bsStepper.length; ++el) {
            bsStepper[el].addEventListener('show.bs-stepper', function (event) {
                var index = event.detail.indexStep;
                var numberOfSteps = $(event.target).find('.step').length - 1;
                var line = $(event.target).find('.step');

                // The first for loop is for increasing the steps,
                // the second is for turning them off when going back
                // and the third with the if statement because the last line
                // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

                for (var i = 0; i < index; i++) {
                    line[i].classList.add('crossed');

                    for (var j = index; j < numberOfSteps; j++) {
                        line[j].classList.remove('crossed');
                    }
                }
                if (event.detail.to == 0) {
                    for (var k = index; k < numberOfSteps; k++) {
                        line[k].classList.remove('crossed');
                    }
                    line[0].classList.remove('crossed');
                }
            });
        }
    }




        var numberedStepper = new Stepper(horizontalWizard),
            $form = $(horizontalWizard).find('form');
        $form.each(function () {
            var $this = $(this);
            $.validator.addMethod("MAC", function(value, element) {
                return this.optional(element) || /^(([A-Fa-f0-9]{2}[:]){5}[A-Fa-f0-9]{2}[,]?)+$/i.test(value);
            }, "Please Insert Valid Mac address");

            $.validator.addMethod('IP4Checker', function(value, element) {

              return this.optional(element) || /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/i.test(value);

            }, 'Invalid IP address');
            $this.validate({
                rules: {
                    username: {
                        required: true,
                        remote: {  // value of 'username' field is sent by default
                            type: 'get',
                            url: '/ISP/users/user_exists',
                        }
                    },

                    password: {
                        required: true
                    },
                    'confirm-password': {
                        required: true,
                        equalTo: '#password'
                    },


                    phone: {

                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },


                    landmark: {
                        required: true
                    },
                    country: {
                        required: true
                    },



                }
            });
        });

        $(horizontalWizard)
            .find('.btn-next')
            .each(function () {
                $(this).on('click', function (e) {
                    var isValid = $(this).parent().siblings('form').valid();
                    if (isValid) {
                        numberedStepper.next();
                    } else {
                        e.preventDefault();
                    }
                });
            });

        $(horizontalWizard)
            .find('.btn-prev')
            .on('click', function () {
                numberedStepper.previous();
            });

        $(horizontalWizard)
            .find('.btn-submit')
            .on('click', function () {
                var username=$('#username').val();
                var password=$('#password').val()
                var plan=$('#plan').val();
                var full_name=$('#full-name').val()
                var email=$('#email').val();
                var country=$('#country').val();
                var city=$('#city').val();
                var state=$('#state').val();
                var address=$('#address').val();
                var pincode=$('#pincode').val();
                var phone=$('#phone').val();
                var addressswitch=$('#addressswitch').is(':checked');
                var countrybill=$('#countrybill').val();
                var citybill=$('#citybill').val();
                var addressbill=$('#addressbill').val();
                var pincodebill=$('#pincodebill').val();
                var owner=$('#owner').val();
                var area=$('#area').val();
                var street=$('#street').val();
                var building=$('#building').val();
                var latitude=$('#latitude').val();
                var longitude=$('#longitude').val();
                var ipswitch=$('#ipswitch').is(':checked');;
                var ipaddress=$('#ip_field').val();
                var mac=$('#mac').val();
                var notification=$('#notification').val();
                var comment=$('#comment').val();
                var company=$('#company').val();
                var acctype=$('#user_type').val()

                var isValid = $(this).parent().siblings('form').valid();


                if (isValid) {


                    $.ajax({
                        dataType:'json',
                        type: 'get',

                        url:'/ISP/users/add'   ,

                        data:  {username:username,password:password,plan:plan,full_name:full_name,email:email,country:country,city:city,address:address,pincode:pincode,phone:phone,
                            addressswitch:addressswitch,countrybill:countrybill,citybill:citybill,addressbill:addressbill,pincodebill:pincodebill,company:company,are:area,
                            street:street,building:building,latitude:latitude,longitude:longitude,ipswitch:ipswitch,ipaddress:ipaddress,mac:mac,notification:notification,comment:comment,state:state,acctype:acctype} ,
                        contentType: 'application/json; charset=utf-8',
                        success: OnSuccess,
                        error:OnError
                    })

                    function OnSuccess(data) {

                        if(data.success=='true')
                        { toastr["success"]( " User has been Added Successfully ");

                            window.location.replace('/ISPUsers/list/all')
                        }
                        else{

                            toastr["error"]("ERROR ! Please Try Again Later");
                        }

                    }
                    function OnError(data) {

                        if(data.success=='true')
                        { toastr["success"]( " User has been Added Successfully ");
                            window.location.replace('/ISPUsers/list/all')
                        }
                        else{

                            toastr["error"]("ERROR ! Please Try Again Later");
                        }

                    }
                }
            });



    // Modern Wizard
    // --------------------------------------------------------------------






}

    $('body').on('change','#ippool',function(){

        var ippool=$('#ippool').val();
        $.ajax({
            url: "/Networks/get_ips",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data:{pool:ippool},
            dataType: "json",


            success: function (data) {
                $('#ips').empty()
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.ip+'">'+o.ip+'</option>';
                });

                $('#ips').append(toAppend);


            },
            error: function (data) {
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.ip+'">'+o.ip+'</option>';
                });

                $('#ips').append(toAppend);




            }
        });



    })
    $('body').on('click','#set_ip',function(){
        $.ajax({
            url: "/Networks/get_pools",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",


            success: function (data) {
                $('#ippool').empty()
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.id+'">'+o.title+'</option>';
                });

                $('#ippool').append(toAppend);
                $('#ipmodal').modal('show')

            },
            error: function (data) {
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.id+'">'+o.title+'</option>';
                });

                $('#ippool').append(toAppend);
                $('#ipmodal').modal('show')



            }
        });


        $('body').on('change','#ippool',function(){

            var ippool=$('#ippool').val();
            $.ajax({
                url: "/Networks/get_ips",
                method: "get",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                data:{pool:ippool},
                dataType: "json",


                success: function (data) {
                    $('#ips').empty()
                    var toAppend = '';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.ip+'">'+o.ip+'</option>';
                    });

                    $('#ips').append(toAppend);


                },
                error: function (data) {
                    var toAppend = '';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.ip+'">'+o.ip+'</option>';
                    });

                    $('#ips').append(toAppend);




                }
            });



        })


    })

    $('body').on('click','.save_ip_mac',function(){
        var ip=$('#ips').val();


        var mac=$('#mac').val();
        var type=$(this).data('type')
        var regexpmac = /^(([A-Fa-f0-9]{2}[:]){5}[A-Fa-f0-9]{2}[,]?)+$/i;
        var regexp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/i;
        var id=$('#user_id').val();


        $('#ip_field').val(ip);
        $('#ipmodal').modal('hide')


    })
    return {

        init: function () {
            handleCheckbox();
            handleDropzone()
            handleWizard()
            handleLocationchange()
        }

    }



}();

jQuery(document).ready(function () {
    AddUser.init(); // init metronic core componets
});
