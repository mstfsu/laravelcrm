@extends('layouts/contentLayoutMaster')

@section('title', 'Ticket Detail')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">

@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/pages/app-chat-list.css'))}}">

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
@endsection

@section('content')
    <section class="">
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
        <div class="modal fade" id="getTicketSubjectsOfType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                <select id="ticketSubjectsOfType"
                                        class="select2 form-control form-control-lg select2-hidden-accessible"
                                        tabindex="-1" aria-hidden="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade " id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 col-12">
                            <form class="form form-vertical" id="createForm" enctype="multipart/form-data"
                                  action="{{route('tasks.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="first-name-vertical">Type</label>
                                            <select id="typeSelect"
                                                    class="select2 form-control form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true" name="task_type_id" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="email-id-vertical">Subject</label>
                                            <select id="subjectSelect"
                                                    class="select2 form-control form-control-lg select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true" name="task_subject_id" required>
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
                                                        tabindex="-1" aria-hidden="true" required> 
                                                    @foreach($status as $statu)
                                                        <option value="{{$statu->id}}">{{$statu->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <strong>Group :  <span class="badge badge-success">{{ $ticket->group->name }}</span>
                                        </strong>
                                        <div class="position-relative">
                                            <input hidden type="text" value="{{ $ticket->group_id }}"  name="group_id">
                                        </div>
                                    </div>

                                    <div class="col-12 mt-1">
                                        <div class="mb-2">
                                            <strong>Assigne to Agent</strong>
                                            <div class="position-relative">
                                                <select name="assigned_agent"
                                                        class="select2 form-control form-control-lg select2-hidden-accessible"
                                                        tabindex="-1" aria-hidden="true" id="assigned_agent" required>
                                                </select>
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
                                        <input name="ticket_id" value="{{ $ticket->id }}" id="ticketId" style="display:none" />

                                        <input name="priority_id" value="{{ $ticket->priority->id }}" style="display:none" />

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
        <div class="modal fade " id="changeAttribute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 col-12">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" id="modalHeader" for="first-name-vertical"></label>
                                    <select id="customSelect"
                                        class="select2 form-control form-control-lg select2-hidden-accessible"
                                        tabindex="-1" aria-hidden="true">
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-detached">
            <div class="content-body">
                <div class="blog-detail-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="card-title">Ticket Subject: <span
                                                class=" badge badge-primary"> {{$ticket->subject->name}}</span></h4>
                                        </div>
                                        @can('Create Task')
                                        <div class="col-md-2 mb-2">
                                            <button onclick="createTask()" class="btn btn-success">create task</button>
                                        </div>
                                        @endcan
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-sm-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Attributes</th>
                                                        <th>Value</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Assigned to admin</td>
                                                        <td onclick="changeAttribute('User')">
                                                           <a href="#"> <span class="badge rounded-pill badge-light-danger me-50"  id="User">@if(isset($ticket->assigned_user->name)){{$ticket->assigned_user->name}}@else Unassigned @endif</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type</td>
                                                        <td onclick="changeAttribute('Type')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-danger me-50" id="Type">{{$ticket->type->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Subject</td>
                                                        <td>
                                                            <a href="#"><span class="badge rounded-pill badge-light-danger me-50" id="Subject">{{$ticket->subject->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td >
                                                            <span class="badge rounded-pill badge-light-warning me-50">{{$ticket->customer->username}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Priority</td>
                                                        <td onclick="changeAttribute('Priority')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-success me-50" id="Priority">{{$ticket->priority->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td onclick="changeAttribute('Status')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-primary me-50" id="Status">{{$ticket->status->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Group</td>
                                                        <td onclick="changeAttribute('ClassificationGroup')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-secondary me-50" id="ClassificationGroup">{{$ticket->group->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Watchers</td>
                                                        <td>
                                                            @foreach($ticket->watchers as $watcher)
                                                                <span class="badge rounded-pill badge-light-danger me-50">{{$watcher->name}}</span>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Attachment</td>
                                                        <td>
                                                            @if($ticket->attachment_url!=null)
                                                                <a target="_blank"
                                                                   href="{{route('download_file',['ticketid'=>$ticket->id,'filename'=>$ticket->attachment_url])}}">Download
                                                                    Attachment</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="card chat-widget">
                                                <div class="card-header" style="background-color:#7367f0">
                                                    <div class="d-flex align-items-center">
                                                        <h5 class="mb-0 text-white">Messages About Tickets</h5>
                                                    </div>
                                                </div>
                                                <section class="chat-app-window">
                                                    <div class="user-chats" style="height: 320px">
                                                        <div class="chats" style="overflow-y: scroll !important; height:300px !important;" id="chats">
                                                            @foreach($ticket->messages as $message)
                                                                @if($message->model=="admin")
                                                                    <div class="chat">
                                                                        <div class="chat-avatar">
                                                                            <span class="avatar box-shadow-1 cursor-pointer">
                                                                                <img src="https://media.istockphoto.com/vectors/male-avatar-profile-picture-employee-work-vector-id931887468"
                                                                                     alt="avatar" height="36"
                                                                                     width="36">
                                                                            </span>
                                                                        </div>
                                                                        <div class="chat-body">
                                                                            <div class="chat-content">
                                                                                <p>{{$message->message}}</p>
                                                                                <hr>
                                                                                <small>{{isset($message->admin->name)==true?$message->admin->name:"Unassigned"}}</small>
                                                                                <br>
                                                                                <small>{{$message->created_at}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="chat chat-left receiver">
                                                                        <div class="chat-avatar">
                                                                    <span class="avatar box-shadow-1 cursor-pointer">
                                                                      <img src="https://media.istockphoto.com/vectors/male-avatar-profile-picture-employee-work-vector-id931887468"
                                                                           alt="avatar" height="36" width="36">
                                                                    </span>
                                                                        </div>
                                                                        <div class="chat-body">
                                                                            <div class="chat-content">
                                                                                <p>{{$message->message}}</p>
                                                                                <hr>
                                                                                <small>{{$message->customer->username}}</small>
                                                                                <br>
                                                                                <small>{{$message->created_at}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <form class="chat-app-form" method="POST" id="messageForm" action="javascript:void(0);">
                                                        @if($ticket->assigned_user != null)
                                                        <div class="input-group input-group-merge me-50 w-75 form-send-message">
                                                            <span class="input-group-text">
                                                              <label for="attach-doc" class="attachment-icon mb-0">
                                                                <input type="file" id="attach-doc"
                                                                       hidden=""> </label></span>
                                                            <input type="text" name="message" class="form-control message" id="message"
                                                                   placeholder="Type your message">
                                                        </div>
                                                      

                                                        <button type="button"
                                                                class="btn  send waves-effect waves-float waves-light"
                                                                onclick="sendMessage({{\Illuminate\Support\Facades\Auth::user()}});" style="background-color: #7367f0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                 height="14" viewBox="0 0 24 24" fill="none"
                                                                 stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="feather feather-send d-lg-none">
                                                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                            </svg>
                                                            <span class="d-none text-nowrap text-white d-lg-block">Send</span>
                                                        </button>
                                                        @else
                                                        <span class="badge badge-warning">When admin assigned this ticket you can send message from here</span>
                                                        @endif
                                                    </form>
                                                </section>
                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="col-sm-12 col-md-12 overflow-auto">
                                            <h4>Ticket Message: </h4>
                                            <p class="card-text mb-2">
                                                {!! $ticket->message !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card user-card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="mikrotik_tab" role="tablist">
                                        @can('Show New Tasks')
                                        <li class="nav-item">
                                            <a class="nav-link "
                                               id="homeIcon-tab"
                                               data-toggle="tab"
                                               href="#tasks"
                                               aria-controls="home"
                                               role="tab"
                                               onclick="ticketsTab()"
                                               aria-selected="true"
                                            ><i data-feather="file-text"></i> Tasks
                                                <div class="ml-2 badge badge-primary text-wrap" style="width: 4rem;"><span
                                                            id="ticketsText"></span>
                                                </div>
                                            </a>
                                        </li>
                                        @endcan
                                      @can('Show Inprogress Tasks')
                                      <li class="nav-item">
                                        <a class="nav-link active"
                                           id="billing-tab"
                                           data-toggle="tab"
                                           href="#inprogress"
                                           aria-controls="home"
                                           role="tab"
                                           onclick="progress()"
                                           aria-selected="true"
                                        ><i data-feather="activity"></i>In Progress
                                            <div class="ml-2 badge badge-primary text-wrap" style="width: 4rem;">
                                                <span id="progressText"></span></div>
                                        </a>
                                    </li>
                                      @endcan
                                       
                                        @can('Show Closed Tasks')
                                        <li class="nav-item">
                                            <a class="nav-link "
                                               id="billing-tab"
                                               data-toggle="tab"
                                               href="#closed_tickets"
                                               aria-controls="home"
                                               role="tab"
                                               onclick="closedTickets()"
                                               aria-selected="true"
                                            ><i data-feather="x-circle"></i>Closed Tasks
                                                <div class="ml-1 badge badge-primary text-wrap" style="width: 4rem;">
                                                    <span id="closedText"></span></div>
                                            </a>
                                        </li>
                                        @endcan
                                       
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane " id="tasks" aria-labelledby="information-tab" role="tabpanel">
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
                                                            <table id="task-datatable" class="permission-list-table table">
                                                                <thead class="thead-light">
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Task Subject</th>
                                                                    <th>Priority</th>
                                                                    <th>Status</th>
                                                                    <th>Group</th>
                                                                    <th>Type</th>
                                                                    <th>Assigned Agent</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                
                                        </div>
                                        @can('Show Inprogress Tasks')
                                        <div class="tab-pane active" id="inprogress" aria-labelledby="inprogress-tab" role="tabpanel">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="card-datatable table-responsive pt-0">
                                                            <table id="task-inprogress" class="permission-list-table table">
                                                                <thead class="thead-light">
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Task Subject</th>
                                                                    <th>Priority</th>
                                                                    <th>Status</th>
                                                                    <th>Group</th>
                                                                    <th>Type</th>
                                                                    <th>Assigned Agent</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endcan
                                        <div class="tab-pane " id="closed_tickets" aria-labelledby="billingtab-tab" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="card-datatable table-responsive pt-0">
                                                        <table id="closed-task-datatable" class="permission-list-table table">
                                                            <thead class="thead-light">
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Task Subject</th>
                                                                <th>Priority</th>
                                                                <th>Status</th>
                                                                <th>Group</th>
                                                                <th>Type</th>
                                                                <th>Assigned Agent</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <form id="delete-ticket" action="" method="POST" style="display: none;">
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </div>
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
    <script src="https://cdn.socket.io/4.1.2/socket.io.min.js" integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts/Tickets/show-ticket.js') }}"></script>

    <script type="text/javascript">
        var modelName="";
        var typeId;
        var ticketIdForType;
        function sendMessage(user){
            let _token = $('meta[name="csrf-token"]').attr('content');
            if($('#message').val()==""){
                toastr['error']('Error! Please type something before send message', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                return false;
            }
            $.ajax({
                url: "send_message",
                type: "POST",
                data: {
                    recipient: {{ $ticket->customer->id }},
                    message: $('#message').val(),
                    ticket_id:{{$ticket->id}},
                    created_by:{{\Illuminate\Support\Facades\Auth::id()}},
                    model:'admin',
                    _token: _token
                },
                success: function (response) {
                    toastr['success'](response.message, {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    sentMessage(user,response);
                    $('#message').val('');

                },
            });
        }
        $(document).ready(function () {

            $("#ticketSubjectsOfType").on("select2:select", function (e) {
                var subjectId = $('#ticketSubjectsOfType').select2('data')[0].id;
                var subjectName = $('#ticketSubjectsOfType').select2('data')[0].text;

                var selectedName = $('#customSelect').select2('data')[0].text;
                $.ajax({
                url: "/tickets/change_type",
                data: {id: ticketIdForType, type: typeId, subject: subjectId},
                success: function (response) {
                    toastr['success']('Success! Type is changed', {
                        closeButton: true,
                        tapToDismiss: false,
                        });
                    $('#getTicketSubjectsOfType').modal('hide');
                    $('#'+modelName).text(selectedName);
                    $('#Subject').text(subjectName);

                    }
                });
            });

            $('#createForm').validate({
                rules: {
                    task_type_id: {
                        required: true,
                    },
                    task_subject_id: {
                        required: true,
                    },
                    assigned_agent: {
                        required: true,
                    },
                    status_id: {
                        required: true,
                    },
                }
            });

            $('#createForm').submit(function(e){
                e.preventDefault();
                if($('#createForm').valid()){
                    $.ajax({
                        type: "POST",
                        url: $('#createForm').attr('action'),
                        data: $(this).serialize(),
                        success: function(response)
                        {
                            $('#createTaskModal').modal('hide');

                            toastr['success'](response, {
                                closeButton: true,
                                tapToDismiss: false,
                            });
                            updateTables();

                        }
                    });
                }
              
            });

            $("#typeSelect").on("select2:select", function (e) {
                var typeId = $('#typeSelect').select2('data')[0].id;
                $.ajax({
                    url: "/tasks/get_subjects",
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

            $('#chats').scrollTop($('#chats').prop('scrollHeight'));
            var app_url = '{{getenv("APP_URL")}}' ;
            let user_id= {{\Illuminate\Support\Facades\Auth::id()}} ;
            let ticket_id = {{ $ticket->id }};
            var socket = io(app_url+':8083', { transports : ['websocket'] });
            socket.on('connect',function (){
                socket.emit("user_connected",user_id,ticket_id);
            })
            socket.on("private-channel:App\\Events\\PrivateMessageEvent",function (message){
                console.log("new message");
                receivedMessage(message);
            });
            $("#customSelect").on("select2:select", function (e) {
                var modelId = $('#customSelect').select2('data')[0].id;
                var selectedName = $('#customSelect').select2('data')[0].text;
                if(modelName==="Type"){
                    $('#changeAttribute').modal('hide');
                    $('#getTicketSubjectsOfType').modal('show');
                    $.ajax({
                        url: "/tickets/subjects_of_type",
                        data: {type_id: modelId},
                        success: function (response) {
                            $('#ticketSubjectsOfType').empty().trigger("change");
                            response.forEach(function (element) {
                                var newOption = new Option(element.name, element.id, false, false);
                                $('#ticketSubjectsOfType').append(newOption).trigger('change');
                            });
                            $('#ticketSubjectsOfType').val(null).trigger('change');  
                            typeId= modelId;    
                            ticketIdForType={{$ticket->id}};
                        }
                    });
                }else{                
                $.ajax({
                    url: "change_attribute",
                    data: {modelId: modelId,model:modelName.toLowerCase()+"_id",ticketId:{{$ticket->id}}},
                    success: function (response) {
                        toastr['success']('Success! Ticket attribute changed', {
                            closeButton: true,
                            tapToDismiss: false,
                        });
                        $('#'+modelName).text(selectedName);
                        $('#changeAttribute').modal('hide');
                    }
                });
        }
            });
        });

        function changeAttribute(model){
            modelName=model;
            $('#modalHeader').text("Select "+model);
            $('#changeAttribute').modal('show');
            $.ajax({
                url: "get_values",
                data: {model:model},
                success: function (response) {
                    $('#customSelect').empty().trigger("change");
                    response.forEach(function (element) {
                        console.log(element);
                        let newOption= new Option(element.name, element.id, false, false);
                        $('#customSelect').append(newOption).trigger('change');
                    });
                    $('#customSelect').val(null).trigger('change');

                }
            });
        }

        function sentMessage(user,response){
            const date= '<small>'+response.data.created_at+'</small>'

            const message = $('#message').val();
            const messageDiv = '<div class="chat">\n' +
                '               <div class="chat-avatar">\n' +
                '                       <span class="avatar box-shadow-1 cursor-pointer">\n' +
                '                               <img src="https://media.istockphoto.com/vectors/male-avatar-profile-picture-employee-work-vector-id931887468"\n' +
                '                                     alt="avatar" height="36"\n' +
                '                                 width="36">\n' +
                '                                  </span>\n' +
                '                           </div>\n' +
                '                        <div class="chat-body">\n' +
                '                      <div class="chat-content">\n' +
                '                    <p>' + message + '</p>\n' +
                '                    <hr>\n' +
                '                    <small>'+user.name+'</small>\n'+
                '                                         <br>\n'+
                                                        date            +
                '                  </div>\n' +
                '          </div>';
            $('#chats').append(messageDiv);
            $('#chats').scrollTop($('#chats').prop('scrollHeight'));

        }
        function receivedMessage(message){
            const date= '<small>'+message.data.data.created_at+'</small>'
            var newMessage = '  <div id="aa" class="chat chat-left receiver">\n'+
                '   <div class="chat-avatar">\n'+
                '       <span class="avatar box-shadow-1 cursor-pointer">\n'+
                '           <img src="https://media.istockphoto.com/vectors/male-avatar-profile-picture-employee-work-vector-id931887468"\n'+
                '                  alt="avatar" height="36" width="36">\n'+
                '                      </span>\n'+
                '                           </div>\n'+
                '                                 <div class="chat-body">\n'+
                '                                     <div class="chat-content">\n'+
                '                                         <p>'+message.data.data.message+'</p>\n'+
                '                                         <hr>\n'+
                '                                         <small>'+message.data.data.receiver_name+'</small>\n'+
                '                                         <br>\n'+
                                                            date+
                '                                     </div>\n'+
                '                                  </div>\n'+
                '                       </div>';
            $('#chats').append(newMessage);
            $('#chats').scrollTop($('#chats').prop('scrollHeight'));
        }

        function createTask(){
            $.ajax({
                url: "/tasks/get_types",
                data: {group_id:{{$ticket->group->id}}},
                success: function (response) {
                    toastr['success']('Success! Type was loaded', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    $('#typeSelect').empty().trigger("change");
                    response['types'].forEach(function (element) {
                        var newOption = new Option(element.name, element.id, false, false);
                        $('#typeSelect').append(newOption).trigger('change');
                    });
                    $('#typeSelect').val(null).trigger('change');

                

                    $('#assigned_agent').empty().trigger("change");
                    //var newOption = new Option("Auto Assign", 0, true, true);
                    //$('#assigned_agent').append(newOption).trigger('change');
                    response['groups']['agents'].forEach(function (element) {
                        var newOption = new Option(element.name, element.id, false, false);
                        $('#assigned_agent').append(newOption).trigger('change');
                    });
                }
            });
            $('#createTaskModal').modal('show');
        }
    </script>
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


