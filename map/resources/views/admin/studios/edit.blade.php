@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Edit studio {{ $studio->id }}</div>
            <div class="panel-body">

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                {!! Form::model($studio, [
                    'method' => 'PATCH',
                    'url' => ['/admin/studios', $studio->id],
                    'class' => 'form-horizontal',
                    'files' => true
                ]) !!}

                @include ('admin.studios.form', ['submitButtonText' => 'Update'])

                {!! Form::close() !!}

            </div>
        </div>            
    </div>
@endsection