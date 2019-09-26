<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
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

        $opciones = ['Nombre' => 'name', 'Email' => 'email'];

        // if ($request->has('orderBy')) $orderBy = $request->query('orderBy');
        // if ($request->has('sortBy')) $sortBy = $request->query('sortBy');
        // if ($request->has('perPage')) $perPage = $request->query('perPage');
        // if (isset($request->name) || isset($request->email)) $filtro = $request->query();

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
    
        
        $users = User::search($filtro)->orderBy($sortBy, $orderBy)->paginate($perPage);
        return view('users.index', compact('orderBy', 'sortBy', 'perPage', 'users', 'opciones'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    // // /**
    // //  * Store a newly created resource in storage.
    // //  *
    // //  * @param  \Illuminate\Http\Request  $request
    // //  * @return \Illuminate\Http\Response
    // //  */
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'name' => 'required|unique:users,name',
             'email' => 'required|unique:users,email',
             'password' => 'required|confirmed',
         ]);
         $validatedData['password'] = Hash::make($validatedData['password']);
         $user = User::create($validatedData);

         return redirect('/users')->with(['msg' => 'success','txt' => 'Se guardo el Usuario!']);
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
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
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
        $validatedData = $request->validate([
            'name' => 'unique:users,name,' . $id,
        ]);

        User::whereId($id)->update(array_filter($validatedData));

        return redirect('/users')->with(['msg' => 'success','txt' => 'Se actualizo correctamente']);
    }

    public function resetview($id)
    {
        $user = User::findOrFail($id);
        return view('users.reset', compact('user'));
    }

    public function reset(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::whereId($id)->update($validatedData);

        return redirect('/users')->with(['msg' => 'success','txt' => 'Se actualizo correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with(['msg' => 'success','txt' => 'Se borro correctamente']);
    }
}