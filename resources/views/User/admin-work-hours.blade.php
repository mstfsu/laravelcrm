@extends('layouts/contentLayoutMaster')

@section('title', 'Admin Work Hours, '.$user->name)

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
    <section id="pick-a-time">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Change Admin Work Hours</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin_work_hours')}}">
                    @csrf
                    <input hidden name="user_id" value="{{$user->id}}">
                    <div class="table-responsive row justify-content-center ">

                        <table class="table">
                            <thead>
                            <tr>
                                <th style="width: 10%">Day</th>
                                <th style="width: 10%">Work</th>
                                <th style="width: 40%">Start Time</th>
                                <th style="width: 40%">Finish Time</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="pt-min-max">Monday</label>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input id="Monday" value="on" type="checkbox" @if($is_work_hours_added && $user->work_hours['Monday']['work']=="on") checked @endif   class="form-check-input checkbox" name="Monday[work]">
                                            <input id="MondayHidden" type='hidden' value='off' name="Monday[work]">

                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="MondayStartTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Monday']['start_time']}}@endif" name="Monday[start_time]">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="MondayFinishTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Monday']['finish_time']}}@endif" name="Monday[finish_time]">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="pt-min-max">Tuesday</label>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input id="Tuesday" @if($is_work_hours_added && $user->work_hours['Tuesday']['work']=="on") checked @endif  type="checkbox" class="form-check-input checkbox"
                                                   value="on"  name="Tuesday[work]">
                                            <input id="TuesdayHidden" type='hidden' value='off' name="Tuesday[work]">

                                        </div>

                                    </td>
                                    <td class="text-center">
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="TuesdayStartTime"  class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Tuesday']['start_time']}}@endif" name="Tuesday[start_time]" >
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input  id="TuesdayFinishTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Tuesday']['finish_time']}}@endif" name="Tuesday[finish_time]">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="pt-min-max">Wednesday</label>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input id="Wednesday" type="checkbox" @if($is_work_hours_added && $user->work_hours['Wednesday']['work']=="on") checked @endif class="form-check-input checkbox"
                                                 value="on"   name="Wednesday[work]">
                                            <input id="WednesdayHidden" type='hidden' value='off' name="Wednesday[work]">
                                        </div>

                                    </td>
                                    <td class="text-center">
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="WednesdayStartTime" class="form-control text-center"  type="time" name="Wednesday[start_time]" value="@if($is_work_hours_added){{$user->work_hours['Wednesday']['start_time']}}@endif">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="WednesdayFinishTime" class="form-control text-center" type="time" name="Wednesday[finish_time]" value="@if($is_work_hours_added){{$user->work_hours['Wednesday']['finish_time']}}@endif">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="pt-min-max">Thursday</label>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input  id="Thursday"   @if($is_work_hours_added && $user->work_hours['Thursday']['work']=="on") checked @endif type="checkbox" class="form-check-input checkbox"
                                                  value="on"  name="Thursday[work]">
                                            <input id="ThursdayHidden" type='hidden' value='off' name="Thursday[work]">


                                        </div>

                                    </td>
                                    <td class="text-center">
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="ThursdayStartTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Thursday']['start_time']}}@endif" name="Thursday[start_time]">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="ThursdayFinishTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Thursday']['finish_time']}}@endif" name="Thursday[finish_time]">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="pt-min-max">Friday</label>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input id="Friday" @if($is_work_hours_added && $user->work_hours['Friday']['work']=="on") checked @endif  type="checkbox" class="form-check-input checkbox"
                                                 value="on"   name="Friday[work]">
                                            <input id="FridayHidden" type='hidden' value='off' name="Friday[work]">

                                        </div>

                                    </td>
                                    <td class="text-center">
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="FridayStartTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Friday']['start_time']}}@endif" name="Friday[start_time]">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="FridayFinishTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Friday']['finish_time']}}@endif" name="Friday[finish_time]">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="pt-min-max">Saturday</label>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input id="Saturday" @if($is_work_hours_added && $user->work_hours['Saturday']['work']=="on") checked @endif  type="checkbox" class="form-check-input checkbox"
                                                  value="on"  name="Saturday[work]">
                                            <input id="SaturdayHidden" type='hidden' value='off' name="Saturday[work]">

                                        </div>

                                    </td>
                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="SaturdayStartTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Saturday']['start_time']}}@endif" name="Saturday[start_time]">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="SaturdayFinishTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Saturday']['finish_time']}}@endif" name="Saturday[finish_time]">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="pt-min-max">Sunday</label>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input id="Sunday"  type="checkbox" @if($is_work_hours_added && $user->work_hours['Sunday']['work']=="on") checked @endif class="form-check-input checkbox"
                                                value="on"    name="Sunday[work]">
                                            <input id="SundayHidden" type='hidden' value='off' name="Sunday[work]">

                                        </div>

                                    </td>
                                    <td class="text-center">
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="SundayStartTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Sunday']['start_time']}}@endif" name="Sunday[start_time]">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-12 col-md-6 form-group">
                                            <input id="SundayFinishTime" class="form-control text-center" type="time" value="@if($is_work_hours_added){{$user->work_hours['Sunday']['finish_time']}}@endif" name="Sunday[finish_time]">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 col-md-12 col-12 offset-sm-3 float-right">
                        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('input[type=checkbox]').each(function () {
                if(this.checked){
                    $('#'+this.id+"Hidden").prop('disabled', true);

                }
            });
            $(".checkbox").change(function() {
                if(this.checked) {
                   $('#'+this.id+"StartTime").prop('required',true);
                   $('#'+this.id+"FinishTime").prop('required',true);
                   $('#'+this.id+"Hidden").prop('disabled', true);
                }else{
                    $('#'+this.id+"StartTime").prop('required',false);
                    $('#'+this.id+"FinishTime").prop('required',false);
                    $('#'+this.id+"Hidden").prop('disabled', false);

                }
            });
        });
    </script>


@endsection
