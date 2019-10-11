@extends('layouts.admin-master')

@section('title')
Clientes
@endsection

@section('content')
<style>
.loader {
  border: 8px solid #f3f3f3; /* Light grey */
  border-top: 8px solid #3498db; /* Blue */
  border-radius: 50%;
  margin: auto;
  width: 60px;
  height: 60px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<section class="section">
    <div class="section-header">
        <h1>Clientes</h1>
        <div class="section-header-button">
            <a href="{{ route('painel.clientes.create')}}" class="btn btn-primary">Add Novo</a>
        </div>
        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.index')}}">Dashboard</a></div>
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
                    <div class="float-left">
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
                <div class="float-right">
                    <form id="blocopesquisa">
                    <div class="input-group">
                        <input id="search" type="text" class="form-control" placeholder="Pesquisar">
                        <div class="input-group-append">
                        <button id="botaosearch" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>                
            </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Todos Clientes <span id="total" class="badge badge-primary"></span></h4>
                    </div>
                    <div class="card-body">      
                        <div class="loader"></div>
                                                                                     
                        <div class="clearfix mb-3"></div>
                        
                        <div class="table-responsive">                            
                            <table id="table" class="table table-striped">                        
                            </table>
                        </div>
                        <div id="links" class="float-right">
                            {{-- {{ $clientes->links() }} --}}
                        </div>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var url = $(this).attr('href');
            // fetch_clientes_data(url);

            fetch_clientes_data('',url);
            
        });
        function fetch_clientes_data(query = '',url)
        {
            $.ajax({
                url:url,
                method:'GET',
                data:{query:query{!!$status != '' ? ',status:'.$status : ''!!}},
                dataType:'json',
                success:function(data)
                {
                    $('#table').html(data.table_data);
                    $('#total').text(data.total);
                    $('#links').html(data.links);
                }
            });
        }
        $(document).on('submit','#botaosearch',function(){
            var query = $(this).val();
            fetch_clientes_data(query);
        });
        $(document).on('keyup','#search',function(){
            var query = $(this).val();
            fetch_clientes_data(query);
        });
    </script>
@endsection