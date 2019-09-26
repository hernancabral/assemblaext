<?php

namespace App\Http\Controllers;

use App\Planning;
use App\Tag;
use App\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class PlanningController extends Controller
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

        $opciones = ['Nombre' => 'name', 'Tag' => 'tag', 'State' => 'state',
        'Desde' => 'date_from', 'Hasta' => 'date_to', 'Equipo' => 'team',
        'Horas disponibles' => 'available_hours'];

        $foreign = ['tag' => ['name','tag'],'team' => ['name', 'team']];
    
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

        $plannings = Planning::search($filtro, $foreign)
        ->orderBy($sortBy, $orderBy)->paginate($perPage);
        return view('planning.index', compact('orderBy', 'sortBy', 'perPage', 'plannings', 'opciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $teams = Team::all();

        return view('planning.create', compact('tags', 'teams'));     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request['date_from'] = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $request['date_to'] = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

        $validatedData = $request->validate([
            'name' => 'nullable|unique:plannings,name,',
            'tag_id' => 'exists:tags,id',
            'team_id' => 'exists:teams,id',
            'state' => 'required',
            'date_from' => 'date_format:Y-m-d',
            'date_to' => 'date_format:Y-m-d|after_or_equal:date_from',
            'available_hours' => 'integer'

        ]);


        Planning::create($validatedData);

        return redirect('/planning')->with(['msg' => 'success','txt' => 'Se guardo el Planning!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function show(Planning $planning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function edit(Planning $planning)
    {

        $planning = Planning::findOrFail($planning->id);
        if ($planning->date_from < Carbon::today()->toDateString()) {
            return redirect('/planning')->with(['msg' => 'error','txt' => 'Ya paso la fecha en que es posible editarlo']);
        }
        $tags = Tag::all();
        $teams = Team::all();

        return view('planning.edit', compact('planning', 'tags', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planning $planning)
    {

        $request['date_from'] = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $request['date_to'] = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

        $validatedData = $request->validate([
            'name' => 'nullable|unique:plannings,name,' . $planning->id,
            'tag_id' => 'exists:tags,id',
            'team_id' => 'exists:teams,id',
            'state' => 'required',
            'date_from' => 'date_format:Y-m-d',
            'date_to' => 'date_format:Y-m-d|after_or_equal:date_from',
            'available_hours' => 'integer'

        ]);

        Planning::whereId($planning->id)->update($validatedData);

        return redirect('/planning')->with(['msg' => 'success','txt' => 'Se actualizo correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planning $planning)
    {
        $planning = Planning::findOrFail($planning->id);
        if ($planning->date_from < Carbon::today()->toDateString()) {
            return redirect('/planning')->with(['msg' => 'error','txt' => 'Ya paso la fecha en que es posible borrarlo']);
        }
        $planning->delete();

        return redirect('/planning')->with(['msg' => 'success','txt' => 'Se borro correctamente']);
    }
}
