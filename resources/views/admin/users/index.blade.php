@extends('layouts.admin-master')

@section('title')
Gerenciar Usuários
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Gerenciar Usuários</h1>
  </div>
  <div class="section-body">
      <users-component></users-component>
  </div>
</section>
@endsection
