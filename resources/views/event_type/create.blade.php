@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px; padding-bottom: 80px;">
        <div class="container-fluid">

            <div class="container">
                <h3>Cadastrar Tipo de Evento</h3>
                <hr>
                {!! form($form->add('insert', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => "Salvar"])) !!}
            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
