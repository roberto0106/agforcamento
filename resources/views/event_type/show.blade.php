@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 100px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Detalhes do Cliente</h3>
                    </div>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <th scope="row">#ID</th>
                        <td>{{$client->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nome</th>
                        <td>{{$client->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Instituição</th>
                        <td>{{$client->institution}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Cursos</th>
                        <td>{{$client->courses}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Conclução</th>
                        <td>{{$month[$client->month_conclusion]}} / {{$client->year_conclusion}}</td>

                    </tr>
                    <tr>
                        <th scope="row">Comentário</th>
                        <td>{{$client->comments}}</td>

                    </tr>
                    </tbody>

                </table>
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('client.destroy', $client->id)}}" method="POST">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="DELETE">
                            <input type="submit" value="Excluir" class="btn btn-danger btn btn-block">
                        </form>
                    </div>
                </div>

                <hr>
                <form action="{{route('client.committeemembers.store', $client->id)}}" method="POST">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="name" placeholder="Nome"
                                   value="{{old('name')}}" required>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="email" name="email" placeholder="E-mail"
                                   value="{{old('email')}}" required>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="text" name="document" value="{{old('document')}}"
                                   placeholder="RG">
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="text" name="phone" value="{{old('phone')}}"
                                   placeholder="Telefone">
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="text" name="course" {{old('course')}} placeholder="Curso">
                        </div>
                        <div class="col-md-1">
                            <input type="submit" class="btn btn-success" value="Salvar">
                        </div>
                    </div>
                </form>

                <hr>
                @foreach($committeeMembers as $committeeMember)
                <div class="row" style=" margin-top: 5px;">
                    <div class="col-md-12">
                        <form action="{{route('client.committeemembers.update', ['client' => $client->id, 'committeeMember' => $committeeMember->id])}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" type="text" name="name" placeholder="Nome"
                                           value="{{$committeeMember->name}}" required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="email" name="email" placeholder="E-mail"
                                           value="{{$committeeMember->email}}" required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="document"
                                           value="{{$committeeMember->document}}" placeholder="RG">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="phone"
                                           value="{{$committeeMember->phone}}" placeholder="Telefone">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="course"
                                           value="{{$committeeMember->course}}" placeholder="Curso">
                                </div>
                                <div class="col-md-1">
                                    <input type="submit" class="btn btn-info" value="Editar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach()
            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
