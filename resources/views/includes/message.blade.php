@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px;">
        <div class="container-fluid">

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Administrador de Usuários</h1>
                    <p class="lead">
                    @if ($message = Session::get('message'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>

                        @endif

                        </p>
                        <hr class="my-4">
                </div>
            </div>


        </div>
    </div>
@endsection