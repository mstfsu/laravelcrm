@extends('layouts/contentLayoutMaster')

@section('title', 'Task & Ticket Detail')
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
        <div class="content-detached">
            <div class="content-body">
                <div class="blog-detail-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-sm-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Task Attributes</th>
                                                        <th>Value</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Assigned Agent</td>
                                                        <td onclick="changeAttribute('User')">
                                                           <a href="#"> <span class="badge rounded-pill badge-light-danger me-50"  id="User">@if(isset($task->agent->name)){{$task->agent->name}}@else Unassigned @endif</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type</td>
                                                        <td onclick="changeAttribute('Type')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-danger me-50" id="Type">{{$task->type->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                  
                                                    <tr>
                                                        <td>Priority</td>
                                                        <td onclick="changeAttribute('Priority')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-success me-50" id="Priority">{{$task->priority->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td onclick="changeAttribute('Status')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-primary me-50" id="Status">{{$task->status->name}}</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Group</td>
                                                        <td onclick="changeAttribute('ClassificationGroup')">
                                                            <a href="#"><span class="badge rounded-pill badge-light-secondary me-50" id="ClassificationGroup">{{$task->group->name}}</span></a>
                                                        </td>
                                                    </tr>
                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-sm-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Ticket Attributes</th>
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
                                        <br>
                
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

     
   
@endsection


