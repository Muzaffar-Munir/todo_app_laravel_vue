<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CancelSubscriptions;
use App\Models\User;
use Illuminate\Http\Request;

class CancelSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = CancelSubscriptions::with('user')->whereHas('user')->with('user.client')->whereHas('user.client', function($client){
            $client->where('subscription_type','=','10');
        })->paginate(9);
        return $users;
        
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
        $this->validate($request, [
            'user' => 'required',
            'reason' => 'required|string'
            ]);
        $user = User::with('client')->whereHas('client')->where('id', '=', $request->user)->first();
        if($user && $user->client){
            $subscription = new CancelSubscriptions;
            $subscription->user_id = $request->user;
            $subscription->reason = $request->reason;
            if($user->client->subscription_type==1){
                $subscription_type = 'Monthly Plan';
            } else{
                $subscription_type = 'Annual Plan';
            }
            $user->client->subscription_type =10;
            if ($subscription->save() && $user->client->save() && $user->subscription($subscription_type)->cancelNow()) {
                return response(null, 200);
            } else {
                return response(null, 400);
            }
        }
        
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
        //
    }
}
