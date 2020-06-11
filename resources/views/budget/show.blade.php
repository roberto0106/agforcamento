@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 50px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Lista de Categorias</h3>
                    </div>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <th scope="row">#ID</th>
                        <td>{{$category->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nome</th>
                        <td>{{$category->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tipo de Evento</th>
                        <td>{{$eventTypes[$category->event_type_id]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>{{$category->status}}</td>

                    </tr>
                    </tbody>

                </table>
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('category.destroy', $category->id)}}" method="POST">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="DELETE">
                            <input type="submit" value="Excluir" class="btn btn-danger btn btn-block">
                        </form>
                    </div>
                </div>

            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
