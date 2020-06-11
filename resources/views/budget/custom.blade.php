@extends('layouts.app')

@section('content')
    @include('includes.menu')

    <div class="content-wrapper" style="margin-top: 60px; padding-bottom: 80px;">
        <div class="container-fluid">

            @if ($message = Session::get('message'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>

            @endif

                <h5 class="card-title">Personalize seu orçamento com uma imagem atrativa:</h5>


            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <br>

            <form action="{{ route('image.upload.post',$budget->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6">
                        <label for="image">Faça upload de seu logo para personalizar seu orçamento :</label>
                        <input type="file" name="image_logo" class="form-control" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label for="image">Escolha a imagem do cabeçalho do orçamento:</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div id="cp2" class="input-group colorpicker colorpicker-component form-group">
                        <div class="col-md-6">
                            <label for="color">Clique no campo abaixo e escolha a cor do tema de seu orçamento:</label>
                            <input type="text" name="cor" class="form-control input-group-addon"
                                   required/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div id="cp3" class="input-group colorpicker colorpicker-component form-group">
                        <div class="col-md-6">
                            <label for="color">Clique no campo abaixo e escolha a cor do texto de seu orçamento:</label>
                            <input type="text" name="text_color" class="form-control input-group-addon"
                                   required/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-block">Salvar Alterações</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('budget.in.show',$budget->id) }}" class="btn btn-primary btn-block">Voltar</a>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <script type="text/javascript">

        $('.colorpicker').colorpicker();

    </script>

@endsection



