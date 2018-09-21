@extends('layouts.app')

@section('content')
<div class="card maincontents_block">
    <div class="card-header">Rooms you can join</div>
    <div id="location"></div>
    <div class="card-body">
        @if (count($rooms) > 0)
            <div class="room_area" id="room">
                <ul style="list-style: none;" class="scroll_area scroll_room">
                    @foreach($rooms as $room)
                        <li class="room_record">
                            <p class="room_name" data-toggle="modal" data-target="#room_{{$room->room_id}}">
                                　<a href=#>{{ $room->room_name }}</a>
                            </p>
                            <p class="room_description">　{{$room->room_description}}</p>
                        </li>
                        @component('components.modal')
                            @slot('room_id', $room->room_id)
                            @slot('room_name', $room->room_name)
                            @slot('confirm', 'このルームに入りますか？')
                            @slot('action', 'entryRoom')
                            @slot('button_name', 'enter')
                        @endcomponent
                    @endforeach
                </ul>
            </div>
        @else
            <div class="content_area" id="room">
                <!-- ボタンクリックでjs呼んで位置情報取得してcontrollerに渡す  -->
                <form method="POST" action="{{ route('findRoom') }}">
                    <p>近くの部屋を探す</p>
                    {{ csrf_field() }}
                    <input type="hidden" id="lat" class="form-control" name="lat">
                    <input type="hidden" id="lng" class="form-control" name="lng">
                    <button class="btn btn-primary btn-block submit_btn" type="submit" onclick="this.disabled=true;this.form.submit();">Find！</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
