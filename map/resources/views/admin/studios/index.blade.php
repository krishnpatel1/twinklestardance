@extends('layouts.app')

@section('content')
    <div class="container">        
        <div class="panel panel-default">
            <div class="panel-heading">Studios</div>
            <div class="panel-body">

                <a href="{{ url('/admin/studios/create') }}" class="btn btn-primary btn-xs" title="Add New studio"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>
                <br/>
                <br/>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>ID</th><th> Name </th><th> Address </th><th> Country </th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($studios as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td><td>{{ $item->address }}</td><td>{{ $item->countryRelationship->name }}</td>
                                <td>
                                    <a href="{{ url('/admin/studios/' . $item->id) }}" class="btn btn-success btn-xs" title="View studio"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                                    <a href="{{ url('/admin/studios/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit studio"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                                    {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['/admin/studios', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete studio" />', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Delete studio',
                                                'onclick'=>'return confirm("Confirm delete?")'
                                        )) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {!! $studios->render() !!} </div>
                </div>

            </div>
        </div>            
    </div>
@endsection