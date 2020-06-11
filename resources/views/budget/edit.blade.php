@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px;">
        <div class="container-fluid">

            <div class="container">
                <h3>Editar Orçamento</h3>
                <hr>

                {{Form::model($budget, array('route' => array('budget.update', $budget->id),'method' => 'PUT'))}}

                <div class="form-row">
                    <div class="col">
                        <label for="name">Nome do Orçamento</label>
                        {{Form::text('name', null, array_merge(['class' => 'form-control','required']))}}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="formGroupExampleInput">Cliente</label>
                        {{Form::select('client_id', $client_for_select, null, array_merge(['class' => 'form-control']))}}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="formGroupExampleInput">Número de Parcelas</label>
                        {{Form::number('number_of_installments', null, array_merge(['class' => 'form-control','id'=>'parcels','empty_value'=>'===Numero de Parcelas===','min'=>1]))}}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="basic-url">Fee</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                            {{Form::number('fee', null, array_merge(['class' => 'form-control','aria-describedby'=>'basic-addon1']))}}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="basic-url">Exclusividade Fotográfica</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="exclusividade_fotografica">R$</span>
                            </div>
                            {{Form::number('photo_exclusivity', null, array_merge(['class' => 'form-control']))}}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="basic-url">Comissão Pagante</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="paying_commission">%</span>
                            </div>
                            {{Form::number('paying_commission', null, array_merge(['class' => 'form-control', 'required']))}}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="formGroupExampleInput">Válido até</label>
                        {{Form::date('shelf_life', null, array_merge(['class' => 'form-control','min'=>1, 'required']))}}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="formGroupExampleInput">Comentário Interno</label>
                        {{Form::textarea('internal_comment', null, array_merge(['class' => 'form-control']))}}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="formGroupExampleInput">Comentário para o Cliente</label>
                        {{Form::textarea('external_comment', null, array_merge(['class' => 'form-control']))}}
                    </div>
                </div>

                {{--<div class="form-row">
                    <div class="col">
                        <label for="formGroupExampleInput">Status</label>
                        {{Form::select('status', \App\Models\Budget::status(), null, array_merge(['class' => 'form-control']))}}
                    </div>
                </div>
--}}
                <div class="form-row">
                    <div class="col">
                        <input type="submit" name="enviar" class="btn btn-primary btn-block">
                    </div>
                </div>
                {{ Form::close() }}

            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
    </div>
    {{--@include('includes.footer')--}}
@endsection
