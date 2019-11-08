<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Processos;
use App\Models\CidCategoria;
use Illuminate\Http\Request;
use App\Models\CidSubcategoria;
use Illuminate\Support\Facades\DB;

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
    public function create()
    {
        $usuarios =  DB::table('users')
        ->join('model_has_roles','model_has_roles.model_id','=','users.id')
        // ->where('users.id','=','model_has_roles.model_id')
        ->where('model_has_roles.role_id','=',1)
        ->get();;
        $cid_categoria = CidCategoria::all();
        $cid_subcategoria = CidSubcategoria::all();

        return view('admin.processos.criar')->with(['usuarios'=>$usuarios,'cid'=>$cid_categoria,'cidsub'=>$cid_subcategoria]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
