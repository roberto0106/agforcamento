@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 50px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Lista de Produtos</h3>
                    </div>
                </div>

                <hr>

                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    <hr>
                @endif


                <form action="{{route('productandservice.index')}}" method="GET">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Procurar produtos e serviços..."
                                       required="required" maxlength="20" aria-label="Procurar produtos e serviços...">
                                <div class="input-group-append" id="button-addon4">
                                    <button class="btn btn-info" type="submit">Buscar</button>
                                    <a href="{{route('productandservice.index')}}" class="btn btn-danger btn" title="LIMPAR BUSCA">Limpar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-success btn-block" href="{{route('productandservice.create')}}">+ Novo</a>
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-responsive-md">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Categoria</th>
                        <th>Qt Subs</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                  @foreach($pas as $p)
                        <?php
                        $subProducts = \App\Models\ProductAndService::where('alias', $p->id)->get();
                        ?>
                        <tr>
                            <td>{{$p->id}}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->price}}</td>
                            <td>{{\App\Models\Category::getCategoryEventTypeArray()[$p->category_id]}}</td>
                            <td>{{$subProducts->count()}}</td>
                            <td>
                                <a href="{{route('productandservice.edit', $p->id)}}" class="btn btn-warning fa fa-edit" title="EDITAR"></a>
                                <a href="{{route('productandservice.destroy', $p->id)}}" class="btn btn-info fa fa-search-plus" title="VER"></a>
                            </td>

                        </tr>

                        @if($subProducts->count() > 0)
                            @foreach($subProducts as $sp)
                            <tr style="background: #f8f9fa; font-size: 16px; font-style: italic;">
                                <td style="background: #FFF; border-top: 0; "><i class="fa fa-arrow-right" style="color: orange"></i> </td>
                                <td style="border-top: 0;">{{$sp->name}}</td>
                                <td style="border-top: 0;">{{$sp->price}}</td>
                                <td style="border-top: 0;">{{\App\Models\Category::getCategoryEventTypeArray()[$sp->category_id]}}</td>
                                <td style="border-top: 0;"></td>
                                <td style="border-top: 0;">
                                    <a href="{{route('productandservice.edit', $sp->id)}}" class="btn btn-warning btn-sm fa fa-edit"></a>
                                    <a href="{{route('productandservice.destroy', $sp->id)}}" class="btn btn-info btn-sm fa fa-search-plus"></a>

                                </td>

                            </tr>
                            @endforeach
                        @endif()
                    @endforeach 
                    </tbody>
                </table>
                <div class="col-md-12">
                    <div class="paging_simple_numbers">
                        {!! $pas->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                </div>

            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
