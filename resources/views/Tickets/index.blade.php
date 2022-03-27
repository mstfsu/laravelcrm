@extends('layouts/contentLayoutMaster')

@section('title', 'Ticket List')
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
        <div
            class="modal fade text-left"
            id="deneme"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel16"
            aria-hidden="true"
            >
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Auto Assign Rules</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="col-12">
                       <div class="row">
                        <div class="row mt-1">
                            <div class="col-md-4 col-sm-12">
                              <div class="list-group" id="list-tab" role="tablist">
                                <a
                                  class="list-group-item list-group-item-action active"
                                  id="list-home-list"
                                  data-toggle="list"
                                  href="#list-home"
                                  role="tab"
                                  aria-controls="list-home"
                                  >Selected Algorithm</a
                                >
                                <a
                                  class="list-group-item list-group-item-action"
                                  id="list-profile-list"
                                  data-toggle="list"
                                  href="#list-profile"
                                  role="tab"
                                  aria-controls="list-profile"
                                  >Admin Work Hours</a
                                >
                                <a
                                  class="list-group-item list-group-item-action"
                                  id="list-messages-list"
                                  data-toggle="list"
                                  href="#list-messages"
                                  role="tab"
                                  aria-controls="list-messages"
                                  >Admin Status</a
                                >
                                <a
                                  class="list-group-item list-group-item-action"
                                  id="list-settings-list"
                                  data-toggle="list"
                                  href="#list-settings"
                                  role="tab"
                                  aria-controls="list-settings"
                                  >Open Ticket Limit</a>
                                  <a
                                  class="list-group-item list-group-item-action"
                                  id="list-admin-group-list"
                                  data-toggle="list"
                                  href="#list-admin-group"
                                  role="tab"
                                  aria-controls="list-settings"
                                  >Ticket and Admin Group</a>
                              </div>
                            </div>
                            <div class="col-md-8 col-sm-12 mt-1">
                              <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                  <p class="card-text">
                                    First of all, you must choose an algorithm from the ticket config.
                                    The selected algorithm will be used when assigning tickets to admins.
                                    If the algorithm is not selected, the automatic assignment will not work.
                                  </p>
                                
                                </div>
                                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                  <p class="card-text">
                                    If the working hours setting is turned on in the settings, only the admins who are in the working hours are selected. If the setting is not on, working hours are not looked at.
                                  </p>
                                </div>
                                <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                                  <p class="card-text">
                                    Only administrators who are online can be assigned.
                                  </p>
                                </div>
                                <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                                  <p class="card-text">
                                    You must enter the maximum number of tickets that can be assigned in the ticket settings. No more than this number of assignments can be made to the admin.
                                  </p>
                                </div>
                                <div class="tab-pane fade" id="list-admin-group" role="tabpanel" aria-labelledby="list-admin-group-list">
                                    <p class="card-text">
                                        Admin and ticket must be in the same group and "This group can assign to tickets" option should be clicked while adding a group.
                                    </p>
                                </div>
                              </div>
                            </div>
                          </div>
                       </div>
                   </div>
                </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="getTasksOfTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <span class="badge badge-primary">Tasks Informations</span>
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Agent</th>

                                    </tr>
                                    </thead>
                                    <tbody id="tasktbody">


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="getSubjectsOfType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <span>Please Select Subject</span>
                                <select id="subjectsOfType"
                                        class="select2 form-control form-control-lg select2-hidden-accessible"
                                        tabindex="-1" aria-hidden="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                            <label class="form-label" for="email-id-vertical">Subject</label>
                                            <select id="subjectSelect"
                                                    class="select2 form-control form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true" name="subject_id">
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
                                            <select name="cc_recipients"
                                                    id="cc_recipients_select"
                                                    class="select2 form-control form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-8">
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
                                    <div class="col-4">
                                        <div class="mb-1">
                                            <strong>Show Auto Assign Rule  </strong>
                                            <div class="position-relative">
                                                <a href="#" onclick="showAutoAssignRules()" class="btn btn-warning">Auto Assign Rules</a>

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
                        <li class="nav-item">
                            <a class="nav-link "
                               id="homeIcon-tab"
                               data-toggle="tab"
                               href="#tickets"
                               aria-controls="home"
                               role="tab"
                               onclick="ticketsTab()"
                               aria-selected="true"
                            ><i data-feather="file-text"></i> Tickets
                                <div class="ml-2 badge badge-primary text-wrap" style="width: 4rem;"><span
                                            id="ticketsText"></span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               id="billing-tab"
                               data-toggle="tab"
                               href="#ticket_sla"
                               aria-controls="home"
                               role="tab"
                               onclick="progress()"
                               aria-selected="true"
                            ><i data-feather="activity"></i>In Progress
                                <div class="ml-2 badge badge-primary text-wrap" style="width: 4rem;">
                                    <span id="progressText"></span></div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link "
                               id="billing-tab"
                               data-toggle="tab"
                               href="#closed_tickets"
                               aria-controls="home"
                               role="tab"
                               onclick="closedTickets()"
                               aria-selected="true"
                            ><i data-feather="x-circle"></i>Closed Tickets
                                <div class="ml-1 badge badge-primary text-wrap" style="width: 4rem;">
                                    <span id="closedText"></span></div>
                            </a>
                        </li>
                        @if($canSeeUnassigned)
                            <li class="nav-item">
                                <a class="nav-link "
                                   id="billing-tab"
                                   data-toggle="tab"
                                   href="#unassigned_tickets"
                                   aria-controls="home"
                                   role="tab"
                                   aria-selected="true"
                                ><i data-feather="user-minus"></i>Unassigned Tickets
                                    <div class="ml-1 badge badge-primary text-wrap" style="width: 4rem;">
                                        <span id="unassignedText"></span></div>
                                </a>
                            </li>
                        @endif

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane " id="tickets" aria-labelledby="information-tab" role="tabpanel">
                            <div class="card">
                               
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table id="ticket-datatable" class="permission-list-table table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Subject</th>
                                                    <th>Customer</th>
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                    <th>Group</th>
                                                    <th>Type</th>
                                                    <th>Assigned to</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane active" id="ticket_sla" aria-labelledby="ticket_sla-tab" role="tabpanel">
                            <div class="card">
                                @if($errors->any())
                                    <div class="alert alert-danger" id="openticketerror" role="alert">
                                        <h4 class="alert-heading">Error Ticket is not saved</h4>
                                        <div class="alert-body">
                                            {{$errors->first()}}
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table id="inprogress-ticket-datatable" class="permission-list-table table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Subject</th>
                                                    <th>Customer</th>
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                    <th>Group</th>
                                                    <th>Type</th>
                                                    <th>Assigned to</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="closed_tickets" aria-labelledby="billingtab-tab" role="tabpanel">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table id="closed-ticket-datatable" class="permission-list-table table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Subject</th>
                                                    <th>Customer</th>
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                    <th>Group</th>
                                                    <th>Type</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form id="delete-ticket" action="" method="POST" style="display: none;">
                                @method('delete')
                                @csrf
                            </form>
                        </div>
                        @if($canSeeUnassigned)
                            <div class="tab-pane " id="unassigned_tickets" aria-labelledby="billingtab-tab" role="tabpanel">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="card-datatable table-responsive pt-0">
                                                <table id="unassigned-ticket-datatable" class="permission-list-table table">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Subject</th>
                                                        <th>Customer</th>
                                                        <th>Priority</th>
                                                        <th>Status</th>
                                                        <th>Group</th>
                                                        <th>Type</th>
                                                        <th>Assigned to</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
    <script src="{{ asset(mix('js/scripts/components/components-modals.js')) }}"></script>


@endsection

@section('page-script')
    <script src="{{ asset( 'js/scripts/forms/form-select2.js') }}"></script>
    <script src="{{ asset('js/scripts/Tickets/ticket-list.js') }}"></script>
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


