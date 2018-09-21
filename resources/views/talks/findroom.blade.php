@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Rooms you can join</div>
                <div id="location"></div>
                <div class="card-body">
                    <div class="content_area" id="room" style="overflow: scroll;">
                        @if (count($rooms) > 0)
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
                        @else
                            <!-- ボタンクリックでjs呼んで位置情報取得してcontrollerに渡す  -->
                            <form method="POST" action="{{ route('findRoom') }}">
                                <p>近くの部屋を探す</p>
                                {{ csrf_field() }}
                                <input type="hidden" id="lat" class="form-control" name="lat">
                                <input type="hidden" id="lng" class="form-control" name="lng">
                                <button class="btn btn-primary btn-block submit_btn" type="submit" onclick="this.disabled=true;this.form.submit();">Find！</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
