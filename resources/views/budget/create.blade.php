@extends('layouts.app')

@section('content')
    @include('includes.menu')
    <div class="content-wrapper" style="margin-top: 60px; padding-bottom: 80px;">
        <div class="container-fluid">

            @if($testClient)
                <div class="container">
                    <h3>Novo Orçamento</h3>
                    <hr>
                    {!! form($form->add('insert', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => "Salvar"])) !!}
                </div>
            @else

                <div class="alert alert-primary" role="alert">
                    Antes de criar um orçamento é necessário <a href="{{ route('client.create') }}">criar um cliente
                        para este orçamento.</a>
                </div>

            @endif

        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        @include('includes.footer')
    </div>
@endsection

@section('scripts')


 <script type="text/javascript">
        document.getElementById("myAnchor").focus();
        $(function () {
            $('#client').change(function () {
                var valueField = $(this).val();
                $.ajax({
                    url: '{{env('APP_URL')}}/api/client/' + valueField,
                    success: function (data) {
                        $('#parcels').html('');
                        for (var i = 1; i <= data.max; i++) {
                            $('#parcels').append('<option value="' + i + '">' + i + '</option>');
                        }
                    }
                });
            })
        });
</script>

@endsection
