@extends('layouts.admin-master')

@section('title')
Clientes
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Clientes</h1>
        <div class="section-header-button">
            <a href="features-post-create.html" class="btn btn-primary">Add Novo</a>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Inicio</a></div>
            <div class="breadcrumb-item">Clientes</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Clientes</h2>
        <p class="section-lead">
            Você pode gerenciar todos os usuarios, tal como editar, apagar e mais.
        </p>
        <p class="text-uppercase">{{ crypt(2,'SGPA')}}</p>
        <div class="row">
            <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                    <a class="nav-link {{ is_null($status) ? 'active' : ''}}" href="{{route('painel.clientes')}}">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (!is_null($status) && $status == 0) ? 'active' : ''}}" href="{{route('painel.clientes',['status'=>0])}}">Concluido</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link {{ (!is_null($status) && $status == 1) ? 'active' : ''}}" href="{{route('painel.clientes',['status'=>1])}}">Rascunho</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link {{ (!is_null($status) && $status == 2) ? 'active' : ''}}" href="{{route('painel.clientes',['status'=>2])}}">Pendente</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link {{ (!is_null($status) && $status == 3) ? 'active' : ''}}" href="{{route('painel.clientes',['status'=>3])}}">Lixeira</a>
                    </li>
                </ul>
                </div>
            </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Todos Clientes</h4>
                    </div>
                    <div class="card-body">
                    <div class="float-left">
                        <select class="form-control selectric">
                        <option selected>Ação para selecionado</option>
                        <option value="0">Mover para Concluidos</option>
                        <option value="1">Mover para Rascunhos</option>
                        <option value="2">Mover para Pendentes</option>
                        <option value="3">Apagar Permanentemente</option>
                        </select>
                    </div>
                    <div class="float-right">
                        <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Pesquisar">
                            <div class="input-group-append">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        </form>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                        <tr>
                            <th class="text-center pt-2">
                                #
                            </th>
                            <th>Nome</th>
                            <th>Profissão</th>
                            <th>Agenciador</th>
                            <th>Criado em</th>
                            <th>Status</th>
                        </tr>
                        
                        @forelse ($clientes as $cliente)
                            @if($cliente->status == $status || is_null($status))
                            <tr>
                                <td>
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-2">
                                    <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                                </div>
                                </td>
                                {{-- <td>{{$cliente->nome}} --}}
                                <div class="table-links">
                                    
                                    <a href="#">Ver</a>
                                    <div class="bullet"></div>
                                    <a href="#">Editar</a>
                                    <div class="bullet"></div>
                                    <a href="#" class="text-danger">Apagar</a>
                                </div>
                                </td>
                                <td>
                                <a href="#">Web Developer</a>,
                                <a href="#">Tutorial</a>
                                </td>
                                <td>
                                <a href="#">
                                    <img alt="image" src="../assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="title" title=""> <div class="d-inline-block ml-1">Rizal Fakhri</div>
                                </a>
                                </td>
                                <td>2018-01-20</td>
                            <td>@php
                                switch ($cliente->status) {
                                    case 0:
                                        echo '<div class="badge badge-primary">Concluido</div>';
                                        break;
                                    case 1:
                                        echo '<div class="badge badge-danger">Rascunho</div>';
                                        break;
                                    case 2:
                                        echo '<div class="badge badge-warning">Pendente</div>';
                                        break;
                                    case 3:
                                        echo '<div class="badge badge-secundary">Apagado</div>';
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                @endphp
                            </tr>
                            @else
                            <tr>
                                <td>#</td>
                                <td>Nenhum cliente encontrado</td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td>#</td>
                                <td>Nenhum cliente encontrado</td>
                            </tr>
                        @endforelse                                                                
                        </table>
                    </div>
                    <div class="float-right">
                        {{ $clientes->appends(request()->except('page'))->links() }}                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection