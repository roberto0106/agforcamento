@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 50px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Detalhes da Categoria</h3>
                        <div class="media">
                            <img src="{{ asset("img/icons/".$imagemCategoria) }}" class="mr-3" alt="..." style="width: 64px; background-color: black;">
                            <div class="media-body">
                              <h5 class="mt-0">{{$category->name}}</h5>
                              </div>
                            </div>
                          </div>  
                    </div>
                </div>
                
                <br><br>
                            
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
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$category->id}})"
                           data-target="#DeleteModal" class="btn btn-xs btn-danger btn-block"><i class="fa fa-trash"></i> <Apagar></Apagar></a>
                    </div>
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
                                <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Sim, Apagar</button>
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
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("category.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>
@endsection
