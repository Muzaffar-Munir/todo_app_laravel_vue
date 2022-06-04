<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscribedUserClients;
use App\Models\User;
use Illuminate\Http\Request;

class SubscribedUserClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->get('freelancer'));
        // $data = SubscribedUserClients::with(['client' => function ($client) {
        //     $client->with(['user']);
        // }])->get();
        // $data = SubscribedUserClients::with('client')->whereHas('client')->with('client.user')->get();
        
        if($request->get('freelancer')){
            $data = SubscribedUserClients::where('freelancer_id','=',$request->get('freelancer'))->with('client')->with('client.user')->paginate(6);
        } else{
            $data = SubscribedUserClients::with('client')->with('client.user')->paginate(6);
        }
        return $data;
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
        $subscibe = new SubscribedUserClients;
        $subscibe->client_id = $request->client_id;
        $freelancer = User::findOrFail($request->user_id)->freelancer;
        $subscibe->freelancer_id = $freelancer->id;
        $subscibe->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_entry = SubscribedUserClients::destroy($id);
        if ($delete_entry) {
            return response(null, 200);
        } else {
            return response(null, 400);
        }
        //
    }
}
