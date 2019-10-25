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
                    <div class="card-body">
                        <form name="editar" action="{{ route('painel.clientes.update',$cliente->id)}}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            {{ csrf_field() }}     
                            <div data-toggle="tooltip" data-placement="top" title="Selecione a foto do perfil do cliente abaixo." class="section-title row mb-4 justify-content-center">Foto do Cliente</div>
                            <div class="form-group row mb-4 justify-content-center">
                                <div data-toggle="tooltip" data-placement="top" title="Somente se quiser alterar a foto." class="custom-file  col-lg-4 col-md-12">
                                    <input type="file" class="custom-file-input" id="perfil" name="perfil">
                                    <label class="custom-file-label" for="perfil">Escolher arquivo</label>
                                </div>
                            </div>                    
                            <div class="form-row row mb-4 justify-content-center">                            
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="name">Nome (*)</label>
                                        
                                <input type="text" name="name" id="name" class="form-control" value="{{$cliente->nome}}" tabindex="1" placeholder="Digite o nome do cliente">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('name') }}</p>
                                    </div>                                    
                                </div>
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="sobrenome">Sobrenome (*)</label>                                    
                                    <input type="text" name="sobrenome" id="sobrenome" class="form-control" value="{{$cliente->sobrenome}}" tabindex="1" placeholder="Digite o sobrenome do cliente">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('sobrenome') }}</p>
                                    </div>
                                        
                                </div>                            
                            </div>
                            <div class="form-row row mb-4 justify-content-center">
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="email">Email (*)</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Endereço de email" name="email" tabindex="1" value="{{$cliente->email}}">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="profissao">Profissão (*)</label>                                    
                                    <input type="text" name="profissao" id="profissao" class="form-control" value="{{$cliente->profissao}}" tabindex="1" placeholder="Digite a profissão do cliente">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('sobrenome') }}</p>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="form-row row mb-4 justify-content-center">                            
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="genero" class="control-label">Genero (*)</label>
                                    <select class="form-control" id="genero" tabindex="10" name="genero">
                                        <option {{ $cliente->genero == 'M' ? ' selected' : '' }} value="M">Masculino</option>
                                        <option {{ $cliente->genero == 'F' ? ' selected' : '' }} value="F">Feminino</option>
                                        <option {{ $cliente->genero == 'O' ? ' selected' : '' }} value="O">Outro</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="estado_civil">Estado Civil (*)</label>
                                        <select class="form-control" id="estado_civil" tabindex="2" name="estado_civil">
                                                <option {{ $cliente->genero == 'Solteiro' ? ' selected' : '' }} value="Solteiro">Solteiro</option>
                                                <option {{ $cliente->genero == 'Casado' ? ' selected' : '' }} value="Casado">Casado</option>
                                                <option {{ $cliente->genero == 'Separado' ? ' selected' : '' }} value="Separado">Separado</option>
                                                <option {{ $cliente->genero == 'Divorciado' ? ' selected' : '' }} value="Divorciado">Divorciado</option>
                                                <option {{ $cliente->genero == 'Viúvo' ? ' selected' : '' }} value="Viúvo">Viúvo</option>
                                                <option {{ $cliente->genero == 'Amasiado' ? ' selected' : '' }} value="Amasiado">Amasiado</option>
                                        </select>                    
                                </div>
                            </div> 

                            <div class="form-row row mb-4 justify-content-center">
                                <div class="form-group col-lg-3 col-md-12">
                                    <label data-toggle="tooltip" data-placement="top" title="Clique em Foto RG para enviar o arquivo do RG." for="rg">RG (*)</label>
                                    <div class="input-group">
                                        <div data-toggle="tooltip" data-placement="top" title="Somente se quiser alterar a foto." class="custom-file">
                                            <input type="file" placeholder="Foto" class="custom-file-input" id="foto_rg" name="foto_rg">
                                            <label class="custom-file-label" for="foto_rg">Foto RG</label>
                                        </div>
                                        <input id="rg" type="text" class="form-control" pattern="[0-9]+" placeholder="Digite seu RG" name="rg" tabindex="1" value="{{$documento->rg}}">
                                    </div>                    
                                </div>
                
                                <div class="form-group col-lg-2 col-md-12">
                                    <label for="orgao">Orgão (*)</label>
                                    <div class="input-group">
                                        <input id="orgao" type="text" class="form-control" placeholder="Expedidor" maxlength="20" name="orgao" tabindex="1" value="{{$documento->orgao}}">
                                    </div>                    
                                </div>
                
                                <div class="form-group col-lg-3 col-md-12">
                                    <label data-toggle="tooltip" data-placement="top" title="Clique em Foto CPF para enviar o arquivo do CPF." for="cpf">CPF (*)</label>
                                    <div class="input-group">
                                        <div data-toggle="tooltip" data-placement="top" title="Somente se quiser alterar a foto." class="custom-file">
                                            <input type="file" placeholder="Foto" class="custom-file-input" id="foto_cpf" name="foto_cpf">
                                            <label class="custom-file-label" for="foto_cpf">Foto CPF</label>
                                        </div>                                    
                                        <input id="cpf" onkeyup="num(this);" type="text" class="form-control " pattern="[0-9]*" maxlength="11" placeholder="Digite seu CPF" name="cpf" tabindex="1" value="{{$documento->cpf}}">
                                    </div>                                        
                                </div>
                                
                                
                            </div>

                            <div class="form-row row mb-4 justify-content-center">
                                <div class="form-group col-lg-3 col-md-12">
                                    <label for="bairro">Bairro (*)</label>
                                    <div class="input-group">
                                        <input id="bairro" type="text" class="form-control" maxlength="50" placeholder="Digite seu Bairro" name="bairro" tabindex="1" value="{{$endereco->bairro}}">
                                    </div>                    
                                </div>
                
                                <div class="form-group col-lg-3 col-md-12">
                                    <label for="cidade">Cidade (*)</label>
                                    <div class="input-group">
                                    <input id="cidade" type="text" class="form-control" maxlength="50" placeholder="Digite sua Cidade" name="cidade" tabindex="1" value="{{$endereco->cidade}}">
                                    </div>                    
                                </div>
                
                                <div class="form-group col-lg-2 col-md-12">
                                    <label for="estado">Estado (*)</label>
                                        <select class="form-control" id="estado" tabindex="2" name="estado">                                        
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
                                <div class="form-group col-lg-5 col-md-12">
                                    <label for="rua">Rua (*)</label>
                                    <div class="input-group">
                                        <input id="rua" type="text" class="form-control{{ $errors->has('rua') ? ' is-invalid' : '' }}" placeholder="Digite sua Rua" name="rua" tabindex="3" value="{{$endereco->rua}}">
                                    </div>
                                    <div class="invalid-feedback">
                                    {{ $errors->first('rua') }}
                                    </div>
                                </div>
                
                                <div class="form-group col-lg-2 col-md-12">
                                    <label for="pais">Pais (*)</label>
                                    <select class="form-control" id="pais" tabindex="2" name="pais">
                                        <option value="Brasil" selected>Brasil</option>    
                                        <option value="África do Sul">África do Sul</option>
                                        <option value="Albânia">Albânia</option>
                                        <option value="Alemanha">Alemanha</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua">Antigua</option>
                                        <option value="Arábia Saudita">Arábia Saudita</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armênia">Armênia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Austrália">Austrália</option>
                                        <option value="Áustria">Áustria</option>
                                        <option value="Azerbaijão">Azerbaijão</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrein">Bahrein</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Bélgica">Bélgica</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermudas">Bermudas</option>
                                        <option value="Botsuana">Botsuana</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgária">Bulgária</option>
                                        <option value="Burkina Fasso">Burkina Fasso</option>
                                        <option value="botão">botão</option>
                                        <option value="Cabo Verde">Cabo Verde</option>
                                        <option value="Camarões">Camarões</option>
                                        <option value="Camboja">Camboja</option>
                                        <option value="Canadá">Canadá</option>
                                        <option value="Cazaquistão">Cazaquistão</option>
                                        <option value="Chade">Chade</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Cidade do Vaticano">Cidade do Vaticano</option>
                                        <option value="Colômbia">Colômbia</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Coréia do Sul">Coréia do Sul</option>
                                        <option value="Costa do Marfim">Costa do Marfim</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Croácia">Croácia</option>
                                        <option value="Dinamarca">Dinamarca</option>
                                        <option value="Djibuti">Djibuti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="EUA">EUA</option>
                                        <option value="Egito">Egito</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Emirados Árabes">Emirados Árabes</option>
                                        <option value="Equador">Equador</option>
                                        <option value="Eritréia">Eritréia</option>
                                        <option value="Escócia">Escócia</option>
                                        <option value="Eslováquia">Eslováquia</option>
                                        <option value="Eslovênia">Eslovênia</option>
                                        <option value="Espanha">Espanha</option>
                                        <option value="Estônia">Estônia</option>
                                        <option value="Etiópia">Etiópia</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Filipinas">Filipinas</option>
                                        <option value="Finlândia">Finlândia</option>
                                        <option value="França">França</option>
                                        <option value="Gabão">Gabão</option>
                                        <option value="Gâmbia">Gâmbia</option>
                                        <option value="Gana">Gana</option>
                                        <option value="Geórgia">Geórgia</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Granada">Granada</option>
                                        <option value="Grécia">Grécia</option>
                                        <option value="Guadalupe">Guadalupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guiana">Guiana</option>
                                        <option value="Guiana Francesa">Guiana Francesa</option>
                                        <option value="Guiné-bissau">Guiné-bissau</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Holanda">Holanda</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungria">Hungria</option>
                                        <option value="Iêmen">Iêmen</option>
                                        <option value="Ilhas Cayman">Ilhas Cayman</option>
                                        <option value="Ilhas Cook">Ilhas Cook</option>
                                        <option value="Ilhas Curaçao">Ilhas Curaçao</option>
                                        <option value="Ilhas Marshall">Ilhas Marshall</option>
                                        <option value="Ilhas Turks & Caicos">Ilhas Turks & Caicos</option>
                                        <option value="Ilhas Virgens (brit.)">Ilhas Virgens (brit.)</option>
                                        <option value="Ilhas Virgens(amer.)">Ilhas Virgens(amer.)</option>
                                        <option value="Ilhas Wallis e Futuna">Ilhas Wallis e Futuna</option>
                                        <option value="Índia">Índia</option>
                                        <option value="Indonésia">Indonésia</option>
                                        <option value="Inglaterra">Inglaterra</option>
                                        <option value="Irlanda">Irlanda</option>
                                        <option value="Islândia">Islândia</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Itália">Itália</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japão">Japão</option>
                                        <option value="Jordânia">Jordânia</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Líbano">Líbano</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lituânia">Lituânia</option>
                                        <option value="Luxemburgo">Luxemburgo</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedônia">Macedônia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malásia">Malásia</option>
                                        <option value="Malaui">Malaui</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marrocos">Marrocos</option>
                                        <option value="Martinica">Martinica</option>
                                        <option value="Mauritânia">Mauritânia</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="México">México</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Mônaco">Mônaco</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Nicarágua">Nicarágua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigéria">Nigéria</option>
                                        <option value="Noruega">Noruega</option>
                                        <option value="Nova Caledônia">Nova Caledônia</option>
                                        <option value="Nova Zelândia">Nova Zelândia</option>
                                        <option value="Omã">Omã</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Panamá">Panamá</option>
                                        <option value="Papua-nova Guiné">Papua-nova Guiné</option>
                                        <option value="Paquistão">Paquistão</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Polinésia Francesa">Polinésia Francesa</option>
                                        <option value="Polônia">Polônia</option>
                                        <option value="Porto Rico">Porto Rico</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Quênia">Quênia</option>
                                        <option value="Rep. Dominicana">Rep. Dominicana</option>
                                        <option value="Rep. Tcheca">Rep. Tcheca</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romênia">Romênia</option>
                                        <option value="Ruanda">Ruanda</option>
                                        <option value="Rússia">Rússia</option>
                                        <option value="Saipan">Saipan</option>
                                        <option value="Samoa Americana">Samoa Americana</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serra Leone">Serra Leone</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Singapura">Singapura</option>
                                        <option value="Síria">Síria</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="St. Kitts & Nevis">St. Kitts & Nevis</option>
                                        <option value="St. Lúcia">St. Lúcia</option>
                                        <option value="St. Vincent">St. Vincent</option>
                                        <option value="Sudão">Sudão</option>
                                        <option value="Suécia">Suécia</option>
                                        <option value="Suiça">Suiça</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Tailândia">Tailândia</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tanzânia">Tanzânia</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                        <option value="Tunísia">Tunísia</option>
                                        <option value="Turquia">Turquia</option>
                                        <option value="Ucrânia">Ucrânia</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Uruguai">Uruguai</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnã">Vietnã</option>
                                        <option value="Zaire">Zaire</option>
                                        <option value="Zâmbia">Zâmbia</option>
                                        <option value="Zimbábue">Zimbábue</option>
                                    </select>                
                                </div>

                                <div class="form-group col-lg-1 col-md-12">
                                    <label for="numero">Número (*)</label>
                                    <div class="input-group">
                                        <input id="numero" type="text" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" pattern="[0-9]+" placeholder="Núm." maxlength="11" name="numero" tabindex="1" value="{{$endereco->numero}}">
                                    </div>
                                    <div class="invalid-feedback">
                                    {{ $errors->first('numero') }}
                                    </div>
                                </div>                                                                        
                            </div>
                            
                            <div class="form-row row mb-4 justify-content-center">
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="complemento">Complemento (*)</label>
                                    <div class="input-group">                    
                                        <input id="complemento" type="text" class="form-control" placeholder="Digite o complemento" name="complemento" tabindex="1" value="{{$endereco->complemento}}" >
                                        <div class="invalid-feedback">
                                            {{ $errors->first('complemento') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="cep">CEP (*)</label>
                                    <div class="input-group">
                                        <input id="cep" type="text" class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}" pattern="[a-zA-Z0-9]+" placeholder="Digite o CEP" maxlength="8" placeholder="Digite seu CEP" name="cep" tabindex="1" value="{{$endereco->cep}}">
                                    </div>
                                    <div class="invalid-feedback">
                                    {{ $errors->first('cep') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-row row justify-content-center">
                                <div class="form-group col-lg-4 col-md-12">
                                    <label for="telefone1">1º Telefone (*)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input id="telefone1" type="text" class="telefone form-control" placeholder="Digite seu telefone" name="telefone1" tabindex="9" value="{{$cliente->telefone1}}" >
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
                                        <input name="telefone2" id="telefone2" type="text" class="telefone form-control" placeholder="Digite seu telefone" tabindex="9" value="{{$cliente->telefone2}}" >
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fone') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4 justify-content-left">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                <div class="col-sm-12 col-md-4">
                                    <select name="status" class="form-control selectric">
                                        <option {{ $cliente->status == '1' ? ' selected' : '' }} value="1">Rascunho</option>
                                        <option {{ $cliente->status == '0' ? ' selected' : '' }} value="0">Concluído</option>
                                        <option {{ $cliente->status == '2' ? ' selected' : '' }} value="2">Pendente</option>
                                    </select>
                                </div>
                            </div>                                                        

                            
                        </form>
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
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
@endsection