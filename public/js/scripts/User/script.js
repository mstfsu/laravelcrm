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
    var csrf=$('#csrf').val();
    var dtAdminsTable = $('.admin-list-table'),

        passwordform = $('#changepasswordform'),
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

    if (passwordform.length) {
        passwordform.validate({
            errorClass: 'error',
            rules: {
                password: {
                    required: true
                },
                'confirm_password': {
                    required: true,
                    equalTo: '#password'
                },

            }
        });

        passwordform.on('submit', function (e) {
            var isValid = passwordform.valid();
            var id=$('#admin_id').val()
            var password=$('#password').val()
            alert(password)
             if(isValid){
                 $.ajax({
                     url: "/Admin/changeAdminPassword",
                     method: "get",
                     headers: {
                         'X-CSRF-TOKEN': csrf
                     },
                     data: {id:id,password:password},
                     dataType: "json",

                     success: function (res) {
                         if(res.success=='true')
                         { toastr["success"]( res.msg);
                         }
                         else{

                             toastr["error"]("ERROR ! Please Try Again Later");
                         }

                     },
                     error: function (res) {
                         if(res.success=='true')
                         { toastr["success"]( res.msg);
                         }
                         else{

                             toastr["error"]("ERROR ! Please Try Again Later");
                         }

                     }
                 });
             }

            e.preventDefault();



        });
    }


    function  initAdminTable() {
        var table = dtAdminsTable.dataTable({
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

            // Buttons with Dropdown
            buttons: [
                {
                    text: 'Add New Admin',
                    className: 'add-new btn btn-primary mt-50',
                    attr: {
                        id: 'add_modal',
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config)
                    {
                        //This will send the page to the location specified
                        window.location.href = '/Admin/add';
                    },
                }
            ],
            ajax: {
                url: "/Admin/admin_list",

            },
            columns: [
                {
                    data: 'id',
                    name: 'id',


                },
                {
                    data: 'name',
                    name: 'name',


                },
                {
                    data: 'email',
                    name: 'email',


                },
                {
                    data: 'role',
                    name: 'role',


                },
                {
                    data: 'company',
                    name: 'company',


                },
                {
                    data: 'created_at',
                    name: 'created_at',


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
            }
        });
    }
    initAdminTable()

    $('body').on('click', '#change_pass', function () {
        var id=$(this).data('id')
       $('#admin_id').val(id);
        $('#changepasswordmodal').modal('show');


    });

    $('body').on('click', '#delete_admin', function () {
        var id=$(this).data('id')
        areyousure(id)


    });


    function areyousure(id){

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
                delete_function(id)
            }
            else
                return "false";
        });



    }


    function delete_function(id) {
        Metronic.blockUI({
            target: dtAdminsTable,
            animate: false,
            boxed: true,
            message: "Loading"
        });

        $.ajax({
            url: "/Admin/delete",
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
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    dtAdminsTable.DataTable().destroy();
                    initAdminTable()
                    Metronic.unblockUI(dtAdminsTable);
                } else {   Metronic.unblockUI(dtAdminsTable);
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }
            },
            error: function (res) {
                Metronic.unblockUI(dtAdminsTable);
                toastr['error']('👋 Please Try Again Later.', 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });

            }
        });
    }
});
