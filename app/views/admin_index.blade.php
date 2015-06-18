@extends('layout')

@section('content')
    <div class="container">

        <div class="row">

            @include('admin_navigation')

            <div class="col-sm-8 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($addresses as $address)
                            <tr>
                                <td>{{ $address->id }}</td>
                                <td>{{ $address->email }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@stop