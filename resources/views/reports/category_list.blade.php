@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px; padding-bottom: 80px;">
        <div class="container-fluid">

            <div class="container">
                <h3>Lista de Ordem das Categorias</h3>
                <hr>
                <?php
                $cores = [
                    1 => '#ff5722',
                    2 => '#2196f3',
                    3 => '#ff9800',
                    4 => '#9c27b0',
                    5 => '#9c27b0',
                    6 => '#9c27b0',
                ];
                $i=1;
                ?>

                @if ($ret == null)
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Primeiro vá ate a sessão Gerencias no menu Categorias e crie sua Categoria</strong>
                    </div>

                @endif

                    @foreach($ret as $r)
                    <table class="table table-hover table-responsive-md">
                        <tbody>
                        <tr style="color: {{$cores[$i]}};"><th><span style="font-size: 28px;"><i class="fa fa-star"></i> {{$r['name']}} </span></th></tr>
                        @foreach($r['cats'] as $c)
                            <tr><td><i class="fa fa-arrow-right" style="color: {{$cores[$i]}};"></i> {{$c}}</td></tr>
                        @endforeach
                        <?php $i++;?>
                        </tbody>
                    </table>
                    <br>
                    @endforeach


            </div>

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection
