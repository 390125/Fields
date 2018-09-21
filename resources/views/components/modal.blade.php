<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#room_{{$room_id}}">
  {{$button_name}}
</button>


<!-- Modal -->
<div class="modal fade" id="room_{{$room_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{$room_name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{$confirm}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="location.href='{{ route($action, ['id' => $room_id] ) }}'">OK</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
