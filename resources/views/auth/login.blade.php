@extends('auth.app')

@section('content')
    <div style="text-align: center">
        <img src="{{ asset("img/nova_logo.jpg") }}" alt="" style="width: 300px; margin: auto 0;">
    </div>
    <div class="container">
        <div class=" card-login mx-auto"
             style="background: rgba(255,255,255,0.8); border-radius: 10px; border: 1px solid #FFF">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            <ul style="padding: 2px; margin-bottom: 0;">
                                {{ $errors->first('email') }}
                            </ul>
                        </div>
                    @endif

                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            <ul style="padding: 2px; margin-bottom: 0;">
                                {{ $errors->first('password') }}
                            </ul>
                        </div>
                    @endif

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required autofocus>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Senha</label>

                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control" name="password" required>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    Manter logado
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Login
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Esqueceu sua senha?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
