@extends('layouts.admin-master')

@section('title')
Editar Perfil ({{ $user->name }})
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Editar Perfil</h1>
  </div>
  <div class="section-body">
      <profile-component user='{!! $user->toJson() !!}'></profile-component>
  </div>
</section>
@endsection
