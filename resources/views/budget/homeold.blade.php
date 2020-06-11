@extends('layouts.app')

@section('content')
@include('includes.menu')


<style>
    .big-checkbox {
        width: 20px;
        height: 20px;
    }
</style>


<div class="content-wrapper" style="padding-bottom: 100px;">

  

    @foreach ($categories as $item_category)
    <h4>{{$item_category->name}}</h4>
    @foreach ($products as $item)
    @if ($item_category->id == $item->category_id)
    
    <form class="form-inline">
        <div class="form-group col-sm-4">
          {{$item->name}}
        </div>
        <div class="form-group mb-2 col-sm-2">
          <label for="inputPassword2" class="sr-only">Quantidade</label>
          <input type="number" class="form-control" id="inputPassword2">
        </div>
        <hr>
    </form>  

    @endif
    @endforeach
    @endforeach
 

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
                            '<td><a href="' + url_product_edit + '" class="btn btn-info"> ' + value.name + ' </a></td>' +
                            '<td>' + value.category + '</td>' +
                            '<td>' + value.typeevent + '</td>' +
                            '<td>' + value.price + '</td>' +
                            '<td><input type="number" name="amount" value="' + value.amount + '" class="form-control" id="prod_amount_' + value.id + '" style="width: 90px"></td>' +
                            '<td>' + value.subtotal + '</td>' +
                            //'<td><button class="btn btn-success updateAmount" data-id="' + value.id + '"><i class="fa fa-refresh"></i></button> <button class="btn btn-danger deleteProd" data-id="' + value.id + '"> <i class="fa fa-trash"> </i> </button> </td>' +
                            '<td><button class="btn btn-success updateAmount" data-id="' + value.id + '"><i class="fa fa-refresh"></i></button> <a href="javascript:;" data-toggle="modal" onclick="deleteData(' + value.id + ')"\n' +
                            '                           data-target="#DeleteModal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> <Apagar></Apagar></a></td>' +
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