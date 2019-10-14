<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Enderecos;
use App\Models\Documentos;
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
                            <a href=\"". route('painel.clientes.ver',$cliente->id) ."\">Ver</a>
                            <div class=\"bullet\"></div>
                            <a href=\"". route('painel.clientes.edit',$cliente->id) ."\">Editar</a>
                            <div class=\"bullet\"></div>
                            <a href=\"javascript:void(0);\" class=\"text-danger\" onclick=\"document.getElementById('form').submit();\" >                            
                            delete
                            </a>
                            <form action=\"". route('painel.clientes.destroy',$cliente->id) ."\" id=\"form\" method=\"post\">
                                " . csrf_field() . "
                                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                            </form>                            
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
        $documento = new Documentos();
        $endereco = new Enderecos();
        if(auth()->user()->can('create-cliente'))
        {
            $request->validate([
            //     'name' => 'required|min:3|max:255',                
                'email' => 'required|email|unique:clientes',
            //     // 'perfil'=>'image|mimes:jpg|max:2048',            
            ]);            
            $cliente->chave_acesso = 0;
            $cliente->agenciador_id=auth()->user()->id;
            $cliente->nome=$request->name;
            $cliente->sobrenome=$request->sobrenome;
            $cliente->email=$request->email;
            $cliente->profissao=$request->profissao;
            $cliente->genero=$request->genero;
            $cliente->estado_civil=$request->estado_civil;
            $cliente->telefone1=$request->telefone1;
            $cliente->telefone2=$request->telefone2;
            $cliente->status=$request->status;
            $cliente->save();
            $cliente->chave_acesso = crypt($cliente->id,'SGPA');
            if($request->perfil){
                try {
                    $namePerfil = "perfil." . request()->perfil->getClientOriginalExtension();
                    $caminhoPerfil = 'assets/img/clientes/'. $cliente->id . '/';
                    $cliente->foto_path = $caminhoPerfil . $namePerfil;
                    request()->perfil->move(public_path($caminhoPerfil),$namePerfil);
                } catch (\Throwable $th) {
                    // return back()->with('falha','A falha foi' . $th->getMessage());
                }
                
            }
            $cliente->save();
            // Documentos
            $documento->cliente_id = $cliente->id;
            $documento->rg=$request->rg;
            if($request->foto_rg){
                try {
                    $nameRg = "rg" . $documento->rg . '.' . request()->foto_rg->getClientOriginalExtension();
                    $caminhoRg = 'assets/img/clientes/'. $cliente->id . '/';
                    $documento->rg_path = $caminhoRg . $nameRg;
                    request()->foto_rg->move(public_path($caminhoRg),$nameRg);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
            }
            $documento->orgao=$request->orgao;
            $documento->cpf=$request->cpf;
            if($request->foto_cpf){
                try {
                    $nameCpf = "cpf" . $documento->cpf . '.' . request()->foto_cpf->getClientOriginalExtension();
                    $caminhoCpf = 'assets/img/clientes/'. $cliente->id . '/';
                    $documento->cpf_path = $caminhoCpf . $nameCpf;
                    request()->foto_cpf->move(public_path($caminhoCpf),$nameCpf);
                } catch (\Throwable $th) {
                    //throw $th;
                }                
            }
            // Endereço
            $endereco->cliente_id = $cliente->id;
            $endereco->bairro=$request->bairro;
            $endereco->cidade=$request->cidade;
            $endereco->estado=$request->estado;                                                
            $endereco->rua=$request->rua;
            $endereco->pais=$request->pais;
            $endereco->numero=$request->numero;
            $endereco->complemento=$request->complemento;
            $endereco->cep=$request->cep;                        
                 
            $documento->save();
            $endereco->save();

            return back()->with('success','Cliente criado com sucesso');
        } else {
            return back()->with('falha','Você não tem permissão para criar novo cliente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clientes  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $cliente)
    {
        $documento = Documentos::where('cliente_id',$cliente->id)->first();
        $endereco = Enderecos::where('cliente_id',$cliente->id)->first();
        return view('admin.clientes.ver')->with(['cliente'=>$cliente,'documento'=>$documento,'endereco'=>$endereco]);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $cliente)
    {
        $documento = Documentos::where('cliente_id',$cliente->id)->first();
        $endereco = Enderecos::where('cliente_id',$cliente->id)->first();
        return view('admin.clientes.editar')->with(['cliente'=>$cliente,'documento'=>$documento,'endereco'=>$endereco]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Clientes::find($id);
        $documento = Documentos::where('cliente_id',$id)->first();
        $endereco = Enderecos::where('cliente_id',$id)->first();
        if(auth()->user()->can('update-cliente'))
        {
            $request->validate([
            //     'name' => 'required|min:3|max:255',                
                'email' => 'required|email|unique:clientes,email,'.$id,
            //     // 'perfil'=>'image|mimes:jpg|max:2048',            
            ]);            
            $cliente->chave_acesso = 0;
            $cliente->agenciador_id=auth()->user()->id;
            $cliente->nome=$request->name;
            $cliente->sobrenome=$request->sobrenome;
            $cliente->email=$request->email;
            $cliente->profissao=$request->profissao;
            $cliente->genero=$request->genero;
            $cliente->estado_civil=$request->estado_civil;
            $cliente->telefone1=$request->telefone1;
            $cliente->telefone2=$request->telefone2;
            $cliente->status=$request->status;
            $cliente->save();
            $cliente->chave_acesso = crypt($cliente->id,'SGPA');
            if($request->perfil){
                try {
                    $namePerfil = "perfil." . request()->perfil->getClientOriginalExtension();
                    $caminhoPerfil = 'assets/img/clientes/'. $cliente->id . '/';
                    $cliente->foto_path = $caminhoPerfil . $namePerfil;
                    request()->perfil->move(public_path($caminhoPerfil),$namePerfil);
                } catch (\Throwable $th) {
                    // return back()->with('falha','A falha foi' . $th->getMessage());
                }
                
            }
            $cliente->save();
            // Documentos
            $documento->cliente_id = $cliente->id;
            $documento->rg=$request->rg;
            if($request->foto_rg){
                try {
                    $nameRg = "rg" . $documento->rg . '.' . request()->foto_rg->getClientOriginalExtension();
                    $caminhoRg = 'assets/img/clientes/'. $cliente->id . '/';
                    $documento->rg_path = $caminhoRg . $nameRg;
                    request()->foto_rg->move(public_path($caminhoRg),$nameRg);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
            }
            $documento->orgao=$request->orgao;
            $documento->cpf=$request->cpf;
            if($request->foto_cpf){
                try {
                    $nameCpf = "cpf" . $documento->cpf . '.' . request()->foto_cpf->getClientOriginalExtension();
                    $caminhoCpf = 'assets/img/clientes/'. $cliente->id . '/';
                    $documento->cpf_path = $caminhoCpf . $nameCpf;
                    request()->foto_cpf->move(public_path($caminhoCpf),$nameCpf);
                } catch (\Throwable $th) {
                    //throw $th;
                }                
            }
            // Endereço
            $endereco->cliente_id = $cliente->id;
            $endereco->bairro=$request->bairro;
            $endereco->cidade=$request->cidade;
            $endereco->estado=$request->estado;                                                
            $endereco->rua=$request->rua;
            $endereco->pais=$request->pais;
            $endereco->numero=$request->numero;
            $endereco->complemento=$request->complemento;
            $endereco->cep=$request->cep;                        
                 
            $documento->save();
            $endereco->save();

            return back()->with('success','Cliente atualizado com sucesso');
        } else {
            return back()->with('falha','Você não tem permissão para editar cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Clientes::destroy($id);        
        return redirect()->back();
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