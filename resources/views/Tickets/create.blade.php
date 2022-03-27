@extends('layouts/contentLayoutMaster')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">

@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">

@endsection
@section('content')
    <section class="basic-select2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Ticket</h4>
                    </div>
                    <form id="formSubmit" enctype="multipart/form-data" action="{{route('tickets.store')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <strong>Customer</strong>
                                    <div class="position-relative">
                                        <select name="customer_id"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($ispUsers as $ispUser)
                                                <option value="{{$ispUser->id}}">{{$ispUser->username}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Assigned To</strong>
                                    <div class="position-relative">
                                        <select name="assigned_to"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($adminUsers as $adminUser)
                                                <option value="{{$adminUser->id}}">{{$adminUser->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Group</strong>
                                    <div class="position-relative">
                                        <select name="group"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Watchers</strong>
                                    <div class="position-relative">
                                        <select name="watchers[]" class="select2 form-control select2-hidden-accessible"
                                                multiple="" id="default-select-multi"
                                                data-select2-id="default-select-multi" tabindex="-1" aria-hidden="true">
                                            @foreach($adminUsers as $adminUser)
                                            <option value="{{$adminUser->id}}">{{$adminUser->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Cc Recipients</strong>
                                    <div class="position-relative">
                                        <input name="cc_recipients" type="text" class="form-control" id="basicInput"
                                               placeholder="Type Cc Recipients"></div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Priority</strong>
                                    <div class="position-relative">
                                        <select name="priority"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($priorities as $priority)
                                                <option value="{{$priority->id}}">{{$priority->name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Status</strong>
                                    <div class="position-relative">
                                        <select name="status"
                                                class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($status as $statu)
                                                <option value="{{$statu->id}}">{{$statu->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Type</strong>
                                    <div class="position-relative">
                                        <select name="type" class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Subject</strong>
                                    <div class="position-relative">
                                        <input name="subject" class="form-control" type="text"
                                                  placeholder="Please type subject">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Location</strong>
                                    <div class="position-relative">
                                        <select class="select2 form-control form-control-lg select2-hidden-accessible"
                                                tabindex="-1" aria-hidden="true">
                                            <option value="It">It</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Attachments</strong>
                                    <div class="position-relative">
                                        <div class="custom-file">
                                            <input name="customFile" type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose Attachments</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-1">
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
                                <div class="col-12">
                                    <button type="submit"
                                            class="btn btn-primary mr-1 waves-effect waves-float waves-light">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset( 'js/scripts/forms/form-select2.js') }}"></script>
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


        $("#formSubmit").on("submit", function () {
            $("#content").val(fullEditor.root.innerHTML);
        })

    </script>
@endsection
