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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});

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
            dtTicketTable.ajax.reload(null, false);
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

function openStatusDropdown(id) {
    if ($("#status" + id + ".show").length == 1) {
        $('#status' + id).removeClass("show");
    } else {
        $('.dropdown-menu').removeClass("show");
        $('#status' + id).addClass("show");
    }
}

function changePriority(priority, id) {
    $('#preLoader').removeAttr('hidden');
    $.ajax({
        url: "/tickets/change_priority",
        data: {id: id, priority: priority},
        success: function (response) {
            dtTicketTable.ajax.reload(null, false);
            toastr['success']('Success! Priority is changed', {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    });
}

function changeStatus(status, id) {
    $.ajax({
        url: "/tickets/change_status",
        data: {id: id, status: status},
        success: function (response) {
            toastr['success']('Success! Status is changed', {
                closeButton: true,
                tapToDismiss: false,
            });
            dtTicketTable.ajax.reload(null, false);
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

function changeType(type, id) {
    $.ajax({
        url: "/tickets/change_type",
        data: {id: id, type: type},
        success: function (response) {
            toastr['success']('Success! Type is changed', {
                closeButton: true,
                tapToDismiss: false,
            });
            dtTicketTable.ajax.reload();
        }
    });
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

function removeType(id) {
    $.ajax({
        url: "/tickets/delete_type",
        data: {id: id},
        success: function (res) {
            if(res!="true"){
                toastr['error'](res, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }else{
                toastr['success']('Success! Type is deleted', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                $('#type' + id).remove();

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

    if ($('#adminCanView').prop('checked')) {
        $('#adminCanViewTable').removeAttr('hidden');
    }

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
});

