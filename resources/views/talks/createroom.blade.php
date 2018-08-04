@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chat</div>
                <button id="getLocation">位置情報取得！</button>
                <div id="location"></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('rooms.store') }}">
                        {{ csrf_field() }}
                        <p>ルーム：</p><input type="text" class="form-control" name="room_name" required>
                        <p>説明文：</p><input type="text" class="form-control" name="room_description">
                        <input type="hidden" id="lat" class="form-control" name="lat">
                        <input type="hidden" id="lng" class="form-control" name="lng">
                        <button class="btn btn-primary btn-block submit_btn" type="submit" onclick="this.disabled=true;this.form.submit();">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
