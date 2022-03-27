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
    var dtdeletedusers = $('.deleted-user-list-table'),

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




    function  initdeletedusersTable() {
        var table = dtdeletedusers.dataTable({
            processing: true,
            serverSide: true,
            buttons: [

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
                url: "/ISPUsers/get_deleted_users",


            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,

                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,


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
                    data: 'phone',
                    name: 'phone',
                    orderable: true,


                },
                {
                    data: 'address',
                    name: 'address',
                    orderable: true,


                },
                {
                    data: 'plan',
                    name: 'profiles.srvname',
                    orderable: true,


                },
                {
                    data: 'owner',
                    name: 'owner',
                    orderable: true,


                },


                {
                    data: 'expiration',
                    name: 'expiration',
                    orderable: true,


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








    initdeletedusersTable()







    $('#checkall').change(function(){

        if($(this).is(':checked')){
            $('.usercheckbox').prop('checked', true);
        }else{
            $('.usercheckbox').prop('checked', false);
        }
    });

$('body').on('click','#restore_customer',function(){
    var id =$(this).data('id');
    areyousure(id)



})
    function  restorefunction(id){
        $.ajax({
            url: "/ISPUsers/restore_customer",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"JSON",
            data: {id: id},
            success: function (res) {
                if (res.success == "true") {
                    toastr['success']( res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                    dtdeletedusers.dataTable().destroy();
                    initdeletedusersTable();

                } else {
                    toastr['error'](  res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }



            },
            error: function (res) {
                if (res.success == "true") {
                    toastr['success']( res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                    dtdeletedusers.dataTable().destroy();
                    initdeletedusersTable();

                } else {
                    toastr['error'](  res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }




            }
        });
    }

    function areyousure(id){

        Swal.fire({
            title: 'Are you sure? ',
            text: "You want to restore this user!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Restore it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                restorefunction(id)
            }
            else
                return "false";
        });



    }

    $('body').on('click',"#restore_customer_bulk",function(){

        Metronic.blockUI({
            target: dtdeletedusers,
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
            var confirmdelete = confirm("Do you really want to Restore Selected Users?");
            if (confirmdelete == true) {
                $.ajax({
                    url: '/ISPUsers/restore_bulk',
                    type: 'post',
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {deleteids_arr: deleteids_arr},
                    success: function(res){
                        toastr['success']('👋 '+ res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtdeletedusers.DataTable().destroy();
                        initdeletedusersTable()

                        Metronic.unblockUI(dtdeletedusers);
                    },
                    error:function(res){
                        toastr['error'](  res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtdeletedusers.DataTable().destroy();
                        initdeletedusersTable()

                        Metronic.unblockUI(dtdeletedusers);
                    }

                });
            }
            else{
                Metronic.unblockUI(dtUserTable);
            }
        }
        else{
            Metronic.unblockUI(dtUserTable);
        }
    });

 
});
