@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                @guest
                    <div class="card-body">

                        You are not login......

                        <a href="/login">login</a>
                    </div>
                @else
                    <div class="card-body">

                        You are login in!

                        <a href="/rooms">rooms</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
