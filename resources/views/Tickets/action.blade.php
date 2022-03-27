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
            <li>
                @can('close Ticket')
                    <a title="Close Ticket" class="text-center" tabindex="-1" href="javascript:void(0)" onclick="closeTicket({{$data->id}})"
                       id="remove">
                        <span data-feather="x-circle"></span>
                    </a>
                @endcan
            </li>
            <li>
                    <a title="Show Tasks" class="text-center" tabindex="-1" href="javascript:void(0)" onclick="showTasks({{$data->id}})"
                       id="remove">
                        <span data-feather="info"></span>
                    </a>
            </li>
            <li>
                @can('show Ticket')
                    <a title="Show Ticket" tabindex="-1" href="/tickets/{{$data->id}}" id="remove">
                        <span data-feather="book-open"></span>
                    </a>
                @endcan
            </li>
            <li>
                @can('read Ticket')

                    @if($data->is_readed==0)
                        <div>
                            <a title="Read Ticket" tabindex="-1" href="javascript:void(0)"
                               onclick="changeReadStatusOfTicket({{$data->id}})"
                               id="delete_user">
                                <span data-feather="eye"></span>
                            </a>
                        </div>
                    @else
                        <div>
                            <a title="Unread Ticket" tabindex="-1" href="javascript:void(0)"
                               onclick="changeReadStatusOfTicket({{$data->id}})"
                               id="delete_user">
                                <span data-feather="eye-off"></span>
                            </a>
                        </div>
                    @endif
                @endcan
            </li>
        </ul>
    </div>
</div>

