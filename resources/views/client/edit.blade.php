@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px; padding-bottom: 80px;">
        <div class="container-fluid">

            <div class="container">
                <h3>Editar Cliente</h3>
                <hr>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! form($form->add('insert', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => "Salvar"])) !!}
            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
