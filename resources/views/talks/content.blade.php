@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <p id='lat'>{{$room->lat}},{{$room->lng}}</p>
                <div class="card-header">{{$room->room_name}}</div>


                <div class="card-body">
                    <div class="content_area" id="room" style="overflow: scroll;">
                        <ul style="list-style: none;">
                            </li>
                            @foreach($contents as $content)
                                <li>{{$content->user_name}}:{{$content->content}}</li>
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
            </div>
        </div>
    </div>
</div>
@endsection
