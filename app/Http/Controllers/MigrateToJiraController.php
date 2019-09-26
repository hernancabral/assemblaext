<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class MigrateToJiraController extends Controller
{
    public $spacesList;

    public function __construct()
    {
        $this->assemblaClient = new \GuzzleHttp\Client(['headers' => ['X-Api-Key'=>env('X_API_KEY'), 
        'X-Api-Secret' => env('X_API_SECRET'), 'Content-Type' => 'application/json']]);
        $this->jiraClient = new \GuzzleHttp\Client(['headers' => ['Authorization'=>env('JIRA_HEADER_AUTHORIZATION'), 
        'Accept' => 'application/json', 'Content-Type' => 'application/json']]);
        $this->spacesList = $this->getSpaces();
        $this->commentsErrors = 0;
        $this->ticketsErrors = 0;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spaces = $this->spacesList;
        return view('migratetojira.index', compact('spaces'));
    }

    public function migrate(Request $request){
        $tickets = Self::export($request);
        Self::import($tickets, $request["project_to"]);

        if ($this->commentsErrors == 0 && $this->ticketsErrors == 0){
            $message = ['type' => 'success', 'text' => 'Se migro correctamente!'];
        } else {
            $message = ['type' => 'error', 'text' => 'Errores de migracion:\nTickets: ' . $this->ticketsErrors . '\nComentarios: ' . $this->commentsErrors];
        }

        $spaces = $this->spacesList;
        return redirect()->action('MigrateToJiraController@index')->with('spaces', $spaces)->with(['msg' => $message['type'],'txt' => $message['text']]);
    }
    
    // RELATIVOS AL INDEX

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

    public function getMilestones($space){
        $client = $this->assemblaClient;
        $url = env('ASSEMBLA_ROOT') . "/spaces/" . $space["space_from"] . "/milestones/all";

        return Self::loopThroughPages($url, $client, 'title');
    }

    public function getProjects(){
        $client = $this->jiraClient;
        $url = env('JIRA_ROOT') . '/project/search';
        $request = $client->get($url);
        $response = $request->getBody()->getContents();
        $contentsDecoded = json_decode($response, true);
        $projects = [];
        foreach ($contentsDecoded['values'] as $c){
            $projects[$c['name']] = $c['id'];
        }
        return $projects;
    }

    public function nextStep(Request $request){
        $validatedData = $request->validate([
            'space_from' => "required",
        ]);
        $milestones = Self::getMilestones($validatedData);
        $projects = Self::getProjects();
        $space = [$validatedData['space_from'] => $this->spacesList[$validatedData['space_from']]];

        return view('migratetojira.create', compact('space','milestones', 'projects'));
    }
    
    // EXPORTAR DE ASSEMBLA

    public function export($request){
        $space = $request['space_from'];
        $milestone = $request["milestone_from"];
        $tickets = Self::getTickets($space, $milestone);
        foreach($tickets as &$t){
            $comments = [];
            array_push($comments, Self::getComments($space, $t['number']));
            $t['comments'] = $comments[0];
            $t['bug'] = Self::isBug($space, $t['number']);
        }

        return $tickets;
    }

    public function getTickets($space, $milestone){
        $client = $this->assemblaClient;
        $url = env('ASSEMBLA_ROOT') . "/spaces/" . $space . "/tickets/milestone/" . $milestone;

        return Self::loopThroughPages($url, $client, 'number', 'titleInJson');
    }

    public function getComments($space, $ticket){
        $client = $this->assemblaClient;
        $url = env('ASSEMBLA_ROOT') . "/spaces/" . $space . "/tickets/" . $ticket . "/ticket_comments";

        return Self::loopThroughPages($url, $client, 'comments', 'noTitleInJson');
    }

    public function isBug($space, $ticket){
        $client = $this->assemblaClient;
        $url = env('ASSEMBLA_ROOT') . "/spaces/" . $space . "/tickets/" . $ticket . "/tags";
        $request = $client->get($url);
        if ($request->getStatusCode() != 200){
            return false;
        }
        $response = $request->getBody()->getContents();
        $contentsDecoded = json_decode($response, true);
        foreach ($contentsDecoded as $c){
            if ($c['name'] =='BUG'){
                return true;
            }
        }
        return false;
    }

    public function loopThroughPages($url, $client, $nombreJson, $ticket=""){
        $list = [];
        for ($page = 1; $page < 1000 ; $page++){
            $request = $client->get(sprintf($url . "?page=" . $page ."&per_page=100"));
            if ($request->getStatusCode() != 200){
                break;
            }
            $response = $request->getBody()->getContents();
            $contentsDecoded = json_decode($response, true);
            foreach ($contentsDecoded as $c){
                if ($ticket =='titleInJson'){
                    $list[$c[$nombreJson]] = $c;
                }else if ($ticket =='noTitleInJson'){
                    array_push($list, $c);
                }else{
                    $list[$c[$nombreJson]] = $c['id'];
                }
            }
        }
        ksort($list);
        return $list;
    }

    // IMPORTAR A JIRA

    public function import($tickets, $project){
        foreach($tickets as $ticket){
            $ticketJSON = Self::createTicketJSON($ticket, $project);
            $ticketID = Self::createTicket($ticketJSON);
            if ($ticketID != 0){
                Self::createComments($ticketID, $ticket['comments']);
            }
        }
    }

    public function createTicketJSON($ticket, $project){
        $JSON = [
            "fields" => [
              "summary" => $ticket["summary"],
              "description" => [
                  "version" => 1,
                  "type" => "doc",
                  "content" => [
                      [
                          "type" => "paragraph",
                          "content" => [
                                [
                                  "type" => "text",
                                  "text" => ($ticket["description"] != null ? $ticket["description"] : "Sin descripcion")
                                ]
                          ]
                      ]
                  ]
              ],
              "issuetype" => [
                "id" => ($ticket["bug"] ? "10103" : "10100")
              ],
              "project" => [
                "id" => $project
              ],
              "priority" => [
                "id" => (isset($ticket["priority"]) ? (string) $ticket["priority"] : "3")
              ],
              "assignee" => [
                "id" => "5cdf5342eba5870dd54640d7"
              ]
            ]
        ];

        return json_encode($JSON);
    }

    public function createTicket($ticketJson){
        $client = $this->jiraClient;
        $url = env('JIRA_ROOT') . "/issue/";
        

        try {
            $request = $client->request('POST', $url, ['body' => $ticketJson]);
            if ($request->getStatusCode() == "201"){
                $response = $request->getBody()->getContents();
                $contentsDecoded = json_decode($response, true);
                return $contentsDecoded['id'];
            } else {
                return 0;
            }
        
        } catch (ClientException $e) {
            return 0;
        }
    }

    public function createCommentsJSON($comment){
        $JSON =
        [ 
            "author" => [
            "displayName" => $comment["user_name"]
        ],
            "body" => [
                "type" => "doc",
                "version" => 1,
                "content" => [
                    [
                        "type" => "paragraph",
                        "content" => [
                            [
                                "text" => $comment["user_name"] . ":\n" . $comment["comment"],
                                "type" => "text"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return json_encode($JSON);
    }

    public function createComments($ticketID, $comments){
        $client = $this->jiraClient;
        $url = env('JIRA_ROOT') . "/issue/" . $ticketID . "/comment";

        foreach($comments as $comment){
            if ($comment["comment"] != null){

                $commentJSON = Self::createCommentsJSON($comment);

                try {
                    $request = $client->request('POST', $url, ['body' => $commentJSON]);
                    if ($request->getStatusCode() != "201"){
                        $this->commentsErrors++;
                    }
               
                } catch (ClientException $e) {
                    $this->commentsErrors++;
                }
            }
            
        }
    }

}
