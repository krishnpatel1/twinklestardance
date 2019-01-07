@extends('layouts.app')

@section('content')
    <div class="container">        
        <div class="panel panel-default">
            <div class="panel-heading">Create New studio</div>
            <div class="panel-body">

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                {!! Form::open(['url' => '/admin/studios', 'class' => 'form-horizontal', 'files' => true]) !!}

                @include ('admin.studios.form')

                {!! Form::close() !!}

            </div>
        </div>            
    </div>
@endsection