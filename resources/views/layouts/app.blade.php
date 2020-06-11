<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SiForme Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Bootstrap core CSS-->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->

    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">

    <link href="{{asset('vendor/jquery-loading/dist/jquery.loading.min.css')}}" rel="stylesheet">

{{--colorpick--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>





</head>
<body style="background-color: #505050;">

<br>
<br>
    @yield('content')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>


    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{asset('bower_components/chart.js/dist/Chart.bundle.js')}}"></script>

    <script src="{{asset('vendor/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin.min.js')}}"></script>
    <!-- Custom scripts for this page-->
    <script src="{{asset('js/sb-admin-charts.min.js')}}"></script>

    <script src="{{asset('vendor/Inputmask/dist/jquery.inputmask.bundle.js')}}"></script>
    <script src="{{asset('vendor/Inputmask/dist/inputmask/phone-codes/phone.js')}}"></script>
    <script src="{{asset('vendor/Inputmask/dist/inputmask/phone-codes/phone-be.js')}}"></script>
    <script src="{{asset('vendor/Inputmask/dist/inputmask/phone-codes/phone-ru.js')}}"></script>

    <script src="{{asset('vendor/jquery-loading/dist/jquery.loading.min.js')}}"></script>


    @yield('scripts')


</body>
</html>
