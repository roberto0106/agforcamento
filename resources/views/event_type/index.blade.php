@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 50px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Lista de Tipos de Eventos</h3>
                    </div>
                </div>

                <hr>
                <form action="{{route('event_type.index')}}" method="GET">
                <div class="row">
                    <div class="col-md-9  col-sm-12">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Procurar Tipos de Evento..."
                                   required="required" maxlength="20" aria-label="Procurar Tipos...">
                            <div class="input-group-append" id="button-addon4">
                                <button class="btn btn-info" type="submit">Buscar</button>
                                <a href="{{route('event_type.index')}}" class="btn btn-danger btn" title="LIMPAR BUSCA">Limpar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-success btn-block" href="{{route('event_type.create')}}">+ Novo</a>
                    </div>
                </div>
                </form>


                <hr>

                <table class="table table-responsive-md">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Posição</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($eventTypes as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->status}}</td>
                            <td>{{$data->position}}</td>
                            <td>
                                <a href="{{route('event_type.edit', $data->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                @if(in_array($data->id, [1,2,3,4,5,6,7,8]))

                                @else
                                    <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$data->id}})"
                                       data-target="#DeleteModal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    <div class="paging_simple_numbers">
                        {!! $eventTypes->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                </div>

            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->

        <div id="DeleteModal" class="modal fade text-danger" role="dialog">
            <div class="modal-dialog ">
                <!-- Modal content-->
                <form action="" id="deleteForm" method="post">
                    <div class="modal-content">

                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <p class="text-center">Tem certeza de que deseja apagar esse evento ?</p>
                        </div>
                        <div class="modal-footer">
                            <center>
                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Sim, Apagar</button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('includes.footer')
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("event_type.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>
@endsection


