@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 50px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3 class="display-6">Clientes</h3>
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


                <form action="{{route('client.index')}}" method="GET">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Procurar Clientes..."
                                       required="required" maxlength="20" aria-label="Procurar Categoria...">
                                <div class="input-group-append" id="button-addon4">
                                    <button class="btn btn-info" type="submit">Buscar</button>
                                    <a href="{{route('client.index')}}" class="btn btn-danger btn" title="LIMPAR BUSCA">Limpar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-success btn-block" href="{{route('client.create')}}">+ Novo</a>
                        </div>
                    </div>
                </form>

                <hr>
                <table class="table table-responsive-md">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Instituição</th>
                        <th>Cursos</th>
                        <th>Conclusão</th>
                        <th>Nome da Turma</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->institution}}</td>
                            <td>{{$data->courses}}</td>
                            <td>{{\App\Models\Config::getMonthOfConclusion()[$data->month_conclusion]}}
                                / {{$data->year_conclusion}}</td>
                            <td>{{$data->name}}</td>
                            <td>
                                <a href="{{route('client.edit', $data->id)}}" class="btn btn-warning fa fa-edit"></a>
                                <a href="{{route('budget_for_client', $data->id)}}" class="btn btn-primary fa fa-money"></a>
                                <a href="{{route('client.destroy', $data->id)}}"
                                   class="btn btn-success fa fa-users"></a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    <div class="paging_simple_numbers">
                        {!! $clients->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                </div>

            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>

@endsection
