@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <br>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">

                    <div class="panel-body">
                        {{Form::model($user, array('route' => array('user.update', $user->id),'method' => 'PUT'))}}
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col">
                                <label for="name">Nome</label>
                                {{Form::text('name', null, array_merge(['class' => 'form-control','required']))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col">
                                <label for="name">Email</label>
                                {{Form::text('email', null, array_merge(['class' => 'form-control','required']))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col">
                                <label for="level">Nivel</label>
                                {{Form::text('level', null, array_merge(['class' => 'form-control','required']))}}
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Alterar
                                </button>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

