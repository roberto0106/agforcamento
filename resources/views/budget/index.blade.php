@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 60px;">
        <div class="container-fluid">
            <br>
            <h3>Lista de Orçamentos</h3>
            <br>
            <form action="{{route('budget.index')}}" method="GET">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Procurar orçamentos..."
                                   required="required" maxlength="20" aria-label="Procurar Orçamentos...">
                            <div class="input-group-append" id="button-addon4">
                                <button class="btn btn-info" type="submit">Buscar</button>
                                <a href="{{route('budget.index')}}" class="btn btn-danger btn" title="LIMPAR BUSCA">Limpar</a>
                            </div>
                        </div>
                    </div>
                    {{--
                                            <div class="col-md-3">
                                                <a class="btn btn-success btn-block" href="{{route('budget.create')}}">+ Novo</a>
                                            </div>
                    --}}
                </div>
            </form>

            <table class="table table-responsive-md">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Parcelas</th>
                  {{--  <th>Fee</th>
                    <th>Exclusividade Fotografica</th>--}}
                    <th>Validade</th>
                    <th>Comissão pagante</th>
                    <th>Status</th>
                    <th>Link</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($budget as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->number_of_installments}}</td>
                        {{--<td>{{$data->fee}}</td>
                        <td>{{$data->photo_exclusivity}}</td>--}}
                        <td>{{$data->shelf_life}}</td>
                        <td>{{$data->paying_commission}}</td>
                        <td>{{$data->status}}</td>
                        @if($data->token_access==null)
                            <td>Link ainda não gerado</td>
                        @else
                            <td>{{env('APP_URL')."/budget/in/viewLinkExternal/".$data->token_access}}</td>
                        @endif

                        <td>
                            <a href="{{route('budget.in.show', $data->id)}}" class="btn btn-warning fa fa-edit"></a>
                            <a href="{{route('budget.duplicate', $data->id)}}"
                               class="btn btn-success fa fa-files-o"></a>
                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$data->id}})"
                               data-target="#DeleteModal" class="btn btn-xs btn-danger fa fa-trash"></a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12">
                <div class="paging_simple_numbers">
                    {!! $budget->links('vendor.pagination.bootstrap-4') !!}
                </div>
            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')

        <div id="DeleteModal" class="modal fade text-danger" role="dialog">
            <div class="modal-dialog ">
                <!-- Modal content-->
                <form action="" id="deleteForm" method="post">
                    <div class="modal-content">

                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <p class="text-center">Tem certeza de que deseja apagar essa categoria ?</p>
                        </div>
                        <div class="modal-footer">
                            <center>
                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                <button type="submit" name="" class="btn btn-danger" data-dismiss="modal"
                                        onclick="formSubmit()">Sim, Apagar
                                </button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function deleteData(id) {
            var id = id;
            var url = '{{ route("budget.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit() {
            $("#deleteForm").submit();
        }
    </script>
@endsection

