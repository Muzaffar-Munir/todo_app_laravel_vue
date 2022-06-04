<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
        try {
            // Stripe::setApiKey('sk_test_51HZ7WDFNRB3NlNKYLHD3CSXvhtY91PVu87vNal0KkDzifLCPSlGe98dfxrj5h8L2cxAHJ6tgbTmfRgEHKGzqnnE900nJr2EBjK');

            // $user = User::find('43089cbf-ce0f-42b4-88e9-8bee7dacc393');

            $stripe = new \Stripe\StripeClient(
                'sk_test_51HZ7WDFNRB3NlNKYLHD3CSXvhtY91PVu87vNal0KkDzifLCPSlGe98dfxrj5h8L2cxAHJ6tgbTmfRgEHKGzqnnE900nJr2EBjK'
            );
            //   $payments = $stripe->balanceTransactions->all(['limit'=>3]);
            $payments = $stripe->subscriptions->all();
            // $payments=  $stripe->subscriptions->all();
            return $payments;
            // $invoices = $user->invoices();

            // dd($invoices);
            // foreach($invoices as $data){
            //     dd($data);
            // }
            // // $invoices = $user->invoicesIncludingPending();
            // return $invoices;
            // return view('invoices', compact('invoices'));

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
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
