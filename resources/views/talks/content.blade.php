@extends('layouts.app')

@section('content')
<div class="card maincontents_block">
    <div class="card-header">{{$room->room_name}}</div>
    <div class="card-body">
        <div class="content_area content_area" id="room">
            <ul style="list-style: none;" class="scroll_area scroll_content">
                </li>
                @foreach($contents as $content)

                    <li><span class="user_icon" style="background-image: url('{{asset('storage/'.$content->icon_path)}}')"></span> {{$content->user_name}}:{{$content->content}}</li>
                @endforeach
            </ul>
        </div>
        <form method="POST" action="{{ route('contents.store') }}">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="content" required>
            <input type="hidden" class="form-control" name="room_id" value="{{$room->room_id}}">
            <button class="btn btn-primary btn-block submit_btn" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
        </form>
    </div>
    <p id='lat'>{{$room->lat}},{{$room->lng}}</p>
</div>
@endsection
