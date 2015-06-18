@extends('layout')

@section('content')
    <div class="container">

        <div class="row">

            @include('admin_navigation')

            <div class="col-sm-8 table-responsive">
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
                @if (Session::has('warning'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('warning') }}</div>
                @endif
                @if (isset($warning))
                    <div class="alert alert-danger" role="alert">{{ $warning }}</div>
                @endif

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Subject</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (isset($mails))
                            @foreach($mails as $mail)
                                <tr>
                                    <td>{{ $mail->from_email }}</td>
                                    <td>{{ $mail->to_email }}</td>
                                    <td>{{ $mail->subject }}</td>
                                </tr>

                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (isset($mails))
                    @if (count($mails) > 0)
                        <div class="row text-right">
                            <a href="{{URL::route('backendCleanInbox')}}" class="btn btn-info" role="button">Clean inbox</a>
                        </div>
                    @endif
                @endif
            </div>

        </div>

    </div>
@stop