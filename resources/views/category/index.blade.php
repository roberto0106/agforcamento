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

                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    <hr>
                @endif


                <hr>

                <form action="{{route('category.index')}}" method="GET">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Procurar categorias..."
                                       required="required" maxlength="20" aria-label="Procurar Categoria...">
                                <div class="input-group-append" id="button-addon4">
                                    <button class="btn btn-info" type="submit">Buscar</button>
                                    <a href="{{route('category.index')}}" class="btn btn-danger btn" title="LIMPAR BUSCA">Limpar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-success btn-block" href="{{route('category.create')}}">+ Novo</a>
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-responsive-md">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Icone</th>
                        <th>Nome</th>
                        <th>Tipo Evento</th>
                        <th>Posição</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td><img src="{{ url("img/icons/".$category->image) }}" class="mr-3" alt="..." style="width: 32px; background-color: black;"></td>
                            <td>{{$category->name}}</td>
                            <td>{{$eventTypes[$category->event_type_id]}}</td>
                            <td>{{$category->position}}</td>
                            <td>{{$category->status}}</td>
                            <td>
                                <a href="{{route('category.edit', $category->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="{{route('category.destroy', $category->id)}}" class="btn btn-info"><i class="fa fa-search-plus"></i></a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    <div class="paging_simple_numbers">
                        {!! $categories->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                </div>

            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
