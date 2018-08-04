@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chat</div>

                <div class="card-body">

                    <div class="content_area">
                        <p>testtesttesttesttesttesttesttest</p>
                        <p>222testtesttesttest</p>
                        <p>test3test</p>
                        <p>444testtest44444</p>
                        <p>testtesttesttesttesttesttesttest555</p>
                        <p>testtes6666t</p>
                        <p>t77e7s7t77tes7t</p>
                        <p>testtesttesttesttesttesttesttest</p>
                        <p>222testtesttesttest</p>
                        <p>test3test</p>
                        <p>444testtest44444</p>
                        <p>testtesttesttesttesttesttesttest555</p>
                        <p>testtes6666t</p>
                        <p>t77e7s7t77tes7t</p>
                        <p>testtesttesttesttesttesttesttest</p>
                        <p>222testtesttesttest</p>
                        <p>test3test</p>
                        <p>444testtest44444</p>
                        <p>testtesttesttesttesttesttesttest555</p>
                        <p>testtes6666t</p>
                        <p>t77e7s7t77tes7t</p>
                        <p>testtesttesttesttesttesttesttest</p>
                        <p>222testtesttesttest</p>
                        <p>test3test</p>
                        <p>444testtest44444</p>
                        <p>testtesttesttesttesttesttesttest555</p>
                        <p>testtes6666t</p>
                        <p>t77e7s7t77tes7t</p>
                    </div>
                        <p>{{$data['content']}}</p>

                        <form method="POST" action="{{ route('comment') }}">
                            {{ csrf_field() }}
                            <input type="text" class="form-control" name="content">
                            <button class="btn btn-primary btn-block" type="submit">Submit</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
