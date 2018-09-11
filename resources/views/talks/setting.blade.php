@extends('layouts.app')

@section('content')
<div class="card maincontents_block">
    <div class="card-header">Dashboard</div>
    <div class="card-body">

        Setting
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('updateUser', ['id' => Auth::user()->user_id] ) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="user_name" value="{{ Auth::user()->user_name }}" required>
            <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
            <input type="file" class="form-control" name="image" required>
            <button class="btn btn-primary btn-block submit_btn" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
        </form>
    </div>
</div>
@endsection
