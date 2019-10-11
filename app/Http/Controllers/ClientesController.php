<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!is_null($request->query('status'))){
        $clientes = DB::table('clientes')
                                ->where('clientes.status',$request->query('status'))
                                ->join('users','users.id','=','clientes.agenciador_id')
                                ->select('users.name','users.avatar','clientes.*')
                                ->paginate(15);
        }else{
            $clientes = DB::table('clientes')
                                ->join('users','users.id','=','clientes.agenciador_id')
                                ->select('users.name','users.avatar','clientes.*')
                                ->paginate(1);
        }
        $output = '';
        if($request->ajax()){
            $query = $request->get('query');        
            if($query != ''){            
                if(!is_null($request->query('status'))){
                    $data = DB::table('clientes')
                    ->where('status',$request->query('status'))
                    ->where('nome','like','%'.$query.'%')
                    ->orWhere('sobrenome','like','%'.$query.'%')
                    ->orWhere('profissao','like','%'.$query.'%')
                    ->join('users','users.id','=','clientes.agenciador_id')
                    ->orderBy('nome','asc')
                    ->select('users.name','users.avatar','clientes.*')
                    ->paginate(15);
                }else{
                    $data = DB::table('clientes')
                    ->where('nome','like','%'.$query.'%')
                    ->orWhere('sobrenome','like','%'.$query.'%')
                    ->orWhere('profissao','like','%'.$query.'%')
                    ->join('users','users.id','=','clientes.agenciador_id')
                    ->orderBy('nome','asc')
                    ->select('users.name','users.avatar','clientes.*')
                    ->paginate(15);
                }
                
            } else {            
                if(!is_null($request->query('status'))){
                    $data = DB::table('clientes')
                            ->where('status',$request->query('status'))
                            ->join('users','users.id','=','clientes.agenciador_id')
                            ->select('users.name','users.avatar','clientes.*')
                            ->paginate(15);
                }else{
                    $data = DB::table('clientes')
                    ->join('users','users.id','=','clientes.agenciador_id')
                    ->select('users.name','users.avatar','clientes.*')
                    ->paginate(15);
                }

            }
            $total_row = $data->count();
            $output = "<tr>
                    <th class=\"text-center pt-2\">
                        #
                    </th>
                    <th>Nome</th>
                    <th>Profissão</th>
                    <th>Agenciador</th>
                    <th>Criado em</th>
                    <th>Status</th>
                </tr>";
            if($total_row > 0){            
                foreach ($data as $cliente) {
                    $dia = date("d", strtotime($cliente->created_at));
                    $mes = date("M", strtotime($cliente->created_at));
                    $ano = date("Y", strtotime($cliente->created_at));
                    switch ($cliente->status) {
                        case 0:
                            $status = '<div class="badge badge-primary">Concluido</div>';
                            break;
                        case 1:
                            $status = '<div class="badge badge-danger">Rascunho</div>';
                            break;
                        case 2:
                            $status = '<div class="badge badge-warning">Pendente</div>';
                            break;
                        case 3:
                            $status = '<div class="badge badge-dark">Apagado</div>';
                            break;
                        default:
                            # code...
                            break;
                    }
                    $output .= "
                    <tr>
                    <td>{$cliente->id}</td>
                    <td>{$cliente->nome} {$cliente->sobrenome}
                        <div class=\"table-links\">
                            <a href='#'>Ver</a>
                            <div class=\"bullet\"></div>
                            <a href='#'>Editar</a>
                            <div class=\"bullet\"></div>
                            <a href=\"#\" class=\"text-danger\">Apagar</a>
                        </div>
                    </td>
                    <td>{$cliente->profissao}</td>
                    <td><img alt=\"image\" src=" . asset($cliente->avatar) . " class=\"rounded-circle\" width=\"35\" data-toggle=\"title\" title=\"\"> <div class=\"d-inline-block ml-1\">{$cliente->name}</div></td>
                    <td>{$dia} de {$mes} de {$ano}</td>
                    <td>{$status}</td>
                    </tr>";
                    
                }
            } else {
                $output .= "
                                <td>#</td>
                                <td>Nenhum cliente encontrado</td>
                            ";
            }
            $links = "{$data->appends(request()->except('page'))->links()}";
            $pesquisa = "
            <div class=\"input-group\">
                <input id=\"search\" type=\"text\" class=\"form-control\" placeholder=\"Pesquisar\">
                <div class=\"input-group-append\">
                <button id=\"botaosearch\" class=\"btn btn-primary\"><i class=\"fas fa-search\"></i></button>
                </div>
            </div>
            ";
            $data = array('table_data' => $output,'total'=>$total_row,'links'=>$links);

            return response()->json($data);  

        }
        
        return view('admin.clientes.index')->with(['clientes'=>$clientes,'output'=>$output,'status'=>$request->status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clientes.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Clientes();
        if(auth()->user()->can('create-cliente'))
        {
            $request->validate([
                'name' => 'required|min:3|max:255',
                'email' => 'required|email|unique:users',
                'senha' => 'required|min:8|confirmed'
            ]);
            $cliente->name=$request->name;
            $cliente->genero=$request->genero;
            $cliente->email=$request->email;
            $cliente->telefone=$request->telefone;
            $cliente->cpf=$request->cpf;
            $cliente->nacionalidade=$request->nacionalidade;
            $cliente->estado_civil=$request->estado_civil;
            $cliente->rg=$request->rg;
            $cliente->orgao=$request->orgao;
            $cliente->rua=$request->rua;
            $cliente->complemento=$request->complemento;
            $cliente->numero=$request->numero;
            $cliente->bairro=$request->bairro;
            $cliente->cep=$request->cep;
            $cliente->cidade=$request->cidade;
            $cliente->estado=$request->estado;                                                
            $cliente->password=Hash::make($request->senha);                         
                 
            $cliente->save();
            return redirect()->back()->with('message','Usuário criado com sucesso');
        } else {
            return redirect()->back()->with('message','Você não tem permissão para criar novo cliente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clientes $clientes)
    {
        //
    }

    // Encontrar usuário por nome, email ou cpf
    public function cliente_nome(Request $request)
    {
        $output = '';
        if($request->ajax()){
        $query = $request->get('query');        
        if($query != ''){
            if(!is_null($request->query('status'))){
                $data = DB::table('clientes')
                ->where('status',$request->query('status'))
                ->where('nome','like','%'.$query.'%')
                ->orWhere('sobrenome','like','%'.$query.'%')
                ->orWhere('profissao','like','%'.$query.'%')
                ->join('users','users.id','=','clientes.agenciador_id')
                ->orderBy('nome','asc')
                ->select('users.name','users.avatar','clientes.*')
                ->get();
            }else{
                $data = DB::table('clientes')
                ->where('nome','like','%'.$query.'%')
                ->orWhere('sobrenome','like','%'.$query.'%')
                ->orWhere('profissao','like','%'.$query.'%')
                ->join('users','users.id','=','clientes.agenciador_id')
                ->orderBy('nome','asc')
                ->select('users.name','users.avatar','clientes.*')
                ->get();
            }
            
        } else {
            if(!is_null($request->query('status'))){
                $data = DB::table('clientes')
                        ->where('status',$request->query('status'))
                        ->join('users','users.id','=','clientes.agenciador_id')
                        ->select('users.name','users.avatar','clientes.*')
                        ->paginate(1);
            }else{
                $data = DB::table('clientes')
                ->join('users','users.id','=','clientes.agenciador_id')
                ->select('users.name','users.avatar','clientes.*')
                ->paginate(1);
            }

        }
        $total_row = $data->count();
        $output = "<tr>
                <th class=\"text-center pt-2\">
                    #
                </th>
                <th>Nome</th>
                <th>Profissão</th>
                <th>Agenciador</th>
                <th>Criado em</th>
                <th>Status</th>
            </tr>";
        if($total_row > 0){            
            foreach ($data as $cliente) {
                $dia = date("d", strtotime($cliente->created_at));
                $mes = date("M", strtotime($cliente->created_at));
                $ano = date("Y", strtotime($cliente->created_at));
                switch ($cliente->status) {
                    case 0:
                        $status = '<div class="badge badge-primary">Concluido</div>';
                        break;
                    case 1:
                        $status = '<div class="badge badge-danger">Rascunho</div>';
                        break;
                    case 2:
                        $status = '<div class="badge badge-warning">Pendente</div>';
                        break;
                    case 3:
                        $status = '<div class="badge badge-dark">Apagado</div>';
                        break;
                    default:
                        # code...
                        break;
                }
                $output .= "
                <tr>
                <td>{$cliente->id}</td>
                <td>{$cliente->nome} {$cliente->sobrenome}
                    <div class=\"table-links\">
                        <a href='#'>Ver</a>
                        <div class=\"bullet\"></div>
                        <a href='#'>Editar</a>
                        <div class=\"bullet\"></div>
                        <a href=\"#\" class=\"text-danger\">Apagar</a>
                    </div>
                </td>
                <td>{$cliente->profissao}</td>
                <td><img alt=\"image\" src=" . asset($cliente->avatar) . " class=\"rounded-circle\" width=\"35\" data-toggle=\"title\" title=\"\"> <div class=\"d-inline-block ml-1\">{$cliente->name}</div></td>
                <td>{$dia} de {$mes} de {$ano}</td>
                <td>{$status}</td>
                </tr>";
                
            }
        } else {
            $output .= "
                            <td>#</td>
                            <td>Nenhum cliente encontrado</td>
                        ";
        }
        }
        $links =  str_replace("cliente_nome","clientes","{$data->appends(request()->except('page'))->links()}");
        $data = array('table_data' => $output,'total'=>$total_row,'links'=>$links);
        
        echo json_encode($data);
    }
}