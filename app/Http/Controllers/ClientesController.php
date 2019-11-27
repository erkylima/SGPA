<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Enderecos;
use App\Models\Processos;
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
                    ->where('status',$request->query('status'))
                    ->paginate(15);
        }else{
            $clientes = DB::table('clientes')
                        ->paginate(15);
        }
        $output = '';
        if($request->ajax()){
            $query = $request->get('query');        
            if($query != ''){            
                if(!is_null($request->query('status'))){
                    $data = DB::table('clientes')
                    ->where('status',$request->query('status'))
                    ->where('nome','like','%'.$query.'%')
                    ->orWhere('profissao','like','%'.$query.'%')
                    ->orWhere('cpf','like','%'.$query.'%')
                    ->orderBy('nome','asc')
                    ->paginate(15);
                }else{
                    $data = DB::table('clientes')
                    ->where('nome','like','%'.$query.'%')
                    ->orWhere('profissao','like','%'.$query.'%')
                    ->orWhere('cpf','like','%'.$query.'%')
                    ->orderBy('nome','asc')
                    ->paginate(15);
                }
                
            } else {            
                if(!is_null($request->query('status'))){
                    $data = DB::table('clientes')
                            ->where('status',$request->query('status'))
                            ->paginate(15);
                }else{
                    $data = DB::table('clientes')
                    ->select('clientes.*')
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
                    <td>{$cliente->nome}
                        <div class=\"table-links\">
                            <a href=\"". route('painel.clientes.ver',$cliente->id) ."\">Ver</a>
                            <div class=\"bullet\"></div>
                            <a href=\"". route('painel.clientes.edit',$cliente->id) ."\">Editar</a>
                            <div class=\"bullet\"></div>
                            <a href=\"javascript:void(0);\" class=\"text-danger\" onclick=\"document.getElementById('form').submit();\" >                            
                            Apagar
                            </a>
                            <form action=\"". route('painel.clientes.destroy',$cliente->id) ."\" id=\"form\" method=\"post\">
                                " . csrf_field() . "
                                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                            </form>                            
                        </div>
                    </td>
                    <td>{$cliente->profissao}</td>
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
        $endereco = new Enderecos();
        if(auth()->user()->can('create-cliente'))
        {            
            $request->validate([
                // 'name' => 'required|min:3|max:255',                
                'cpf' => 'unique:clientes',
                // 'perfil'=>'image|mimes:jpg|max:2048',            
            ]);

            if($request->whats1 == 'on'){
                $request->whats1 = 1;
            }else{
                $request->whats1 = 0;
            }

            if($request->whats2 == 'on'){
                $request->whats2 = 1;
            }else{
                $request->whats2 = 0;
            }

            if($request->incapaz == 'on'){
                $request->incapaz = 1;
            }else{
                $request->incapaz = 0;
            }

            $cliente->chave_acesso = 0;
            $cliente->nome=$request->name;
            $cliente->apelido=$request->apelido;
            $cliente->nome_mae=$request->nome_mae;
            $cliente->email=$request->email;
            $cliente->profissao=$request->profissao;
            $cliente->estado_civil=$request->estado_civil;
            $cliente->telefone1=$request->telefone1;
            $cliente->telefone2=$request->telefone2;
            $cliente->whatstelefone1=$request->whats1;
            $cliente->whatstelefone2=$request->whats2;
            $cliente->rg=$request->rg;
            $cliente->orgao=$request->orgao;
            $cliente->cpf=$request->cpf;
            $cliente->nascimento = $request->nascimento;
            $cliente->incapaz = $request->incapaz;
            $cliente->status=$request->status;
            $cliente->nomeresp=$request->nomeresp;
            $cliente->rgresp=$request->rgresp;
            $cliente->orgaoresp=$request->orgaoresp;
            $cliente->cpfresp=$request->cpfresp;
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
            // Endereço
            $endereco->cliente_id = $cliente->id;
            $endereco->bairro=$request->bairro;
            $endereco->cidade=$request->cidade;
            $endereco->estado=$request->estado;
            $endereco->rua=$request->rua;
            $endereco->numero=$request->numero;
            $endereco->complemento=$request->complemento;
            $endereco->cep=$request->cep;

            $endereco->save();


            return redirect()->route('painel.processos.novo', ['cliente_id'=>$cliente->id]);
            // return back()->with('success','Cliente criado com sucesso');
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
        $endereco = Enderecos::where('cliente_id',$cliente->id)->first();
        $processos = Processos::all()->where('id_resp');
        return view('admin.clientes.ver')->with(['cliente'=>$cliente,'endereco'=>$endereco,'processos'=>$processos]);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $cliente)
    {
        $endereco = Enderecos::where('cliente_id',$cliente->id)->first();
        return view('admin.clientes.editar')->with(['cliente'=>$cliente,'endereco'=>$endereco]);
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
        $endereco = Enderecos::where('cliente_id',$id)->first();
        if(auth()->user()->can('update-cliente'))
        {
            $request->validate([
            //     'name' => 'required|min:3|max:255',                
                'email' => 'required|email|unique:clientes,email,'.$id,
            //     // 'perfil'=>'image|mimes:jpg|max:2048',            
            ]);            
            if($request->whats1 == 'on'){
                $request->whats1 = 1;
            }else{
                $request->whats1 = 0;
            }
            if($request->whats2 == 'on'){
                $request->whats2 = 1;
            }else{
                $request->whats2 = 0;
            }
            if($request->incapaz == 'on'){
                $request->incapaz = 1;
            }else{
                $request->incapaz = 0;
            }
            $cliente->nome=$request->name;
            $cliente->sobrenome=$request->sobrenome;
            $cliente->apelido=$request->apelido;
            $cliente->nome_mae=$request->nome_mae;
            $cliente->email=$request->email;
            $cliente->profissao=$request->profissao;
            $cliente->genero=$request->genero;
            $cliente->estado_civil=$request->estado_civil;
            $cliente->telefone1=$request->telefone1;
            $cliente->telefone2=$request->telefone2;
            $cliente->whatstelefone1=$request->whats1;
            $cliente->whatstelefone2=$request->whats2;
            $cliente->rg=$request->rg;
            $cliente->orgao=$request->orgao;
            $cliente->cpf=$request->cpf;
            $cliente->nascimento = $request->nascimento;
            $cliente->incapaz = $request->incapaz;
            $cliente->status=$request->status;
            $cliente->nomeresp=$request->nomeresp;
            $cliente->rgresp=$request->rgresp;
            $cliente->orgaoresp=$request->orgaoresp;
            $cliente->cpfresp=$request->cpfresp;
            $cliente->save();
            // if($request->perfil){
            //     try {
            //         $namePerfil = "perfil." . request()->perfil->getClientOriginalExtension();
            //         $caminhoPerfil = 'assets/img/clientes/'. $cliente->id . '/';
            //         $cliente->foto_path = $caminhoPerfil . $namePerfil;
            //         request()->perfil->move(public_path($caminhoPerfil),$namePerfil);
            //     } catch (\Throwable $th) {
            //         // return back()->with('falha','A falha foi' . $th->getMessage());
            //     }
                
            // }
            $cliente->save();
            
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
       
}