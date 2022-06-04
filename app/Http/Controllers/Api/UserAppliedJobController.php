<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\UserAppliedJob;
use Illuminate\Http\Request;

class UserAppliedJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (isset($_GET['freelancer'])) {
            // $jobs = UserAppliedJob::with(['service' => function ($q) {
            //     $q->with(['client' => function ($user) {
            //         $user->with(['user']);
            //     }]);
            // }])->where('freelancer_id', '=', $_GET['freelancer'])->get();
            $jobs = UserAppliedJob::with('service')->with('service.client')->with('service.client.user')->where('freelancer_id', '=', $_GET['freelancer'])->paginate(6);
            return $jobs;
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

        $this->validate($request, [
            'freelancer_id' => 'required|string',
            'service_id' => 'required|string',
        ]);
        $input_data = $request->all();
        $jobApply = new UserAppliedJob;
        $jobApply->freelancer_id = $input_data['freelancer_id'];
        $jobApply->service_id = $input_data['service_id'];
        if ($jobApply->save()) {
            return response(null, 200);
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
        if (isset($_GET['applicants']) && $_GET['applicants']) {
            $jobs = UserAppliedJob::with(['service', 'freelancer'])->with('freelancer.user')->where('service_id', '=', $id)->get();
            return $jobs;
        } else if (isset($_GET['applid_user']) && $_GET['applid_user']) {
            $jobs = UserAppliedJob::where('service_id', '=', $id)->where('freelancer_id', '=',  $_GET['applid_user'])->get();
            return $jobs;
        } else {
            $jobs = UserAppliedJob::findOrFail($id);
            return $jobs;
        }

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
        $delete_entry = UserAppliedJob::destroy($id);
        if ($delete_entry) {
            return response(null, 200);
        } else {
            return response(null, 400);
        }
    }
}
