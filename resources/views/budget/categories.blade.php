@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="padding-bottom: 100px;">
        <div class="container-fluid">

            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Orçamento</h3>
                    </div>
                </div>
                <hr>
                <div class="card mb-3">
                    <div class="card-header">Dados do Orçamento<b></b>

                        @if($categoriesActives->count() > 0)
                            <a class="btn btn-success float-right" href="{{route('budget.in.home')}}">Home</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th scope="row">#ID</th>
                                <td>{{$budget->id}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nome</th>
                                <td>{{$budget->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Instituição</th>
                                {{--                                <td>{{$budget->client->name}} | {{$budget->client->institution}}</td>--}}
                                <td>{{$budget->client->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Cursos</th>
                                <td>{{$budget->client->courses}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Conclução</th>
                                <td>{{$budget->client->month_conclusion}} / {{$budget->client->year_conclusion}}</td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-9">
                        <h3>Orçamento - Gerenciando Tipos de Eventos</h3>
                    </div>
                </div>
                <hr>
                <form action="" method="POST">

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

                    @if(isset($categoriesArray) and count($categoriesArray) > 0)
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="formGroupExampleInput">Tipo de Evento</label>
                                {{Form::select('category_id', $categoriesArray, null, array_merge(['class' => 'form-control','id'=>'select_event_type','onchange'=>'myFunction()']))}}
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="number_forming">Total de Formandos</label>
                                <input class="form-control" type="number" id="number_forming" name="number_forming"
                                       placeholder="Total Formandos"
                                       value="{{old('number_forming')}}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="invitations_by_forming">Convites por Formando</label>
                                <input class="form-control" type="number" id="invitations_by_forming"
                                       name="invitations_by_forming"
                                       placeholder="Convites por Formando"
                                       value="{{old('invitations_by_forming')}}" required title="Convites por Formando">
                            </div>
                            <div class="col-md-4">
                                <label for="extra_invitations">Qt de Conv. Extras por Formando</label>
                                <input class="form-control" type="number" id="extra_invitations"
                                       name="extra_invitations"
                                       value="{{old('extra_invitations')}}"
                                       placeholder="QT Convites Extras" required title="QT Convites Extras">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="extra_invitations_value">Valor dos Convites Extras</label>
                                <input class="form-control" type="text" required id="extra_invitations_value"
                                       name="extra_invitations_value"
                                       value="{{old('extra_invitations_value')}}"
                                       placeholder="VL Convites Extras">
                            </div>
                            <div class="col-md-4">
                                <label for="extra_tables">Qt de Mesas Extras</label>
                                <input class="form-control" type="number" required id="extra_tables" name="extra_tables"
                                       value="{{old('extra_tables')}}"
                                       placeholder="QT Mesas Extras" title="QT Mesas Extras">
                            </div>
                            <div class="col-md-4">
                                <label for="extra_tables">Valor de Mesas Extras</label>
                                <input class="form-control" type="text" required id="extra_tables_value"
                                       name="extra_tables_value"
                                       {{old('extra_tables_value')}} placeholder="VL Mesas Extras">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <input type="submit" id="incluir" class="btn btn-success btn-block" value="Salvar">
                            </div>
                        </div>
                    @endif
                </form>

                <br>
                <div class="row">
                    <div class="col-md-9">
                        <h3>Orçamento - Tipos de Eventos Incluidos no Orçamento</h3>
                    </div>
                </div>
                <hr>
                @foreach($categoriesActives as $categoriesActive)
                    <div class="row" style=" margin-top: 5px;">
                        <div class="col-md-12">
                            <form action="{{route('budget.in.categories.update', ['eventtype' => $categoriesActive->id])}}"
                                  method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="category_name"><small>Tipo de Evento</small></label>
                                        <input class="form-control" disabled type="text" name="category_id"
                                               value="{{\App\Models\EventType::find($categoriesActive->category_id)->name}}"
                                               required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="number_forming"><small>Nº de Formandos</small></label>
                                        <input class="form-control" type="number" name="number_forming"
                                               placeholder="Total Formandos"
                                               value="{{$categoriesActive->number_forming}}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="invitations_by_forming"><small>Convites</small></label>
                                        <input class="form-control" type="number" name="invitations_by_forming"
                                               placeholder="Convites por Formando"
                                               value="{{$categoriesActive->invitations_by_forming}}" required
                                               title="Convites por Formando">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="extra_invitations"><small>Conv(Extras)</small></label>
                                        <input class="form-control" type="number" name="extra_invitations"
                                               value="{{$categoriesActive->extra_invitations}}"
                                               placeholder="QT Convites Extras" title="QT Convites Extras">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="extra_invitations_value"><small>$Conv(Extra)</small></label>
                                        <input class="form-control" name="extra_invitations_value" id="extra_invitations_value" value="{{$categoriesActive->extra_invitations_value}}"/>

                                    </div>
                                    <div class="col-md-4">
                                        <label for="extras_tables"><small>Mesas Ext</small></label>
                                        <input class="form-control" type="number" name="extra_tables"
                                               value="{{$categoriesActive->extra_tables}}"
                                               placeholder="QT Mesas Extras" title="QT Mesas Extras">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="extra_tables_value"><small>$Mesa(Extra) s/ convites</small></label>
                                        <input class="form-control" name="extra_tables_value" id="extra_tables_value" value="{{$categoriesActive->extra_tables_value}}"/>

                                    </div>
                                    <div class="col-md-4">
                                        <label for="editar">
                                            <small>Editar</small>
                                        </label>
                                        <button id="editar" type="submit" class="btn btn-info form-control"><i
                                                    class="fa fa-edit">Salvar</i></button>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="excluir"><small>Excluir</small></label>
                                        <button type="button" class="btn btn-danger form-control"
                                                onClick="document.getElementById('form_delete_{{$categoriesActive->id}}').submit()">
                                            <i class="fa fa-trash">Excluir</i></button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('budget.in.categories.delete', ['eventtype' => $categoriesActive->id])}}"
                                  method="POST" id="form_delete_{{$categoriesActive->id}}">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </div>
                    </div>
                    <hr>
                @endforeach()


            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection



@section('scripts')



    <script type="text/javascript">

        $( document ).ready(function() {
            $(".extra_tables_value").inputmask('R$ 999.999.999,99', {numericInput: true});    //123456  =>  R$ ___.__1.234,56
            $(".extra_invitations_value").inputmask('R$ 999.999.999,99', {numericInput: true});    //123456  =>  R$ ___.__1.234,56
        });

        $(document).ready(function(){
            $(":input").inputmask();
        });

        $(function () {

            $("#extra_tables_value").inputmask('R$ 999.999.999,99', {numericInput: true});    //123456  =>  R$ ___.__1.234,56
            $("#extra_invitations_value").inputmask('R$ 999.999.999,99', {numericInput: true});    //123456  =>  R$ ___.__1.234,56
            $("#extra_tables_value_a").inputmask('R$ 999.999.999,99', {numericInput: true});    //123456  =>  R$ ___.__1.234,56
            $("#extra_invitations_value_a").inputmask('R$ 999.999.999,99', {numericInput: true});    //123456  =>  R$ ___.__1.234,56

        });

        var select_event_type = document.getElementById("select_event_type");
        var btn = document.getElementById("teste");

        var invitations_by_forming = document.getElementById("invitations_by_forming");
        var extra_invitations = document.getElementById("extra_invitations");
        var extra_invitations_value = document.getElementById("extra_invitations_value");
        var extra_tables = document.getElementById("extra_tables");
        var extra_tables_value = document.getElementById("extra_tables_value");


        $('input').on("input", function (e) {
            $(this).val($(this).val().replace(".", ","));
        });


        function myFunction(e) {

            if (select_event_type.options[select_event_type.selectedIndex].text == "Formatura") {

                //deixa editavel
                invitations_by_forming.removeAttribute("readonly");
                invitations_by_forming.setAttribute('value', '');

                //deixa editavel
                extra_invitations.removeAttribute("readonly");
                extra_invitations.setAttribute('value', '');

                //deixa editavel
                extra_invitations_value.removeAttribute("readonly");
                extra_invitations_value.setAttribute('value', '');

                //deixa editavel
                extra_tables.removeAttribute("readonly");
                extra_tables.setAttribute('value', '');

                //deixa editavel
                extra_tables_value.removeAttribute("readonly");
                extra_tables_value.setAttribute('value', '');
            }
            if (select_event_type.options[select_event_type.selectedIndex].text == "Colação de Grau") {
                //deixa editavel
                invitations_by_forming.removeAttribute("readonly");
                invitations_by_forming.setAttribute('value', '');

                //somente leitura
                extra_invitations.setAttribute('readonly', true);
                extra_invitations.setAttribute('value', 0);
                //somente leitural
                extra_invitations_value.setAttribute('value', 0);
                extra_invitations_value.setAttribute('readonly', true);
                //somente leitura
                extra_tables.setAttribute('readonly', true);
                extra_tables.setAttribute('value', 0);
                //somente leitura
                extra_tables_value.setAttribute('readonly', true);
                extra_tables_value.setAttribute('value', 0);
            }
            if (select_event_type.options[select_event_type.selectedIndex].text == "Jantar") {
                invitations_by_forming.removeAttribute('readonly');
                invitations_by_forming.setAttribute('value', '');
                extra_invitations.removeAttribute('readonly');
                extra_invitations.setAttribute('value', '');
                extra_invitations_value.removeAttribute('readonly');
                extra_invitations_value.setAttribute('value', '');
                extra_tables.removeAttribute('readonly');
                extra_tables.setAttribute('value', '');
                extra_tables_value.removeAttribute('readonly');
                extra_tables_value.setAttribute('value', '');
            }
            if (select_event_type.options[select_event_type.selectedIndex].text == "Pré Evento") {
                invitations_by_forming.removeAttribute("readonly");
                invitations_by_forming.setAttribute('value', '');
                extra_invitations.removeAttribute("readonly");
                extra_invitations.setAttribute('value', '');
                extra_invitations_value.removeAttribute("readonly");
                extra_invitations_value.setAttribute('value', '');
                extra_tables.setAttribute('readonly', true);
                extra_tables.setAttribute('value', 0);
                extra_tables_value.setAttribute('readonly', true);
                extra_tables_value.setAttribute('value', 0);
            }
            if (select_event_type.options[select_event_type.selectedIndex].text == "Churrasco") {
                invitations_by_forming.removeAttribute("readonly");
                invitations_by_forming.setAttribute('value', '');
                extra_invitations.setAttribute('readonly', true);
                extra_invitations.setAttribute('value', 0);
                extra_invitations_value.setAttribute('readonly', true);
                extra_invitations_value.setAttribute('value', 0);
                extra_tables.setAttribute('readonly', true);
                extra_tables.setAttribute('value', 0);
                extra_tables_value.setAttribute('readonly', true);
                extra_tables_value.setAttribute('value', 0);
            }
            if (select_event_type.options[select_event_type.selectedIndex].text == "Culto Ecomenico") {
                invitations_by_forming.setAttribute('readonly', true);
                invitations_by_forming.setAttribute('value', 0);
                extra_invitations.setAttribute('readonly', true);
                extra_invitations.setAttribute('value', 0);
                extra_invitations_value.setAttribute('readonly', true);
                extra_invitations_value.setAttribute('value', 0);
                extra_tables.setAttribute('readonly', true);
                extra_tables.setAttribute('value', 0);
                extra_tables_value.setAttribute('readonly', true);
                extra_tables_value.setAttribute('value', 0);
            }
            if (select_event_type.options[select_event_type.selectedIndex].text == "After") {
                invitations_by_forming.removeAttribute("readonly");
                invitations_by_forming.setAttribute('value', '');
                extra_invitations.setAttribute('readonly', true);
                extra_invitations.setAttribute('value', 0);
                extra_invitations_value.setAttribute('readonly', true);
                extra_invitations_value.setAttribute('value', 0);
                extra_tables.setAttribute('readonly', true);
                extra_tables.setAttribute('value', 0);
                extra_tables_value.setAttribute('readonly', true);
                extra_tables_value.setAttribute('value', 0);
            }
            if (select_event_type.options[select_event_type.selectedIndex].text == "Festa do Meio Médico") {
                invitations_by_forming.removeAttribute("readonly");
                invitations_by_forming.setAttribute('value', '');

                extra_invitations.removeAttribute("readonly");
                extra_invitations.setAttribute('value', '');

                extra_invitations_value.removeAttribute("readonly");
                extra_invitations_value.setAttribute('value', '');

                extra_tables.removeAttribute("readonly");
                extra_tables.setAttribute('value', '');

                extra_tables_value.removeAttribute("readonly");
                extra_tables_value.setAttribute('value', '');
            }
        };

    </script>

@endsection

