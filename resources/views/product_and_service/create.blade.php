@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px; padding-bottom: 80px;">
        <div class="container-fluid">

            @if($teste)
                <div class="container">
                    <h3>Cadastrar Produto ou Serviço</h3>
                    <hr>
                    {!! form($form->add('insert', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => "Salvar"])) !!}
                </div>
            @else

                <div class="alert alert-primary" role="alert">
                  Antes de criar um produto é necessário <a href="{{ route('category.create') }}">criar uma categoria.</a>
                </div>

            @endif

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>





@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $("#price").inputmask('R$ 999.999.999,99', { numericInput: true });    //123456  =>  R$ ___.__1.234,56
        $("#cost_price").inputmask('R$ 999.999.999,99', { numericInput: true });    //123456  =>  R$ ___.__1.234,56
        $("#minimum_price").inputmask('R$ 999.999.999,99', { numericInput: true });    //123456  =>  R$ ___.__1.234,56
    });
</script>
@endsection
