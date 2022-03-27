<div class="text-center">
  @if($data->change_phone_request==1)
    <a href="#" onclick="changePhoneRequest({{ $data->id }})" class="btn btn-success">Approve</a>
  @else
    <span class="badge badge-danger">There is no request</span>
  @endif

</div>

