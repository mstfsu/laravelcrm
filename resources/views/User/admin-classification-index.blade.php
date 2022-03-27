@extends('layouts/contentLayoutMaster')

@section('title', 'Admins List')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">

@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection
@section('content')
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="modal fade" id="editAdminLevelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <strong>Levels</strong>
                                        <select id="level_new_name"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($levels as $level)
                                                <option value="{{$level->name}}">{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="editAdminLevel()"
                                    class="btn btn-primary waves-effect waves-float waves-light"
                                    data-bs-dismiss="modal">Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" class="form-control" id="group-name" placeholder="Type Group Name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="addGroup()"
                                    class="btn btn-primary waves-effect waves-float waves-light"
                                    data-bs-dismiss="modal">Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <strong>Admin</strong>
                                    <div class="position-relative">
                                        <select id="admin_id"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Admin Level</strong>
                                    <div class="position-relative">
                                        <select id="level_name"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($levels as $level)
                                                <option value="{{$level->name}}">{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input hidden id="group_id" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="sendForm()"
                                    class="btn btn-primary waves-effect waves-float waves-light"
                                    data-bs-dismiss="modal">Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Admin Classification</h4>
                                <span class="badge badge-danger">Attention Please !</span>
                                <span class="badge badge-warning">If you don't select "Assign Ticket", when you create ticket,
                                    you can not see this group.
                                </span>
                            </div>
                            <div class="col-6">
                                <a onclick="showAddGroupModal()"
                                   class="btn btn-outline-success btn-sm text-success float-right">Add Group<span
                                            data-feather="plus"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 20%">Group</th>
                            <th style="width: 50%">Admins</th>
                            <th style="width: 20%">Assign Ticket</th>
                            <th style="width: 10%" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="tableBody">
                        @foreach($groups as $group )
                            <tr id="group{{$group->id}}">
                                <td>
                                    <span class="fw-bold">{{$group->name}}</span>
                                </td>
                                <td>
                                    <div class="row" id="mainDiv{{$group->id}}">
                                        @foreach($group->admins as $admin)
                                            <div id="adminDiv{{$admin->id.$group->id}}" class="col-12">
                                                {{$admin->name}} (<span class="text-primary" id="level{{$admin->id.$group->id}}">{{$admin->pivot->level_name}}</span>)
                                                <a href="javascript:void(0)" title="Delete Admin"
                                                   onclick="deleteAdmin('{{$admin->id}}','{{$group->id}}')"><span
                                                            data-feather="trash"></span></a>
                                                <a href="javascript:void(0)" title="Edit Admin" onclick="showEditAdminModal('{{$admin->id}}','{{$group->id}}')"><span
                                                            data-feather="edit"></span></a>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-primary">
                                        <input id="checkbox{{$group->id}}" value="{{$group->id}}" type="checkbox" {{$group->assign_ticket==1?"checked":""}} class="form-check-input checkbox" id="colorCheck1" >
                                        <label class="form-check-label" for="colorCheck1">This group can assign to tickets</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="javascript:void(0)" title="Add Admin to This Group" onclick="showModal({{$group->id}})"><span
                                                    data-feather="plus-square"></span></a>
                                        <a href="javascript:void(0)" title="Delete This Group" onclick="deleteGroup({{$group->id}})"><span
                                                    data-feather="trash"></span></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')

    <script src="{{ asset(mix('js/scripts/components/components-modals.js')) }}"></script>
    <script src="{{ asset( 'js/scripts/forms/form-select2.js') }}"></script>
    <script src="{{ asset('js/scripts/User/admin-classification.js') }}"></script>
@endsection
