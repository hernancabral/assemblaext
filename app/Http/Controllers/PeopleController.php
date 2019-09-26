<?php

namespace App\Http\Controllers;

use App\People;
use App\Team;
use Illuminate\Http\Request;

class PeopleController extends Controller
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

        $opciones = ['Nombre' => 'name', 'User' => 'username', 'Mail' => 'email',
        'Equipo' => 'team'];

        //Aclarar las foreign keys, respetando los filtros arriba. No son obligatorias.
        //Nombre de filtro => en que campo de la table relacionada buscar, nombre de la relacion.
        $foreign = ['team' => ['name', 'team']];
    
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

        $peoples = People::search($filtro, $foreign)
        ->orderBy($sortBy, $orderBy)->paginate($perPage);
        return view('people.index', compact('orderBy', 'sortBy', 'perPage', 'peoples', 'opciones'));
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
     * @param  \App\People  $people
     * @return \Illuminate\Http\Response
     */
    public function show(People $people)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\People  $people
     * @return \Illuminate\Http\Response
     */
    public function edit(People $person)
    {
        $people = People::findOrFail($person->id);
        $teams = Team::all();

        return view('people.edit', compact('people', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\People  $people
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, People $person)
    {
        $validatedData = $request->validate([
            'team_id' => 'exists:teams,id',
        ]);

        People::whereId($person->id)->update($validatedData);

        return redirect('/people')->with(['msg' => 'success','txt' => 'Se actualizo correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\People  $people
     * @return \Illuminate\Http\Response
     */
    public function destroy(People $people)
    {
        //
    }
}
