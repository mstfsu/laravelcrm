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

    var csrf= $('meta[name="csrf-token"]').attr('content');
    var dtTicketTable = $('.user-ticket-table'),

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




    function  initTicketTable() {
        var table = dtTicketTable.dataTable({
            processing: true,
            serverSide: true,
            buttons: [
                {
                    text: 'Add New Ticket',
                    className: 'add-new btn btn-primary mt-50',
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config) {
                        $.ajax({
                            url: "/tickets/get_types",
                            data: {},
                            success: function (response) {
                                toastr['success']('Success! Type was loaded', {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });
                                $('#typeSelect').empty().trigger("change");
                                response.forEach(function (element) {
                                    var newOption = new Option(element.name, element.id, false, false);
                                    $('#typeSelect').append(newOption).trigger('change');
                                });
                                $('#typeSelect').val(null).trigger('change');

                            }
                        });
                        $('#createTicketModal').modal('show');
                    },
                }
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
                url: "/ISP/users/tickets",
                data  : {

                    id: $('#user_id').val()
                }
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,

                },
                {
                    data: 'subject',
                    name: 'subject',
                    orderable: true,


                },
                {
                    data: 'priority',
                    name: 'priority',
                    orderable: true,


                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,


                },

                {
                    data: 'group',
                    name: 'group',
                    orderable: true,


                },
                {
                    data: 'type',
                    name: 'type',
                    orderable: true,


                },
                {
                    data: 'assigned_to',
                    name: 'assigned_to',
                    orderable: true,


                },
                {
                    data: 'actions', width: "10%", render: function (data, type, row) {
                        var isReadAction = '<div>' +
                            '        <a title="Delete" href="javascript:void(0)" onclick="changeReadStatusOfTicket(' + row.id + ')" id="delete_user">' +
                            '            <span data-feather="eye-off"></span>' +
                            '        </a>' +
                            '        <div>';
                        if (row.is_readed == 0) {
                            isReadAction = '<div>' +
                                '        <a title="Delete" href="javascript:void(0)" onclick="changeReadStatusOfTicket(' + row.id + ')" id="delete_user">' +
                                '            <span data-feather="eye"></span>' +
                                '        </a>' +
                                '        <div>'
                        }
                        var myvar = '<div>' +
                            '        <a title="Remove" href="javascript:void(0)" onclick="closeTicket(' + row.id + ')" id="remove">' +
                            '            <span data-feather="x-circle"></span>' +
                            '        </a>' +
                            '        <a title="Remove" href="/tickets/'+row.id+'"  id="remove">' +
                            '            <span data-feather="book-open"></span>' +
                            '        </a>' +
                            '    </div>' + isReadAction;
                        return myvar;
                    }
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

    $("a[href='#tickettabe']").on('shown.bs.tab', function () {

        Metronic.blockUI({
            target: 'body',
            animate: false,
            boxed: true,
            message: "Loading"
        });
        dtTicketTable.DataTable().destroy()
        initTicketTable()
        Metronic.unblockUI('body');
    })

    function openDropdown(id) {
        if ($("#drop" + id + ".show").length == 1) {
            $('#drop' + id).removeClass("show");
        } else {
            $('.dropdown-menu').removeClass("show");
            $('#drop' + id).addClass("show");
        }
    }
    $('body').on('click','.priority',function(){

         var id=$(this).data('id');

        if ($("#drop" + id + ".show").length == 1) {
            $('#drop' + id).removeClass("show");
        } else {
            $('.dropdown-menu').removeClass("show");
            $('#drop' + id).addClass("show");
        }
    })

    $(document).ready(function(){
        $('body').on('click','.status',function(){

            var id=$(this).data('id');
             if ($("#status" + id + ".show").length == 1) {

                $('#status' + id).removeClass("show");
            } else {
                $('.dropdown-menu').removeClass("show");
                $('#status' + id).addClass("show");
            }
        })
        $('body').on('click','.type',function(){

            var id=$(this).data('id');
            if ($("#type" + id + ".show").length == 1) {

                $('#type' + id).removeClass("show");
            } else {
                $('.dropdown-menu').removeClass("show");
                $('#type' + id).addClass("show");
            }
        })
    });
    $('body').on('click','.priority_option',function(){

        var id=$(this).data('id');
        var priority=$(this).data('name')

        $.ajax({
            url: "/tickets/change_priority",
            data: {id: id, priority: priority},
            success: function (response) {
                dtTicketTable.DataTable().destroy();
                initTicketTable()
                toastr['success']('Success! Priority is changed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        });
    })

    $('body').on('click','.status_option',function(){

        var id=$(this).data('id');
        var status=$(this).data('name')

        $.ajax({
            url: "/tickets/change_status",
            data: {id: id, status: status},
            success: function (response) {
                toastr['success']('Success! Status is changed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                dtTicketTable.DataTable().destroy();
                initTicketTable()
            }
        });
    })
    $('body').on('click','.type_option',function(){

        var id=$(this).data('id');
        var type=$(this).data('name')

        $.ajax({
            url: "/tickets/change_type",
            data: {id: id, type: type},
            success: function (response) {
                toastr['success']('Success! Type is changed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                dtTicketTable.DataTable().destroy();
                initTicketTable()
            }
        });
    })

$('body').on('click','#change_read_status',function(){
    var id=$(this).data('id')
    $.ajax({
        url: "/tickets/change_read_status",
        data: {id: id},
        success: function (response) {
            if (response == 1) {
                toastr['success']('Success! Ticket is readed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            } else {
                toastr['success']('Success! Ticket is not readed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
            dtTicketTable.ajax.reload(null, false);
        }
    });
})

    $('body').on('click','#close_ticket',function(){
        var id=$(this).data('id')
        $.ajax({
            url: "/tickets/close_ticket",
            data: {id: id},
            success: function (response) {
                toastr['success']('Success! Ticket is closed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                dtTicketTable.ajax.reload(null, false);
            }
        });
    })






    $("#typeSelect").on("select2:select", function (e) {
        var typeId = $('#typeSelect').select2('data')[0].id;
        $.ajax({
            url: "/tickets/get_subjects",
            data: {id: typeId},
            success: function (response) {
                toastr['success']('Success! Subject was loaded', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                $('#subjectSelect').empty().trigger("change");
                response.forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#subjectSelect').append(newOption).trigger('change');
                });
                $('#subjectSelect').val(null).trigger('change');

            }
        });
    });

    var fullEditor = new Quill('#full-container .editor', {
        bounds: '#full-container .editor',
        modules: {
            formula: true,
            syntax: true,
            toolbar: [
                [{
                    font: []
                },
                    {
                        size: []
                    }
                ],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    color: []
                },
                    {
                        background: []
                    }
                ],
                [{
                    script: 'super'
                },
                    {
                        script: 'sub'
                    }
                ],
                [{
                    header: '1'
                },
                    {
                        header: '2'
                    },
                    'blockquote',
                    'code-block'
                ],
                [{
                    list: 'ordered'
                },
                    {
                        list: 'bullet'
                    },
                    {
                        indent: '-1'
                    },
                    {
                        indent: '+1'
                    }
                ],
                [
                    'direction',
                    {
                        align: []
                    }
                ],
                ['link', 'image', 'video', 'formula'],
                ['clean']
            ]
        },
        theme: 'snow'
    });


    $("#createForm").on("submit", function () {
        $("#content").val(fullEditor.root.innerHTML);
    })

    $('#createForm').validate({
        rules: {
            assigned_to: {
                required: true,
            },
            subject_id: {
                required: true,
            },
            type: {
                required: true,
            },
            customer_id: {
                required: true,
            },
            cc_recipients: {
                required: true,
            },
            group: {
                required: true,
            },
            message: {
                required: true,
            },
            watchers: {
                required: true,
            },
            status: {
                required: true,
            }

        }
    });
    // $("#createForm").on('submit', function (e) {
    //     var isValid = $("#createForm").valid();
    //     $("#content").val(fullEditor.root.innerHTML);
    //     var data = $("#createForm").serialize();
    //
    //     e.preventDefault();
    //     if (isValid) {
    //
    //
    //
    //             $.ajax({
    //                 dataType: 'json',
    //                 type: 'post',
    //
    //                 url: '/ISP/users/save_user_ticket',
    //
    //                 data:  data,
    //                 contentType: 'application/json; charset=utf-8',
    //                 headers: {
    //                     'X-CSRF-TOKEN': csrf
    //                 },
    //                 success: OnSuccess,
    //                 error: OnError
    //             })
    //
    //             function OnSuccess(data) {
    //
    //                 if (data.success == 'true') {
    //                     toastr["success"](data.msg);
    //                     dtTicketTable.DataTable().destroy();
    //                     initTicketTable();
    //                 } else {
    //
    //                     toastr["error"]("ERROR ! Please Try Again Later");
    //                 }
    //
    //             }
    //
    //             function OnError(data) {
    //
    //                 if (data.success == 'true') {
    //                     toastr["success"](data.msg);
    //                     dtTicketTable.DataTable().destroy();
    //                     initTicketTable();
    //                 } else {
    //
    //                     toastr["error"]("ERROR ! Please Try Again Later");
    //                 }
    //
    //             }
    //
    //     }
    //
    //
    // });


 
});
