<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\People;
use Illuminate\Http\Request;

class TicketController extends Controller
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

        $opciones = ['Numero' => 'nro', 'Titulo' => 'title'];


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

        $tickets = Ticket::search($filtro)->orderBy($sortBy, $orderBy)->paginate($perPage);
        return view('ticket.index', compact('orderBy', 'sortBy', 'perPage', 'tickets', 'opciones'));
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
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticket = Ticket::findOrFail($ticket->id);
        $peoples = People::all();

        return view('ticket.show', compact('ticket', 'peoples'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
