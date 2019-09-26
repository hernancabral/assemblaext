<?php

namespace App\Http\Controllers;

use App\CloneTicket;
use Illuminate\Http\Request;
use App\Space;
use GuzzleHttp\Exception\ClientException;

class CloneTicketController extends Controller
{

    public $spacesList;
    public $assemblaClient;

    public function __construct()
    {
        $this->assemblaClient = new \GuzzleHttp\Client(['headers' => ['X-Api-Key'=>env('X_API_KEY'), 
        'X-Api-Secret' => env('X_API_SECRET'), 'Content-Type' => 'application/json']]);
        $this->spacesList = $this->getSpaces();
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spaces = $this->spacesList;

        return view('cloneticket.index', compact('spaces'));
    }

    public function store(Request $request)
    {

        $client = $this->assemblaClient;
        $url = "https://api.assembla.com/v1/spaces/%s/tickets/";

        $validatedData = $request->validate([
            'nro' => 'required',
            'space_from' => 'required',
            "space_to" => 'required'
        ]);
        
        try {
            $request = $client->get(sprintf($url,$validatedData['space_from']) . $validatedData['nro']);
            $response = $request->getBody()->getContents();
            $body = '{"ticket":' . $response . '}';
            $contentsDecoded = json_decode($body, true);
            $contentsDecoded['ticket']['summary'] = 'prueba desde app';
            $body = json_encode($contentsDecoded);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == '404') {
                $message = ['type' => 'error', 'text' => 'No se encuentra ticket!'];
            } else {
                $message = ['type' => 'error', 'text' => 'Hubo un problema!'];
            }

            return redirect()->back()->with(['msg' => $message['type'],'txt' => $message['text']]);
        }

        try {
            $request = $client->request('POST', sprintf($url,$validatedData['space_to']), ['body' => $body]);
            if ($request->getStatusCode() == "201"){
                $message = ['type' => 'success', 'text' => 'Se clono el ticket!'];
            } else {
                $message = ['type' => 'error', 'text' => 'Hubo un problema!'];
            }
        } catch (ClientException $e) {

            if ($e->getResponse()->getStatusCode() == '404') {
                $message = ['type' => 'error', 'text' => 'No se encuentra space!'];
            } else {
                $message = ['type' => 'error', 'text' => 'Hubo un problema!'];
            }

        }

        return redirect()->back()->with(['msg' => $message['type'],'txt' => $message['text']]);

    }

    public function getSpaces(){
        $client = $this->assemblaClient;
        $url = env('ASSEMBLA_ROOT') . "/spaces";
        
        $request = $client->get($url);
        $response = $request->getBody()->getContents();
        $contentsDecoded = json_decode($response, true);
        $spaces = [];
        foreach ($contentsDecoded as $c){
            $spaces[$c['id']] = $c['name'];
        }
        return $spaces;
    }
}
