@extends('layout')

@section('content')
    <div class="container">

        <div class="row">

            @include('admin_navigation')

            <div class="col-sm-8 table-responsive">
                {{ Form::open(array('url' => '/admin/sendEmail')) }}
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

                    <div class="form-group">
                        {{ Form::label('from', 'From'); }}
                        {{ Form::email('from', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('subject', 'Subject'); }}
                        {{ Form::text('subject', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('text', 'Text'); }}
                        {{ Form::textarea('text', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::submit('Submit', array('class' => 'btn btn-default')); }}
                    </div>
                {{ Form::close() }}
            </div>

        </div>

    </div>
@stop