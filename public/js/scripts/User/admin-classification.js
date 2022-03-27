var idOfAdmin;
var idOfGroup;

$( document ).ready(function() {
    $(".checkbox").change(function() {
        if(this.checked) {
            $.ajax({
                url: "/Admin/change_assign_ticket",
                data: {groupId: this.value,value:1},
                success: function (response) {
                    toastr['success']('Success! Group setting changed', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                }
            });
        }else{
            $.ajax({
                url: "/Admin/change_assign_ticket",
                data: {groupId: this.value,value:0},
                success: function (response) {
                    toastr['success']('Success! Group setting changed', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                }
            });
        }
    });
});


function sendForm() {
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "/Admin/classification_group_add_admin",
        type: "POST",
        data: {
            admin_id: $('#admin_id').val(),
            level_name: $('#level_name').val(),
            group_id: $('#group_id').val(),
            _token: _token
        },
        success: function (response) {
            if (response == 'false') {
                toastr['error']('Error! Admin is already added', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            } else {
                toastr['success']('Success! Admin is added', {
                    closeButton: true,
                    tapToDismiss: false,
                });

                var parameter = "'" + response['admin_id'] + "'" + "," + "'" + $('#group_id').val() + "'";

                var id = response['admin_id'] + response['group_id'];
                var adminDiv = '<div id="adminDiv' + id + '" class="col-12">' + response['admin_name'] + ' (<span class="text-primary" id="level'+id+'">' + response['level_name'] + '</span>) ' +
                    '<a href="javascript:void(0)" title="Delete Admin" onclick="deleteAdmin(' + parameter + ')"><span' + 'data-feather="trash">' + '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>'
                    + '</span></a>'+

                    '<a href="javascript:void(0)" title="Edit Admin" onclick="showEditAdminModal(' + parameter + ')"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>'
                    + ' </div>';
                $('#mainDiv' + response['group_id']).append(adminDiv);

            }

            $('#editModal').modal('hide');

        },
    });
}

function showModal(id) {
    $('#group_id').val(id);
    $('#editModal').modal('show');

}

function deleteAdmin(admin_id, group_id) {
    $.ajax({
        url: "/Admin/delete_admin_from_group",
        data: {admin_id: admin_id, group_id: group_id},
        success: function (response) {
            toastr['success']('Success! Admin is removed', {
                closeButton: true,
                tapToDismiss: false,
            });
            $('#adminDiv' + admin_id + group_id).remove();
        }
    });
}

function showAddGroupModal() {
    $('#addModal').modal('show');


}





function addGroup() {
    $.ajax({
        url: "/Admin/add_classification_group",
        data: {group_name: $("#group-name").val()},
        success: function (response) {
            if(response=="false"){
                toastr['error']("you can not add group with same name", {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }else{

                toastr['success']('Success! Group is added', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                let checkedStatus="";
                if(response.assign_ticket==1){
                    checkedStatus="checked";
                }
                var myvar = '<tr id="group'+response.id+'">' +
                    '                                <td>' +
                    '                                    <span class="fw-bold">' + response.name + '</span>' +
                    '                                </td>' +
                    '                                <td>' +
                    '                                    <div class="row" id="mainDiv' + response.id + '">' +
                    '                                            <div id="adminDiv11" class="col-12">' +
                    '                                               ' +
                    '                                            </div>' +
                    '                                    </div>' +
                    '                                </td>' +
                    '                               <td>'+
                    '                                   <div class="form-check form-check-primary">'+
                    '                                       <input id="checkbox'+response.id+'" value="'+response.id+'" type="checkbox" class="form-check-input checkbox" id="colorCheck1" >'+
                    '                                       <label class="form-check-label" for="colorCheck1">This grup can assign to tickets</label>'+
                    '                                   </div>'+
                    '                               </td>'+
                    '                                <td>' +
                    '                                    <div class="text-center">' +
                    '                                        <a href="javascript:void(0)" title="Add Admin to This Group" onclick="showModal(' + response.id + ')"><span' +
                    '                                                    data-feather="plus-square"><svg viewBox="0 0 24 24" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></span></a>' +
                    '<a href="javascript:void(0)" title="Delete This Group" onclick="deleteGroup(' + response.id + ')"><span' +
                    '                                                                data-feather="trash"><svg viewBox="0 0 24 24" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>'+
                    '                                    </div>' +
                    '                                </td>' +
                    '                            </tr>';

                $('#tableBody').append(myvar);
                $('#addModal').modal('hide');
            }


        }
    });
}

function showEditAdminModal(adminid, groupid) {
    idOfAdmin = adminid;
    idOfGroup = groupid;
    $('#editAdminLevelModal').modal("show");
}

function deleteGroup(groupId){
    $.ajax({
        url: "/Admin/delete_group",
        data: {groupId: groupId},
        success: function (response) {
            if(response=="true"){
                toastr['success']('Success! You deleted group', {
                    closeButton: true,
                    tapToDismiss: false,
                });
               $('#group'+groupId).remove();
            }else{
                toastr['error'](response, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        }
    });
}
function editAdminLevel() {
    var level = $("#level_new_name").val();
    $.ajax({
        url: "/Admin/change_admin_level",
        data: {admin_id: idOfAdmin, group_id: idOfGroup, level: level},
        success: function (response) {
            toastr['success']('Success! Level is updated', {
                closeButton: true,
                tapToDismiss: false,
            });
            $('#editAdminLevelModal').modal("hide");
            console.log(level);
            console.log(idOfAdmin+idOfGroup);
            $("#level" + idOfAdmin + idOfGroup).text(level);
        }
    });
}
