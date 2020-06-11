@extends('layouts.app')

@section('content')
    @include('includes.menu')

    <div class="content-wrapper">
        <div class="container-fluid">
            <br>

            @if ($message = Session::get('message'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>

            @endif


            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Administrador de Usuários</h1>
                    <p class="lead">Cada nível libera acesso a uma parte do sistema. A tabela abaixo mostra os níveis e quais partes os respectivos níveis tem acesso.</p>
                    <hr class="my-4">
                    <table class="table">
                       <thead>
                       <tr>
                           <th>Nivel</th>
                           <th>Perfil</th>
                           <th>Usuarios</th>
                           <th>Clientes</th>
                           <th>Orçamentos</th>
                           <th>Produtos</th>
                           <th>Categorias</th>
                           <th>Eventos</th>
                       </tr>
                       </thead>
                       <tbody>
                       <tr>
                           <td>0</td>
                           <td>Administrador</td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                       </tr>
                       <tr>
                           <td>1</td>
                           <td>Gestor</td>
                           <td><i class="fa fa-times"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                       </tr>
                       <tr>
                           <td>2</td>
                           <td>Vendedor</td>
                           <td><i class="fa fa-times"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-check"></i></td>
                           <td><i class="fa fa-times"></i></td>
                           <td><i class="fa fa-times"></i></td>
                           <td><i class="fa fa-times"></i></td>
                       </tr>

                       </tbody>
                   </table>
                </div>
            </div>
            <br>
            <a href="{{ route('user.create') }}" class="btn btn-success">Criar novo usuario</a>
            <br>
            <br>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Nivel</th>
                    <th>Criado</th>
                    <th>Ultima alteração</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->level}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>{{$data->updated_at}}</td>
                        <td>
                            <a href="{{route('user.edit', $data->id)}}" class="btn btn-warning fa fa-edit"></a>
                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$data->id}})"
                               data-target="#DeleteModal" class="btn btn-xs btn-danger fa fa-trash"></a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div id="DeleteModal" class="modal fade text-danger" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <form action="" id="deleteForm" method="post">
                <div class="modal-content">

                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <p class="text-center">Tem certeza de que deseja apagar esse usuarios ?</p>
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
@endsection

@section('scripts')
    <script type="text/javascript">
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("user.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>
@endsection