@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 100px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Detalhes do Produto</h3>
                    </div>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <th scope="row">#ID</th>
                        <td>{{$productandservice->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nome</th>
                        <td>{{$productandservice->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Categoria</th>
                        <td>{{\App\Models\Category::getCategoryEventTypeArray()[$productandservice->category_id]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Preço</th>
                        <td>{{$productandservice->price}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Preço de Custo</th>
                        <td>{{$productandservice->cost_price}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Preço Minimo</th>
                        <td>{{$productandservice->minimum_price}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Descrição</th>
                        <td>{{$productandservice->description}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Proporção por pessoa</th>
                        <td>{{$productandservice->proportion_per_person}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Multiplicado por Formando</th>
                        <td>{{\App\Models\Config::yesNo()[$productandservice->multiplying_graduates]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Multiplicado por Convite</th>
                        <td>{{\App\Models\Config::yesNo()[$productandservice->multiplied_invitations]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Multiplicado por Convites Extras</th>
                        <td>{{\App\Models\Config::yesNo()[$productandservice->extras_invitations]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Multiplicado por Mesas Extras</th>
                        <td>{{\App\Models\Config::yesNo()[$productandservice->extras_tables]}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Sub Produto de</th>
                        @if($productandservice->alias > 0)
                        <td>{{\App\Models\ProductAndService::getProductsArray()[$productandservice->alias]}}</td>
                        @else()
                        <td>Nenhum</td>
                        @endif()
                    </tr>
                    <tr>
                        <th scope="row">Comentário</th>
                        <td>{{$productandservice->comments}}</td>

                    </tr>
                    </tbody>

                </table>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('productandservice.edit', $productandservice->id)}}" class="btn btn-warning btn-block">Editar</a>
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('productandservice.destroy', $productandservice->id)}}" method="POST">
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
