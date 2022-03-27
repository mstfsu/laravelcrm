@extends('layouts/contentLayoutMaster')

@section('title', 'Agent Classification')

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
                                        <select id="agent_id"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($agents as $agent)
                                                <option value="{{$agent->id}}">{{$agent->name}}</option>
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
                                <h4 class="card-title">Agent Classification</h4>
                            </div>
<!--                            <div class="col-6">
                                <a onclick="showAddGroupModal()"
                                   class="btn btn-outline-success btn-sm text-success float-right">Add Group<span
                                            data-feather="plus"></span></a>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 20%">Project</th>
                            <th style="width: 50%">Agents</th>
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
                                        @foreach($group->agents as $agent)
                                            <div id="adminDiv{{$agent->id.$group->id}}" class="col-12">
                                                {{$agent->name}} (<span class="text-primary" id="level{{$agent->id.$group->id}}">{{$agent->pivot->level_name}}</span>)
                                                <a href="javascript:void(0)" title="Delete Admin"
                                                   onclick="deleteAgent('{{$agent->id}}','{{$group->id}}')"><span
                                                            data-feather="trash"></span></a>
                                                <a href="javascript:void(0)" title="Edit Admin" onclick="showEditAdminModal('{{$agent->id}}','{{$group->id}}')"><span
                                                            data-feather="edit"></span></a>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        @can('Agent Classification Add Admin')
                                        <a href="javascript:void(0)" title="Add Admin to This Group" onclick="showModal({{$group->id}})"><span
                                            data-feather="plus-square"></span></a>
                                        @endcan
                                        
<!--                                        <a href="javascript:void(0)" title="Delete This Group" onclick="deleteGroup({{$group->id}})"><span
                                                    data-feather="trash"></span></a>-->
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
    <script src="{{ asset('js/scripts/Agents/classification.js') }}"></script>
@endsection
