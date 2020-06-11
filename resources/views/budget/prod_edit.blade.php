@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px;">
        <div class="container-fluid">

            <div class="container">
                <h3>Editar Produto</h3>
                <hr>
                {!! form($form->add('insert', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => "Salvar Alterações"])) !!}
                <br>
                <br>
                <br>
            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
