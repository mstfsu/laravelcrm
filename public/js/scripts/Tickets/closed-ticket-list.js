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
$(function () {
    'use strict';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (dtTicketTable.length) {
        dtTicketTable = dtTicketTable.DataTable({
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
            ajax: {
                url: '/tickets/closed',
                data: {data: 'getTicketData'}
            }, // JSON file to add data
            columns: [
                {data: 'id'},
                {data: 'subject', render: function (data) {
                        let output = "<span  style='color:#5DADE2;font-weight:bold' " + ">" + data.name + "</span>";
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
            buttons: [],
            drawCallback: function (settings) {
                feather.replace()
            },
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
        });
    }
    // To initialize tooltip with body container
});

function deleteTicket(id) {
    let name = "/tickets/" + id;
    $('#delete-ticket').attr('action', name);
    $('#delete-ticket').submit();
}

function openTicket(id) {
    $.ajax({
        url: "open_ticket",
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
                dtTicketTable.ajax.reload();
            }
        }
    });
}