@extends('layouts.admin-master')

@section('title')
    Editar Cliente
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{auth()->user()->can('ver-clientes') ? route('painel.clientes') : route('admin.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Editar Cliente</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
            @if(auth()->user()->can('ver-clientes')) 
            <div class="breadcrumb-item"><a href="{{route('painel.clientes')}}">Clientes</a></div>
            @endif
            <div class="breadcrumb-item">Editar Cliente</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Editar Cliente - {{ $cliente->nome }}</h2>
            <p class="section-lead">
            Nessa página você pode editar o cliente e repreencher seus campos.
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>Preencha o Formulário</h4>                    
                    </div>
                    <div class="card-body" style="position:relative">
                        <div class="row">
                            <div class="col-2">
                                <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Home</a>
                                <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Profile</a>                                
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                    <form name="editar" class="jumbotron" action="{{ route('painel.clientes.update',$cliente->id)}}" method="post" enctype="multipart/form-data">
                                        @method('PUT')
                                        {{ csrf_field() }}   
                                        <div class='row justify-content-center'>
                                            <h4 class="text-primary">Dados do Cliente</h4>
                                        </div>  
                                        <div data-toggle="tooltip" data-placement="top" title="Selecione a foto do perfil do cliente abaixo." class="section-title row mb-4 justify-content-center">Foto do Cliente</div>
                                        <div class="form-group row mb-4 justify-content-center">
                                            <div class="custom-file  col-lg-4 col-md-12">
                                                <input type="file" class="custom-file-input" id="perfil" name="perfil" tabindex="1">
                                                <label class="custom-file-label" for="perfil">Escolher arquivo</label>
                                            </div>
                                        </div>                    
            
                                        <div class="form-row row mb-4 justify-content-center">                            
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label for="name">Nome </label>
                                                    
                                                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$cliente->nome)}}" tabindex="1" placeholder="Digite o nome do cliente">
                                                <div class="invalid-feedback">
                                                    <p>{{ $errors->first('name') }}</p>
                                                </div>                                    
                                            </div>
                                            <div class="form-group col-lg-2 col-md-12" style="background: #e3342f">
                                                <div class="control-label" style="color: white">CLIENTE INCAPAZ?</div>
                                                <label for="incapaz" class="custom-switch mt-2">
                                                    <input type="checkbox" onchange="checkIncapaz()" {{ $cliente->incapaz == '1' ? ' checked' : '' }} tabindex="1" name="incapaz" id="incapaz" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description" style="color: white">Marcar se sim</span>
                                                </label>
                                            </div>                          
                                        </div>                            
            
                                        <div class="form-row row mb-4 justify-content-center">                            
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="apelido">Apelido (opcional)</label>                                        
                                                <input type="text" name="apelido" id="apelido" class="form-control" value="{{old('apelido',$cliente->apelido)}}" tabindex="1" placeholder="Digite o apelido do cliente">
                                                <div class="invalid-feedback">
                                                    <p>{{ $errors->first('apelido') }}</p>
                                                </div>                                    
                                            </div>
                                            <div class="form-group col-lg-2 col-md-12"  style="background: #38c172">
                                                <label for="nascimento" style="color:white">Data de Nascimento </label>
                                                <input tabindex="1" name="nascimento" id="nascimento" type="date" value="{{old('nascimento',$cliente->nascimento)}}" class="form-control">
                                                <div class="invalid-feedback">
                                                    <p>{{ $errors->first('nascimento') }}</p>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12" style="background: #0f9acd">
                                                <label for="nome_mae" style="color:white">Nome da Mãe </label>                                    
                                                <input type="text" name="nome_mae" id="nome_mae" class="form-control" value="{{old('nome_mae',$cliente->nome_mae)}}" tabindex="1" placeholder="Digite o nome da mãe do cliente">
                                                <div class="invalid-feedback">
                                                    <p>{{ $errors->first('nome_mae') }}</p>
                                                </div>
                                                    
                                            </div>                            
                                        </div>
            
                                        <div class="form-row row mb-4 justify-content-center">                                                            
                                            
                                            <div class="form-group col-lg-3 col-md-12" style="background: #e3342f">
                                                <label for="senhainss" style="color:white">Senha INSS (opcional)</label>                                    
                                                <input type="text" name="senhainss" id="senhainss" class="form-control" value="{{old('senhainss',$cliente->senhainss)}}" tabindex="1" placeholder="Digite a senha do INSS">
                                                <div class="invalid-feedback">
                                                    <p>{{ $errors->first('senhainss') }}</p>
                                                </div>                                    
                                            </div>
            
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="profissao">Profissão </label>                                    
                                                <input type="text" name="profissao" id="profissao" class="form-control" value="{{old('profissao',$cliente->profissao)}}" tabindex="1" placeholder="Digite a profissão do cliente">
                                                <div class="invalid-feedback">
                                                    <p>{{ $errors->first('profissao') }}</p>
                                                </div>                                    
                                            </div>
            
                                            <div class="form-group col-lg-2 col-md-12">
                                                <label for="estado_civil">Estado Civil </label>
                                                <select class="form-control" id="estado_civil" tabindex="1" name="estado_civil">
                                                    <option {{ $cliente->estado_civil == 'Solteiro' ? ' selected' : '' }} value="Solteiro">Solteiro</option>
                                                    <option {{ $cliente->estado_civil == 'Casado' ? ' selected' : '' }} value="Casado">Casado</option>
                                                    <option {{ $cliente->estado_civil == 'Separado' ? ' selected' : '' }} value="Separado">Separado</option>
                                                    <option {{ $cliente->estado_civil == 'Divorciado' ? ' selected' : '' }} value="Divorciado">Divorciado</option>
                                                    <option {{ $cliente->estado_civil == 'Viúvo' ? ' selected' : '' }} value="Viúvo">Viúvo</option>
                                                    <option {{ $cliente->estado_civil == 'Amasiado' ? ' selected' : '' }} value="Amasiado">Amasiado</option>
                                                </select>                    
                                            </div>
            
                                            
                                        </div>
            
                                        
            
                                        <div class="form-row row mb-4 justify-content-center">
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="rg">RG </label>
                                                <div class="input-group">
                                                    {{-- <div class="custom-file">
                                                        <input type="file" placeholder="Foto" class="custom-file-input" id="foto_rg" name="foto_rg">
                                                        <label class="custom-file-label" for="foto_rg">Foto RG</label>
                                                    </div> --}}
                                                    <input id="rg" type="text" onkeyup="num(this);" class="form-control" pattern="[0-9]+" placeholder="Digite seu RG" name="rg" tabindex="1" value="{{old('rg',$cliente->rg)}}">
                                                </div>                    
                                            </div>
                            
                                            <div class="form-group col-lg-2 col-md-12">
                                                <label for="orgao">Orgão </label>
                                                <div class="input-group">
                                                    <input id="orgao" type="text" class="form-control" placeholder="Expedidor" maxlength="20" name="orgao" tabindex="1" value="{{old('orgao',$cliente->orgao)}}">
                                                </div>                    
                                            </div>
                            
                                            <div class="form-group col-lg-3 col-md-12" style="background: #e3342f">
                                                <label for="cpf" style="color:white">CPF </label>
                                                <div class="input-group">
                                                    {{-- <div class="custom-file">
                                                        <input type="file" placeholder="Foto" class="custom-file-input" id="foto_cpf" name="foto_cpf">
                                                        <label class="custom-file-label" for="foto_cpf">Foto CPF</label>
                                                    </div> --}}
                                                    <input id="cpf" onkeyup="num(this);" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }} " pattern="[0-9]*" maxlength="11" placeholder="Digite seu CPF" name="cpf" tabindex="1" value="{{old('cpf',$cliente->cpf)}}">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('cpf') }}
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
            
                                        <div class="form-row row mb-4 justify-content-center" style="background: #0f9acd" id="incapazone">
            
                                        </div>
            
                                        <div class="form-row row mb-4 justify-content-center">
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="cep">CEP </label>
                                                <div class="input-group">
                                                    <input id="cep" type="text" onkeyup="pesquisacep(value)" class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}" pattern="[a-zA-Z0-9]+" placeholder="Digite o CEP" maxlength="8" placeholder="Digite seu CEP" name="cep" tabindex="1" value="{{old('cep',$endereco->cep)}}">
                                                </div>
                                                <div class="invalid-feedback">
                                                {{ $errors->first('cep') }}
                                                </div>
                                            </div>                                                            
                            
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="cidade">Cidade </label>
                                                <div class="input-group">
                                                <input id="cidade" type="text" class="form-control" maxlength="50" placeholder="Digite sua Cidade" name="cidade" tabindex="1" value="{{old('cidade',$endereco->cidade)}}">
                                                </div>                    
                                            </div>
                            
                                            <div class="form-group col-lg-2 col-md-12">
                                                <label for="estado">Estado </label>
                                                    <select class="form-control" id="estado" tabindex="1" name="estado">
                                                        <option {{ $endereco->estado == 'AC' ? ' selected' : '' }} value="AC">Acre</option>
                                                        <option {{ $endereco->estado == 'AL' ? ' selected' : '' }} value="AL">Alagoas</option>
                                                        <option {{ $endereco->estado == 'AP' ? ' selected' : '' }} value="AP">Amapá</option>
                                                        <option {{ $endereco->estado == 'AM' ? ' selected' : '' }} value="AM">Amazonas</option>
                                                        <option {{ $endereco->estado == 'BA' ? ' selected' : '' }} value="BA">Bahia</option>
                                                        <option {{ $endereco->estado == 'CE' ? ' selected' : '' }} value="CE">Ceará</option>
                                                        <option {{ $endereco->estado == 'DF' ? ' selected' : '' }} value="DF">Distrito Federal</option>
                                                        <option {{ $endereco->estado == 'ES' ? ' selected' : '' }} value="ES">Espírito Santo</option>
                                                        <option {{ $endereco->estado == 'GO' ? ' selected' : '' }} value="GO">Goiás</option>
                                                        <option {{ $endereco->estado == 'MA' ? ' selected' : '' }} value="MA">Maranhão</option>
                                                        <option {{ $endereco->estado == 'MT' ? ' selected' : '' }} value="MT">Mato Grosso</option>
                                                        <option {{ $endereco->estado == 'MS' ? ' selected' : '' }} value="MS">Mato Grosso do Sul</option>
                                                        <option {{ $endereco->estado == 'MG' ? ' selected' : '' }} value="MG">Minas Gerais</option>
                                                        <option {{ $endereco->estado == 'PA' ? ' selected' : '' }} value="PA">Pará</option>
                                                        <option {{ $endereco->estado == 'PB' ? ' selected' : '' }} value="PB">Paraíba</option>
                                                        <option {{ $endereco->estado == 'PR' ? ' selected' : '' }} value="PR">Paraná</option>
                                                        <option {{ $endereco->estado == 'PE' ? ' selected' : '' }} value="PE">Pernambuco</option>
                                                        <option {{ $endereco->estado == 'PI' ? ' selected' : '' }} value="PI">Piauí</option>
                                                        <option {{ $endereco->estado == 'RJ' ? ' selected' : '' }} value="RJ">Rio de Janeiro</option>
                                                        <option {{ $endereco->estado == 'RN' ? ' selected' : '' }} value="RN">Rio Grande do Norte</option>
                                                        <option {{ $endereco->estado == 'RS' ? ' selected' : '' }} value="RS">Rio Grande do Sul</option>
                                                        <option {{ $endereco->estado == 'RO' ? ' selected' : '' }} value="RO">Rondônia</option>
                                                        <option {{ $endereco->estado == 'RR' ? ' selected' : '' }} value="RR">Roraima</option>
                                                        <option {{ $endereco->estado == 'SC' ? ' selected' : '' }} value="SC">Santa Catarina</option>
                                                        <option {{ $endereco->estado == 'SP' ? ' selected' : '' }} value="SP">São Paulo</option>
                                                        <option {{ $endereco->estado == 'SE' ? ' selected' : '' }} value="SE">Sergipe</option>
                                                        <option {{ $endereco->estado == 'TO' ? ' selected' : '' }} value="TO">Tocantins</option>
                                                        <option {{ $endereco->estado == 'EX' ? ' selected' : '' }} value="EX">Estrangeiro</option>
                                                    </select>                    
                                            </div>                        
                                        </div>
            
                                        <div class="form-row row mb-4 justify-content-center">
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label for="rua">Endereço </label>
                                                <div class="input-group">
                                                    <input id="rua" type="text" class="form-control{{ $errors->has('rua') ? ' is-invalid' : '' }}" placeholder="Digite o endereço" name="rua" tabindex="1" value="{{ old('rua',$endereco->rua) }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                {{ $errors->first('rua') }}
                                                </div>
                                            </div>
                            
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="bairro">Bairro </label>
                                                <div class="input-group">
                                                    <input id="bairro" type="text" class="form-control" maxlength="50" placeholder="Digite seu Bairro" name="bairro" tabindex="1" value="{{ old('bairro',$endereco->bairro) }}">
                                                </div>                    
                                            </div>
            
                                            <div class="form-group col-lg-1 col-md-12">
                                                <label for="numero">Número </label>
                                                <div class="input-group">
                                                    <input id="numero" type="text" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" pattern="[0-9]+" placeholder="Núm." maxlength="11" name="numero" tabindex="1" value="{{ old('numero',$endereco->numero) }}">
                                                </div>
                                                <div class="invalid-feedback">
                                                {{ $errors->first('numero') }}
                                                </div>
                                            </div>                                                                        
                                        </div>
                                        
                                        <div class="form-row row mb-4 justify-content-center">
                                            <div class="form-group col-lg-8 col-md-12">
                                                <label for="complemento">Ponto de Referência </label>
                                                <div class="input-group">                    
                                                    <input id="complemento" type="text" class="form-control" placeholder="Digite o ponto de referencia" name="complemento" tabindex="1" value="{{ old('complemento',$endereco->complemento) }}" >
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('complemento') }}
                                                    </div>
                                                </div>
                                            </div>                                
                                        </div>
            
                                        <div class="form-row row justify-content-center">
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label for="telefone1">1º Telefone </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-phone"></i>
                                                        </div>
                                                    </div>
                                                    <input id="telefone1" type="text" class="telefone form-control" placeholder="Digite seu telefone" name="telefone1" tabindex="9" value="{{ old('telefone1',$cliente->telefone1) }}" >
                                                    <div class="custom-control custom-checkbox ml-2">
                                                        <input type="checkbox" tabindex="9" class="custom-control-input" {{ old('whats1',$cliente->whatstelefone1) == '1' ? 'checked' : '' }} name="whats1" id="whats1">
                                                        <label class="custom-control-label" for="whats1">WhatsApp?</label>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('fone') }}
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="form-group col-lg-4 col-md-12">
                                                <label for="telefone2">2º Telefone</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-phone"></i>
                                                        </div>
                                                    </div>
                                                    <input name="telefone2" id="telefone2" type="text" class="telefone form-control" placeholder="Digite seu telefone" tabindex="9" value="{{old('telefone2',$cliente->telefone2)}}" >                                        
                                                    <div class="custom-control custom-checkbox ml-2">
                                                        <input type="checkbox" tabindex="9" class="custom-control-input" name="whats2" {{ old('whats2',$cliente->whatstelefone2) == '1' ? 'checked' : '' }} id="whats2">
                                                        <label class="custom-control-label" for="whats2">WhatsApp?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="form-row row mb-4 justify-content-center">
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="email">Email (opcional)</label>
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Endereço de email" name="email" tabindex="9" value="{{old('email',$cliente->email)}}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12">
                                                <label for="recado">Pessoa para recado (opcional)</label>
                                                <input id="recado" type="recado" class="form-control{{ $errors->has('recado') ? ' is-invalid' : '' }}" placeholder="Endereço de email" name="recado" tabindex="9" value="{{old('recado',$cliente->nome_recado)}}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('recado') }}
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-2 col-md-12">
                                                <label for="recado_telefone">Telefone para Recado</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-phone"></i>
                                                        </div>
                                                    </div>
                                                    <input name="recado_telefone" id="recado_telefone" type="text" class="telefone form-control" placeholder="Digite número recado" tabindex="9" value="{{old('recado_telefone',$cliente->recado_telefone)}}" >                                        
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="form-group row mb-4 justify-content-left">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                            <div class="col-sm-12 col-md-3">
                                                <select tabindex="9" name="status" class="form-control selectric">
                                                    <option value="1">Rascunho</option>
                                                    <option value="0">Concluído</option>
                                                    <option value="2">Pendente</option>
                                                </select>
                                            </div>
                                        </div>  
            
                                        
                                    </form> 
                                </div>
                                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                    @include('admin.processos.formProcesso',['cliente_id'=>1,'cid'=>$cid_categoria,'cidsub'=>$cid_subcategoria])
                                </div>                                
                                </div>
                            </div>
                        </div>
                        
                        <div class="row offset-8">
                            <button class="btn btn-lg btn-info" onclick="editarUser()" type="button" tabindex="16"><i class="fas fa-user-edit"></i> Editar Cliente</button>
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
                document.getElementById("incapazone").innerHTML = `
                <div class='row'>
                    <h4 style='color:white'>Dados do Responsável</h4>
                </div>
                <div class='row justify-content-center'>
                    <div class='form-group col-lg-3 col-md-12'>
                        <label for='nomeresp' style='color:white;'>Nome</label>
                        <input type='text' name='nomeresp' id='nomeresp' class='form-control' value='{{ old('nomeresp',$cliente->nomeresp)}}' tabindex='1' placeholder='Digite o nome do responsável'>
                        <div class='invalid-feedback'><p>{{ $errors->first('nomeresp') }}</p></div>
                    </div>
                    <div class='form-group col-lg-2 col-md-12'>
                        <label for='cpfresp' style='color:white;'>CPF</label>
                        <input type='text' name='cpfresp' pattern='[0-9]*'' maxlength='11' onkeyup='num(this);' id='cpfresp' class='form-control' value='{{ old('cpfresp',$cliente->cpfresp)}}' tabindex='1' placeholder='Digite o cpf do responsável'>
                        <div class='invalid-feedback'><p>{{ $errors->first('cpfresp') }}</p></div>
                    </div>
                    <div class='form-group col-lg-2 col-md-12'>
                        <label for='rgresp' style='color:white;'>RG</label>
                        <input type='text' name='rgresp' pattern='[0-9]*'' maxlength='11' onkeyup='num(this);' id='rgresp' class='form-control' value='{{ old('rgresp',$cliente->rgresp)}}' tabindex='1' placeholder='Digite o rg do responsável'>
                        <div class='invalid-feedback'><p>{{ $errors->first('rgresp') }}</p></div>
                    </div>
                    <div class='form-group col-lg-2 col-md-12'>
                        <label for='orgaoresp' style='color:white;'>Orgão Expeditor</label>
                        <input type='text' name='orgaoresp' id='orgaoresp' class='form-control' value='{{ old('orgaoresp',$cliente->orgaoresp)}}' tabindex='1' placeholder='Digite o orgão expeditor'><div class='invalid-feedback'><p>{{ $errors->first('orgaoresp') }}</p></div></div>
                    </div>`;
            }else{
                $('#incapazone').removeClass('jumbotron');
                document.getElementById("incapazone").innerHTML="";
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            checkIncapaz();
        });
        function editarUser(){      
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
                title: "Tem certeza disso?",
                text: "Você está editando esse cliente permanentemente!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    swal("Tentando atualizar dados do cliente", {

                    icon: "success",
                    });
                    document.editar.submit();                    
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

        $(document).ready(function(){
        var url = $(this).attr('href');
        // fetch_clientes_data(url);

        fetch_categoria_data('',url);
        fetch_subcategoria_data('',url);
    });

    function fetch_categoria_data(query = '',url)
    {
        $.ajax({
            url:url,
            method:'GET',
            data:{query:query},
            dataType:'json',
            success:function(data)
            {
                $('#cid').html(data.options);                    
            }
        });
    }        

    function fetch_subcategoria_data(subquery = '',url)
    {
        $.ajax({
            url:url,
            method:'GET',
            data:{subquery:subquery},
            dataType:'json',
            success:function(data)
            {
                $('#subcid').html(data.options2);                    
            }
        });
    }

    $(document).on('keyup','#cidesc',function(){
        var query = $(this).val();
        fetch_categoria_data(query);
    });
    
    $(document).on('keyup','#subcidesc',function(){
        var subquery = $(this).val();
        fetch_subcategoria_data(subquery);
    });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
@endsection