<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Processos;
use App\Models\CidCategoria;
use Illuminate\Http\Request;
use App\Models\CidSubcategoria;
use App\Models\ProcessoJudicial;
use Illuminate\Support\Facades\DB;
use App\Models\ProcessoAposentadoria;
use App\Models\ProcessoAuxilioDoenca;
use App\Models\ProcessoAdministrativo;
use App\Models\ProcessoAuxilioAcidente;
use App\Models\ProcessoBpcloasDeficiente;
use App\Models\ProcessoSalarioMaternidade;

class ProcessosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $usuarios =  DB::table('users')
        ->join('model_has_roles','model_has_roles.model_id','=','users.id')
        // ->where('users.id','=','model_has_roles.model_id')
        ->where('model_has_roles.role_id','=',1)
        ->get();;
        $cid_categoria = CidCategoria::all();
        $cid_subcategoria = CidSubcategoria::all();
        $output = '';
        $output2 = '';

        if($request->ajax()){
            $query = $request->get('query');        
            if($query != ''){
                $data = DB::table('cid_categoria')
                ->where('cod','like','%'.$query.'%')
                ->orWhere('descricao','like','%'.$query.'%')
                ->get();
            } else {                                                
                $data = DB::table('cid_categoria')
                ->get();                            
            }
            $total_row = $data->count();
            $output = ``;
            if($total_row > 0){            
                foreach ($data as $cid_cat) {                                        
                    $output .= "
                    <option value='{$cid_cat->id}'>{$cid_cat->cod} - {$cid_cat->descricao}</option>";                    
                }
            } else {
                $output .= "
                                <option>CID não encontrado</td>
                            ";
            }   
            
            $subquery = $request->get('subquery');        
            if($subquery != ''){
                $data2 = DB::table('cid_subcategoria')
                ->where('cod','like','%'.$subquery.'%')
                ->orWhere('descricao','like','%'.$subquery.'%')
                ->get();
            } else {                                                
                $data2 = DB::table('cid_subcategoria')
                ->get();                            
            }
            $total_row2 = $data2->count();
            $output2 = ``;
            if($total_row2 > 0){            
                foreach ($data2 as $subcid_cat) {                                        
                    $output2 .= "
                    <option value='{$subcid_cat->id}'>{$subcid_cat->cod} - {$subcid_cat->descricao}</option>";                    
                }
            } else {
                $output2 .= "
                                <option>CID não encontrado</td>
                            ";
            }            
            
            
            $data = array('options' => $output,'options2'=>$output2);

            return response()->json($data);  

        }
        

        return view('admin.processos.criar')->with(['cliente_id'=>$request->cliente_id,'usuarios'=>$usuarios,'cid'=>$cid_categoria,'cidsub'=>$cid_subcategoria]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $processo = new Processos();
        $processo->numero_processo = $request->numero_processo;
        $processo->responsavel = $request->responsavel;
        $processo->tipo = $request->tipo_processo;
        $processo->subtipo = $request->subtipo_processo;
        $processo->categoria = $request->categoria;
        $processo->status = 1;
        $processo->valor_cadastro = 1000;
        $processo->valor_responsavel = 100;
        $processo->save();

        switch ($request->categoria) {
            case '1':
                $administrativo = new ProcessoAdministrativo();                
                $administrativo->datarequerimento = $request->der;
                $administrativo->processo_id = $processo->id;

                switch ($request->tipo_processo) {
                    case '1':                
                        $administrativo->endereco = $request->localpericia;
                        $administrativo->datapericia = $request->datapericia;

                        $auxilio_doenca = new ProcessoAuxilioDoenca();
                        $auxilio_doenca->cid = $request->cid;
                        $auxilio_doenca->subcid = $request->subcid;
                        $auxilio_doenca->subtipo = $request->subtipo_processo;
                        $auxilio_doenca->processo_id = $processo->id;
                        $auxilio_doenca->save();
                        break;
                    case '2':
                        $administrativo->endereco = $request->localpericia;
                        $administrativo->datapericia = $request->datapericia;

                        $bpcloasdeficiente = new ProcessoBpcloasDeficiente();
                        $bpcloasdeficiente->cid = $request->cid;
                        $bpcloasdeficiente->subcid = $request->subcid;
                        $bpcloasdeficiente->subtipo = $request->subtipo_processo;
                        $bpcloasdeficiente->processo_id = $processo->id;
                        $bpcloasdeficiente->save();
                        break;
                    case '3':
                        $aposentadoria = new ProcessoAposentadoria();
                        $aposentadoria->processo_id = $processo->id;
                        $aposentadoria->subtipo = $request->subtipo_processo;

                        if($request->subtipo_processo == 1){
                            $administrativo->endereco = $request->localpericia;
                            $administrativo->datapericia = $request->datapericia;
    
                            $aposentadoria->cid = $request->cid;
                            $aposentadoria->subcid = $request->subcid;
                        }
                        $aposentadoria->save();
                    case '5':
                        $salariomaternidade = new ProcessoSalarioMaternidade();
                        $salariomaternidade->processo_id = $processo->id;
                        $salariomaternidade->nome_crianca = $request->nome_crianca;
                        $salariomaternidade->data_parto = $request->data_parto;
                        $salariomaternidade->save();
                        break;
                    case '7':                        
                        $auxilio_doenca = new ProcessoAuxilioAcidente();
                        $auxilio_doenca->cid = $request->cid;
                        $auxilio_doenca->subcid = $request->subcid;

                        $auxilio_doenca->processo_id = $processo->id;
                        $auxilio_doenca->save();
                    default:
                        # code...
                        break;
                }
                $administrativo->save();
                break;
            case '2':
                $judicial = new ProcessoJudicial();
                $judicial->processo_id = $processo->id;
                $judicial->numero_beneficio = $request->numerobeneficio;
                $judicial->der = $request->der;
                $judicial->valor_causa = 2000;
                switch ($request->tipo_processo) {
                    case '1':                                        
                        $auxilio_doenca = new ProcessoAuxilioDoenca();
                        $auxilio_doenca->cid = $request->cid;
                        $auxilio_doenca->subcid = $request->subcid;
                        $auxilio_doenca->subtipo = $request->subtipo_processo;
                        $auxilio_doenca->processo_id = $processo->id;
                        $auxilio_doenca->save();
                        break;
                    case '2':                        
                        $bpcloasdeficiente = new ProcessoBpcloasDeficiente();
                        $bpcloasdeficiente->cid = $request->cid;
                        $bpcloasdeficiente->subcid = $request->subcid;
                        $bpcloasdeficiente->subtipo = $request->subtipo_processo;
                        $bpcloasdeficiente->processo_id = $processo->id;
                        $bpcloasdeficiente->save();
                        break;
                    case '3':
                        $aposentadoria = new ProcessoAposentadoria();
                        $aposentadoria->processo_id = $processo->id;
                        $aposentadoria->subtipo = $request->subtipo_processo;

                        if($request->subtipo_processo == 1){
                            $administrativo->endereco = $request->localpericia;
                            $administrativo->datapericia = $request->datapericia;
    
                            $aposentadoria->cid = $request->cid;
                            $aposentadoria->subcid = $request->subcid;
                        }
                        $aposentadoria->save();
                    case '5':
                        $salariomaternidade = new ProcessoSalarioMaternidade();
                        $salariomaternidade->processo_id = $processo->id;
                        $salariomaternidade->nome_crianca = $request->nome_crianca;
                        $salariomaternidade->data_parto = $request->data_parto;
                        $salariomaternidade->save();
                        break;
                    case '7':                        
                        $auxilio_doenca = new ProcessoAuxilioAcidente();
                        $auxilio_doenca->cid = $request->cid;
                        $auxilio_doenca->subcid = $request->subcid;

                        $auxilio_doenca->processo_id = $processo->id;
                        $auxilio_doenca->save();
                    default:
                        # code...
                        break;
                }
                $judicial->save();
                break;                        
            default:
                # code...
                break;
        }

        
        
        return redirect()->route('painel.clientes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Processos  $processos
     * @return \Illuminate\Http\Response
     */
    public function show(Processos $processos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Processos  $processos
     * @return \Illuminate\Http\Response
     */
    public function edit(Processos $processos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Processos  $processos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Processos $processos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Processos  $processos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Processos $processos)
    {
        //
    }
}
