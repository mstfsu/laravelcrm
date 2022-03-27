@if($data->roles->count() > 0)

        @foreach ($data->roles as $role)

           <span class="badge badge-secondary" >{{$role->name}}</span>

        @endforeach

@endif
