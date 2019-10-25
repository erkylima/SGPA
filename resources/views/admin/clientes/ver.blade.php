@extends('layouts.admin-master')

@section('title')
    Visualizar Cliente
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{auth()->user()->can('ver-clientes') ? route('painel.clientes') : route('admin.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Vizualizar Cliente</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
            @if(auth()->user()->can('ver-clientes')) 
            <div class="breadcrumb-item"><a href="{{route('painel.clientes')}}">Clientes</a></div>
            @endif
            <div class="breadcrumb-item">Visualizar Cliente</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Cliente: {{ $cliente->nome }}</h2>
            <p class="section-lead">
                Visualização geral do cliente
            </p>

            <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ $cliente->foto_path != null ? asset($cliente->foto_path) : asset("assets/img/avatar/avatar-1.png") }}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                    <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Processos</div>
                        <div class="profile-widget-item-value">2</div>
                    </div>
                    {{-- <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Ações</div>
                        <div class="profile-widget-item-value">6,8K</div>
                    </div> --}}
                    <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Following</div>
                        <div class="profile-widget-item-value">2,1K</div>
                    </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name">{{ $cliente->nome}} {{ $cliente->sobrenome}} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> {{ $cliente->profissao }}</div></div>
                    <div class="font-weight-bold mb-2">Documentos</div>                
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">CPF</div>
                            <div class="profile-widget-item-value">{{ $documento->cpf }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Identidade</div>
                            <div class="profile-widget-item-value">{{ $documento->rg }}</div>
                        </div>
                    </div>
                    <div class="font-weight-bold mb-2">Endereço</div>                
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Cidade</div>
                            <div class="profile-widget-item-value">{{ $endereco->cidade }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Estado</div>
                            <div class="profile-widget-item-value">{{ $endereco->estado }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">CEP</div>
                            <div class="profile-widget-item-value">{{ $endereco->cep }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">País</div>
                            <div class="profile-widget-item-value">{{ $endereco->pais }}</div>
                        </div>
                    </div>
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Rua</div>
                            <div class="profile-widget-item-value">{{ $endereco->rua }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Numero</div>
                            <div class="profile-widget-item-value">{{ $endereco->numero }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Complemento</div>
                            <div class="profile-widget-item-value">{{ $endereco->complemento }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Bairro</div>
                            <div class="profile-widget-item-value">{{ $endereco->bairro }}</div>
                        </div>
                    </div>                
                </div>
                <div class="card-footer text-center">
                    <div class="font-weight-bold mb-2">Anotações</div>
                    <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                    <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                    <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-github mr-1">
                    <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-instagram">
                    <i class="fab fa-instagram"></i>
                    </a>
                </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4>Todos Processos</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                            <th class="text-center pt-2">
                                #
                            </th>
                            <th>Titulo</th>
                            <th>Tipo</th>
                            <th>Agenciador</th>
                            <th>Status</th>
                            </tr>
                            <tr>
                            <td>
                                1
                            </td>
                            <td>Tiroteio
                                <div class="table-links">
                                <a href="#">Ver</a>
                                <div class="bullet"></div>
                                <a href="#">Editar</a>
                                <div class="bullet"></div>
                                <a href="#" class="text-danger">Apagar</a>
                                </div>
                            </td>
                            <td>
                                <a href="#">Tutorial</a>
                            </td>
                            <td>
                                <a href="#">
                                <img alt="image" src="{{ asset('assets/img/avatar/avatar-5.png')}}" class="rounded-circle" width="35" data-toggle="title" title=""> <div class="d-inline-block ml-1">Rizal Fakhri</div>
                                </a>
                            </td>
                            <td><div class="badge badge-primary">Concluído</div></td>
                            </tr>
                            
                        </table>
                        </div>
                        <div class="float-right">
                        <nav>
                            <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                                </a>
                            </li>
                            </ul>
                        </nav>
                        </div>
                    </div>
                </div>

                <div class="card">
                <form method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                    <h4>Enviar email</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="assunto">Assunto</label>
                                <input autofocus class="form-control" type="text" name="assunto" id="assunto">
                                
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-12">
                            <label>Mensagem</label>
                            <textarea name="mensagem" id="mensagem" class="form-control summernote-simple"></textarea>
                        </div>
                        </div>                    
                    </div>
                    
                    <div class="card-footer text-right">
                    <button class="btn btn-primary">Enviar</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>    
    <script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js') }}"></script>    
    <script src="{{ asset('assets/modules/summernote/summernote.js') }}"></script>    

    <script>
        
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote.css') }}">
@endsection

