<div class="text-center">
    <div class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" class="aas">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-more-vertical font-medium-3 cursor-pointer" data-bs-toggle="dropdown"
                 aria-expanded="false">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="12" cy="5" r="1"></circle>
                <circle cx="12" cy="19" r="1"></circle>
            </svg>
        </a>
        <ul class="dropdown-menu text-center" role="menu" aria-labelledby="dLabel">
            @can('Remove Agent')
            <li>
                <a title="Remove Agent" onclick="deleteAgent({{$data->id}})" href="javascript:void(0)" data-username="{{$data->username}}">
                    <span data-feather="x-circle"></span>
                </a>
            </li>
            @endcan
           
            @can('Show Agent')
            <li>
                <a title="Show Agent" tabindex="-1" href="/agents/{{$data->id}}" id="remove">
                    <span data-feather="book-open"></span>
                </a>
            </li>
            @endcan
           
            @can('Show Agent Work Hours')
            <li>
                <a href="{{route('agents_work_hours',$data->id)}}"   id="change_passs" title="Change Admin Work Hours"      ><span data-feather="calendar"></span></a>

            </li>
            @endcan
           @can('Edit Agent')
           <li>
            <a href="{{route('agents.edit',$data->id)}}" id="edit_admin" title="Edit Admin"      ><span data-feather="edit"></span></a>

        </li>
           @endcan
            
        </ul>
    </div>


</div>

