@extends('layouts/contentLayoutMaster')

@section('title', 'Agent List')
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
@endsection

@section('content')
    <section class="">
        <div class="col-12">
            <div class="card user-card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="mikrotik_tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active"
                               id="homeIcon-tab"
                               data-toggle="tab"
                               href="#agents"
                               aria-controls="home"
                               role="tab"
                               onclick="ticketsTab()"
                               aria-selected="true"
                            ><i data-feather="users"></i> Agents
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active " id="agents" aria-labelledby="information-tab" role="tabpanel">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table id="ticket-datatable" class="permission-list-table table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Company</th>
                                                    <th class="text-center">Change Phone Request</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <form id="delete-agent" action="" method="POST" style="display: none;">
                            @method('delete')
                            @csrf
                        </form>
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
    <script src="{{ asset('js/scripts/Agents/agents-list.js') }}"></script>
@endsection


