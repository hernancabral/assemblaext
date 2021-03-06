<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Milestone;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = 'id';
        $orderBy = 'desc';
        $filtro = null;

        $opciones = ['Nombre' => 'name'];
        $combo = ['Activo'=> "1", 'No Activo'=> "0"];
    
        if ($request->has('orderBy')) $orderBy = $request->query('orderBy');
        if ($request->has('sortBy')) $sortBy = $request->query('sortBy');
        if ($request->has('perPage')){
            $request->session()->put('perPage', $request->only('perPage'));
            $perPage = session('perPage')['perPage'];
        } else if (null != (session('perPage'))) {
            $perPage = session('perPage')['perPage'];
        } else{
            $perPage = 20;
        }
        if (!empty( $request->except('_token'))) $filtro = $request->query();

        $milestones = Milestone::search($filtro)
        ->orderBy($sortBy, $orderBy)->paginate($perPage);
        return view('milestone.index', compact('orderBy', 'sortBy', 'perPage', 'milestones', 'opciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $milestone = Milestone::findOrFail($id);

        return view('milestone.edit', compact('milestone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $monitor = Milestone::find($id);
        $monitor->monitor = $request->monitor;
        //$request->update(request(['monitor']))
        if ($monitor->save()) {
            return redirect('/milestone')->with(['msg' => 'success','txt' => 'Se actualizo correctamente']);
        }
        else {
            return redirect('/milestone')->with(['msg' => 'danger','txt' => 'Hubo un error']);
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
