@extends('layouts.auth-master')

@section('title')
Acessar Conta
@endsection

@section('content')
<div class="card card-primary">
  <div class="card-header"><h4>Acessar Conta</h4></div>

  <div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf
      <div class="form-group">
        <label for="email">Email</label>
        <input aria-describedby="emailHelpBlock" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Digite seu email" tabindex="1" value="{{ old('email') }}" autofocus>
        <div class="invalid-feedback">
          {{ $errors->first('email') }}
        </div>        
      </div>

      <div class="form-group">
        <div class="d-block">
            <label for="password" class="control-label">Senha</label>
          <div class="float-right">
            <a href="{{ route('password.request') }}" class="text-small">
              Esqueceu sua senha?
            </a>
          </div>
        </div>
        <input aria-describedby="passwordHelpBlock" id="password" type="password" placeholder="Senha de sua conta" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password" tabindex="2">
        <div class="invalid-feedback">
          {{ $errors->first('password') }}
        </div>        
      </div>

      <div class="form-group">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember"{{ old('remember') ? ' checked': '' }}>
          <label class="custom-control-label" for="remember">Lembre de mim</label>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          Login
        </button>
      </div>
    </form>
  </div>
</div>
<div class="mt-5 text-white text-center">
  {{-- Não tem uma conta? <a href="{{ route('register') }}">Crie uma</a> --}}
</div>
@endsection
