<?php

namespace App\Http\Controllers;

use App\Team;
use App\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
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

        $opciones = ['Nombre' => 'name', 'Lider' => 'leader'];

        //Aclarar las foreign keys, respetando los filtros arriba. No son obligatorias.
        //Nombre de filtro => en que campo de la table relacionada buscar, nombre de la relacion.
        $foreign = ['leader' => ['name', 'leader']];
                    
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
    
        
        $teams = Team::search($filtro, $foreign)->orderBy($sortBy, $orderBy)->paginate($perPage);
        return view('team.index', compact('orderBy', 'sortBy', 'perPage', 'teams', 'opciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $peoples = People::all();
        return view('team.create', compact('peoples')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:teams,name,',
            'leader_id' => 'required|exists:people,id',
        ]);

        Team::create($validatedData);

        return redirect('/team')
        ->with(['msg' => 'success','txt' => 'Se guardo el Equipo!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        // Poner los integrantes?
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $team = Team::findOrFail($team->id);
        $peoples = People::all();

        return view('team.edit', compact('team', 'peoples'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $validatedData = $request->validate([
            'name' => 'unique:teams,name,' . $team->id,
            'leader_id' => 'exists:people,id',
        ]);

        Team::whereId($team->id)->update(array_filter($validatedData));

        return redirect('/team')
        ->with(['msg' => 'success','txt' => 'Se actualizo correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team = Team::findOrFail($team->id);
        DB::table('people')->where('team_id', $team->id)->update(['team_id' => null]);
        $team->delete();

        return redirect('/team')
        ->with(['msg' => 'success','txt' => 'Se borro correctamente']);
    }
}
