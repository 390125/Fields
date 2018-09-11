@extends('layouts.app')

@section('content')
<div class="card maincontents_block">
    <div class="card-header">ROOOOOMS</div>
    <div class="card-body">
        <div class="room_area" id="room">
            <ul style="list-style: none;" class="scroll_area scroll_room">
                @if (count($rooms) > 0)
                    @foreach($rooms as $room)
                        <li class="room_record">
                            <p class="room_name">
                                　<a href="{{ route('contents.show', ['content' => $room->room_id] ) }}">{{ $room->room_name }}</a>
                                <img src="{{ asset('img/system/enter.png') }}" width="20px" data-toggle="modal" data-target="#room_{{$room->room_id}}">
                            </p>
                                @component('components.modal')
                                    @slot('room_id', $room->room_id)
                                    @slot('room_name', $room->room_name)
                                    @slot('confirm', '本当にこのルームから退出しますか？')
                                    @slot('action', 'exitRoom')
                                    @slot('button_name', 'exit')
                                @endcomponent
                        </li>
                    @endforeach
                @else
                    <p>　現在参加中の部屋はありません。</p>
                    <a class="nav-link" href="{{ route('find') }}">入室可能な部屋を探しに行く</a>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
