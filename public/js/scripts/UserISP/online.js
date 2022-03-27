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
    var select = $('.select2');



    var csrf= $('meta[name="csrf-token"]').attr('content');
    var dtonlineusers = $('.online-users-list-table'),

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




    function  initonlineusersTable() {
        var table = dtonlineusers.dataTable({
            processing: true,
            serverSide: true,
            "lengthMenu": [[50,100, 200, 500, 1000,2000,5000], [50,100, 200, 500, 1000,2000,5000]],
            buttons: [
                {
                    text: ' <i data-feather="search"></i>',
                    className: 'btn btn-icon btn-outline-primary',
                    attr: {
                        id: 'search_div',
                        style:"margin:10px;border-radius: 10px",
                        status:"show"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config)
                    {
                        //This will send the page to the location specified
                        //   window.location.href = '/ISP/users/adduser';
                    },
                },
                {
                    text: ' <i data-feather="upload"></i>',
                    className: 'btn btn-icon btn-outline-primary',
                    attr: {
                        id: 'export_modal_btn',
                        style:"margin:10px;border-radius: 10px"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config)
                    {
                        //This will send the page to the location specified
                        //   window.location.href = '/ISP/users/adduser';
                    },
                },
            ],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',

            // Buttons with Dropdown

            ajax: {
                url: "/ISP/users/get_online_users",
                data  : {

                    owner: $('#owner_filter').val(),
                    type: $('#search_select').val(),

                }

            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false

                },

                {
                    data: 'username',
                    name: 'username',


                },
                {
                    data: 'fullname',
                    name: 'fullname',
                    orderable: true,


                },


                {
                    data: 'plan',
                    name: 'profiles.srvname',
                    orderable: true,


                },
                {
                    data: 'owner',
                    name: 'company.name',
                    orderable: true,




                },
                {
                    data: 'mac',
                    name: 'callingstationid',
                    orderable: true,



                },

                {
                    data: 'ip',
                    name: 'ip',
                    orderable: true,
                    searcharble: true

                },
                {
                    data: 'interface',
                    name: 'interface',
                    orderable: true,



                },
                {
                    data: 'acctype',
                    name: 'acctype',
                    orderable: true,



                },
                {
                    data: 'nasipaddress',
                    name: 'nasipaddress',
                    orderable: true,
                    searcharble: true




                },
                {
                    data: 'starttime',
                    name: 'acctstarttime',
                    orderable: true,



                },
                {
                    data: 'duration',
                    name: 'duration',
                    orderable: true,
                    searcharble: false


                },


                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: "25%"
                }




            ],


            drawCallback: function( settings ) {
                feather.replace()
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },

        });
    }
    get_connected_percent();
    function get_connected_percent(){
        $.ajax({
            url: '/ISP/users/get_connected_percent',
            type: 'get',
            dataType: "json",

            success: function(res){
              $('#active_session_percent').html(res.percent);
                $('#active_session').html(res.allusers);
                $('#inactive_session').html(res.inactive);


            },
            error:function(res){


            }

        });
    }







    initonlineusersTable()

    $('body').on('click','#search_div',function (){
        var status=$(this).attr('status')
        if(status=='show') {
            $('#search_row').show();

            $(this).attr('status','hide')

        }
        else{
            $('#search_row').hide();
             $(this).attr('status','show')
        }
    })


    $('.show-popover')
        .popover({
            title: 'Popover Show Event',
            content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
            trigger: 'click',
            placement: 'right'
        })
        .on('show.bs.popover', function () {
            var x=$(this).data('hi');
            alert('Show event fired.');
        });



    $('#checkall').change(function(){

        if($(this).is(':checked')){
            $('.usercheckbox').prop('checked', true);
        }else{
            $('.usercheckbox').prop('checked', false);
        }
    });

    $('#disconnect_users').click(function(){
        Metronic.blockUI({
            target: dtonlineusers,
            animate: true,
            boxed: true,
            message: "Loading"
        });
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        console.log(deleteids_arr);
        // Check checkbox checked or not
        if(deleteids_arr.length > 0){

            // Confirm alert
            var confirmdelete = confirm("Do you really want to Disconnect Selected Users?");
            if (confirmdelete == true) {
                $.ajax({
                    url: '/ISP/users/disconnect_bulk',
                    type: 'get',
                    dataType: "json",
                    data: {deleteids_arr: deleteids_arr},
                    success: function(res){
                        toastr['success']('👋 '+ res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                       // dtonlineusers.DataTable().destroy();

                        Metronic.unblockUI(dtonlineusers);
                    },
                    error:function(res){
                        toastr['error'](  res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                       // dtonlineusers.DataTable().destroy();
                       // initonlineusersTable()

                        Metronic.unblockUI(dtonlineusers);
                    }

                });
            }
            else{
                Metronic.unblockUI(dtonlineusers);
            }
        }
        else{
            Metronic.unblockUI(dtonlineusers);
        }
    });

    $('body').on('click','#disconnect_customer',function(){
        Metronic.blockUI({
            target: dtonlineusers,
            animate: true,
            boxed: true,
            message: "Loading"
        });

        // Read all checked checkboxes
        var username=$(this).data('id');


        // Check checkbox checked or not


            // Confirm alert
            var confirmdelete = confirm("Do you really want to Disconnect this User?");
            if (confirmdelete == true) {
                $.ajax({
                    url: '/ISP/users/disconnect/'+username,
                    type: 'get',
                    dataType: "json",

                    success: function(res){
                        toastr['success']('👋 '+ res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtonlineusers.DataTable().destroy();
                        initonlineusersTable()

                        Metronic.unblockUI(dtonlineusers);
                    },
                    error:function(res){
                        toastr['error'](  res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtonlineusers.DataTable().destroy();
                        initonlineusersTable()

                        Metronic.unblockUI(dtonlineusers);
                    }

                });
            }
            else{
                Metronic.unblockUI(dtonlineusers);
            }

    });

    $('body').on('change', '#owner_filter', function () {
        var status=$(this).val()
        dtonlineusers.DataTable().destroy();
        initonlineusersTable()


    });
    $('#change_owner').click(function(){

        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });


        // Check checkbox checked or not
        if(deleteids_arr.length > 0){

            // Confirm alert
            $('#ownermodal').modal('show')



        }
    });
    $('#save_owner').click(function() {
        Metronic.blockUI({
            target: $('#ownermodal'),
            animate: true,
            boxed: true,
            message: "Loading"
        });

        var owner=$('#owner_bulk').val();
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        $.ajax({
            url: '/ISP/users/change_ownerbulk',
            type: 'get',
            dataType: "json",
            data: {deleteids_arr: deleteids_arr,owner:owner},
            success: function(res){
                toastr['success']('👋 '+ res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
                Metronic.unblockUI($('#ownermodal'));
                $('#ownermodal').modal('hide')
                dtUserTable.DataTable().destroy();
                initUserTable()
                fill_users_status()

            }
        });
    });
    $(document).ready(function () {
        $('body').on('mouseenter', '.popoverhref', function () {
            var e = $(this);
            var mac = $(this).data('mac')

            e.popover({
                html: true,
                trigger: 'manual',
                content: function () {
                    return $.ajax({
                        url: 'https://admin.ispcrm.online:5004/get_mac/',
                        dataType: 'html',
                        data: {mac: mac},
                        async: false
                    }).responseText;
                }
            });
            e.popover('show');
        })
        $('body').on('mouseleave', '.popoverhref', function () {

            $(this).popover('hide');
        });
    });
    $('body').on('change','#search_select',function(){

        dtonlineusers.DataTable().destroy();
        initonlineusersTable()
    })

    $('body').on('click','.filter_session',function(){
        var value=$(this).data('name');
        $('#search_select').val(value)
        $('#search_select').change();
    })
    $('body').on('input','#search_text',function(){

        dtonlineusers.DataTable().destroy();
        initonlineusersTable()
    })
$('body').on('mouseover',".popoverhrefs",function(){
        let popoverBtn = $(this);
        let dataProviderURL = "https://crm.zapbytes.in:5004/get_mac/";
    
        popoverBtn.popover({
            title: "Vendor",
            placement: "top",
            html: true,
            content: "<div id='popover-body'><img src='/img/loading.gif' alt='Loading...'></div>"
        });

        popoverBtn.on("shown.bs.popover", function () {
            var mac=$(this).data("mac");
            $(".popover-close-btn").click(function () {
                popoverBtn.popover("hide");
            });

            let popoverTitle = $(".popover-header");
            let popoverBody = $(".popover-body");

            $.ajax({
                url: dataProviderURL,
                type: "GET",

               
                data: {mac: mac},
                headers: {  'Access-Control-Allow-Origin': '*' },

                success: function (result) {

                    popoverTitle.html("Vendor");
                    popoverBody.html(result);
                    popoverBtn.popover("update");
                },
                error: function (result) {
                    console.log(result)
                    popoverBody.html("<em class='text-danger'>"+result+".</em>");
                }
            });
        });
});

 
});
