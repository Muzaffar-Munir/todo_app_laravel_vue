<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Image;


class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])->except('index', 'show', 'searchBy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (isset($_GET['user_id']) && $_GET['user_id']) {
            $user = User::findOrFail($_GET['user_id']);
            $client = $user->client;
            $services = Services::where('client_id', '=', $client->id)->paginate(9);
            return $services;
        } else {
            $services = Services::with(['client'])->with(['client.user'])->paginate(9);
            return $services;
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
        $input_data = $request->all();
        $client = User::findOrFail($input_data['client_id'])->client;
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string|min:3',
            'price' => 'required|integer',
            'sales_method' => 'required|string|max:50',
            'audience' => 'required|string',
            'industry' => 'required|string',
            'location' => 'required|string',
            'url' => 'required|string',
            'requirements' => 'required|string|min:3',
            'client_id' => 'required|string|max:50',
        ]);
        $service = new Services;
        $service->title = $input_data['title'];
        $service->description = $input_data['description'];
        $service->price = $input_data['price'];
        $service->sales_method = $input_data['sales_method'];
        $service->industry = $input_data['industry'];
        $service->audience = $input_data['audience'];
        $service->location = $input_data['location'];
        $service->url = $input_data['url'];
        $service->requirements = $input_data['requirements'];
        $service->client_id = $client->id;
        if ($service->save()) {
            if ($request->has('attachment') &&  $request->attachment != null) {
                $uploadFileName = $service->id . "_" . $request->attachment->getClientOriginalName();
                //checking and creating directory 
                if (!file_exists(public_path('images/services'))) {
                    mkdir(public_path('images/services'), 0755, true);
                }
                // $request->attachment->move(public_path('images/services'), $uploadFileName);
                $image = $request->file('attachment');
                $input['imagename'] = $uploadFileName;

                $destinationPath = public_path('/images/services');
                $img = Image::make($image->getRealPath());
                // $img->resize(500, 500, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($destinationPath . '/' . $input['imagename']);
                $img->resize(500, 500)->save($destinationPath . '/' . $input['imagename']);
                $service->attachment = $uploadFileName;
                $service->save();
            }
            return response(null, 200);
        } else {
            return response(null, 400);
        }
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
        $service = Services::with(['salesMethods'])->findOrFail($id);
        return $service;
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
        $input_data = $request->all();
        $service = Services::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'sales_method' => 'required|string|max:50',
            'audience' => 'required|string',
            'location' => 'required|string',
            'url' => 'required|string',
            'requirements' => 'required|string',
            'industry' => 'required|string',
            'client_id' => 'required|string|max:50',
        ]);
        if (isset($request->attachment) && $request->has('attachment') &&  $request->attachment != null) {
            $uploadFileName = $service->id . "_" . $request->attachment->getClientOriginalName();
            //checking and creating directory 
            if (!file_exists(public_path('images/services'))) {
                mkdir(public_path('images/services'), 0755, true);
            }
            // remove previous image of service on update
            if($service->attachment!='avatar.png' && file_exists(public_path('images/services/').$service->attachment)){
                unlink(public_path('images/services/').$service->attachment);
            }
            // $request->attachment->move(public_path('images/services'), $uploadFileName);
            $image =  $request->file('attachment');
            $input['imagename'] = $uploadFileName;

            $destinationPath = public_path('/images/services');
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
            $service->attachment = $uploadFileName;
            $service->save();
        }
        $service->title = $input_data['title'];
        $service->description = $input_data['description'];
        $service->price = $input_data['price'];
        $service->sales_method = $input_data['sales_method'];
        $service->industry = $input_data['industry'];
        $service->audience = $input_data['audience'];
        $service->location = $input_data['location'];
        $service->url = $input_data['url'];
        $service->requirements = $input_data['requirements'];

        if ($service->save()) {
            return response(null, 200);
        } else {

            return response(null, 400);
        }
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

        $delete_entry = Services::findOrFail($id);
        if ($delete_entry->delete()) {
            return response(null, 200);
        } else {
            return response(null, 400);
        }
    }

    /**
     * update service status active/inactive by admin user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {

        $Service = Services::findOrFail($_GET['id']);
        $Service->status = $request->status;
        if ($Service->save()) {
            return response($Service, 200);
        } else {
            return response(null, 400);
        }
    }
    /**
     * filter for search by  on index page.
     *
     * @param  string  $text
     * @return \Illuminate\Http\Response
     */
    public function searchBy(Request $request)
    {
        $services = [];
        $input = $request->text;
        if ($input && $input != 'null') {
            if (!empty($input['title'])) {
                $services =  Services::where('title', 'like', "%{$input['title']}%")->with(['client'])->with(['client.user'])->paginate(9);
            } elseif (!empty($input['sales_method'])) {
                $services = Services::where('sales_method', '=', $input['sales_method'])->with(['client'])->with(['client.user'])->paginate(9);
            } else {
                $services =  Services::with(['client'])->with(['client.user'])->paginate(9);
            }
        } else {
            $services = Services::with(['client'])->with(['client.user'])->paginate(9);
        }
        return $services;
        //
    }
}
