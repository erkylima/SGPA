<?php

namespace App\Http\Controllers;

use App\Models\Processos;
use Illuminate\Http\Request;

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
        return view('admin.processos.criar');
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
