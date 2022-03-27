/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
    'use strict';
    var   selectAjax = $('.select2-data-ajax'),select = $('.select2');
    var csrf=$('#csrf').val();
    var dtOnlineTable = $('.online-session-table'),
      passwordbtn=$('#change_pass_btn'),
      passwordmodal=$('#chnagepassmodal')  ,
      changeplanmodal=$('#changeplanmodal'),
     dtLogsTable=$('.user-logs-table'),


        statusObj = {
            1: { title: 'Pending', class: 'badge-light-warning' },
            2: { title: 'Active', class: 'badge-light-success' },
            3: { title: 'Inactive', class: 'badge-light-secondary' }
        };

    var assetPath = '../../../app-assets/',
        userView = 'app-user-view.html',
        userEdit = 'app-user-edit.html';
    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
        userView = assetPath + 'app/user/view';
        userEdit = assetPath + 'app/user/edit';
    }

    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent()
        });
    });


    selectAjax  .select2({

        ajax: {
            url: '/Networks/search_ip',
            data: function (term) {
                console.log(term)
                return {
                    pool: $('#ippool').val(),
                    term:term
                };
            },
            dataType: 'json',
            delay: 250,
        
            processResults: function (data, params) {
       

                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.ip,
                            id: item.ip
                        }
                    })
                };
            },
            cache: true
        },
        placeholder: 'Search for IP address',


    });
 
 
    $("a[href='#statisticstab']").on('shown.bs.tab', function () {
        var username=$('#username').val();
        Reports.initDashboardDaterange();
        GetUserData()
        Reports.init();
    })

    function GetUserData(username){

        Metronic.blockUI({
            target: $('#statisticstab'),
            animate: false,
            boxed: true,
            message: "Loading"
        });

        $.ajax({
            url: "/ISP/GetUserData",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data: {username: username},
            success: function (res) {

               $('#user_usage').html(res)


                    Metronic.unblockUI('#statisticstab');

            },
            error: function (res) {
                $('#user_usage').html(res)
                Metronic.unblockUI('#statisticstab');;


            }
        });
    }


    $('body').on('click', '#change_plan', function () {

        Metronic.blockUI({
            target: $('#changeplanmodal'),
            animate: false,
            boxed: true,
            message: "Loading"
        });

        var username=$("#username").val()
        $.ajax({
            url: "/Plans/plan_get_list",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"json",
            data: {username: username},
            success: function (res) {
                console.log(res)
                res.forEach(function(obj) {
                    $('#plan_list').append($('<option>', {
                        value: obj.id,
                        text : obj.srvname
                    }));

                })
                changeplanmodal.modal('show')




                Metronic.unblockUI('#changeplanmodal');

            },
            error: function (res) {
                changeplanmodal.modal('show')
                $('#password').val(res.password)
                Metronic.unblockUI('#changeplanmodal');;


            }
        });
    })

    $('body').on('click', '#save_user', function () {
        Metronic.blockUI({
            target: $('#userdiv'),
            animate: false,
            boxed: true,
            message: "Saving"
        });

        var username=$('#username').val();
        var phone=$('#phone').val()
        var full_name=$('#fullname').val()
        var email=$('#email').val()
        var pincode=$('#pincode').val()
        var state=$('#state').val();
        var city=$('#city').val()
        var address=$('#address').val();
        var latitude=$('#latitude').val()
        var longitue=$('#longitude').val();

        $.ajax({
            url: "/ISP/users/user_save",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"json",
            data: {username: username,pincode:pincode,state:state,city:city,address:address,latitude:latitude,longitue:longitue,phone:phone,full_name:full_name,email:email},
            success: function (res) {

                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });



                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }




                Metronic.unblockUI('#userdiv');

            },
            error: function (res) {
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });



                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }

                Metronic.unblockUI('#userdiv');;


            }
        });




    });

    $('body').on('click', '#save_main', function () {
        Metronic.blockUI({
            target: $('body'),
            animate: false,
            boxed: true,
            message: "Saving"
        });

        var username=$('#username').val();
        var phone=$('#phone').val()
        var email=$('#email').val();
        var fullname=$('#full_name').val()
        var owner=$('#owner_select').val();
        var latitude=$('#latitude').val()
        var longitue=$('#longitude').val();

        $.ajax({
            url: "/ISP/users/user_save",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"json",
            data: {username: username,pincode:pincode,state:state,city:city,address:address,latitude:latitude,longitue:longitue},
            success: function (res) {

                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });



                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }




                Metronic.unblockUI('#userdiv');

            },
            error: function (res) {
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });



                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }

                Metronic.unblockUI('#userdiv');;


            }
        });




    });
    $('body').on('click', '#save_plan', function () {
        var username=$('#username').val();
        var plan=$('#plan_list').val();
        Metronic.blockUI({
            target: $('#changeplanmodal'),
            animate: false,
            boxed: true,
            message: "Loading"
        });


        $.ajax({
            url: "/ISP/change_plan",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"json",
            data: {username: username,plan:plan},
            success: function (res) {
                console.log(res)
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    changeplanmodal.modal('hide')
                    location.reload();


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }




                Metronic.unblockUI('#changeplanmodal');

            },
            error: function (res) {
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    changeplanmodal.modal('hide')


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }

                Metronic.unblockUI('#chnagepassmodal');;


            }
        });




    });

    $('body').on('click', '#view_pass', function () {
        $('#password').attr('type', 'text')


    });
    $('body').on('click', '#view_pass_portal', function () {
        $('#portal_password').attr('type', 'text')


    });



    $('body').on('click', '#change_pass_btn', function () {
        $('#password').attr('type', 'password')
        Metronic.blockUI({
            target: $('#chnagepassmodal'),
            animate: false,
            boxed: true,
            message: "Loading"
        });

        var username=$("#username").val()
        $.ajax({
            url: "/ISP/GetUserPassword",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data: {username: username},
            success: function (res) {
                passwordmodal.modal('show')
                $('#password').val(res.password)


                Metronic.unblockUI('#chnagepassmodal');

            },
            error: function (res) {
                passwordmodal.modal('show')
                $('#password').val(res.password)
                Metronic.unblockUI('#chnagepassmodal');;


            }
        });




    });

    $('body').on('click', '#save_pass_portal_btn', function () {
        var username=$('#username').val();
        var password=$('#portal_password').val();
        Metronic.blockUI({
            target: $('#change_portal_password'),
            animate: false,
            boxed: true,
            message: "Loading"
        });


        $.ajax({
            url: "/ISP/change_portal_password",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"json",
            data: {username: username,password:password},
            success: function (res) {
                console.log(res)
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    passwordmodal.modal('hide')


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }




                Metronic.unblockUI('#change_portal_password');

            },
            error: function (res) {
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    passwordmodal.modal('hide')


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }

                Metronic.unblockUI('#change_portal_password');;


            }
        });




    });
    $('body').on('click', '#save_pass', function () {
        var username=$('#username').val();
        var password=$('#password').val();
        Metronic.blockUI({
            target: $('#chnagepassmodal'),
            animate: false,
            boxed: true,
            message: "Loading"
        });


        $.ajax({
            url: "/ISP/change_password",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"json",
            data: {username: username,password:password},
            success: function (res) {
                console.log(res)
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    passwordmodal.modal('hide')


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }




                Metronic.unblockUI('#chnagepassmodal');

            },
            error: function (res) {
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    passwordmodal.modal('hide')


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }

                Metronic.unblockUI('#chnagepassmodal');;


            }
        });




    });
    function  initLogTable() {
        var table = dtLogsTable.dataTable({
            processing: true,
            serverSide: true,
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: 'Search',
                searchPlaceholder: 'Search..'
            },
            // Buttons with Dropdown
            buttons: [
                {

                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
            ],
            ajax: {
                "url": "/ISP/getuserLogs",
                "type": "GET",
                "data": {
                    "username": $("#username").val(),

                }
            }
            ,

            columns: [
                {
                    data: 'username',
                    name: 'username',


                },
                {
                    data: 'acctinputoctets',
                    name: 'acctinputoctets',
                    orderable: true,


                },
                {
                    data: 'acctoutputoctets',
                    name: 'acctoutputoctets',
                    orderable: true,


                },
                {
                    data: 'acctstarttime',
                    name: 'acctstarttime',
                    orderable: true,


                },
                {
                    data: 'acctstoptime',
                    name: 'acctstoptime',
                    orderable: true,


                },

                {
                    data: 'framedipaddress',
                    name: 'framedipaddress',
                    orderable: true,


                },
                {
                    data: 'callingstationid',
                    name: 'callingstationid',
                    orderable: true,


                },

                {
                    data: 'nasipaddress',
                    name: 'nasipaddress',
                    orderable: false,
                    searchable: false,

                }
            ],


            drawCallback: function( settings ) {
                feather.replace()
            }

        });
    }



    function  initOnlineTable() {
        var table = dtOnlineTable.dataTable({
            processing: true,
            serverSide: true,
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: 'Search',
                searchPlaceholder: 'Search..'
            },
            // Buttons with Dropdown
            buttons: [
                {

                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
            ],
            ajax: {
                "url": "/ISP/getusersessions",
                "type": "GET",
                "data": {
                    "username": $("#username").val(),

                }
            }
,

                columns: [
                {
                    data: 'username',
                    name: 'username',


                },
                {
                    data: 'acctinputoctets',
                    name: 'acctinputoctets',
                    orderable: true,


                },
                {
                    data: 'acctoutputoctets',
                    name: 'acctoutputoctets',
                    orderable: true,


                },
                {
                    data: 'acctstarttime',
                    name: 'acctstarttime',
                    orderable: true,


                },
                {
                    data: 'time',
                    name: 'time',
                    orderable: true,


                },
                {
                    data: 'framedipaddress',
                    name: 'framedipaddress',
                    orderable: true,


                },
                {
                    data: 'callingstationid',
                    name: 'callingstationid',
                    orderable: true,


                },

                {
                    data: 'nas',
                    name: 'nas',
                    orderable: false,
                    searchable: false,

                },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,

                    }
            ],


            drawCallback: function( settings ) {
                feather.replace()
            }

        });
    }

    $("a[href='#Logtab']").on('shown.bs.tab', function () {
        dtLogsTable.DataTable().destroy()
        initLogTable()
    })
    $("a[href='#onlinetab']").on('shown.bs.tab', function () {
        dtOnlineTable.DataTable().destroy()
        initOnlineTable()
    })
    $("a[href='#logstabs']").on('shown.bs.tab', function () {
        $(' a[href="#loginlogstab"]').tab('show')
    })

    // Check Validity


    //////////////////////////Activity tab///////////
    $("a[href='#activitytab']").on('shown.bs.tab', function () {

      //  fill_lead_activity()
    })

    function  fill_lead_activity(){
        var username=$('#username').val();

        $.ajax({
            url: "/ISP/users/get_activities",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data:{username:username},
            dataType: "json",

            success: function (res) {
                console.log(res)
                var data=res.data;
                $('#user_activity_table').html('')
                data.forEach(function(obj) {
                    var checked_var=' '
                    var messages="";
                    var msgarray=obj.msg;
                    var paginate=obj.links;
                    msgarray.forEach(function(item) {
                        messages+='<li>'+item+'</li>'

                    });
                    console.log(messages)
                    var htmlq= '<ul class="customers-activity-history-list" id="leads_activity_history_list_33">    \n' +
                        '<li class="clearfix customer-activity-log-item" style="">\n' +
                        '    <div class="pull-left customer-activity-log-avatar">\n' +

                        '            </div>\n' +
                        '    <div class="pull-left customer-activity-log-message-text">\n' +
                        '        <span class="message-content"><b>'+obj.causer.name+'</b>  ' +obj.description+'</b>  '+obj.log_name+'   <b> #'+obj.subject_id+'</b>\n' +

                        '<ul>\n' +
                        messages + '   ' +
                        '<div class="time">\n' +
                        '            <time class="text-muted timeago" datetime=" " title="2021-06-05 10:02:50">'+obj.diff+'</time>\n' +
                        '            <time class="text-muted"> ('+obj.created_at+')</time>\n' +
                        '        </div>'+
                        ' </ul></span></div></li></ul>'+


                        '<hr>'


                    $('#user_activity_table').append(htmlq)
                    feather.replace()

                })

                //  $('#links').html(links())


            },
            error: function (res) {


            }
        });
    }
    $('body').on('change','.additional',function(){
       var type=$(this).attr('id')
        var newval=$(this).val();
        change_additional(type,newval)

    });
    function change_additional(type,newval) {

var user_id=$('#user_id').val()


            $.ajax({
                url: "/ISP/users/change_additional",
                method: "get",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                dataType: "json",
                data: {type: type, user_id: user_id,newval:newval},
                success: function (res) {

                    if (res.success == "true") {
                        toastr['success']('👋 ' + res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        fill_users_comment()


                    } else {
                        toastr['error']('👋 ' + res.msg, 'Error!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    }
                },
                error: function (res) {

                    toastr['error']('👋 Please Try Again Later.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }
            });


    }

    $('body').on('click', '#add_comment_show', function () {
        var status=$(this).data('status');

        if(status=='add'){
            $('#comment_div').show()
            $(this).data('status','edit')
        }
        else{
            $('#comment_div').hide()
            $(this).data('status','add')
        }


    });

    $('body').on('click', '#add_comment_btn', function () {
        var status=$('#add_comment_btn').data('status')
        var comment=$('textarea#comment').val();


        var user_id=$('#user_id').val()
         if(status=='add') {
             $.ajax({
                 url: "/ISP/users/add_comment",
                 method: "get",
                 headers: {
                     'X-CSRF-TOKEN': csrf
                 },
                 dataType: "json",
                 data: {comment: comment, user_id: user_id},
                 success: function (res) {

                     if (res.success == "true") {
                         toastr['success']('👋 ' + res.msg, 'Success!', {
                             closeButton: true,
                             tapToDismiss: false,

                         });
                         fill_users_comment()


                     } else {
                         toastr['error']('👋 ' + res.msg, 'Error!', {
                             closeButton: true,
                             tapToDismiss: false,

                         });
                     }
                 },
                 error: function (res) {

                     toastr['error']('👋 Please Try Again Later.', 'Error!', {
                         closeButton: true,
                         tapToDismiss: false,

                     });

                 }
             });
         }
        if(status=='edit') {
            var id=$('#comment_id').val()
            $.ajax({
                url: "/ISP/users/edit_comment",
                method: "get",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                dataType: "json",
                data: {comment: comment, id: id},
                success: function (res) {

                    if (res.success == "true") {
                        toastr['success']('👋 ' + res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        fill_users_comment()


                    } else {
                        toastr['error']('👋 ' + res.msg, 'Error!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    }
                },
                error: function (res) {

                    toastr['error']('👋 Please Try Again Later.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }
            });
        }
    });
    function  fill_users_comment(){
        var id=$('#user_id').val();
        $.ajax({
            url: "/ISP/users/get_comments_users",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data:{user_id:id},
            dataType: "json",

            success: function (res) {
                $('#users_comments_table').html('')
                res.forEach(function(obj) {
                    var checked_var=' '
                    if(obj.status==1)
                        checked_var='checked disabled';

                    var htmlq='         <div class="transaction-item">\n' +
                        '                    <div class="font-weight-bolder text-danger" style="width: 5px"><div class="badge badge-primary">'+obj.comment+'</div></div>\n' +
                        '                    <div class="font-weight-bolder  ">'+obj.diff+'</div>\n' +
                        '\n' +
                        '\n' +
                        '                    <div class="font-weight-bolder text-grean"> <a   title="Delete" href="javascript:void(0)"  data-id="'+obj.id+'" id="delete_comment"  ><span data-feather="trash-2"></span></a>' +
                        '<a href="javascript:void(0)" id="edit_comment"   data-id="'+obj.id+'" data-comment="'+obj.comment+'" title="Edit"    ><span data-feather="edit"></span></a></div>\n' +
                        '\n' +
                        '                </div> '+
                        '<hr>'

                    $('#users_comments_table').append(htmlq)
                    feather.replace()

                })


            },
            error: function (res) {


            }
        });
    }
    $('body').on('click', '#delete_comment', function () {
        var id=$(this).data('id')
        areyousure(id,'comment')


    });
    $('body').on('click', '#edit_comment', function () {
        var comment=$(this).data('comment')
        var id=$(this).data('id');
        $('#comment_id').val(id)
        $('textarea#comment').text(comment)
         $('#add_comment_btn').data('status','edit')
        $('#comment_div').show()


    });
    $('body').on('click', '#delete_user', function () {
        var id=$('#user_id').val()
        areyousure(id,'users')


    });
    function areyousure(srvname,type){

        Swal.fire({
            title: 'Are you sure? ',
            text: "You will not be able to restore it !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {

                delete_function(srvname,type)

            }
            else
                return "false";
        });



    }
    function delete_function(id,type) {

        if (type == 'user')
        {
            $.ajax({
                url: "/ISP/users/Delete",
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                dataType: "json",
                data: {id: id},
                success: function (res) {
                    console.log(res)
                    console.log(res.success)
                    if (res.success == "true") {
                        toastr['success']('👋 ' + res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        window.location.replace('/ISPUsers/list')

                    } else {
                        toastr['error']('👋 ' + res.msg, 'Error!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    }
                },
                error: function (res) {

                    toastr['error']('👋 Please Try Again Later.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }
            });

        }
        else if (type == 'comment')
        {
            $.ajax({
                url: "/CRM/lead/delete_comment",
                method: "get",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                dataType: "json",
                data: {id: id},
                success: function (res) {

                    if (res.success == "true") {
                        toastr['success']('👋 ' + res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        fill_users_comment();

                    } else {
                        toastr['error']('👋 ' + res.msg, 'Error!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    }
                },
                error: function (res) {

                    toastr['error']('👋 Please Try Again Later.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }
            });

        }
        else if (type == 'quote')
        {
            $.ajax({
                url: "/CRM/quote/delete_quote",
                method: "get",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                dataType: "json",
                data: {id: id},
                success: function (res) {

                    if (res.success == "true") {
                        toastr['success']('👋 ' + res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });



                    } else {
                        toastr['error']('👋 ' + res.msg, 'Error!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    }
                },
                error: function (res) {

                    toastr['error']('👋 Please Try Again Later.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }
            });

        }
    }
    fill_users_comment()
    $('input[type=radio][name=renewradio]').change(function() {
        var id=$('#user_id').val();
        var username=$('#username').val();
        var values=$(this).val();
        var plan_id=$('#select_plan_renew').val();
        var times=$('#renew_times').val()
        calculate(id,username,values,plan_id,times)

    });
    $('#select_plan_renew').change(function() {
        var id=$('#user_id').val();
        var username=$('#username').val();
        var values=$('input[type=radio][name=renewradio]:checked').val();
        var plan_id=$('#select_plan_renew').val();
        var times=$('#renew_times').val()
        calculate(id,username,values,plan_id,times)

    });
    $('#open_renewmodal').on('click',function(){
        $('#renew_times').val(1)
        var id=$('#user_id').val();
        var username=$('#username').val();
        var values=$('input[type=radio][name=renewradio]:checked').val();
        var plan_id=$('#select_plan_renew').val();
        var times=$('#renew_times').val()
        calculate(id,username,values,plan_id,times)
        $('#renewmodal').modal('show');
    })

    $('#renew_times').on('input', function() {
        var id=$('#user_id').val();
        var username=$('#username').val();
        var values=$('input[type=radio][name=renewradio]:checked').val();
        var plan_id=$('#select_plan_renew').val();
        var times=$('#renew_times').val()
        calculate(id,username,values,plan_id,times)
    });
    function calculate(id,username,values,plan_id,times){
        $.ajax({
            url: "/ISP/users/getrenewvalue",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data: {id: id,username:username,values:values,plan_id:plan_id,times:times},
            success: function (res) {
                if(res.success=="false")
                {
                    $('#renew_error').show();
                    $('#renew_btn').attr('disabled',"disabled")
                }

                else{
                    $('#renew_error').hide();
                    $('#renew_btn').attr('disabled',false)
                }
                $('#newexp').val(res.newdate)
                $('#total_price').val(res.price);
                $('#unit_price').val(res.unit_price);
                $('#total_tax').val(res.total_tax)


            },
            error: function (res) {

                $('#newexp').val(res.newdate)
                $('#total_price').val(res.price);
                $('#unit_price').val(res.unit_price);
                $('#total_tax').val(res.total_tax)

            }
        });
    }

    $('body').on('click','#renew_btn',function (){
        Metronic.blockUI({
            target: 'body',
            animate: true,
            boxed: true,

        });
        var values=$('input[type=radio][name=renewradio]:checked').val();

        var comment=$('#renewcomment').val();
        var id=$('#user_id').val();
        var newexpir=$('#newexp').val();
        var plan=$('#select_plan_renew').val()
        var times=$('#renew_times').val();
        var payment_collected=$('#payment_collected').is(':checked');

        $.ajax({
            url: "/ISP/users/saverenewvalue",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data: {id: id,comment:comment,newexpir:newexpir,plan:plan,times:times,payment_collected:payment_collected,values:values},
            success: function (res) {

                if (res.success == "true") {

                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }
                Metronic.unblockUI('body');
                $('#renewmodal').modal('hide');
            },
            error: function (res) {

                if (res.success == "true") {

                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }
                Metronic.unblockUI('body');
                $('#renewmodal').modal('hide');

            }
        });
    })
    $('body').on('click','#revert_btn',function (){
        var comment=$('#revertcomment').val();
        var id=$('#user_id').val();

        $.ajax({
            url: "/ISP/users/revert",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data: {id: id,comment:comment },
            success: function (res) {

                if (res.success == "true") {
                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }
            },
            error: function (res) {

                if (res.success == "true") {

                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }

            }
        });
    })

    $('body').on('click','#save_grace',function (){
        var reason=$('#reason').val();
        var id=$('#user_id').val();
        var grace_period=$('#grace_period').val();

        $.ajax({
            url: "/ISP/users/grace",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data: {id: id,reason:reason,grace_period:grace_period },
            success: function (res) {

                if (res.success == "true") {
                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }
            },
            error: function (res) {

                if (res.success == "true") {

                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }

            }
        });
    })


    // $('body').on('click','#save_mac',function(){
    //     var mac=$('#mac').val();
    //     var id=$('#user_id').val();
    //     var regexp = /^(([A-Fa-f0-9]{2}[:]){5}[A-Fa-f0-9]{2}[,]?)+$/i;
    //
    //     if(regexp.test(mac)) {
    //         $.ajax({
    //             url: "/ISP/users/save_user_data",
    //             method: "get",
    //             headers: {
    //                 'X-CSRF-TOKEN': csrf
    //             },
    //             dataType: "json",
    //             data: {id: id,mac:mac,type:'mac'},
    //             success: function (res) {
    //
    //                 if (res.success == "true") {
    //                     toastr['success']('👋 ' + res.msg, 'Success!', {
    //                         closeButton: true,
    //                         tapToDismiss: false,
    //
    //                     });
    //
    //                 } else {
    //                     toastr['error']('👋 ' + res.msg, 'Error!', {
    //                         closeButton: true,
    //                         tapToDismiss: false,
    //
    //                     });
    //                 }
    //             },
    //             error: function (res) {
    //
    //                 if (res.success == "true") {
    //
    //                     toastr['success']('👋 ' + res.msg, 'Success!', {
    //                         closeButton: true,
    //                         tapToDismiss: false,
    //
    //                     });
    //                 } else {
    //                     toastr['error']('👋 ' + res.msg, 'Error!', {
    //                         closeButton: true,
    //                         tapToDismiss: false,
    //
    //                     });
    //                 }
    //
    //             }
    //         });
    //
    //
    //
    //
    //     } else {
    //
    //     }
    // })

    $('body').on('click','.save_ip_mac',function(){
        var ip=$('#ips').val();
       if($('#switch-ip').is(':checked'))
           ip=$('#ip_address_manual').val()

       

        var mac=$('#mac').val();
        var type=$(this).data('type')
        var regexpmac = /^(([A-Fa-f0-9]{2}[:]){5}[A-Fa-f0-9]{2}[,]?)+$/i;
        var regexp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/i;
        var id=$('#user_id').val();

        if(type=='ip') {


            if (regexp.test(ip) || ip=='') {

                $.ajax({
                    url: "/ISP/users/save_user_data",
                    method: "get",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    dataType: "json",
                    data: {id:id, ip:ip, type:type, mac:mac},
                    success: function (res) {

                        if (res.success == "true") {
                            toastr['success']('👋 ' + res.msg, 'Success!', {
                                closeButton: true,
                                tapToDismiss: false,

                            });

                        } else {
                            toastr['error'](  res.msg, 'Error!', {
                                closeButton: true,
                                tapToDismiss: false,

                            });

                        }
                        $('#ip_field').val(ip);
                        $('#ipmodal').modal('hide')
                    },
                    error: function (res) {

                        if (res.success == "true") {

                            toastr['success']('👋 ' + res.msg, 'Success!', {
                                closeButton: true,
                                tapToDismiss: false,

                            });
                        } else {
                            toastr['error']('👋 ' + res.msg, 'Error!', {
                                closeButton: true,
                                tapToDismiss: false,

                            });
                        }
                        $('#ip_field').val(ip);
                        $('#ipmodal').modal('hide')
                    }
                });
            } else {
                toastr['error']( "Please Insert Valid IP Address", 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
            }
        }
        else if(type=='mac'){
            if(regexpmac.test(mac) || mac=="") {
                $.ajax({
                    url: "/ISP/users/save_user_data",
                    method: "get",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    dataType: "json",
                    data: {id: id,mac:mac,type:type},
                    success: function (res) {

                        if (res.success == "true") {
                            toastr['success']('👋 ' + res.msg, 'Success!', {
                                closeButton: true,
                                tapToDismiss: false,

                            });

                        } else {
                            toastr['error'](   res.msg, 'Error!', {
                                closeButton: true,
                                tapToDismiss: false,

                            });
                        }
                    },
                    error: function (res) {


                    }
                });




            } else {
                toastr['error']( "Please Insert Valid Mac Address", 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
            }
        }
    })

    $('body').on('click','#disconnect',function (){
var username=$(this).data('username');
        $.ajax({
            url: "/ISP/users/disconnect/"+username,
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",

            success: function (res) {

                if (res.success == "true") {
                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                } else {
                    toastr['error'](  res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }
            },
            error: function (res) {

                if (res.success == "true") {

                    toastr['success']('👋 ' + res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }

            }
        });


    })
$('body').on('click','#unset_ip',function(){
    var id =$(this).data('id');
    $.ajax({
        url: "/ISP/users/save_user_data",
        method: "get",
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        dataType: "json",
        data: {id:id, ip:"", type:"ip"},
        success: function (res) {

            if (res.success == "true") {
                toastr['success']('👋 ' + res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });

            } else {
                toastr['error'](  res.msg, 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
            }
        },
        error: function (res) {

            if (res.success == "true") {

                toastr['success']('👋 ' + res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
            } else {
                toastr['error']('👋 ' + res.msg, 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
            }

        }
    });
})



    $('body').on('change','#ispgroups_select',function() {


        var group_id=$('#ispgroups_select').val();
        var username=$('#username').val()

        $.ajax({
            url: '/ISP/users/change_users_group',
            type: 'get',
            dataType: "json",
            data: {username: username,group_id:group_id},
            success: function(res){
                toastr['success']('👋 '+ res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });



            }
        });
    });

        $('body').on('change', '#switch-ip', function () {
            if($(this).is(':checked'))
                $('#manual_ip_div').show()
            else
                $('#manual_ip_div').hide()
        });
    $('body').on('change', '#switch-block', function () {

        var username=$(this).data('username')
        var id=$(this).data('id')
        var status=$(this).is(':checked')
        $.ajax({
            url: "/ISP/users/block",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data:{username:username,id:id,status:status},

            success: function (res) {


                toastr['success']('👋 '+ res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });


            },
            error: function (res) {

                toastr['error'](' Error! Please try again Later', 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
          

            }
        });

    });
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
                getipool()
                $('#ipmodal').modal('show')

            },
            error: function (data) {
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.id+'">'+o.title+'</option>';
                });

                $('#ippool').append(toAppend);
                getipool()
                $('#ipmodal').modal('show')



            }
        });

function getipool(){
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


    })
    // To initialize tooltip with body container
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        container: 'body'
    });
});
