@extends('layouts/contentLayoutMaster')

@section('title', 'Task Settings')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
    <style>
        /* #ticket-datatable tbody tr:hover {
             background-color: whitesmoke;
             cursor: pointer;
         }*/

    </style>
@endsection

@section('content')
    <section class="">
        <div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="typeValue" placeholder="Type">
                            </div>
                            <div class="col-md-12 mt-1">
                                <select id="typeColor"
                                        class="select2 form-control form-control-lg select2-hidden-accessible"
                                        tabindex="-1" aria-hidden="true">
                                    <option value="primary">Primary</option>
                                    <option value="success">Success</option>
                                    <option value="warning">Warning</option>
                                    <option value="dark">Dark</option>
                                    <option value="danger">Danger</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" onclick="addType()"
                                class="btn btn-primary waves-effect waves-float waves-light"
                                data-bs-dismiss="modal">Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <strong>Subject</strong>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="subjectName" placeholder="Type">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <strong>Priority</strong>
                                <div class="position-relative">
                                    <select id="priority_id"
                                            class="select2 form-control form-control-lg select2-hidden-accessible"
                                            tabindex="-1" aria-hidden="true">
                                        @foreach($priorities as $priority)
                                            <option value="{{$priority['id']}}">{{$priority['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input hidden value="" id="idType">
                    <div class="modal-footer">
                        <button type="button" onclick="addSubject()"
                                class="btn btn-primary waves-effect waves-float waves-light"
                                data-bs-dismiss="modal">Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade " id="createTicketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 col-12">
                            <form class="form form-vertical" id="createForm" enctype="multipart/form-data"
                                  action="{{route('tickets.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="first-name-vertical">Customer</label>
                                            <select id="customerSelect"
                                                    class="select2 form-control livesearch form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true" name="customer_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="first-name-vertical">Type</label>
                                            <select id="typeSelect"
                                                    class="select2 form-control form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true" name="type_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="email-id-vertical">Subject</label>
                                            <select id="subjectSelect"
                                                    class="select2 form-control form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true" name="subject_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <strong>Status</strong>
                                            <div class="position-relative">
                                                <select name="status_id"
                                                        id="status"
                                                        class="select2 form-control form-control-lg select2-hidden-accessible"
                                                        tabindex="-1" aria-hidden="true">
                                                    @foreach($status as $statu)
                                                        <option value="{{$statu->id}}">{{$statu->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <strong>Group</strong>
                                        <div class="position-relative">
                                            <select name="group_id"
                                                    id="group"
                                                    class="select2 form-control form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <strong>Cc Recipients</strong>
                                        <div class="position-relative">
                                            <input name="cc_recipients" type="text" class="form-control" id="basicInput"
                                                   placeholder="Type Cc Recipients">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <strong>Assigned To</strong>
                                            <div class="position-relative">
                                                <select name="assigned_to"
                                                        class="select2 form-control form-control-lg select2-hidden-accessible"
                                                        tabindex="-1" aria-hidden="true" id="assigned_to">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <strong>Watchers</strong>
                                        <div class="position-relative">
                                            <select name="watchers[]"
                                                    id="watchers"
                                                    class="select2 form-control select2-hidden-accessible"
                                                    multiple=""
                                                    data-select2-id="default-select-multi" tabindex="-1"
                                                    aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <strong>Attachments</strong>
                                            <div class="position-relative">
                                                <div class="custom-file">
                                                    <input name="customFile" type="file" class="custom-file-input"
                                                           id="customFile">
                                                    <label class="custom-file-label" for="customFile">Choose
                                                        Attachments</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <strong>Message</strong>
                                            <div class="position-relative">
                                                <div class="col-sm-12">
                                                    <div id="full-wrapper">
                                                        <div id="full-container">
                                                            <div class="editor" id="editor" style="height: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea name="message" id="content" style="display:none"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                                class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                            Save
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary waves-effect">Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <input hidden value="" id="typeId">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card user-card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="mikrotik_tab" role="tablist">
                       <li class="nav-item ">
                            <a class="nav-link active "
                                id="billing-tab"
                                data-toggle="tab"
                                href="#task_config"
                                aria-controls="home"
                                role="tab"
                                aria-selected="true"
                            ><i data-feather="dollar-sign"></i> Task Template</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="task_config" aria-labelledby="billingtab-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    @can('Add Task Type')
                                    <button type="button" onclick="$('#addTypeModal').modal('show')"
                                        class="btn btn-outline-success round waves-effect float-right">Add Type
                                     </button>
                                    @endcan 
                                 
                                </div>
                                <div class="col-md-12 mt-1">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width: 20%">Type</th>
                                                <th style="width: 40%">Subject</th>
                                            
                                                <th style="width: 10%" class="text-center">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                            @foreach($types as $type)
                                                <tr id="type{{$type['id']}}">
                                                    <td>
                                                        <span class="fw-bold">{{$type['name']}}</span>
                                                    </td>

                                                    <td>
                                                        <ul class="list-group list-group-flush"
                                                            id="subjectUl{{$type['id']}}">
                                                            @foreach($type['subjects'] as $subject)
                                                                <li id="subject{{$subject['id']}}"
                                                                    class="list-group-item">{{$subject['name']}}
                                                                    (<span class="text-info">{{$subject['priority']['name']}}</span>)
                                                                    @can('Remove Task Subject')
                                                                    <a href="javascript:void(0)"
                                                                    onclick="deleteSubject({{$subject['id']}})"><span
                                                                            data-feather="trash"></span></a>
                                                                    @endcan
                                                                   
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        @can('Add Task Subject')
                                                            <a class="float-right" title="Add Subject" href="javascript:void(0)"
                                                                onclick="showAddSubjectModal({{$type['id']}})"><span
                                                                        data-feather="plus"></span></a>
                                                        @endcan
                                                    </td>
                                                    <td>
                                                        @can('Remove Task Type')
                                                            <button onclick="removeType({{$type['id']}})" type="button"
                                                                class="btn btn-outline-danger btn-sm text-center round waves-effect">
                                                                Remove
                                                            </button>
                                                        @endcan
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>  
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset( 'js/scripts/forms/form-select2.js') }}"></script>
    <script src="{{ asset('js/scripts/Tasks/config.js') }}"></script>
@endsection


