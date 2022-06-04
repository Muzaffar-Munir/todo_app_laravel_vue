<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Image;

class ClientsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])->except('index', 'searchBy','findReferal');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $clients = User::with(['client'])
        //     ->where('role', '=', 'client')
        //     ->get();
        $clients =  $clients = User::where('role', '=', 'client')->with(['client'])->whereHas('client')->paginate(9);
        return $clients;
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

        $client = Clients::findOrFail($id);
        $input_data = $request->all();
        if (isset($_GET['type']) && $_GET['type'] == 'subscribe') {
            $client->subscription_type = $input_data['selected_plan'];
            if ($client->save()) {
                return response(null, 200);
            } else {
                return response(null, 400);
            }
        } else {
            $user = $client->user;

            $this->validate($request, [
                'first_name' => 'required|string|max:50|min:3',
                'last_name' => 'required|string|max:50|min:3',
                'business_name' => 'required|string|max:50|min:3',
                'business_address' => 'required|string|max:50|min:3',
                'phone' => 'required|string|max:50|min:3',
            ]);
            $user->first_name = $input_data['first_name'];
            $user->last_name = $input_data['last_name'];
            if ($user->email != $input_data['email']) {
                $this->validate($request, [
                    'email' => 'required|string|max:50|unique:users',
                ]);
                $user->email = $input_data['email'];
            }
            $user->phone = $input_data['phone'];
            $user->sales_method = $input_data['sales_method'];
            $client->abn = $input_data['abn'];
            $client->address = $input_data['address'];
            $client->business_name = $input_data['business_name'];
            $client->business_address = $input_data['business_address'];
            if ($request->has('profile_picture') &&  $request->profile_picture != null) {
                $uploadFileName = $user->id . "_" . $request->profile_picture->getClientOriginalName();
                //checking and creating directory 
                if (!file_exists(public_path('images/users'))) {
                    mkdir(public_path('images/users'), 0755, true);
                }
                $image =  $request->file('profile_picture');
                $input['imagename'] = $uploadFileName;

                $destinationPath = public_path('/images/users');
                // $img = Image::make($image->getRealPath());
                $img = Image::make(file_get_contents(str_replace(' ', '%20',$image->getRealPath())));
                // $img->resize(500, 500, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($destinationPath . '/' . $input['imagename']);
                $img->resize(500, 500)->save($destinationPath . '/' . $input['imagename']);
                if($user->profile_picture!='avatar.png' && file_exists(public_path('images/users/').$user->profile_picture)){
                    unlink(public_path('images/users/').$user->profile_picture);
                }
                $user->profile_picture = $uploadFileName;
                $user->save();
            }
            if ($client->save() && $user->save()) {
                return response(['client' => $client, 'user' => $user], 200);
            } else {
                return response(null, 400);
            }
        }
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
    /**
     *find the email if client is from referal email.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findReferal(Request $request)
    {
        $client = Clients::where('referal_email', '=', $request->email)->first();
        return $client;
    }
    /**
     * filter for search by  on index page.
     *
     * @param  string  $text
     * @return \Illuminate\Http\Response
     */
    public function searchBy(Request $request)
    {
        $clients = [];
        $input = $request->text;
        if ($input && $input != 'null') {
            if (!empty($input['name'])) {
                $clients = User::where('role', '=', 'client')->where('full_name', 'like', "%{$input['name']}%")->with('client')->whereHas('client')->paginate(9);
            } elseif (!empty($input['email'])) {
                $clients = User::where('role', '=', 'client')->where('email', 'like', "%{$input['email']}%")->with('client')->whereHas('client')->paginate(9);
            } elseif (!empty($input['location'])) {
                $clients = User::where('role', '=', 'client')->with(['client' => function ($q) use ($input) {
                    $q->where('location', '=', $input['location']);
                }])->whereHas('client')->paginate(9);
            } elseif (!empty($input['sales_method'])) {
                $clients = User::where('role', '=', 'client')->where('sales_method', '=', $input['sales_method'])->with('client')->whereHas('client')->paginate(9);
            } else {
                $clients = User::where('role', '=', 'client')->with('client')->whereHas('client')->paginate(9);
            }
        } else {
            $clients = User::where('role', '=', 'client')->with('client')->whereHas('client')->paginate(9);
        }
        return $clients;
        //
    }
    public function showMyPayments(Request $request)
    {
        try {
            Stripe::setApiKey(config('stripe.secret'));

            $user = User::find($request->user_id);

            $invoices = $user->invoices();
            if (!empty($invoices)) {
                $data = [];
                $i = 0;
                foreach ($invoices as $invoice) {
                    $stripeInvoice = $invoice->asStripeInvoice();
                    $start_date = (Carbon::createFromTimestamp($stripeInvoice->lines->data[0]->period->start))->toFormattedDateString();
                    $end_date = (Carbon::createFromTimestamp($stripeInvoice->lines->data[0]->period->end))->toFormattedDateString();
                    $data[$i]['id'] = $invoice->id;
                    $data[$i]['date'] = $invoice->date()->toFormattedDateString();
                    $data[$i]['start_date'] = $start_date;
                    $data[$i]['end_date'] = $end_date;
                    $data[$i]['total'] = $invoice->total();
                    $data[$i]['status'] = $invoice->status;
                    $data[$i]['pdf_link'] = $invoice->invoice_pdf;
                    $i++;
                }
                return $data;
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
