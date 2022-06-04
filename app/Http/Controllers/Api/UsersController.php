<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordEmail;
use App\Mail\matchedProfessonals;
use App\Models\Clients;
use App\Models\Freelancers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;
use Image;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])->except('store', 'sendEMails', 'updateForgetPassword', 'passwordResetEmail', 'emailVerified', 'expireSubscription','getSetupIntent','postPaymentMethods','removePaymentMethod','updateSubscription','getPaymentMethods');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['role'])) {
            if ($_GET['role'] == 'client') {
                $users = User::with(['client'])->where('role', '=', $_GET['role'])->get();
            } else if ($_GET['role'] == 'freelancer') {
                $users = User::with(['freelancer'])->where('role', '=', $_GET['role'])->get();
            } else {
                $users = User::where('role', '!=', $_GET['role'])->paginate(9);
            }
        } else {
            $users = User::get();
        }

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

        $input_data = $request->all();
        $uploadFileName = '';


        if (isset($input_data['role']) && $input_data['role'] == 'client') {
            $this->validate($request, [
                'first_name' => 'required|string|max:50|min:3',
                'last_name' => 'required|string|max:50|min:3',
                'email' => 'required|string|max:50|unique:users',
                'password' => 'required|string|max:50|min:3',
                'confirm_password' => 'required|string|max:50|min:3|same:password',
                'phone' => 'required|string|max:50|min:3',
                'business_name' => 'required|string|max:50|min:3',
                'business_address' => 'required|string|max:50|min:3',
            ]);
        } else {
            $this->validate($request, [
                'first_name' => 'required|string|max:50|min:3',
                'last_name' => 'required|string|max:50|min:3',
                'email' => 'required|string|max:50|unique:users',
                'password' => 'required|string|max:50|min:5',
                'confirm_password' => 'required|string|max:50|min:5|same:password',
                'phone' => 'required|string|max:50|min:3',
                'primary_contact' => 'required|string|max:50|min:3',
                'industry' => 'required|string',
            ]);
        }

        $user = new User;
        $user->first_name = $input_data['first_name'];
        $user->last_name = $input_data['last_name'];
        $user->full_name = $user->first_name . ' ' . $user->last_name;
        $user->email = $input_data['email'];
        $user->password = Hash::make($input_data['password']);
        $user->source = $input_data['source'];
        $user->phone = $input_data['phone'];

        $user->role = $input_data['role'];
        $user->sales_method = $input_data['sales_method'];

        if ($user->save()) {
            $user->sendEmailVerificationNotification();
            if ($request->has('profile_picture') &&  $request->profile_picture != null) {
                $uploadFileName = $user->id . "_" . $request->profile_picture->getClientOriginalName();

                //checking and creating directory 
                if (!file_exists(public_path('images/users'))) {
                    mkdir(public_path('images/users'), 0755, true);
                }
                $image = $request->file('profile_picture');
                $input['imagename'] = $uploadFileName;
             
                $destinationPath = public_path('/images/users');
                $img = Image::make($image->getRealPath());
                // $img->resize(500, 500, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($destinationPath.'/'.$input['imagename']);
                $img->resize(500, 500)->save($destinationPath . '/' . $input['imagename']);
           
                // $destinationPath = public_path('/images');
                // $image->move($destinationPath, $input['imagename']);
                // $request->profile_picture->move(public_path('images/users'), $uploadFileName);
                $user->profile_picture = $uploadFileName;
                $user->save();
            }
            if ($user->role == 'freelancer') {
                $freelancer = new Freelancers;
                $freelancer->user_id = $user->id;
                $freelancer->industry = $input_data['industry'];
                $freelancer->experience = $input_data['experience'];
                $freelancer->primary_contact = $input_data['primary_contact'];
                $freelancer->description = $input_data['description'];
                $freelancer->price = $input_data['price'];

                if ($freelancer->save()) {
                    return response(null, 200);
                } else {
                    return response(null, 400);
                }
            } else {
                $client = new Clients;
                $client->user_id = $user->id;
                $client->address = $input_data['address'];
                $client->business_name = $input_data['business_name'];
                $client->business_address = $input_data['business_address'];
                $client->referal_email = $input_data['referal_email'];
                $client->subscription_type = isset($input_data['subscription_type']) ? $input_data['subscription_type'] : 0;
                $client->location = $input_data['location'];
                $client->abn = $input_data['abn'];
                $client->stripe_token = isset($input_data['stripe_token']) ? $input_data['stripe_token'] : '';
                if ($client->save()) {
                    $user->client = $client;
                    return response($user, 200);
                } else {
                    return response(null, 400);
                }
            }
        } else {
            return response(null, 400);
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
        $user = User::findOrFail($id);
        if (isset($_GET['subscriptions']) && $user->role == 'freelancer') {
            $subscriptions = $user->freelancer->mysubscriptions;
            return $subscriptions;
        }
        if (isset($_GET['profile-details'])) {
            if ($user->role == 'freelancer') {
                $user->salesmethods;
                $freelancer = $user->freelancer;
                $freelancer->industries;
                return ['freelancer' => $freelancer, 'user' => $user];
            } else {
                $client = $user->client;
                return ['client' => $client, 'user' => $user];
            }

            // 

        } else {
            return $user;
        }
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
        $user = User::findOrFail($id);
        if (isset($_GET['status_change']) && $_GET['status_change']) {
            $user->status = $request->status;
            if ($user->save()) {
                return response($user, 200);
            } else {
                return response(null, 400);
            }
        } else {
            $this->validate($request, [
                'new_password' => 'required|max:50|min:5|different:current_password',
                'confirm_password' => 'required|string|max:50|min:5|same:new_password',
                'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }],
            ]);
            if (Hash::check($request->current_password, $user->password)) {
                $user->fill([
                    'password' => Hash::make($request->new_password)
                ])->save();

                return response(null, 200);
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
        $delete_entry = User::findOrFail($id);
        if ($delete_entry->delete()) {
            return response(null, 200);
        } else {
            return response(null, 400);
        }
    }
    /**
     * Call to action for updating password of users from admin role
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'new_password' => 'required|max:50|min:5',
            'confirm_password' => 'required|string|max:50|min:5|same:new_password',
        ]);
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->new_password);
        if ($user->save()) {
            return response(null, 200);
        } else {
            return response(null, 400);
        }
    }
    /**
     * Call to action for updating password for forget password form
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /** 
     * Call to action for sending email for forget password
     * 
     */
    public function passwordResetEmail(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            $obj_data = new \stdClass();
            $obj_data->app_url = config('app.url');
            $obj_data->token = sha1(time());
            $user->remember_token = $obj_data->token;
            $user->save();
            $obj_data->user = $user;

            Mail::to($request->email)->send(new ForgetPasswordEmail($obj_data));
        } else {
            return response(['message' => ['errors' => ['email' => "We can't find a user with that email address."]]], 422);
        }
    }
    public function updateForgetPassword(Request $request)
    {

        $user = User::where('email', '=', $request->email)->first();

        if ($request->token == $user->remember_token) {
            $this->validate($request, [
                'new_password' => 'required|max:50|min:5',
                'confirm_password' => 'required|string|max:50|min:5|same:new_password',
                'email' => 'required',
                'token' => 'required'
            ]);
            $user->password = Hash::make($request->new_password);
            if ($user->save()) {
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
                return response(null, 200);
            } else {
                return response(null, 400);
            }
        } else {
            return response(null, 406);
        }
    }
    public function emailVerified(Request $request, $uid, $id)
    {
        $user = User::findOrFail($uid);
        $user->email_verified_at = date("Y-m-d h:i:s");
        $user->save();
        return  redirect()->away('/');
    }
    public function getSetupIntent(Request $request)
    {
        $user = User::findOrFail($_GET['user_id']);
        return $user->createSetupIntent();
    }
    /**
     * Adds a payment method to the current user. 
     * 
     * @param Request $request The request data from the user.
     */
    public function postPaymentMethods(Request $request)
    {
        // $user = $request->user();
        $user = User::findOrFail($request->user);
        $paymentMethodID = $request->get('payment_method');

        if ($user->stripe_id == null) {
            $user->createAsStripeCustomer();
        }

        $user->addPaymentMethod($paymentMethodID);
        $user->updateDefaultPaymentMethod($paymentMethodID);

        return response()->json(null, 204);
    }
    /**
     * Returns the payment methods the user has saved
     * 
     * @param Request $request The request data from the user.
     */
    public function getPaymentMethods(Request $request)
    {
        // $user = $request->user();

        $user = User::findOrFail($_GET['user_id']);
        $methods = array();

        if ($user->hasPaymentMethod()) {

            foreach ($user->paymentMethods() as $method) {
                array_push($methods, [
                    'id' => $method->id,
                    'brand' => $method->card->brand,
                    'last_four' => $method->card->last4,
                    'exp_month' => $method->card->exp_month,
                    'exp_year' => $method->card->exp_year,
                ]);
            }
        }

        return response()->json($methods);
    }
    /**
     * Removes a payment method for the current user.
     * 
     * @param Request $request The request data from the user.
     */
    public function removePaymentMethod(Request $request)
    {
        $user = User::findOrFail($request->user);
        $paymentMethodID = $request->get('id');

        $paymentMethods = $user->paymentMethods();

        foreach ($paymentMethods as $method) {
            if ($method->id == $paymentMethodID) {
                $method->delete();
                break;
            }
        }

        return response()->json(null, 204);
    }
    /**
     * Updates a subscription for the user
     * 
     * @param Request $request The request containing subscription update info.
     */
    public function updateSubscription(Request $request)
    {
        $user = User::findOrFail($request->user);
        $planID = $request->get('plan');
        $paymentID = $request->get('payment');
        if (!$request->coupon && $user->newSubscription($request['subscription_title'], $planID)->create($paymentID)) {
            $client = $user->client;
            if ($request->subscription_title == 'Monthly Plan') {
                $client->subscription_type = 1;
            } else if ($request->subscription_title == 'Annual Plan') {
                $client->subscription_type = 2;
            }
            $client->save();
            return response()->json([
                'subscription_updated' => true
            ], 204);
        }
        if ($request->coupon) {
            // if request has coupon and user is subscribed first time then create subsction else throw error for contact support that coupon is already used
            if(!$user->subscriptions()->first() && $user->newSubscription($request['subscription_title'], $planID)->withCoupon($request->coupon)->create($paymentID)){
                $client = $user->client;
                if ($request->subscription_title == 'Monthly Plan') {
                    $client->subscription_type = 1;
                } else if ($request->subscription_title == 'Annual Plan') {
                    $client->subscription_type = 2;
                }
                $client->save();
                return response()->json([
                    'subscription_updated' => true
                ], 204);
            } else{
                return response(null, 406);
            }
           
        }


        
    }

    /**getting admins users  for admin dashboard*/
    public function getAdminUsers()
    {
        $users = User::with(['freelancer'])->where('role', '=', 'admin')->get();
        return $users;
    }
    public function sendEMails()
    {
        // $users = User::where('role', '=', 'clie nt')->with(['client'])->whereHas('client')->get();
        $users = User::where('role', '=', 'client')->with('client')->whereHas('client', function ($obj) {
            $obj->where('subscription_type', '=', '2');
        })->with('client.services')->whereHas('client.services')->get();

        if ($users) {

            foreach ($users as $user) {
                $services = $user->client  && $user->client->services ? $user->client->services : '';

                if ($services) {
                    foreach ($services as $service) {
                        $freelancers = User::where('role', '=', 'freelancer')->with('freelancer')->whereHas('freelancer', function ($obj) use ($service) {
                            $price_from = (int)$service->price - 5;
                            $price_to = (int)$service->price + 5;
                            $obj->where('industry', '=', $service->industry);
                            $obj->orWhere('price', '>=', $price_from)->orWhere('price', '<=', $price_to);
                        })->get();
                        if ($freelancers) {
                            $objProfessionals = new \stdClass();
                            $objProfessionals->user = $user;
                            $objProfessionals->freelancers = $freelancers;
                            $objProfessionals->service = $service;
                            $objProfessionals->app_url = config('app.url');
                            try {
                                Mail::to($user->email)->send(new matchedProfessonals($objProfessionals));
                            } catch (Throwable $e) {
                                print_r($e);
                            }
                        }
                    }
                }
            }
        }
    }
    public function expireSubscription()
    {

        $users = User::where('role', '=', 'client')->with('client')->whereHas('client', function ($obj) {
            $obj->where('subscription_type', '=', '1');
            $obj->orWhere('subscription_type', '=', '2');
        })->get();
        foreach ($users as $user) {
            if ($user->subscriptions) {
                
                $subscription_name = $user->subscriptions()->first()->name;
                $subscription_ended = $user->subscription($subscription_name)->asStripeSubscription()->current_period_end;
                $end_date = date("Y-m-d", $subscription_ended);
                if ($this->isToday($end_date) || $this->isPastDate($end_date)) {
                    $user->client->subscription_type = 5;
                    if($user->client->subscription_type==1){
                        $subscription_type = 'Monthly Plan';
                    } else{
                        $subscription_type = 'Annual Plan';
                    }
                    if ($user->client->save() && $user->subscription($subscription_type)->cancelNow()) {
                        echo "subscription expired of user $user->id" . "\n" . "<br>";
                    } else{
                        echo "subscription is  not going to expired of user $user->id" . "\n" . "<br>";
                    }
                } else{
                    echo "nothing is expired" . "\n" . "<br>";
                }
            }
           
            // $invoices = $user->invoices();
           
            // if (!empty($invoices)) {
            //     $isExpired = false;
            //     foreach ($invoices as $invoice) {
            //         $stripeInvoice = $invoice->asStripeInvoice();
            //         $start_date = date("Y-m-d", $stripeInvoice->lines->data[0]->period->start);
            //         $end_date = date("Y-m-d", $stripeInvoice->lines->data[0]->period->end);   
            //         dd($end_date);                 
            //         if ($this->isPastDate($end_date)) {
            //             $isExpired = true;
            //         }
            //         if ($this->isToday($end_date)) {
            //             $isExpired = true;
            //         }
            //     }
            //     if ($isExpired) {
            //         $user->client->subscription_type = 5;
            //         if ($user->client->save()) {
            //             echo "subscription expired of user $user->id" . "\n" . "<br>";
            //         }
            //     }
            // }
        }
    }
    function isToday($time) // only passing date
    {
        return (strtotime($time) === strtotime('today'));
    }
    function isPastDate($time) // only passing date
    {
        return (strtotime($time) < strtotime('today'));
    }
}
