@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px;">
        <div class="container-fluid">


            @isset($form)
            <div class="container">
                <h3>Cadastrar Categoria</h3>
                <hr>
                {!! form($form->add('insert', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => "Salvar"])) !!}
            </div>
            @else

                <div class="alert alert-primary" role="alert">
                    Antes de criar uma categoria é necessário <a href="{{ route('event_type.create') }}">criar um tipo de evento.</a>
                </div>

            @endif

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
