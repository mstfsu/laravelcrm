@extends('layouts/contentLayoutMaster')

@section('title', 'Task List')
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

                        <div class="form-group col-md-3">
                            <label class="form-label" for="first-name-vertical">Ticket Subject</label>
                            <select id="ticketSelect"
                                    class="select2 form-control livesearch form-control-lg select2-hidden-accessible"
                                    tabindex="-1" aria-hidden="true" name="customer_id">
                            </select>

                        </div>
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
                                                    <th>Ticket Subject</th>
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
                                                    <th>Ticket Subject</th>
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
                                                <th>Ticket Subject</th>
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
    <script src="{{ asset('js/scripts/Tasks/task-list.js') }}"></script>
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


