/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
var dtTicketTable = $('#ticket-datatable'),
    newUserSidebar = $('.new-gallery-modal');
var inProgressTickets= $('#inprogress-ticket-datatable');
var closedTicketTable=$('#closed-ticket-datatable');
var typeId;
var ticketIdForType;
var unassignedDatatable;
$(function () {
    'use strict';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.aas', function (e) {
        e.preventDefault();
        $(e.target).find('.dropdown-menu').toggle();
    });



    if (dtTicketTable.length) {
        dtTicketTable = dtTicketTable.DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            stateSave: false,
            destroy:true,
            cache: false,


            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            ajax: {
                url: '/tickets/index_data',
                dataType: "json",
            },
            columns: [
                {data: 'id', width: "5%"},
                {
                    data: 'subject', width: "10%"
                    , render: function (data,type,row) {
                        let url = "/tickets/" + row.id;
                        let output = "<a href=" + url + "><span  style='color:#5DADE2;font-weight:bold' " + ">" + data.name + "</span></a>";
                        return output;
                    }
                },
                {
                    data: 'customer', width: "10%", render: function (data) {
                        let url = "/ISP/userview/" + data;
                        let output = "<a href=" + url + "><span  style='color:#2874A6;font-weight:bold' " + ">" + data + "</span></a>";
                        return output;
                    }
                },
                {
                    data: 'priority', width: "15%", render: function (data, type, row, meta) {
                        var priorities = dtTicketTable.ajax.json().priorities;
                        var options = "";
                        for (var i = 0; i < priorities.length; i++) {
                            var name = "'" + priorities[i].id + "'" + "," + row.id;
                            options += '<a class="dropdown-item" onclick="changePriority(' + name + ')"' + '><span class="badge badge-' + priorities[i].color + '">' + priorities[i].name + '</span></a>';
                        }
                        var myvar = '<div class="btn-group">' +
                            '    <button type="button" onclick="openDropdown(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                            data.name +
                            '    </button>' +
                            '    <div id="drop' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                            options +
                            '    </div>' +
                            '</div>';

                        return myvar;
                    }
                },
                {
                    data: 'status', width: "15%", render: function (data, type, row, meta) {
                        var status = dtTicketTable.ajax.json().status;
                        var options = "";
                        for (var i = 0; i < status.length; i++) {
                            var name = "'" + status[i].id + "'" + "," + row.id;
                            options += '<a class="dropdown-item" onclick="changeStatus(' + name + ')"' + '><span class="badge badge-' + status[i].color + '">' + status[i].name + '</span></a>';

                        }
                        var myvar = '<div class="btn-group">' +
                            '    <button type="button" onclick="openStatusDropdown(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                            data.name +
                            '    </button>' +
                            '    <div id="status' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                            options +
                            '    </div>' +
                            '</div>';

                        return myvar;
                    }
                },
                {
                    data: 'group', width: "10%"},
                {
                    data: 'type', width: "20%", render: function (data, type, row, meta) {
                        var types = dtTicketTable.ajax.json().types;
                        var options = "";
                        for (var i = 0; i < types.length; i++) {
                            var name = "'" + types[i].id + "'" + "," + row.id;
                            options += '<a class="dropdown-item" onclick="changeType(' + name + ')"' + '><span class="badge badge-' + types[i].color + '">' + types[i].name + '</span></a>';
                        }
                        var myvar = '<div class="btn-group">' +
                            '    <button type="button" onclick="openTypeDropdown(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                            data.name +
                            '    </button>' +
                            '    <div id="type' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                            options +
                            '    </div>' +
                            '</div>';

                        return myvar;
                    }
                },
                {
                    data: 'assigned_user', width: "5%", render: function (data) {
                        if(data==null){
                            return '<span  class="badge badge-danger">Unassigned</span>';
                        }else{
                            return '<span  class="badge badge-success">' + data.name + '</span>';

                        }
                    }
                },
                {
                    data: 'actions', width: "10%"}
            ],
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
                                // $('#typeSelect').empty().trigger("change");
                                // response['types'].forEach(function (element) {
                                //     var newOption = new Option(element.name, element.id, false, false);
                                //     $('#typeSelect').append(newOption).trigger('change');
                                // });
                                // $('#typeSelect').val(null).trigger('change');

                                $('#subjectSelect').empty().trigger("change");
                                response['subjects'].forEach(function (element) {
                                    var newOption = new Option(element.name, element.id, false, false);
                                    $('#subjectSelect').append(newOption).trigger('change');
                                });
                                $('#subjectSelect').val(null).trigger('change');


                                $('#group').empty().trigger("change");
                                response['groups'].forEach(function (element) {
                                    var newOption = new Option(element.name, element.id, false, false);
                                    $('#group').append(newOption).trigger('change');
                                });
                                $('#group').val(null).trigger('change');

                                //$('#assigned_to').empty().trigger("change");
                                //$('#watchers').empty().trigger("change");
                                //var newOption = new Option("Auto Assign", 0, true, true);
                                //$('#assigned_to').append(newOption).trigger('change');
                                // response['adminUsers'].forEach(function (element) {
                                //     var newOption = new Option(element.name, element.id, false, false);
                                //     $('#assigned_to').append(newOption).trigger('change');
                                // });

                                // response['adminUsers'].forEach(function (element) {
                                //     var newOption = new Option(element.name, element.id, false, false);
                                //     $('#watchers').append(newOption).trigger('change');
                                // });
                                //$('#assigned_to').val(null).trigger('change');
                                //$('#watchers').val(null).trigger('change');

                            }
                        });
                        $('#createTicketModal').modal('show');
                    },
                }
            ],
            drawCallback: function (settings,json) {
                feather.replace();
                $('#ticketsText').text(settings.json.count);

            },
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
        });
    }

    if(inProgressTickets.length){
        inProgressTickets = inProgressTickets.DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            stateSave: false,
            destroy:true,
            cache: false,


            dom:
            '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
            '<"col-lg-12 col-xl-6" l>' +
            '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
            '>t' +
            '<"d-flex justify-content-between mx-2 row mb-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        ajax: {
            url: '/tickets/inprogress_index_data',
            dataType: "json",
        },
        columns: [
            {data: 'id', width: "5%"},
            {
                data: 'subject', width: "10%"
                , render: function (data,type,row) {
                    let url = "/tickets/" + row.id;
                    let output = "<a href=" + url + "><span  style='color:#5DADE2;font-weight:bold' " + ">" + data.name + "</span></a>";
                    return output;
                }
            },
            {
                data: 'customer', width: "10%", render: function (data) {
                    let url = "/ISP/userview/" + data;
                    let output = "<a href=" + url + "><span  style='color:#2874A6;font-weight:bold' " + ">" + data + "</span></a>";
                    return output;
                }
            },
            {
                data: 'priority', width: "15%", render: function (data, type, row, meta) {
                    var priorities = inProgressTickets.ajax.json().priorities;
                    var options = "";
                    for (var i = 0; i < priorities.length; i++) {
                        var name = "'" + priorities[i].id + "'" + "," + row.id;
                        options += '<a class="dropdown-item" onclick="changePriority(' + name + ')"' + '><span class="badge badge-' + priorities[i].color + '">' + priorities[i].name + '</span></a>';
                    }
                    var myvar = '<div class="btn-group">' +
                        '    <button type="button" onclick="openDropdownIn(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                        data.name +
                        '    </button>' +
                        '    <div id="dropin' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                        options +
                        '    </div>' +
                        '</div>';

                    return myvar;
                }
            },
            {
                data: 'status', width: "15%", render: function (data, type, row, meta) {
                    var status = inProgressTickets.ajax.json().status;
                    var options = "";
                    for (var i = 0; i < status.length; i++) {
                        var name = "'" + status[i].id + "'" + "," + row.id;
                        options += '<a class="dropdown-item" onclick="changeStatus(' + name + ')"' + '><span class="badge badge-' + status[i].color + '">' + status[i].name + '</span></a>';

                    }
                    var myvar = '<div class="btn-group">' +
                        '    <button type="button" onclick="openStatusDropdown(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                        data.name +
                        '    </button>' +
                        '    <div id="status' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                        options +
                        '    </div>' +
                        '</div>';

                    return myvar;
                }
            },
            {
                data: 'group', width: "10%"},
            {
                data: 'type', width: "20%", render: function (data, type, row, meta) {
                    var types = inProgressTickets.ajax.json().types;
                    var options = "";
                    for (var i = 0; i < types.length; i++) {
                        var name = "'" + types[i].id + "'" + "," + row.id;
                        options += '<a class="dropdown-item" onclick="changeType(' + name + ')"' + '><span class="badge badge-' + types[i].color + '">' + types[i].name + '</span></a>';
                    }
                    var myvar = '<div class="btn-group">' +
                        '    <button type="button" onclick="openTypeDropdownIn(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                        data.name +
                        '    </button>' +
                        '    <div id="typein' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                        options +
                        '    </div>' +
                        '</div>';

                    return myvar;
                }
            },
            {
                data: 'assigned_user', width: "5%", render: function (data) {
                    if(data==null){
                        return '<span  class="badge badge-danger">Unassigned</span>';
                    }else{
                        return '<span  class="badge badge-success">' + data.name + '</span>';

                    }
                }
            },
            {
                data: 'actions', width: "10%"}
        ],
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
                            // $('#typeSelect').empty().trigger("change");
                            // response['types'].forEach(function (element) {
                            //     var newOption = new Option(element.name, element.id, false, false);
                            //     $('#typeSelect').append(newOption).trigger('change');
                            // });
                            // $('#typeSelect').val(null).trigger('change');

                            $('#subjectSelect').empty().trigger("change");
                            response['subjects'].forEach(function (element) {
                                var newOption = new Option(element.name, element.id, false, false);
                                $('#subjectSelect').append(newOption).trigger('change');
                            });
                            $('#subjectSelect').val(null).trigger('change');


                            $('#group').empty().trigger("change");
                            response['groups'].forEach(function (element) {
                                var newOption = new Option(element.name, element.id, false, false);
                                $('#group').append(newOption).trigger('change');
                            });
                            $('#group').val(null).trigger('change');

                            // $('#assigned_to').empty().trigger("change");
                            // $('#watchers').empty().trigger("change");
                            // var newOption = new Option("Auto Assign", 0, true, true);
                            // $('#assigned_to').append(newOption).trigger('change');
                            // response['adminUsers'].forEach(function (element) {
                            //     var newOption = new Option(element.name, element.id, false, false);
                            //     $('#assigned_to').append(newOption).trigger('change');
                            // });

                            // response['adminUsers'].forEach(function (element) {
                            //     var newOption = new Option(element.name, element.id, false, false);
                            //     $('#watchers').append(newOption).trigger('change');
                            // });
                            //$('#assigned_to').val(null).trigger('change');
                            //$('#watchers').val(null).trigger('change');

                        }
                    });
                    $('#createTicketModal').modal('show');
                },
            }
        ],
        drawCallback: function (settings) {
            feather.replace();
            $('#progressText').text(settings.json.count);
            },
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },
    });

    }

    if(closedTicketTable.length){
        if ( ! $.fn.DataTable.isDataTable( '#closed-ticket-datatable' ) ) {
            closedTicketTable= $('#closed-ticket-datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: false,

                dom:
                    '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                    '<"col-lg-12 col-xl-6" l>' +
                    '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                ajax: {
                    url: '/tickets/closed',
                    data: {data: 'getTicketData'}
                }, // JSON file to add data

                columns: [
                    {data: 'id'},
                    {data: 'subject', render: function (data,type,row) {
                            let url = "/tickets/" + row.id;
                            let output = "<a href=" + url + "><span  style='color:#5DADE2;font-weight:bold' " + ">" + data.name + "</span></a>";
                            return output;
                        }},
                    {data: 'customer'},
                    {
                        data: 'priority', render: function (data) {
                            return '<span  class="badge badge-' + data.color + '">' + data.name + '</span>';
                        }
                    },
                    {
                        data: 'status', render: function (data) {
                            return '<span  class="badge badge-' + data.color + '">' + data.name + '</span>';
                        }
                    },
                    {
                        data: 'group', width: "10%", render: function (data) {
                            return data.name;
                        }
                    },
                    {
                        data: 'type', render: function (data) {
                            return '<span  class="badge badge-' + data.color + '">' + data.name + '</span>';
                        }
                    },
                    {
                        data: 'actions', render: function (data, type, row) {

                            var myvar = '<a title="Remove Ticket" onclick="deleteTicket(' + row.id + ')" href="javascript:void(0)" data-username="{{$data->username}}">' +
                                '        <span data-feather="x-circle"></span>' +
                                '    </a>' +
                                '    <a title="Re-open Ticket" onclick="openTicket(' + row.id + ')" href="javascript:void(0)" data-username="{{$data->username}}">' +
                                '        <span data-feather="corner-down-left"></span>' +
                                '    </a>';

                            return myvar;
                        }
                    }
                ],
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
                                    // $('#typeSelect').empty().trigger("change");
                                    // response['types'].forEach(function (element) {
                                    //     var newOption = new Option(element.name, element.id, false, false);
                                    //     $('#typeSelect').append(newOption).trigger('change');
                                    // });
                                    // $('#typeSelect').val(null).trigger('change');

                                    $('#subjectSelect').empty().trigger("change");
                                    response['subjects'].forEach(function (element) {
                                        var newOption = new Option(element.name, element.id, false, false);
                                        $('#subjectSelect').append(newOption).trigger('change');
                                    });
                                    $('#subjectSelect').val(null).trigger('change');
    
                                    $('#group').empty().trigger("change");
                                    response['groups'].forEach(function (element) {
                                        var newOption = new Option(element.name, element.id, false, false);
                                        $('#group').append(newOption).trigger('change');
                                    });
                                    $('#group').val(null).trigger('change');
    
                                    // $('#assigned_to').empty().trigger("change");
                                    // $('#watchers').empty().trigger("change");
                                    // var newOption = new Option("Auto Assign", 0, true, true);
                                    // $('#assigned_to').append(newOption).trigger('change');
                                    // response['adminUsers'].forEach(function (element) {
                                    //     var newOption = new Option(element.name, element.id, false, false);
                                    //     $('#assigned_to').append(newOption).trigger('change');
                                    // });
    
                                    // response['adminUsers'].forEach(function (element) {
                                    //     var newOption = new Option(element.name, element.id, false, false);
                                    //     $('#watchers').append(newOption).trigger('change');
                                    // });
                                    // $('#assigned_to').val(null).trigger('change');
                                    // $('#watchers').val(null).trigger('change');
    
                                }
                            });
                            $('#createTicketModal').modal('show');
                        },
                    }
                ],
                drawCallback: function (settings) {
                    feather.replace();
                    $('#closedText').text(settings.json.count);

                },
                language: {
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                },
            });
        }
    }

    if ($('#unassigned-ticket-datatable').length){
         unassignedDatatable =    $('#unassigned-ticket-datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            stateSave: false,
            destroy:true,

            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            ajax: {
                url: '/tickets/unassigned_ticket',
                dataType: "json",
            },
            columns: [
                {data: 'id', width: "5%"},
                {
                    data: 'subject', width: "10%"
                    , render: function (data,type,row) {
                        let url = "/tickets/" + row.id;
                        let output = "<a href=" + url + "><span  style='color:#5DADE2;font-weight:bold' " + ">" + data.name + "</span></a>";
                        return output;
                    }
                },
                {
                    data: 'customer', width: "10%", render: function (data) {
                        let url = "/ISP/userview/" + data;
                        let output = "<a href=" + url + "><span  style='color:#2874A6;font-weight:bold' " + ">" + data + "</span></a>";
                        return output;
                    }
                },
                {
                    data: 'priority', width: "15%", render: function (data, type, row, meta) {
                        var priorities = unassignedDatatable.ajax.json().priorities;
                        var options = "";
                        for (var i = 0; i < priorities.length; i++) {
                            var name = "'" + priorities[i].id + "'" + "," + row.id;
                            options += '<a class="dropdown-item" onclick="changePriority(' + name + ')"' + '><span class="badge badge-' + priorities[i].color + '">' + priorities[i].name + '</span></a>';
                        }
                        var myvar = '<div class="btn-group">' +
                            '    <button type="button" onclick="openDropdownUnAssigned(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                            data.name +
                            '    </button>' +
                            '    <div id="dropUnAssigned' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                            options +
                            '    </div>' +
                            '</div>';

                        return myvar;
                    }
                },
                {
                    data: 'status', width: "15%", render: function (data, type, row, meta) {
                        var status = unassignedDatatable.ajax.json().status;
                        var options = "";
                        for (var i = 0; i < status.length; i++) {
                            var name = "'" + status[i].id + "'" + "," + row.id;
                            options += '<a class="dropdown-item" onclick="changeStatus(' + name + ')"' + '><span class="badge badge-' + status[i].color + '">' + status[i].name + '</span></a>';

                        }
                        var myvar = '<div class="btn-group">' +
                            '    <button type="button" onclick="openUnassignedStatusDropdown(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                            data.name +
                            '    </button>' +
                            '    <div id="unassignedstatus' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                            options +
                            '    </div>' +
                            '</div>';

                        return myvar;
                    }
                },
                {
                    data: 'group', width: "10%"},
                {
                    data: 'type', width: "20%", render: function (data, type, row, meta) {
                        var types = unassignedDatatable.ajax.json().types;
                        var options = "";
                        for (var i = 0; i < types.length; i++) {
                            var name = "'" + types[i].id + "'" + "," + row.id;
                            options += '<a class="dropdown-item" onclick="changeType(' + name + ')"' + '><span class="badge badge-' + types[i].color + '">' + types[i].name + '</span></a>';
                        }
                        var myvar = '<div class="btn-group">' +
                            '    <button type="button" onclick="openUnassigedTypeDropdown(' + row.id + ')" class="btn btn-outline-' + data.color + ' dropdown-toggle waves-effect show" data-bs-toggle="dropdown" aria-expanded="true">' +
                            data.name +
                            '    </button>' +
                            '    <div id="unassignedtype' + row.id + '" class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-start">' +
                            options +
                            '    </div>' +
                            '</div>';

                        return myvar;
                    }
                },
                {
                    data: 'assigned_user', width: "5%", render: function (data) {
                        if(data==null){
                            return '<span  class="badge badge-danger">Unassigned</span>';
                        }else{
                            return '<span  class="badge badge-success">' + data.name + '</span>';

                        }
                    }
                },
                {
                    data: 'actions', width: "10%"}
            ],
            buttons: [
            ],
            drawCallback: function (settings) {
                feather.replace();
                $('#unassignedText').text(settings.json.count);
            },
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
        });

    }
});
function closedTickets(){
    closedTicketTable.ajax.reload(null, false);

}
function showAutoAssignRules(){
    $('#deneme').modal('show');
    $("#createTicketModal").css("z-index", "1045");
    $("#deneme").css("z-index", "1052");

}

function progress(){
    inProgressTickets.ajax.reload(null, false);

}
function changeReadStatusOfTicket(id) {
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
            updateAllDatatables();
        }
    });
}

function closeTicket(id) {
    $.ajax({
        url: "/tickets/close_ticket",
        data: {id: id},
        success: function (response) {
            if(response=="true"){
                toastr['success']('Success! Ticket is closed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                dtTicketTable.ajax.reload(null, false);
                inProgressTickets.ajax.reload(null, false);

            }else{
                toastr['error'](response, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }

        }
    });
}

function openDropdown(id) {
    if ($("#drop" + id + ".show").length == 1) {
        $('#drop' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#drop' + id).addClass("show");
    }
}
function openDropdownIn(id) {
    if ($("#dropin" + id + ".show").length == 1) {
        $('#dropin' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#dropin' + id).addClass("show");
    }
}
function openDropdownUnAssigned(id) {
    if ($("#dropUnAssigned" + id + ".show").length == 1) {
        $('#dropUnAssigned' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#dropUnAssigned' + id).addClass("show");
    }
}

function openStatusDropdown(id) {
    if ($("#status" + id + ".show").length == 1) {
        $('#status' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#status' + id).addClass("show");
    }
}
function openUnassignedStatusDropdown(id) {
    console.log(id);
    if ($("#unassignedstatus" + id + ".show").length == 1) {
        $('#unassignedstatus' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#unassignedstatus' + id).addClass("show");
    }
}
function changePriority(priority, id) {
    $('#preLoader').removeAttr('hidden');
    $.ajax({
        url: "/tickets/change_priority",
        data: {id: id, priority: priority},
        success: function (response) {
            closedTicketTable.ajax.reload(null, false);
            dtTicketTable.ajax.reload(null, false);
            inProgressTickets.ajax.reload(null, false);
            unassignedDatatable.ajax.reload(null, false);

            toastr['success']('Success! Priority is changed', {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    });
}
function updateAllDatatables(){
    if(unassignedDatatable instanceof $.fn.dataTable.Api){
        unassignedDatatable.ajax.reload(null, false);
    }
    if(inProgressTickets instanceof $.fn.dataTable.Api){
        inProgressTickets.ajax.reload(null, false);
    }
    if(closedTicketTable instanceof $.fn.dataTable.Api){
        closedTicketTable.ajax.reload(null, false);
    }
    if(dtTicketTable instanceof $.fn.dataTable.Api){
        dtTicketTable.ajax.reload(null, false);
    }
}

function changeStatus(status, id) {
    $.ajax({
        url: "/tickets/change_status",
        data: {id: id, status: status},
        success: function (response) {

            if (response=="true"){
                updateAllDatatables();
                toastr['success']('Success! Status is changed', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }else{
                toastr['error'](response, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }

        }
    });
}

function openTypeDropdown(id) {
    if ($("#type" + id + ".show").length == 1) {
        $('#type' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#type' + id).addClass("show");
    }
}
function openTypeDropdownIn(id) {
    if ($("#typein" + id + ".show").length == 1) {
        $('#typein' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#typein' + id).addClass("show");
    }
}
function openUnassigedTypeDropdown(id) {
    if ($("#unassignedtype" + id + ".show").length == 1) {
        $('#unassignedtype' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#unassignedtype' + id).addClass("show");
    }
}
function changeType(type, id) {
    $('#getSubjectsOfType').modal('show');
    $.ajax({
        url: "/tickets/subjects_of_type",
        data: {type_id: type},
        success: function (response) {
            $('#subjectsOfType').empty().trigger("change");
            response.forEach(function (element) {
                var newOption = new Option(element.name, element.id, false, false);
                $('#subjectsOfType').append(newOption).trigger('change');
            });
            $('#subjectsOfType').val(null).trigger('change');  
            typeId= type;    
            ticketIdForType=id;
        }
    });
    

    // $.ajax({
    //     url: "/tickets/change_type",
    //     data: {id: id, type: type},
    //     success: function (response) {

    //         dtTicketTable.ajax.reload();
    //         inProgressTickets.ajax.reload();
    //         inProgressTickets.ajax.reload(null, false);
    //         unassignedDatatable.ajax.reload(null, false);
    //         toastr['success']('Success! Type is changed', {
    //             closeButton: true,
    //             tapToDismiss: false,
    //         });
    //     }
    // });
}

function saveRespondTimeInfo(id) {
    var timeType = $('#respondselect' + id).val();
    var resolveTimeType = $('#resolveselect' + id).val();
    var timeValue = $('#respondTimeValue' + id).val();
    var resolveTimeValue = $('#resolveTimeValue' + id).val();
    var email = $('#email' + id).val();
    var sms = $('#sms' + id).val();
    $.ajax({
        url: "/tickets/change_priority_values",
        data: {
            id: id,
            sms: sms,
            email: email,
            respond_within_time_type: timeType,
            respond_within_time_value: timeValue,
            resolve_within_time_type: resolveTimeType,
            resolve_within_time_value: resolveTimeValue
        },
        success: function (response) {
            toastr['success']('Success! Priority values changed', {
                closeButton: true,
                tapToDismiss: false,
            });
            $('#respondselect' + id).val(timeType).trigger('change');
            $('#resolveselect' + id).val(resolveTimeType).trigger('change');
        }
    });

}

function addType() {
    var typeValue = $("#typeValue").val();
    var typeColor = $('#typeColor').select2('data')[0].id;
    $.ajax({
        url: "/tickets/add_type",
        data: {name: typeValue, color: typeColor},
        success: function (response) {
            toastr['success']('Success! Type is created', {
                closeButton: true,
                tapToDismiss: false,
            });
            var myvar = '<tr id="type' + response.id + '">' +
                '                                                        <td>' +
                '                                                            <span class="fw-bold">' + response.name + '</span>' +
                '                                                        </td>' +
                '                                                        <td>' +
                '                                                        <ul class="list-group list-group-flush"' +
                '                                                            id="subjectUl' + response.id + '">' +
                '                                                        </ul>' +
                '                                                        <a class="float-right" href="javascript:void(0)"' +
                '                                                           onclick="showAddSubjectModal(' + response.id + ')"><span' +
                '                                                                    data-feather="plus"></span></a>'
                + '                                                                                                    </td>' +
                '                                                        <td>' +
                '                                                           <button id="yes' + response.id + '"' +
                '                                                                    hidden type="button"' +
                '                                                                    onclick="changeOthers(' + response.id + ')"' +
                '                                                                    class="btn btn-flat-success waves-effect">Yes' +
                '                                                            </button>' +
                '                                                            <button id="no' + response.id + '"' +
                '                                                                    type="button"' +
                '                                                                    onclick="changeOthers(' + response.id + ')"' +
                '                                                                    class="btn btn-flat-danger waves-effect">No' +
                '                                                            </button>' +
                '                                                        </td>' +
                '                                                        <td>' +
                '                                                           <button id="yesVisible' + response.id + '"' +
                '                                                                    hidden type="button"' +
                '                                                                    onclick="changeOnlyVisible(' + response.id + ')"' +
                '                                                                    class="btn btn-flat-success waves-effect">Yes' +
                '                                                            </button>' +
                '                                                            <button id="noVisible' + response.id + '"' +
                '                                                                    type="button"' +
                '                                                                    onclick="changeOnlyVisible(' + response.id + ')"' +
                '                                                                    class="btn btn-flat-danger waves-effect">No' +
                '                                                            </button>'
                +
                '                                                        </td>' +
                '                                                        <td>' +
                '                                                            <button onclick="removeType(' + response.id + ')" type="button" class="btn btn-outline-danger btn-sm text-center round waves-effect">Remove</button>' +
                '                                                        </td>' +
                '                                                    </tr>';


            $('#tableBody').append(myvar);
            $('#addTypeModal').modal('hide');
            feather.replace();

        }
    });
}

function deleteSubject(id) {
    $.ajax({
        url: "/tickets/delete_subject",
        data: {id: id},
        success: function (response) {
            if(response=="true"){
                toastr['success']('Success! Subject is deleted', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                $('#subject' + id).remove();
            }else{
                toastr['error'](response, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        }
    });
}



function showAddSubjectModal(id) {
    $('#idType').val(id);
    $('#addSubjectModal').modal('show');
}

function addSubject() {
    var priority = $('#priority_id').select2('data');
    $('#typeSelect').val(null).trigger('change');

    $.ajax({
        url: "/tickets/add_subject",
        data: {type_id: $('#idType').val(), priority_id: $('#priority_id').val(), name: $('#subjectName').val()},
        success: function (response) {
            toastr['success']('Success! Subject is deleted', {
                closeButton: true,
                tapToDismiss: false,
            });
            var myvar = '<li id="subject' + response.id + '" class="list-group-item">' + response.name +
                '                                                                        (<span class="text-info">' + priority[0].text + '</span>)' +
                '                                                                        <a href="javascript:void(0)"' +
                '                                                                           onclick="deleteSubject(' + response.id + ')"><span' +
                '                                                                                    data-feather="trash"></span></a>' +
                '                                                                    </li>';
            $('#subjectUl' + $('#idType').val()).append(myvar);
            feather.replace();

            $('#addSubjectModal').modal('hide');
        }
    });
}

function changeOthers(id) {
    var others = 0;
    if ($('#yes' + id).is(":hidden")) {
        others = 1;
    }
    $.ajax({
        url: "/tickets/change_others",
        data: {id: id, others: others},
        success: function () {
            toastr['success']('Success! Others is changed', {
                closeButton: true,
                tapToDismiss: false,
            });
            if (others == 0) {
                $('#yes' + id).attr('hidden', true);
                $('#no' + id).removeAttr('hidden');
            } else {
                $('#no' + id).attr('hidden', true);
                $('#yes' + id).removeAttr('hidden');
            }
        }
    });
}

function changeOnlyVisible(id) {
    var only_visible = 0;
    if ($('#yesVisible' + id).is(":hidden")) {
        only_visible = 1;
    }
    $.ajax({
        url: "/tickets/change_only_visible",
        data: {id: id, only_visible: only_visible},
        success: function () {
            toastr['success']('Success! Only Visible For Admin is changed', {
                closeButton: true,
                tapToDismiss: false,
            });
            if (only_visible == 0) {
                $('#yesVisible' + id).attr('hidden', true);
                $('#noVisible' + id).removeAttr('hidden');
            } else {
                $('#noVisible' + id).attr('hidden', true);
                $('#yesVisible' + id).removeAttr('hidden');
            }
        }
    });
}

function saveReopenSettings() {
    $.ajax({
        url: "/tickets/save_reopen_settings",
        data: {reOpenTime: $('#reOpenTimeValue').val(), reOpenTimeType: $('#reOpenSelect').select2('data')[0].id},
        success: function () {
            toastr['success']('Success! ReOpen settings is saved', {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    });
}

function saveOpenTicketsNumber() {
    $.ajax({
        url: "/tickets/save_open_ticket_limit_settings",
        data: {openTicketLimit: $('#openTicketsNumber').val()},
        success: function () {
            toastr['success']('Success! Open Ticket Limit settings is saved', {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    });
}

function useTimeBasedSettings() {
    $.ajax({
        url: "/tickets/use_time_based",
        data: {useTimeBased: $('#useTimeBased').prop('checked')},
        success: function (response) {
            if (response=="false"){
                toastr['error']("Error! Some Admins don't have work hours value, please firstly set work hours of all admins", {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }else{
                toastr['success']('Success! Use Time Based settings is saved', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }

        }
    });
}

function saveAutomaticAdminAssign() {
    $.ajax({
        url: "/tickets/automatic_admin_assign",
        data: {automaticAdminAssign: $('#automaticAdminAssign').val()},
        success: function () {
            toastr['success']('Success! Use Time Based settings is saved', {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    });
}

function ticketsTab() {
    dtTicketTable.ajax.reload(null, false);
}

function getAdminClassificationGroup(name) {
    if (typeof name === "undefined") {
        $('#adminClassificationModal').modal('show');
    } else {
        $('#adminUnassignedClassificationModal').modal('show');
    }
    $.ajax({
        url: "/tickets/get_admin_classification",
        data: {},
        success: function (response) {
            toastr['success']('Success! Admin Classification Group and Level was get', {
                closeButton: true,
                tapToDismiss: false,
            });
            if (typeof name === "undefined") {
                $('#classificationGroupSelect').empty().trigger("change");
                response['classificationGroups'].forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#classificationGroupSelect').append(newOption).trigger('change');
                });
                $('#levelSelect').empty().trigger("change");
                response['levels'].forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#levelSelect').append(newOption).trigger('change');
                });
            } else {
                $('#classificationUnassignedGroupSelect').empty().trigger("change");
                response['classificationGroups'].forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#classificationUnassignedGroupSelect').append(newOption).trigger('change');
                });

                $('#levelUnassignedSelect').empty().trigger("change");
                response['levels'].forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#levelUnassignedSelect').append(newOption).trigger('change');
                });
            }
        }
    });
}

function saveRestrictSettings(){
    var levels = [];
    selected = $('#restrictLevelSelect').select2("data");
    for (var i = 0; i <= selected.length - 1; i++) {
        levels.push({'id': selected[i].id, 'name': selected[i].text})
    }
    $.ajax({
        url: "/tickets/save_restrict_settings",
        data: {levels: levels},
        success: function () {
            toastr['success']('Success! Restrict Settings is saved', {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    });
}

function saveAdminViewTickets(type) {
    var levels = [];
    var classificationGroup = "";
    var classificationGroupName = "";
    var selected = [];

    if (type == 'fromUnassigned') {
        selected = $('#levelUnassignedSelect').select2("data");
        for (var i = 0; i <= selected.length - 1; i++) {
            levels.push({'id': selected[i].id, 'name': selected[i].text})
        }
        classificationGroup = $('#classificationUnassignedGroupSelect').val();
        classificationGroupName = $('#classificationUnassignedGroupSelect').select2('data')[0].text;
    } else {
        selected = $('#levelSelect').select2("data");
        for (var i = 0; i <= selected.length - 1; i++) {
            levels.push({'id': selected[i].id, 'name': selected[i].text})
        }
        classificationGroup = $('#classificationGroupSelect').val();
        classificationGroupName = $('#classificationGroupSelect').select2('data')[0].text;
    }

    $.ajax({
        url: "/tickets/admin_view_tickets",
        data: {
            levels: levels,
            classificationGroup: classificationGroup,
            classificationGroupName: classificationGroupName,
            type: type
        },
        success: function (response) {
            if(response=="true"){
                toastr['success']('Success! Admin View Ticket settings is saved', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                var level = " ";
                levels.forEach(function (element) {
                    level += '<span class="text-info">' + element.name + ' ' + '</span>';
                });
                if (type == 'fromUnassigned') {
                    var myvar = '<li id="adminUnassigned' + classificationGroup + '"' +
                        ' class="list-group-item">' + classificationGroupName +
                        level + ' ' +
                        '<a href="javascript:void(0)"' +
                        'onclick="deleteUnassignmedClassificationGroup(' + classificationGroup + ')"><span' +
                        ' data-feather="trash"></span></a>' +
                        ' </li>';
                    $('#adminUnassignedViewDiv').append(myvar);
                    $('#adminUnassignedClassificationModal').modal('hide');

                } else {
                    var myvar = '<li id="admin' + classificationGroup + '"' +
                        ' class="list-group-item">' + classificationGroupName +
                        level + ' ' +
                        '<a href="javascript:void(0)"' +
                        'onclick="deleteClassificationGroup(' + classificationGroup + ')"><span' +
                        ' data-feather="trash"></span></a>' +
                        ' </li>';
                    $('#adminViewDiv').append(myvar);
                    $('#adminClassificationModal').modal('hide');
                }
                feather.replace();
            }else{
                toastr['error'](response, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        }
    });
}

function deleteClassificationGroup(id) {
    $.ajax({
        url: "/tickets/delete_classification_group",
        data: {classificationGroupId: id},
        success: function () {
            toastr['success']('Success! Classification group is removed', {
                closeButton: true,
                tapToDismiss: false,
            });
            $('#admin' + id).remove();
        }
    });
}



function deleteTicket(id) {
    let name = "/tickets/" + id;
    $('#delete-ticket').attr('action', name);
    $('#delete-ticket').submit();
}
function showTasks(id){
    $.ajax({
        url: "/tickets/tasks",
        data: {id: id},
        success: function (response) {
            $('#getTasksOfTicket').modal('show');
            $('#tasktbody').empty();
            response.forEach(function (element) {

               $('#tasktbody').append(
                    $('<tr>').append( $('<td>').text(element.subject.name),
                        $('<td>').html('<span class="badge badge-success">'+element.priority.name+'</span>'),
                        $('<td>').html('<span class="badge badge-info">'+element.status.name+'</span>'),
                        $('<td>').text(( element.agent != null) ? element.agent.name: "Unassigned" )));
            });

        }
    });
}

function openTicket(id) {
    $.ajax({
        url: "/tickets/open_ticket",
        data: {id: id},
        success: function (response) {

            if(response=='false'){
                toastr['error']('Error, You can not re-open ticket', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }else{
                toastr['success']('Success! Ticket is opened', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                updateAllDatatables();


            }
        }
    });
}
function deleteUnassignmedClassificationGroup(id) {
    $.ajax({
        url: "/tickets/delete_unassignmedn_classification_group",
        data: {classificationGroupId: id},
        success: function () {
            toastr['success']('Success! Classification group is removed', {
                closeButton: true,
                tapToDismiss: false,
            });
            $('#adminUnassigned' + id).remove();
        }
    });
}

$(document).ready(function () {

    $('#myList a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
      });

    if ($('#adminCanView').prop('checked')) {
        $('#adminCanViewTable').removeAttr('hidden');
    }

    $("#subjectsOfType").on("select2:select", function (e) {
        var subjectId = $('#subjectsOfType').select2('data')[0].id;
            $.ajax({
            url: "/tickets/change_type",
            data: {id: ticketIdForType, type: typeId, subject: subjectId},
            success: function (response) {
                updateAllDatatables();
                toastr['success']('Success! Type is changed', {
                    closeButton: true,
                    tapToDismiss: false,
                    });
                $('#getSubjectsOfType').modal('hide');
                }
            });
    });

    $('.livesearch').select2({
        placeholder: 'Select Customer',
        ajax: {
            url: '/tickets/get_customer_with_live_search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.username,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    if($('#openticketerror') != null) {
        setTimeout(function () {
            $('#openticketerror').attr('hidden', true)
        }, 6000);

    }
    $("#adminCanView").change(function () {
        if (this.checked) {
            $('#adminCanViewTable').removeAttr('hidden');
            $.ajax({
                url: "/tickets/admin_can_view_only_assigned",
                data: {status:"checked"},
                success: function (response) {
                }
            });

        } else {
            $('#adminCanViewTable').attr('hidden', true);
            $.ajax({
                url: "/tickets/admin_can_view_only_assigned",
                data: {status:""},
                success: function (response) {
                }
            });
        }
    });
    $.ajax({
        url: "/tickets/get_admin_classification",
        data: {},
        success: function (response) {
            $('#restrictLevelSelect').empty().trigger("change");
            response['levels'].forEach(function (element) {
                let newOption;
                var result = $.grep(response['restrict_level'] , function(e){ return e.id == element.id; });
                if (result.length === 0) {
                    newOption = new Option(element.name, element.id, false, false);
                } else {
                    newOption = new Option(element.name, element.id, false, true);
                }
                $('#restrictLevelSelect').append(newOption).trigger('change');
            });
        }
    });
    $('.time-select2').select2();
    $('#typeSelect').val(null).trigger('change');
    $('#customerSelect').val(null).trigger('change');
    $('#assigned_to').val(null).trigger('change');
    $('#status').val(null).trigger('change');
    $('#group').val(null).trigger('change');
    $("#subjectSelect").on("select2:select", function (e) {
        var typeId = $('#subjectSelect').select2('data')[0].id;
        $.ajax({
            url: "/tickets/get_subjects",
            data: {id: typeId},
            success: function (response) {
                toastr['success']('Success! Subject was loaded', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                $('#typeSelect').empty().trigger("change");
                var newOption = new Option(response.name, response.id, false, true);
                $('#typeSelect').append(newOption).trigger('change');

            }
        });
    });

    $("#group").on("select2:select", function (e) {
        var groupId = $('#group').select2('data')[0].id;
        $.ajax({
            url: "/tickets/cc_recipients",
            data: {id: groupId},
            success: function (response) {
                toastr['success']('Success! Cc_recipients admins was loaded', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                 
                $('#watchers').empty().trigger("change");

                response.forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#watchers').append(newOption).trigger('change');
                });
                $('#watchers').val(null).trigger('change');

                $('#assigned_to').empty().trigger("change");
                var newOption = new Option("Auto Assign", 0, true, true);
                $('#assigned_to').append(newOption).trigger('change');
                response.forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#assigned_to').append(newOption).trigger('change');
                });


                $('#cc_recipients_select').empty().trigger("change");
                response.forEach(function (element) {
                    var newOption = new Option(element.name, element.id, false, false);
                    $('#cc_recipients_select').append(newOption).trigger('change');
                });
                $('#cc_recipients_select').val(null).trigger('change');

            }
        });
    });

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
            group: {
                required: true,
            },
            message: {
                required: true,
            },
            status: {
                required: true,
            }

        }
    });
});

