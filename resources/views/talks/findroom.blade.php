@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Rooms you can join</div>
                <div class="card-body">
                    <div class="content_area" id="room" style="overflow: scroll;">
                        <ul style="list-style: none;">
                            @foreach($rooms as $room)
                                <li>
                                    <p>
                                        {{ $room->room_name }}
                                    </p>
                                    <p>{{$room->room_description}}</p>
                                </li>
                                @component('components.modal')
                                    @slot('room_id', $room->room_id)
                                    @slot('room_name', $room->room_name)
                                    @slot('confirm', 'このルームに入りますか？')
                                    @slot('action', 'entryRoom')
                                    @slot('button_name', '入室')
                                @endcomponent
                            @endforeach
                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
