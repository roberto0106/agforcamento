@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 100px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3></h3>
                    </div>
                </div>


                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    <hr>
                @endif

                <div class="card mb-3">
                    <div class="card-header"><h3>{{$budget->name}}</h3><b></b>
                        <a class="btn btn-success float-right" href="{{route('budget.in.categories')}}">Editar
                            Categorias</a>
                        <a class="btn btn-outline-primary float-right" style="margin-right: 5px; margin-left: 5px;"
                           href="{{route('budget.custom',['budget'=>$budget->id])}}">Customizar</a>
                        <a href="javascript:;" data-toggle="modal" onclick=""
                           data-target="#GerarLinkModal" class="btn btn-info float-right">Gerar Link</a>

                        <a class="btn btn-info float-right" style="margin-right: 5px;"
                           href="{{route('budget.edit',['budget'=>$budget->id])}}">Editar Orçamento</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th scope="row">Instituição / Cursos / Conclusão</th>
                                <td>{{$budget->client->institution}} - {{$budget->client->courses}}
                                    - @if($budget->client->month_conclusion<6)1 SEMESTRE @else 2 SEMESTRE @endif
                                    / {{$budget->client->year_conclusion}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <thead style="background: #f9f2f4">
                            <tr>
                                <td>Nome</td>
                                <td>Formandos</td>
                                <td>Convites por formando</td>
                                <td>Convites Extras</td>
                                <td>Valor</td>
                                <td>Mesas Extras</td>
                                <td>Valor</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($budget->eventTypes as $eventType)
                                <tr>
                                    <td>{{\App\Models\EventType::find($eventType->category_id)->name}}</td>
                                    <td>{{$eventType->number_forming}}</td>
                                    <td>{{$eventType->invitations_by_forming}}</td>
                                    <td>{{$eventType->extra_invitations}}</td>
                                    <td>R${{$eventType->extra_invitations_value}}</td>
                                    <td>{{$eventType->extra_tables}}</td>
                                    <td>R${{$eventType->extra_tables_value}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <thead style="background: #f9f2f4">
                            <tr>
                                <td>FEE</td>
                                <td>Exclusividade Fotográfica</td>
                                <td>Número de Parcelas</td>
                                <td>Validado até</td>
                                <td>Comissão</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$budget->fee}} %</td>
                                <td>R${{$budget->photo_exclusivity}}</td>
                                <td>{{$budget->number_of_installments}}</td>
                                <td>{{$budget->shelf_life}}</td>
                                <td>Integrantes da Comissão ({{$comissao->count()}}
                                    ) @if($budget->paying_commission == 0) | <span class="badge badge-primary"> Não Pagante </span> @else
                                        <span class="badge badge-secondary"> Pagarão {{ $budget->paying_commission }} % </span> @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header"><h3>Produtos e Serviços</h3><b></b></div>
                    <div class="card-body">
                        <form name="form_search" id="form_search" method="GET">
                            <div class="row">

                                <div class="col-md-11">
                                    <input class="form-control" type="text" name="search" id="search"
                                           placeholder="Digite o nome do Produto ou Serviço">
                                </div>
                                <div class="col-md-1">
                                    <button class="btn" type="submit" name="search_at" id="search_at"> Buscar</button>
                                </div>


                                <div class="col-md-12">
                                    <hr>
                                    <div class="card mb-3">
                                        <div class="card-body" style="height: 150px; overflow: auto">
                                            <table class="table table-striped">
                                                <tbody id="resProducts">
                                                <tr>
                                                    <td colspan="5">Nenhum produto buscado!</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card mb-3">
                    <div class="card-header"><h3>Produtos e Serviços</h3><b></b></div>
                    <div class="card-body">
                        <form name="form_search" id="form_search" method="GET">
                            <div class="row">

                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Nome</th>
                                            <th>Categoria</th>
                                            <th>Tipo Evento</th>
                                            <th>Valor</th>
                                            <th>Quantidade</th>
                                            <th>Subtotal</th>
                                            <th>Atualizar</th>
                                            <th>Apagar</th>
                                            <th>Editar</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="refreshProds">
                                        @foreach($products as $product)
                                            @php
                                                $subtotal = $product->price * $product->amount;
                                                @$total+= $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{$product->name}} </a></td>
                                                <td>{{$product->category->name}}</td>
                                                <td>{{\App\Models\EventType::find($product->category->event_type_id)->name}}</td>
                                                <td>{{number_format($product->price, 2, ',', '.')}}</td>
                                                <td><input type="number" name="amount" value="{{$product->amount}}"
                                                           class="form-control" id="prod_amount_{{$product->id}}"
                                                           style="width: 90px"></td>
                                                <td>{{number_format($subtotal, 2, ',', '.')}}</td>
                                                <td>
                                                    <button class="btn btn-success updateAmount"
                                                            data-id="{{$product->id}}"><i class="fa fa-refresh"> </i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger deleteProd"
                                                            data-id="{{$product->id}}"><i class="fa fa-trash"> </i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="{{route('budget.in.prod.edit',['prod' => $product->id])}}" class="btn btn-info"><i class="fa fa-edit"></i> </a>   
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="5">Total:</th>
                                            <th id="total">{{number_format(@$total, 2, ',', '.')}}</th>
                                        </tr>
                                        <tr class="sub-types-events">
                                            <th colspan="5">SubTotal:</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>


    <div id="GerarLinkModal" class="modal fade text-danger" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <form action="" id="deleteForm" method="post">
                <div class="modal-content">

                    <div class="modal-body">
                        <p class="text-center">
                            @if($flag==1)
                                Atenção! Ao clicar em Gerar Novo Link o link que seu cliente já possui será alterado.
                                Caso deseje somente ver a alteração que realizou, clique em <b>Ver link do orçamento
                                    editado</b>.
                            @else
                                Com essa ação você irá gerar um link de acesso para que seu cliente possa ver esse
                                orçamento online.
                                Todas as alterações que voce fizer nesse orçamento irão refletir nesse link.
                            @endisset
                        </p>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <a class="btn btn-primary float-right" style="margin-right: 5px;"
                               href="{{route('budget.in.viewlink')}}">Gerar Novo Link</a>

                            @if($flag==1)
                                <a class="btn btn-success float-right" style="margin-right: 5px;"
                                   href="{{route('budget.in.viewlinkExternal',$budget->token_access)}}">Ver link do
                                    orçamentos editado</a>
                            @endisset
                        </center>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="DeleteModal" class="modal fade text-danger" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->

            <div class="modal-content">

                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <p class="text-center">Tem certeza de que deseja retirar essa produto do orçamento ?</p>
                </div>
                <div class="modal-footer" id="refreshProdsModal">
                    <center>
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                        {{--                            <button type="submit" name="" class="btn btn-danger deleteProd" data-dismiss="modal" onclick="removeProduct()">Sim, retirar</button>--}}
                        <button class="btn btn-danger deleteProd" id="deleteProduct" data-dismiss="modal"><i
                                    class="fa fa-trash"></i></button>
                    </center>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
        var id_product = getUrlParameter('id_prod');

        function deleteData(id) {
            var id = id;
            $("#deleteProduct").attr('onclick', "deleteProduct(" + id + ")");
        }

        function deleteProduct(id) {
            console.log("qual id chegou aqui?" + id)
            var url = '{{env('APP_URL')}}/api/budget/products/delete/' + id;

            $.ajax({
                url: url,
                data: {id: id},
                dataType: 'json',
                method: "GET",
                beforeSend: function () {
                    $("#resProducts").loading();
                },
                success: function (data) {
                    if (data.error == 1) {
                        alert(data.msg);
                    }

                },
                complete: function () {
                    $("#resProducts").loading('stop');
                    refreshProds();
                }
            });
            return false;
        }

        function refreshProds() {
            console.log("inicio da refreshProds")
            $.ajax({
                url: '{{env('APP_URL')}}/api/budget/products/refresh',
                //url: 'http://pni-orcamento.test/api/budget/products/refresh',
                method: "GET",
                beforeSend: function () {
                    $("#refreshProds").loading();
                },
                success: function (data) {
                    $('#refreshProds').html('');
                    $.each(data.prods, function (index, value) {
                        console.log("Dentro da RefreshProducts qual id esta carregado:" + value.id)
                        var product_id = value.id;
                        var url_product_edit = "{{ route('budget.in.prod.edit', '_id_') }}".replace('_id_', product_id);

                        $('#refreshProds').append('<tr>' +
                            '<td>' + value.name + '</td>' +
                            '<td>' + value.category + '</td>' +
                            '<td>' + value.typeevent + '</td>' +
                            '<td>' + value.price + '</td>' +
                            '<td><input type="number" name="amount" value="' + value.amount + '" class="form-control" id="prod_amount_' + value.id + '" style="width: 90px"></td>' +
                            '<td>' + value.subtotal + '</td>' +
                            //'<td><button class="btn btn-success updateAmount" data-id="' + value.id + '"><i class="fa fa-refresh"></i></button> <button class="btn btn-danger deleteProd" data-id="' + value.id + '"> <i class="fa fa-trash"> </i> </button> </td>' +
                            '<td><button class="btn btn-success updateAmount" data-id="' + value.id + '"><i class="fa fa-refresh"></i></button></td>' + 
                            '<td><a href="javascript:;" data-toggle="modal" onclick="deleteData(' + value.id + ')"\n' +
                            '                           data-target="#DeleteModal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> <Apagar></Apagar></a></td>' +
                            '<td><a href="' + url_product_edit + '" class="btn btn-info"><i class="fa fa-edit"></i></td>' +
                            '</tr>');
                    });
                    $('#total').html(data.total);
                    $('.sub-types-events').html('');
                    $('.remove').remove();
                    $.each(data.rel, function (index, value) {
                        console.log(value);
                        $('.sub-types-events').before(
                            '<tr class="remove"><th colspan="5">' + index + ':</th>' +
                            '<th>' + value + '</th></tr>'
                        );
                    });
                },
                complete: function () {
                    $("#refreshProds").loading('stop');
                    $("#prod_amount_" + id_product).css("color", "red");
                    $("#prod_amount_" + id_product).focus();

                }
            });
        }

        $(function () {
            $('#form_search').submit(function (e) {
                var search = $('#search').val();
                $.ajax({
                    url: '{{env('APP_URL')}}/api/budget/products',
                    //url: 'http://pni-orcamento.test/api/budget/products',
                    data: {search: search},
                    method: "GET",
                    beforeSend: function () {
                        $("#resProducts").loading();
                    },
                    success: function (data) {
                        $('#resProducts').html('');
                        $.each(data, function (index, value) {
                            $('#resProducts').append('<tr><td>' + value.id + '</td><td>' + value.name + '</td><td>' + value.category + '</td><td>' + value.eventtype + '</td><td>' + value.price + '</td><td><button href="' + value.link + '" class="btn addProduct"><i class="fa fa-plus"></i></button></td></tr>')
                        });
                    },
                    complete: function () {
                        $("#resProducts").loading('stop');
                    }
                });
                return false;
            });
            $('#refreshProds').on('click', '.updateAmount', function () {
                var id = $(this).data('id');
                var price = parseFloat($("#product_price_" + id).val()) * 100;
                var amount = $("#prod_amount_" + id).val();
                var url = '{{env('APP_URL')}}/api/budget/products/update/amount/' + id;
                //var url = 'http://pni-orcamento.test/api/budget/products/update/amount/' + id;
                $.ajax({
                    url: url,
                    data: {id: id, amount: amount},
                    dataType: 'json',
                    method: "GET",
                    beforeSend: function () {
                        $("#resProducts").loading();
                    },
                    success: function (data) {
                        if (data.error == 1) {
                            alert(data.msg);
                        }
                        $("#prod_amount_51").focus();
                    },
                    complete: function () {
                        $("#resProducts").loading('stop');
                        refreshProds();
                    }
                });
                return false;
            });
            $('#refreshProds').on('click', '.deleteProd', function () {
                var id = $(this).data('id');
                var url = '{{env('APP_URL')}}/api/budget/products/delete/' + id;
                //var url = 'http://pni-orcamento.test/api/budget/products/delete/' + id;

                $.ajax({
                    url: url,
                    data: {id: id},
                    dataType: 'json',
                    method: "GET",
                    beforeSend: function () {
                        $("#resProducts").loading();
                    },
                    success: function (data) {
                        if (data.error == 1) {
                            alert(data.msg);
                        }
                    },
                    complete: function () {
                        $("#resProducts").loading('stop');
                        refreshProds();
                    }
                });
                return false;
            });
            $('#resProducts').on('click', '.addProduct', function () {
                var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    method: "GET",
                    beforeSend: function () {
                        $("#resProducts").loading();
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    complete: function () {
                        $("#resProducts").loading('stop');
                        refreshProds();
                        // $('#search').focus().select();

                    }
                });
                return false;
            })
            refreshProds();
        })

    </script>
@endsection
