@extends('layouts.app')

@section('content')
    <div class="container">        
        <div class="panel panel-default">
            <div class="panel-heading">studio {{ $studio->id }}</div>
            <div class="panel-body">

                <a href="{{ url('admin/studios/' . $studio->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit studio"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                {!! Form::open([
                    'method'=>'DELETE',
                    'url' => ['admin/studios', $studio->id],
                    'style' => 'display:inline'
                ]) !!}
                    {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-xs',
                            'title' => 'Delete studio',
                            'onclick'=>'return confirm("Confirm delete?")'
                    ))!!}
                {!! Form::close() !!}
                <br/>
                <br/>

                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>ID</th><td>{{ $studio->id }}</td>
                            </tr>
                            <tr><th> Name </th><td> {{ $studio->name }} </td></tr><tr><th> Address </th><td> {{ $studio->address }} </td></tr><tr><th> Country </th><td> {{ $studio->country }} </td></tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
            
    </div>
@endsection