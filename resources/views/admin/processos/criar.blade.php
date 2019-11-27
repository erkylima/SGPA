@extends('layouts.admin-master')

@section('title')
    Novo Cadastro - Parte 2
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{auth()->user()->can('ver-clientes') ? route('painel.clientes') : route('admin.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Criar Novo Cadastro - Parte 2</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
            @if(auth()->user()->can('ver-clientes')) 
            <div class="breadcrumb-item"><a href="{{route('painel.clientes')}}">Clientes</a></div>
            @endif
            <div class="breadcrumb-item">Criar Novo Processo</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Novo Processo</h2>
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
                        
                        <form name="criar" action="{{ route('painel.processos.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}     
                            {{-- <div data-toggle="tooltip" data-placement="top" title="Selecione a foto do perfil do cliente abaixo." class="section-title row mb-4 justify-content-center">Foto do Cliente</div>
                            <div class="form-group row mb-4 justify-content-center">
                                <div class="custom-file  col-lg-4 col-md-12">
                                    <input type="file" class="custom-file-input" id="perfil" name="perfil">
                                    <label class="custom-file-label" for="perfil">Escolher arquivo</label>
                                </div>
                            </div>                     --}}

                            {{-- <div class="form-row row mb-4 justify-content-center">                            
                                <div class="form-group col-lg-8 col-md-12">
                                    <label for="titulo">Titulo (*)</label>
                                        
                                    <input tabindex="1" type="text" name="titulo" id="titulo" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old('titulo')}}" tabindex="1" placeholder="Digite o nome do projeto">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('titulo') }}</p>
                                    </div>                                    
                                </div>                                                            
                            </div> --}}
                            
                            <div class="form-row row mb-4 justify-content-center">                            
                                <div class="form-group col-lg-8 col-md-12">
                                    <label for="responsavel">Responsável (*)</label>
                                    
                                    <input tabindex="1" type="text" name="responsavel" id="responsavel" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old('responsavel')}}" tabindex="1" placeholder="Responsável pelo processo">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('responsavel') }}</p>
                                    </div> 
                                </div>
                            </div> 

                            <div class="form-row justify-content-left mb-4">
                                {{-- <div class="form-group col-lg-3 col-md-12">
                                    <label for="agenciador">Agenciador</label>
                                    <select tabindex="1" id="agenciador" class="form-control" name="agenciador">
                                        <option disabled selected>Selecione o agenciador</option>
                                        @foreach ($usuarios as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            
                                        @endforeach
                                        {{var_dump($usuarios)}}
                                    </select>
                                </div> --}}
                                <div class="offset-2">

                                </div>
                                <div class="form-group col-lg-2 col-md-12">
                                    <label for="numero_processo">Número do Processo (*)</label>
                                    <input tabindex="1" type="text" name="numero_processo" id="numero_processo" class="form-control" value="{{old('numero_processo')}}" tabindex="1" placeholder="Digite o número do processo">
                                    <div class="invalid-feedback">
                                        <p>{{ $errors->first('numero_processo') }}</p>
                                    </div>                                                                       
                                </div>
                                <div class="form-group col-lg-2 col-md-12">                                      
                                    <label for="tipo_processo">Tipo do processo</label>
                                    <select tabindex="1" id="tipo_processo" onchange="selectionartipo(this.options[this.selectedIndex].value)" class="form-control" name="tipo_processo">
                                        <option disabled selected value="0">Selecione o tipo</option>
                                        <option value="1">1 - Auxílio-Doença</option>
                                        <option value="2">2 - BPC-LOAS Deficiente</option>
                                        <option value="3">3 - Aposentadoria</option>                                        
                                        <option value="4">4 - Pensão por Morte</option>
                                        <option value="5">5 - Salário Maternidade</option>
                                        <option value="6">6 - BPC-LOAS Idoso</option>
                                        <option value="7">7 - Auxílio Acidente</option>
                                        <option value="8">8 - Auxílio Reclusão</option>
                                        <option value="9">9 - Trabalhista</option>
                                        <option value="10">10 - Cívil</option>
                                        <option value="11">11 - Criminal</option>
                                        <option value="12">12 - Outros</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-md-12">
                                    <label for="subtipo_processo" id="labelsubtipo">Subtipo do processo</label>
                                    <select tabindex="1" id="subtipo_processo" onchange="selectionarsubtipo(this.options[this.selectedIndex].value)" class="form-control" name="subtipo_processo">
                                        <option disabled selected>Selecione o subtipo</option>

                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-md-12">
                                    <label for="categoria" id="labelcategoria">Categoria</label>
                                    <select tabindex="1" id="categoria" onchange="selectionarcategoria(this.options[this.selectedIndex].value)" class="form-control" name="categoria">
                                        <option disabled selected>Selecione a categoria</option>
                                        <option value="1">Administrativo</option>
                                        <option value="2">Judicial</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                            <input id="cliente_id" class="form-control" type="hidden" name="" value="{{ $cliente_id }}">
                            </div>
                            <div class="form-row justify-content-center" id="auxilio_doenca"></div>
                            <div class="form-row justify-content-center" id="categoriadiv"></div>                            
                            <div class="form-row justify-content-center" id="aposentadoria"></div>                            
                            <div class="form-row justify-content-center" id="civil"></div>                            
                            <div class="form-row justify-content-center" id="criminal"></div>                            
                            <div class="form-row justify-content-center" id="pensao_morte"></div>                        
                            <div class="form-row justify-content-center" id="selario_maternidade"></div>
                            <div class="form-row justify-content-center" id="selario_maternidade"></div>
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
                document.getElementById("incapazone").innerHTML = `<div class='form-group col-lg-3 col-md-12'><label for='nomeresp'>Nome do Responsável (*)</label><input type='text' name='nomeresp' id='nomeresp' class='form-control' value='' tabindex='1' placeholder='Digite o nome do responsável'><div class='invalid-feedback'><p>{{ $errors->first('nomeresp') }}</p></div></div><div class='form-group col-lg-2 col-md-12'><label for='cpfresp'>CPF do Responsável (*)</label><input type='text' name='cpfresp' pattern='[0-9]*'' maxlength='11' onkeyup='num(this);' id='cpfresp' class='form-control' value='' tabindex='1' placeholder='Digite o cpf do responsável'><div class='invalid-feedback'><p>{{ $errors->first('cpfresp') }}</p></div></div><div class='form-group col-lg-2 col-md-12'><label for='rgresp'>RG do Responsável (*)</label><input type='text' name='rgresp' pattern='[0-9]*'' maxlength='11' onkeyup='num(this);' id='rgresp' class='form-control' value='' tabindex='1' placeholder='Digite o rg do responsável'><div class='invalid-feedback'><p>{{ $errors->first('rgresp') }}</p></div></div><div class='form-group col-lg-2 col-md-12'><label for='orgaoresp'>Orgão Expeditor do RG (*)</label><input type='text' name='orgaoresp' id='orgaoresp' class='form-control' value='' tabindex='1' placeholder='Digite o orgão expeditor'><div class='invalid-feedback'><p>{{ $errors->first('orgaoresp') }}</p></div></div>`;
            }else{
                $('#incapazone').removeClass('jumbotron');
                document.getElementById("incapazone").innerHTML="";
            }
        }

        function selecid(){
            document.getElementById('cid').selectedIndex = "50";
        }

        function selectionarcategoria(valor){
            switch (valor) {
                case '1':
                    if(document.getElementById('tipo_processo').value == '1' || document.getElementById('tipo_processo').value == '2' || (document.getElementById('tipo_processo').value == '3' && document.getElementById('subtipo_processo').value == '1')){
                        document.getElementById('categoriadiv').innerHTML = `
                        <div class="form-group col-lg-3 col-md-12">
                            <label for="localpericia">Local da Perícia</label>
                            <input tabindex="1" id="localpericia" placeholder="Local da Perícia" class="form-control" type="text" name="localpericia">
                        </div>
                        <div class="form-group col-lg-3 col-md-12">
                            <label for="datapericia">Data de Perícia (*)</label>
                            <input tabindex="1" name="datapericia" id="datapericia" type="date" value="{{old('datapericia')}}"class="form-control">
                            <div class="invalid-feedback">
                                <p>{{ $errors->first('datapericia') }}</p>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-12">
                            <label for="der">Entrada no Requerimento (*)</label>
                            <input tabindex="1" name="der" id="der" type="date" value="{{old('der')}}"class="form-control">
                            <div class="invalid-feedback">
                                <p>{{ $errors->first('der') }}</p>
                            </div>
                        </div>
                        `;
                    } else {
                        document.getElementById('categoriadiv').innerHTML = `                        
                        <div class="form-group col-lg-3 col-md-12">
                            <label for="der">Entrada no Requerimento (*)</label>
                            <input tabindex="1" name="der" id="der" type="date" value="{{old('der')}}"class="form-control">
                            <div class="invalid-feedback">
                                <p>{{ $errors->first('der') }}</p>
                            </div>
                        </div>
                        <div class="offset-5"></div>
                        `;
                    }
                    break;
                case '2':
                    document.getElementById('categoriadiv').innerHTML = `                        
                        <div class="form-group col-lg-3 col-md-12">
                            <label for="der">Entrada no Requerimento (*)</label>
                            <input tabindex="1" name="der" id="der" type="date" value="{{old('der')}}"class="form-control">
                            <div class="invalid-feedback">
                                <p>{{ $errors->first('der') }}</p>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-12">
                            <label for="numerobeneficio">Número do Benefício</label>
                            <input tabindex="1" id="numerobeneficio" placeholder="Número do benefício" class="form-control" type="text" name="numerobeneficio">
                        </div>                        
                        `;
                    break;            
                default:
                    break;
            }
        }
        
        function selectionartipo(valor){
            selectionarcategoria(document.getElementById('categoria').value);
            document.getElementById('categoria').options[1].style.display = 'block';
            document.getElementById('categoria').options[1].disabled = false;
            switch (valor) {
                case '1':
                    document.getElementById('auxilio_doenca').innerHTML = divsCid();
                    document.getElementById('labelsubtipo').style.visibility = "visible";
                    document.getElementById('subtipo_processo').style.visibility = "visible";
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='0'>Selecione o tipo</option><option value='1'>Concessão</option><option value='2'>Restabelecimento</option>";
                    break;
                case '2':
                    document.getElementById('labelsubtipo').style.visibility = "visible";
                    document.getElementById('subtipo_processo').style.visibility = "visible";
                    document.getElementById('auxilio_doenca').innerHTML = divsCid();
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='0'>Selecione o tipo</option><option value='1'>Concessão</option><option value='2'>Restabelecimento</option>";
                    break;
                case '3':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='0'>Selecione o tipo</option><option value='1'>Por Invalidez</option><option value='2'>Por Idade</option><option value='3'>Por Tempo de Contribuição</option><option value='4'>Híbrida</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('labelsubtipo').style.visibility = "visible";
                    document.getElementById('subtipo_processo').style.visibility = "visible";
                    
                    break;
                case '4':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('labelsubtipo').style.visibility = "visible";
                    document.getElementById('subtipo_processo').style.visibility = "visible";
                    break;
                case '5':
                    document.getElementById('auxilio_doenca').innerHTML = "<div class='form-group col-md-12 col-lg-5'><label for='nome_crianca'>Nome da Criança</label><input id='nome_crianca' class='form-control' type='text' name='nome_crianca'></div><div class='form-group col-md-12 col-lg-3'><label for='data_parto'>Data do Parto</label><input id='data_parto' class='form-control datetimepicker' type='date' name='data_parto'></div>";
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '6':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '7':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = divsCid();
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '7':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '8':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '9':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('categoria').options[1].disabled = true;
                    document.getElementById('categoria').options[1].style.display = 'none';
                    document.getElementById('categoria').selectedIndex = 2;
                    selectionarcategoria('2');
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '10':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('categoria').options[1].style.display = 'none';
                    document.getElementById('categoria').options[1].disabled = true;
                    document.getElementById('categoria').selectedIndex = 2;
                    selectionarcategoria('2');
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '11':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('categoria').options[1].style.display = 'none';
                    document.getElementById('categoria').options[1].disabled = true;
                    document.getElementById('categoria').selectedIndex = 2;
                    selectionarcategoria('2');
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                case '12':
                    document.getElementById('subtipo_processo').innerHTML = "<option disabled selected value='1'>Padrão</option>";
                    document.getElementById('auxilio_doenca').innerHTML = "";
                    document.getElementById('categoria').options[1].disabled = true;
                    document.getElementById('categoria').selectedIndex = 2;
                    document.getElementById('categoria').options[1].style.display = 'none';
                    selectionarcategoria('2');
                    document.getElementById('labelsubtipo').style.visibility = "hidden";
                    document.getElementById('subtipo_processo').style.visibility = "hidden";
                    break;
                default:
                    break;
            }
        }

        function divsCid(){
            return `                                
                    
                    <div class="form-group col-md-12 col-lg-4">
                        <label for="cid">Defina a categoria CID</label>
                        <div class="input-group">
                            <input tabindex="1" class="form-control" type="search" name="cidesc" id="cidesc" placeholder="Cod ou Descrição" aria-label="Descrição do CID" aria-describedby="my-addon">                                    
                            <select tabindex="1" id="cid" class="form-control" name="cid">
                                @foreach ($cid as $item)
                                    <option value="{{ $item->id }}">{{ $item->cod }} - {{ $item->descricao }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group col-md-12 col-lg-4">
                        <label for="cid">Defina a subcategoria CID</label>
                        <div class="input-group">
                            <input tabindex="1" class="form-control" type="search" name="subcidesc" id="subcidesc" placeholder="Cod ou Descrição" aria-label="Descrição do CID" aria-describedby="my-addon">                                    
                            <select tabindex="1" id="subcid" class="form-control" name="subcid">
                                @foreach ($cidsub as $item)
                                    <option value="{{ $item->id }}">{{ $item->cod }} - {{ $item->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    `;
        }

        function selectionarsubtipo(valor){
            selectionarcategoria(document.getElementById('categoria').value);
            if(document.getElementById('tipo_processo').value == 3){
                switch (document.getElementById('subtipo_processo').value) {
                    case '0':
                        document.getElementById('auxilio_doenca').innerHTML = "";
                        break;
                    case '1':
                        document.getElementById('auxilio_doenca').innerHTML = divsCid();
                        break;
                    case '2':
                        document.getElementById('auxilio_doenca').innerHTML = "";
                    case '3':
                        document.getElementById('auxilio_doenca').innerHTML = "";
                    case '4':
                        document.getElementById('auxilio_doenca').innerHTML = "";
                    default:
                        break;
                }
            }
        }

        function criarProcesso(){
            // if(document.getElementById("name").value.length < 1 ){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um nome',
            //         position: 'topRight',
            //     });
            // } else if(!emailIsValid(document.getElementById("email").value)){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um email válido',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("rg").value.length < 7){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um rg válido',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("orgao").value.length < 2){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um orgão expeditor',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("bairro").value.length < 3){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um bairro',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("cpf").value.length < 11){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um cpf válido',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("cidade").value.length < 2){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um cidade',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("rua").value.length < 2){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir uma rua',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("numero").value.length < 1){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir o número',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("complemento").value.length < 1){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir o complemento',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("cep").value.length < 8){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa definir um CEP válido',
            //         position: 'topRight',
            //     });
            // } else if(document.getElementById("telefone1").value.length < 10){
            //     iziToast.error({
            //         title: 'Ops...',
            //         message: 'Você precisa o definir 1º telefone',
            //         position: 'topRight',
            //     });
            // } else {
            //     swal({
            //     title: "Os dados estão corretos?",
            //     text: "Você está adicionando um novo cliente!",
            //     icon: "warning",
            //     buttons: true,
            //     dangerMode: true,
            //     })
            //     .then((willDelete) => {
            //     if (willDelete) {
            //         swal("Tentando criar usuário", {

            //         icon: "success",
            //         });
            //         document.criar.submit();                    
            //     } else {
            //         swal("Você cancelou a ação!");
            //     }
            //     });
            // }
            document.criar.submit();
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
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
@endsection