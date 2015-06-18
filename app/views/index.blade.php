@extends('layout')

@section('content')
    <div class="container">

        <div class="row text-center">
            <div class="col-sm-8 col-sm-offset-2">

            {{ Form::open(array('route' => 'frontendRegisterAddress')) }}
                <div class="form-group">
                    @if ($errors->has())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
                    @endif

                    {{ Form::label('email', 'E-Mail Address'); }}
                    {{ Form::email('email', null, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::submit('Submit', array('class' => 'btn btn-default')); }}
                </div>
            {{ Form::close() }}

            </div>
        </div>

    </div>
@stop