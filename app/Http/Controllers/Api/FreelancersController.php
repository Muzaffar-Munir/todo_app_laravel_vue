<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Freelancers;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Image;

class FreelancersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])->except('index', 'searchBy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freelancers = User::where('role', '=', 'freelancer')->with('freelancer')->with('freelancer.industries')->whereHas('freelancer')->paginate(9);
        return $freelancers;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $freelancer = Freelancers::with('industries')->findOrFail($id);
        return ['freelancer' => $freelancer, 'user' => $freelancer->user, 'sales_method' => $freelancer->user->salesMethods];
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
        $freelancer = Freelancers::findOrFail($id);
        $user = $freelancer->user;
        $input_data = $request->all();
        $this->validate($request, [
            'first_name' => 'required|string|max:50|min:3',
            'last_name' => 'required|string|max:50|min:3',
            'industry' => 'required|string',
            'phone' => 'required|string|max:50|min:3',
            'primary_contact' => 'required|string|max:50|min:3',
            'sales_method' => 'required|',
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
        $freelancer->industry = $input_data['industry'];
        $freelancer->price = $input_data['price'];
        $freelancer->experience = $input_data['experience'];
        $user->sales_method = $input_data['sales_method'];
        $freelancer->primary_contact = $input_data['primary_contact'];
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
            // })->save($destinationPath . '/' . $input['imagename']);
            $img->resize(500, 500)->save($destinationPath . '/' . $input['imagename']);
            if($user->profile_picture!='avatar.png' && file_exists(public_path('images/users/').$user->profile_picture)){
                unlink(public_path('images/users/').$user->profile_picture);
            }
            $user->profile_picture = $uploadFileName;
            $user->save();
        }
        if ($freelancer->save() && $user->save()) {
            return response(null, 200);
        } else {
            return response(null, 400);
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
     * filter for search by  on index page.
     *
     * @param  string  $text
     * @return \Illuminate\Http\Response
     */
    public function searchBy(Request $request)
    {
        $freelancers = [];
        $input = $request->text;
        if ($input && $input != 'null') {
            if (!empty($input['name'])) {

                $freelancers = User::where('role', '=', 'freelancer')->where('full_name', 'like', "%{$input['name']}%")->with(['freelancer'])->paginate(9);
            } elseif (!empty($input['email'])) {
                $freelancers = User::where('role', '=', 'freelancer')->where('email', 'like', "%{$input['email']}%")->with(['freelancer'])->paginate(9);
            } elseif (!empty($input['location'])) {
                $freelancers = User::where('role', '=', 'freelancer')->with(['freelancer' => function ($q) use ($input) {
                    $q->where('location', 'like', "%{$input['location']}%");
                }])->get();
            } elseif (!empty($input['sales_method'])) {
                $freelancers = User::where('role', '=', 'freelancer')->where('sales_method', '=', $input['sales_method'])->with(['freelancer'])->paginate(9);
            } elseif (!empty($input['industry'])) {
                // $freelancers = User::where('role', '=', 'freelancer')->with(['freelancer' => function ($obj) use ($input) {
                //     $obj->where('industry', '=', $input['industry']);
                // }])->get();

                $freelancers = User::where('role', '=', 'freelancer')->with('freelancer')->whereHas('freelancer', function ($obj) use ($input) {
                    $obj->where('industry', '=', $input['industry']);
                })->paginate(9);
            } else {
                $freelancers = User::where('role', '=', 'freelancer')->with(['freelancer'])->paginate(9);
            }
        } else {
            $freelancers = User::where('role', '=', 'freelancer')->with(['freelancer'])->paginate(9);
        }
        return $freelancers;
        //
    }
}
