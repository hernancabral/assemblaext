<?php

namespace App\Http\Controllers;

use App\Prioritized;
use Illuminate\Http\Request;
use App\People;
use App\Ticket;
use App\Team;
use App\Brand;
use App\Milestone;
use GuzzleHttp\Exception\ClientException;

class PrioritizedController extends Controller
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
        $perPage = 20;
        $filtro = null;


        //Nombre de los filtros
        $opciones = ['Numero' => 'ticket_nro', 'Titulo' => 'ticket_title', 
        'Marca' => 'ticket_brand', 'Milestone' => 'ticket_milestone', 'Status' => 'ticket_status',
         'Equipo' => 'team', 'Estimado' => 'ticket_estimate', 
         'Estimado original' => 'ticket_original_estimate', 'Trabajado' => 'ticket_worked_hours'];

        //Aclarar las foreign keys, respetando los filtros arriba. No son obligatorias.
        //Nombre de filtro => en que campo de la table relacionada buscar, nombre de la relacion.
        $foreign = ['ticket_nro' => ['nro', 'ticket'], 'ticket_title' => ['title', 'ticket'], 
        'ticket_brand' => ['name', 'ticket.brand'], 'ticket_milestone' => ['name', 'ticket.milestone'],
        'ticket_status' => ['status', 'ticket'], 'team' => ['name', 'team'], 'ticket_estimate' => ['estimate', 'ticket'],
        'ticket_original_estimate' => ['original_estimate', 'ticket'], 'ticket_worked_hours' => ['worked_hours', 'ticket']];

        $peoples = People::all();
        $teams = Team::all();

        if (!empty( $request->except('_token'))) $filtro = $request->query();

        $prioritizeds = Prioritized::search($filtro, $foreign)
        ->orderBy('order','ASC')->get();
        return view('prioritized.index', compact('orderBy', 'sortBy', 'prioritizeds', 'opciones', 'peoples', 'teams'));
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
        
        $validatedData = $request->validate([
            'ticket_id' => 'required',
            'team_id' => 'exists:teams,id' 
        ]);

        Self::createOrUpdateTicket($validatedData, $request, false);
        return redirect()->back();
    }

    public function refresh(Request $request, Prioritized $prioritized){
        $planning_data = [
            'ticket_id' => $prioritized->ticket->nro,
            'team_id' => $prioritized->team->id,
        ];

        Self::createOrUpdateTicket($planning_data, $request, true);
        return redirect()->back();
    }

    public function refresh_all(Request $request){
        $priorities = Prioritized::all();
        foreach( $priorities as $priority){
            Self::refresh($request, $priority, true);
        }
        return redirect()->back();
    }

    public function createOrUpdateTicket($validatedData, $request, $refresh){
        $client = new \GuzzleHttp\Client(['headers' => ['X-Api-Key'=>env('X_API_KEY'), 
        'X-Api-Secret' => env('X_API_SECRET'), 'Content-Type' => 'application/json']]);
        $url = "https://api.assembla.com/v1/spaces/soft-liness-2/tickets/";
        
        try {
            $request = $client->get($url . $validatedData['ticket_id']);
            $response = $request->getBody()->getContents();
            $contentsDecoded = json_decode($response, true);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == '404') {
                $message = ['type' => 'error', 'text' => 'No se encuentra ticket!'];
            } else {
                $message = ['type' => 'error', 'text' => 'Hubo un problema!'];
            }

            return redirect()->back()->with(['msg' => $message['type'],'txt' => $message['text']]);
        }

        //Se crea Brand en caso de que no exista
        $brand = $contentsDecoded['custom_fields']['Marca'];
        if ($brand != ""){
            $brand = Brand::firstOrCreate(['name' => $brand], 
            ['name' => $brand, 'code' => '1']);
        }

        //Se crea Milestone en caso de que no exista
        $milestone = $contentsDecoded['milestone_id'];
        if ($milestone != ""){
            $milestone = Milestone::firstOrNew(['code' => $milestone]);
            if (!$milestone->exist){
                $milestone_request = $client->
                get("https://api.assembla.com/v1/spaces/" . $contentsDecoded['space_id'] ."/milestones/" . $contentsDecoded['milestone_id']);
                $milestone_response = $milestone_request->getBody()->getContents();
                $milestone_decoded = json_decode($milestone_response, true);            
                $milestone->code = $milestone_decoded['id'];
                $milestone->name = $milestone_decoded['title'];
                $milestone->monitor = '0';
                $milestone->save();
            }
        }

        //Se crea People en caso de que no exista
        $people = $contentsDecoded['assigned_to_id'];
        if ($people != ""){
            $people = People::firstOrNew(['code' => $people]);
            if (!$people->exist){
                $people_request = $client->
                get("https://api.assembla.com/v1/users/" . $contentsDecoded['assigned_to_id']);
                $people_response = $people_request->getBody()->getContents();
                $people_decoded = json_decode($people_response, true);            
                $people->code = $people_decoded['id'];
                $people->name = $people_decoded['name'];
                $people->email = $people_decoded['email'];
                $people->username = $people_decoded['login'];
                $people->picture = $people_decoded['picture'];
                $people->save();
            }
        }

        //Se crea Tester en caso de que no exista
        $tester = $contentsDecoded['assigned_to_id'];
        if ($tester != ""){
            $tester = People::firstOrNew(['code' => $tester]);
            if (!$tester->exist){
                $tester_request = $client->
                get("https://api.assembla.com/v1/users/" . $contentsDecoded['assigned_to_id']);
                $tester_response = $tester_request->getBody()->getContents();
                $tester_decoded = json_decode($tester_response, true);            
                $tester->code = $tester_decoded['id'];
                $tester->name = $tester_decoded['name'];
                $tester->email = $tester_decoded['email'];
                $tester->username = $tester_decoded['login'];
                $tester->picture = $tester_decoded['picture'];
                $tester->save();
            }
        }

        //Se asignan datos para creacion/actualizacion
        $data = [
            'nro' => $contentsDecoded['number'],
            'space_id' => $contentsDecoded['space_id'],
            'title' => $contentsDecoded['summary'],
            'code' => $contentsDecoded['id'],
            'milestone_id' => isset($milestone->id) ? $milestone->id : null,
            'assigned_id' => isset($people->id) ? $people->id : null,
            'tester_id' => isset($tester->id) ? $tester->id : null,
            'status' => $contentsDecoded['status'],
            'work_remaining' => $contentsDecoded['number'] != "" ? $contentsDecoded['number'] : null,
            'worked_hours' => $contentsDecoded['total_invested_hours'] != "" ? $contentsDecoded['total_invested_hours'] : null,
            'estimate' => $contentsDecoded['estimate'] != "" ? $contentsDecoded['estimate'] : null,
            'original_estimate' =>$contentsDecoded['custom_fields']['Estimate original'] != "" ? $contentsDecoded['custom_fields']['Estimate original'] : null,
            'brand_id' => isset($brand->id) ? $brand->id : null,
            'production_date' => $contentsDecoded['custom_fields']['Fecha Produccion'],
        ];

        //Se crea ticket en caso de que sea necesario y prioridad
        if (Prioritized::whereHas('ticket', function ($query) use ($validatedData)
        {$query->where('nro', $validatedData['ticket_id']);})->first() == null || $refresh){
            $new_ticket = Ticket::updateOrCreate(['nro' => $contentsDecoded['number']], $data);
            Prioritized::updateOrCreate(
                ['ticket_id' => $new_ticket['id']],
                ['ticket_id' => $new_ticket['id'],
                'people_id' => $new_ticket['assigned_id'],
                'team_id' => $validatedData['team_id']]);
            $refresh ? $txt = 'Se actualizo correctamente!' :  $txt = 'Prioridad Creada';
            $message = ['type' => 'success', 'text' => $txt];
        }else{
            $message = ['type' => 'error', 'text' => 'La prioridad ya existe'];
        }
        return redirect()->back()->with(['msg' => $message['type'],'txt' => $message['text']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prioritized  $prioritized
     * @return \Illuminate\Http\Response
     */
    public function show(Prioritized $prioritized)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prioritized  $prioritized
     * @return \Illuminate\Http\Response
     */
    public function edit(Prioritized $prioritized)
    {
        $prioritized = Prioritized::findOrFail($prioritized->id);
        $peoples = People::all();

        return view('prioritized.edit', compact('prioritized', 'peoples'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prioritized  $prioritized
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prioritized $prioritized)
    {
        $validatedData = $request->validate([
            'ticket_id' => 'exists:tickets,nro',
            'people_id' => 'exists:people,id',
            'order' => '',
        ]);

        $validatedData['ticket_id'] = Ticket::where('nro', $validatedData['ticket_id'])->first()['id'];
        Prioritized::whereId($prioritized->id)->update($validatedData);

        return redirect('/prioritized')->with(['msg' => 'success','txt' => 'Se actualizo correctamente']);
    }

    public function updateOrder(Request $request)
    {
        $priorities = Prioritized::all();

        foreach ($priorities as $priority) {
            $priority->timestamps = false; // To disable update_at field updation
            $id = $priority->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $priority->update(['order' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prioritized  $prioritized
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prioritized $prioritized)
    {
        $prioritized->delete();

        return redirect('/prioritized')->with(['msg' => 'success','txt' => 'Se borro correctamente']);
    }
}
