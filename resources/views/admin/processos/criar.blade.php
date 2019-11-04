@extends('layouts.admin-master')

@section('title')
    Novo Cliente
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{auth()->user()->can('ver-clientes') ? route('painel.clientes') : route('admin.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Criar Novo Cliente</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
            @if(auth()->user()->can('ver-clientes')) 
            <div class="breadcrumb-item"><a href="{{route('painel.clientes')}}">Clientes</a></div>
            @endif
            <div class="breadcrumb-item">Criar Novo Cliente</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Novo Cliente</h2>
            <p class="section-lead">
            Nessa página você pode criar um novo cliente e preencher seus campos.
            </p>
            @if(session()->get('success'))
            <div class="alert alert-success m-3" role="alert">
                {{ session()->get('success') }}
            </div>
            @elseif(session()->get('falha'))
                <div class="alert alert-danger m-3" role="alert">
                    {{ session()->get('falha') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">                   
                    {{ $errors->first('cpf') }}

                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>Preencha o Formulário</h4>                    
                    </div>
                    <div class="card-body">
                        
                        <form name="criar" action="{{ route('painel.clientes.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}     
                            {{-- <div data-toggle="tooltip" data-placement="top" title="Selecione a foto do perfil do cliente abaixo." class="section-title row mb-4 justify-content-center">Foto do Cliente</div>
                            <div class="form-group row mb-4 justify-content-center">
                                <div class="custom-file  col-lg-4 col-md-12">
                                    <input type="file" class="custom-file-input" id="perfil" name="perfil">
                                    <label class="custom-file-label" for="perfil">Escolher arquivo</label>
                                </div>
                            </div>                     --}}

                            <div class="form-row row mb-4 justify-content-center">                            
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="name">Nome (*)</label>
                                        
                                    <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" tabindex="1" placeholder="Digite o nome do cliente">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('name') }}</p>
                                    </div>                                    
                                </div>
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="sobrenome">Sobrenome (*)</label>                                    
                                    <input type="text" name="sobrenome" id="sobrenome" class="form-control" value="{{old('sobrenome')}}" tabindex="1" placeholder="Digite o sobrenome do cliente">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('sobrenome') }}</p>
                                    </div>
                                        
                                </div>                            
                            </div>
                            
                        </form>
                        <div class="row offset-8">
                            <button class="btn btn-lg btn-info" onclick="criarProcesso()" type="button" tabindex="16"><i class="fas fa-plus"></i> Criar Cliente</button>
                        </div> 
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

    <script>
        function emailIsValid (email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
        function checkIncapaz(){
            if($('#incapaz').is(':checked')){
                $('#incapazone').addClass('jumbotron');
                document.getElementById("incapazone").innerHTML = "<div class='form-group col-lg-3 col-md-12'><label for='nomeresp'>Nome do Responsável (*)</label><input type='text' name='nomeresp' id='nomeresp' class='form-control' value='' tabindex='1' placeholder='Digite o nome do responsável'><div class='invalid-feedback'><p>{{ $errors->first('nomeresp') }}</p></div></div><div class='form-group col-lg-2 col-md-12'><label for='cpfresp'>CPF do Responsável (*)</label><input type='text' name='cpfresp' pattern='[0-9]*'' maxlength='11' onkeyup='num(this);' id='cpfresp' class='form-control' value='' tabindex='1' placeholder='Digite o cpf do responsável'><div class='invalid-feedback'><p>{{ $errors->first('cpfresp') }}</p></div></div><div class='form-group col-lg-2 col-md-12'><label for='rgresp'>RG do Responsável (*)</label><input type='text' name='rgresp' pattern='[0-9]*'' maxlength='11' onkeyup='num(this);' id='rgresp' class='form-control' value='' tabindex='1' placeholder='Digite o rg do responsável'><div class='invalid-feedback'><p>{{ $errors->first('rgresp') }}</p></div></div><div class='form-group col-lg-2 col-md-12'><label for='orgaoresp'>Orgão Expeditor do RG (*)</label><input type='text' name='orgaoresp' id='orgaoresp' class='form-control' value='' tabindex='1' placeholder='Digite o orgão expeditor'><div class='invalid-feedback'><p>{{ $errors->first('orgaoresp') }}</p></div></div>";
            }else{
                $('#incapazone').removeClass('jumbotron');
                document.getElementById("incapazone").innerHTML="";
            }
        }
        
        function criarProcesso(){      
            if(document.getElementById("name").value.length < 1 ){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um nome',
                    position: 'topRight',
                });
            } else if(!emailIsValid(document.getElementById("email").value)){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um email válido',
                    position: 'topRight',
                });
            } else if(document.getElementById("rg").value.length < 7){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um rg válido',
                    position: 'topRight',
                });
            } else if(document.getElementById("orgao").value.length < 2){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um orgão expeditor',
                    position: 'topRight',
                });
            } else if(document.getElementById("bairro").value.length < 3){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um bairro',
                    position: 'topRight',
                });
            } else if(document.getElementById("cpf").value.length < 11){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um cpf válido',
                    position: 'topRight',
                });
            } else if(document.getElementById("cidade").value.length < 2){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um cidade',
                    position: 'topRight',
                });
            } else if(document.getElementById("rua").value.length < 2){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir uma rua',
                    position: 'topRight',
                });
            } else if(document.getElementById("numero").value.length < 1){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir o número',
                    position: 'topRight',
                });
            } else if(document.getElementById("complemento").value.length < 1){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir o complemento',
                    position: 'topRight',
                });
            } else if(document.getElementById("cep").value.length < 8){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa definir um CEP válido',
                    position: 'topRight',
                });
            } else if(document.getElementById("telefone1").value.length < 10){
                iziToast.error({
                    title: 'Ops...',
                    message: 'Você precisa o definir 1º telefone',
                    position: 'topRight',
                });
            } else {
                swal({
                title: "Os dados estão corretos?",
                text: "Você está adicionando um novo cliente!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    swal("Tentando criar usuário", {

                    icon: "success",
                    });
                    document.criar.submit();                    
                } else {
                    swal("Você cancelou a ação!");
                }
                });
            }
        }

        jQuery("input.telefone")
            .mask("(99) 99999-999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if(phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
        }); 
        
        function num(dom){
            dom.value=dom.value.replace(/\D/g,'');
        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
@endsection