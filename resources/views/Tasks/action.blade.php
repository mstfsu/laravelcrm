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
            @can('Close Task')
                  
            <li>
                <a title="Close Task" class="text-center" tabindex="-1" href="javascript:void(0)" onclick="closeTicket({{$data->id}})"
                   id="remove">
                    <span data-feather="x-circle"></span>
                </a>
        </li>
            @endcan
          
            @can('Show Task')
            <li>
                <a title="Show Task" tabindex="-1" href="/tasks/{{$data->id}}" id="remove">
                    <span data-feather="book-open"></span>
                </a>
            </li>
            @endcan
           
        </ul>
    </div>
</div>

