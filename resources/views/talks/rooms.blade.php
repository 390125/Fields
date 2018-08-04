@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ROOOOOMS</div>
                <div class="card-body">
                    <div class="content_area" id="room" style="overflow: scroll;">
                        <ul style="list-style: none;">
                            @foreach($rooms as $room)
                                <li>
                                    <p>
                                        <a href="{{ route('contents.show', ['content' => $room->room_id] ) }}">{{ $room->room_name }}</a>
                                    </p>
                                    <p>{{$room->room_description}}</p>
                                </li>
                                <li>
                                    @component('components.modal')
                                        @slot('room_id', $room->room_id)
                                        @slot('room_name', $room->room_name)
                                        @slot('confirm', '本当にこのルームから退出しますか？')
                                        @slot('action', 'exitRoom')
                                        @slot('button_name', '退出する')
                                    @endcomponent
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Button trigger modal -->





                </div>
            </div>
        </div>
    </div>
</div>
@endsection
