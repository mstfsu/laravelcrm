@if(!auth()->user()->hasAnyRole(['super admin']))


<div >
    @can('delete admins')
    @if($data->id!=1)

        <a   title="Delete Admin" href="javascript:void(0)"  id="delete_admin"   data-id="{{$data->id}}"><span data-feather="trash-2"></span></a>

    @endif
    @endcan
        @can('edit Admins')
        <a href="/Admin/edit/{{$data->id}}" id="edit_admin" title="Edit ADmin"      ><span data-feather="edit"></span></a>
        @endcan
        @can('change')
            <a href="javascript:void(0)" data-id="{{$data->id}}"  id="change_pass" title="Change Password"      ><span data-feather="eye"></span></a>
        @endcan

</div>
@else
    <div >

            @if($data->id!=1)

                <a   title="Delete Admin" href="javascript:void(0)"  id="delete_admin"   data-id="{{$data->id}}"><span data-feather="trash-2"></span></a>

            @endif


            <a href="/Admin/edit/{{$data->id}}" id="edit_admin" title="Edit Admin"      ><span data-feather="edit"></span></a>


            <a href="javascript:void(0)" data-id="{{$data->id}}"  id="change_pass" title="Change Password"      ><span data-feather="eye"></span></a>

            <a href="{{route('Admin-admin_work_hours',$data->id)}}"   id="change_passs" title="Change Admin Work Hours"      ><span data-feather="calendar"></span></a>

    </div>
@endif
