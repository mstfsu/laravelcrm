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
var unassignedDatatable;
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
                url: '/agents/index_data',
                dataType: "json",
            },
            columns: [
                {data: 'id', width: "10%"},
                {data: 'name', width: "20%"},
                {data: 'email', width: "10%"},
                {data: 'phone', width: "20%", },
                {data: 'company', width: "10%",render(data) {
                        return '<span  class="badge badge-success">' + data + '</span>';
                    }
                },
                {data:'change_phone_request',width:"20%"},
                {data: 'actions', width: "10%"}
            ],
            buttons: [
                {
                    text: 'Add New Agent',
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

                          window.location.href = '/agents/create';
                    },
                },
                {
                    text: 'Approve All Requests',
                    className: 'btn btn-icon btn-outline-success',
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

                        $.ajax({
                            url: "/agents/approve_all_request",
                            success: function (response) {
                               if(response=="true"){
                                toastr['success']('Success all request approved', {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });
                                dtTicketTable.ajax.reload();
                               }else{
                                toastr['error'](response, {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });
                               }
                            }
                        });
                    },
                },
            ],
            drawCallback: function (settings,json) {
                feather.replace();
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
function deleteAgent(id) {
    let name = "/agents/" + id;
    $('#delete-agent').attr('action', name);
    $('#delete-agent').submit();
}
function changePhoneRequest(id){
    $.ajax({
        url: "/agents/approve_agent_request",
        data: {id:id},
        success: function (response) {
           if(response=="true"){
            toastr['success']('Success all request approved', {
                closeButton: true,
                tapToDismiss: false,
            });
            dtTicketTable.ajax.reload();
           }else{
            toastr['error'](response, {
                closeButton: true,
                tapToDismiss: false,
            });
           }
        }
    });
}
