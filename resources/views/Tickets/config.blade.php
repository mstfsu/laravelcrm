@extends('layouts/contentLayoutMaster')

@section('title', 'Ticket Settings')
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
        <div class="modal fade " id="adminClassificationModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="classificationGroupSelect">Classification
                                            Group</label>
                                        <select id="classificationGroupSelect"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="levelSelect">Level</label>
                                        <select id="levelSelect"
                                                class="select2 form-control form-control-lg select2-hidden-accessible multi-select "
                                                multiple="multiple"
                                                tabindex="-1" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit"
                                            class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                            onclick="saveAdminViewTickets()">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade " id="adminUnassignedClassificationModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="classificationUnassignedGroupSelect">Classification
                                            Group</label>
                                        <select id="classificationUnassignedGroupSelect"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="levelUnassignedSelect">Level</label>
                                        <select id="levelUnassignedSelect"
                                                class="select2 form-control form-control-lg select2-hidden-accessible multi-select "
                                                multiple="multiple"
                                                tabindex="-1" aria-hidden="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit"
                                            class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                            onclick="saveAdminViewTickets('fromUnassigned')">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card user-card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="mikrotik_tab" role="tablist">
                        @can('show Config Ticket')

                            <li class="nav-item ">
                                <a class="nav-link active "
                                   id="billing-tab"
                                   data-toggle="tab"
                                   href="#ticket_config"
                                   aria-controls="home"
                                   role="tab"
                                   aria-selected="true"
                                ><i data-feather="dollar-sign"></i> Ticket Template</a>
                            </li>
                        @endcan

                        @can('show Sla Ticket')
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="profileIcon-tab"
                                   data-toggle="tab"
                                   href="#ticket_sla"
                                   aria-controls="profile"
                                   role="tab"
                                   aria-selected="false"
                                ><i data-feather="pie-chart"></i> Ticket Config</a>
                            </li>
                        @endcan
                    </ul>
                    <div class="tab-content">

                        @can('show Config Ticket')

                            <div class="tab-pane active" id="ticket_config" aria-labelledby="billingtab-tab" role="tabpanel">
                                <div class="container">
                                    <div class="row">
                                        @can('add Type Ticket')
                                            <div class="col-12">
                                                <button type="button" onclick="$('#addTypeModal').modal('show')"
                                                        class="btn btn-outline-success round waves-effect float-right">Add Type
                                                </button>
                                            </div>
                                        @endcan
                                        <div class="col-12 mt-1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 20%">Type</th>
                                                        <th style="width: 40%">Subject</th>
                                                        <th style="width: 15%">Others</th>
                                                        <th style="width: 15%">ONLY VISIBLE FOR ADMIN</th>
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
                                                                            <a href="javascript:void(0)"
                                                                               onclick="deleteSubject({{$subject['id']}})"><span
                                                                                        data-feather="trash"></span></a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                @can('add Subject Ticket')
                                                                    <a class="float-right" title="Add Subject" href="javascript:void(0)"
                                                                       onclick="showAddSubjectModal({{$type['id']}})"><span
                                                                                data-feather="plus"></span></a>
                                                                @endcan
                                                            </td>
                                                            <td>
                                                                <button id="yes{{$type['id']}}"
                                                                        {{$type['others']==1?'':'hidden'}} type="button"
                                                                        onclick="changeOthers({{$type['id']}})"
                                                                        class="btn btn-flat-success waves-effect">Yes
                                                                </button>
                                                                <button id="no{{$type['id']}}"
                                                                        {{$type['others']==1?'hidden':''}} type="button"
                                                                        onclick="changeOthers({{$type['id']}})"
                                                                        class="btn btn-flat-danger waves-effect">No
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button id="yesVisible{{$type['id']}}"
                                                                        {{$type['only_visible_for_admin']==1?'':'hidden'}} type="button"
                                                                        onclick="changeOnlyVisible({{$type['id']}})"
                                                                        class="btn btn-flat-success waves-effect">Yes
                                                                </button>
                                                                <button id="noVisible{{$type['id']}}"
                                                                        {{$type['only_visible_for_admin']==1?'hidden':''}} type="button"
                                                                        onclick="changeOnlyVisible({{$type['id']}})"
                                                                        class="btn btn-flat-danger waves-effect">No
                                                                </button>
                                                            </td>
                                                            <td>
                                                                @can('remove Type Ticket')
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
                        @endcan

                        @can('show Sla Ticket')
                            <div class="tab-pane" id="ticket_sla" aria-labelledby="ticket_sla-tab" role="tabpanel">
                                <div class="card">
                                    <div class="row" id="table-hover-row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">SLA POLICIES</h4>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 10%">Priority</th>
                                                            <th style="width: 35%">Respond Within</th>
                                                            <th style="width: 35%">Resolve Within</th>
                                                            <th style="width: 10%">E-Mails</th>
                                                            <th style="width: 5%">Sms</th>
                                                            <th style="width: 5%"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($priorities as $priority)
                                                            <tr>
                                                                <td>
                                                                    <span class="fw-bold">{{$priority['name']}}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <input type="number" class="form-control"
                                                                                   id="respondTimeValue{{$priority['id']}}"
                                                                                   placeholder="Type Time Value"
                                                                                   value="{{$priority['respond_within_time_value']}}">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <select class="time-select2"
                                                                                    id="respondselect{{$priority['id']}}"
                                                                                    name="respond_time_type">
                                                                                <option {{$priority['respond_within_time_type']=="Hrs"?"selected":""}} value="Hrs">Hours</option>
                                                                                <option {{$priority['respond_within_time_type']=="Mins"?"selected":""}} value="Mins">Minutes</option>
                                                                                <option {{$priority['respond_within_time_type']=="Days"?"selected":""}} value="Days">Days</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <input type="number" class="form-control"
                                                                                   id="resolveTimeValue{{$priority['id']}}"
                                                                                   placeholder="Type Time Value"
                                                                                   value="{{$priority['resolve_within_time_value']}}">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <select class="time-select2"
                                                                                    id="resolveselect{{$priority['id']}}">
                                                                                <option {{$priority['resolve_within_time_type']=="Hrs"?"selected":""}} value="Hrs">Hours</option>
                                                                                <option {{$priority['resolve_within_time_type']=="Mins"?"selected":""}} value="Mins">Minutes</option>
                                                                                <option {{$priority['resolve_within_time_type']=="Days"?"selected":""}} value="Days">Days</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    <select class="time-select2"
                                                                            id="email{{$priority['id']}}">
                                                                        <option {{$priority['email']==1?"selected":""}} value="1">
                                                                            Yes
                                                                        </option>
                                                                        <option {{$priority['email']==0?"selected":""}} value="0"
                                                                                value="0">No
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="time-select2"
                                                                            id="sms{{$priority['id']}}">
                                                                        <option {{$priority['sms']==1?"selected":""}} value="1"
                                                                                value="1">Yes
                                                                        </option>
                                                                        <option {{$priority['sms']==0?"selected":""}} value="0">
                                                                            No
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="col-2">
                                                                        <button type="button"
                                                                                onclick="saveRespondTimeInfo({{$priority['id']}})"
                                                                                class="btn btn-icon btn-outline-primary waves-effect">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <h4 class="card-title text-primary">USE TIME BASED ON WORKING HOURS</h4>

                                                            </div>
                                                            <div class="col-8">
                                                                <span class="badge badge-danger">Attention Please !</span>
                                                                <span style="font-size:15px" class="badge badge-warning">If you open this setting, admins who are in working hours will appear on the ticket processes (create ticket etc.)
                                                                </span>
                                                            </div>

                                                        </div>

                                                    </div>
                                                   
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 20%"></th>
                                                                        <th style="width: 30%"></th>
                                                                        <th style="width: 30%" class="text-center">Actions
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            Use Time Based on Working Hours ?
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="custom-control custom-control-primary custom-switch">
                                                                                <input type="checkbox"
                                                                                       {{\App\Models\Settings::get('use_time_based_on_working_hours')=='true'?'checked':''}}
                                                                                       class="custom-control-input"
                                                                                       id="useTimeBased"/>
                                                                                <label class="custom-control-label"
                                                                                       for="useTimeBased"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                    onclick="useTimeBasedSettings()"
                                                                                    class="btn btn-icon btn-outline-primary waves-effect">
                                                                                Save
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title text-primary">TICKETS RE-OPEN TIME LIMIT</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 20%">Tickets</th>
                                                                        <th style="width: 30%">Re-open within</th>
                                                                        <th style="width: 20%">Time Type</th>
                                                                        <th style="width: 30%" class="text-center">Actions
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            All Tickets
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                   value="{{\App\Models\Settings::get('re_open_within_time')}}"
                                                                                   class="form-control" id="reOpenTimeValue"
                                                                                   placeholder="Enter Time">
                                                                        </td>
                                                                        <td>
                                                                            <select class="time-select2"
                                                                                    id="reOpenSelect">
                                                                                <option {{\App\Models\Settings::get('re_open_within_time_value')=="Hrs"?'selected':''}} value="Hrs">
                                                                                    Hours
                                                                                </option>
                                                                                <option {{\App\Models\Settings::get('re_open_within_time_value')=="Mins"?'selected':''}} value="Mins">
                                                                                    Minutes
                                                                                </option>
                                                                                <option {{\App\Models\Settings::get('re_open_within_time_value')=="Days"?'selected':''}} value="Days">
                                                                                    Days
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                    onclick="saveReopenSettings()"
                                                                                    class="btn btn-icon btn-outline-primary waves-effect">
                                                                                Save
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title text-primary">OPEN TICKETS LIMIT</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 20%">Tickets</th>
                                                                        <th class="text-center" style="width: 10%">Limit
                                                                        </th>
                                                                        <th style="width: 30%" class="text-center">Actions
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            Open Tickets
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <input type="number" class="form-control"
                                                                                   id="openTicketsNumber"
                                                                                   placeholder="Type Limit"
                                                                                   value="{{\App\Models\Settings::get('open_ticket_limit')}}">
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                    onclick="saveOpenTicketsNumber()"
                                                                                    class="btn btn-icon btn-outline-primary waves-effect">
                                                                                Save
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title text-primary">AUTOMATIC TICKET ASSIGNMENT</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 20%">Tickets</th>
                                                                        <th style="width: 30%">Option</th>
                                                                        <th style="width: 30%" class="text-center">Actions
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            All Tickets
                                                                        </td>
                                                                        <td>
                                                                            <select class="time-select2"
                                                                                    id="automaticAdminAssign">
                                                                                <option {{$automaticAdminAssignWay=="round_robin"?'selected':''}} value="round_robin">Round Robin
                                                                                    System
                                                                                </option>
                                                                                <option {{$automaticAdminAssignWay=="admin_with_less_ticket"?'selected':''}} value="admin_with_less_ticket">Admin
                                                                                    with less tickets
                                                                                </option>
                                                                                <option {{$automaticAdminAssignWay=="nearest_admins_based_on_location"?'selected':''}} value="nearest_admins_based_on_location">
                                                                                    Nearest admins based on location
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                    onclick="saveAutomaticAdminAssign()"
                                                                                    class="btn btn-icon btn-outline-primary waves-effect">
                                                                                Save
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <h4 class="card-title text-primary">ADMIN VIEW TICKETS</h4>

                                                            </div>
                                                            <div class="col-8">
                                                                <span class="badge badge-danger">Attention Please !</span>
                                                                <span style="font-size:15px" class="badge badge-warning">If you open this setting and add group, admins in the selected group will be able to see all tickets
                                                                </span>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span>Admin can view only the tickets assigned to him/her ?</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-control-primary custom-switch">
                                                                <input type="checkbox"
                                                                       class="custom-control-input"
                                                                       id="adminCanView" {{\App\Models\Settings::get("admin_can_view_only_tickets_assigned")}}/>
                                                                <label class="custom-control-label"
                                                                       for="adminCanView"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2" hidden id="adminCanViewTable">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 30%"></th>
                                                                        <th class="text-center" style="width: 40%">ADMIN
                                                                            CLASSIFICATION GROUPS
                                                                        </th>
                                                                        <th style="width: 30%" class="text-center">Actions
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            Admin view all Tickets
                                                                        </td>
                                                                        <td>
                                                                            <ul class="list-group list-group-flush text-center"
                                                                                id="adminViewDiv">
                                                                                @if(isset($adminViewAllTickets))
                                                                                    @foreach($adminViewAllTickets as $admin)
                                                                                        <li id="admin{{$admin->classification_id}}"
                                                                                            class="list-group-item">{{$admin->classification_name}}
                                                                                            @foreach($admin->levels as $level)
                                                                                                <span class="text-info">{{$level->name}}</span>
                                                                                            @endforeach
                                                                                            <a href="javascript:void(0)"
                                                                                               onclick="deleteClassificationGroup({{$admin->classification_id}})"><span
                                                                                                        data-feather="trash"></span></a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                            </ul>

                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="javascript:void(0)"
                                                                               onclick="getAdminClassificationGroup()"><span
                                                                                        data-feather="plus"></span></a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <h4 class="card-title text-primary">ADMIN VIEW UNASSIGNED TICKETS</h4>

                                                            </div>
                                                            <div class="col-8">
                                                                <span class="badge badge-danger">Attention Please !</span>
                                                                <span style="font-size:15px" class="badge badge-warning">If you open this setting and add group, admins in the selected group can see own tickets and unassigned tickets
                                                                </span>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 mt-2">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 30%"></th>
                                                                        <th class="text-center" style="width: 40%">ADMIN
                                                                            CLASSIFICATION GROUPS
                                                                        </th>
                                                                        <th style="width: 30%" class="text-center">Actions
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Admin view unassigned Tickets</td>
                                                                        <td>
                                                                            <ul class="list-group list-group-flush text-center"
                                                                                id="adminUnassignedViewDiv">
                                                                                @if(isset($adminViewAllUnassignedTickets))
                                                                                    @foreach($adminViewAllUnassignedTickets as $admin)
                                                                                        <li id="adminUnassigned{{$admin->classification_id}}"
                                                                                            class="list-group-item">{{$admin->classification_name}}
                                                                                            @foreach($admin->levels as $level)
                                                                                                <span class="text-info">{{$level->name}}</span>
                                                                                            @endforeach
                                                                                            <a href="javascript:void(0)"
                                                                                               onclick="deleteUnassignmedClassificationGroup({{$admin->classification_id}})"><span
                                                                                                        data-feather="trash"></span></a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                            </ul>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @php($name=10)
                                                                            <a href="javascript:void(0)"
                                                                               onclick="getAdminClassificationGroup('unassigned')"><span
                                                                                        data-feather="plus"></span></a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <h4 class="card-title text-primary">RESTRICT CLOSING TICKET
                                                                </h4>

                                                            </div>
                                                            <div class="col-8">
                                                                <span class="badge badge-danger">Attention Please !</span>
                                                                <span style="font-size:15px" class="badge badge-warning">Admins in the selected levels can close tickets
                                                                </span>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 mt-2">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 30%"></th>
                                                                        <th class="text-center" style="width: 20%">Levels
                                                                        </th>
                                                                        <th style="width: 30%" class="text-center">Actions
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Restrict close ticket from admin Levels ?</td>
                                                                        <td>
                                                                            <select class="time-select2"  multiple="multiple"
                                                                                    id="restrictLevelSelect">
                                                                                <option value="1" selected>ss</option>
                                                                            </select>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" onclick="saveRestrictSettings()"
                                                                                    class="btn btn-icon btn-outline-primary waves-effect"
                                                                                    data-bs-dismiss="modal">Save
                                                                            </button>
                                                                        </td>
                                                                    </tr>
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
                            </div>
                        @endcan
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
    <script src="{{ asset('js/scripts/Tickets/config.js') }}"></script>
    <script>

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
        });


    </script>

@endsection


