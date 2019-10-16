<?php

namespace App\Http\Controllers;

use App\Job;
use App\Files;
use Excel;
use Auth;

use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $job;
    protected $file;

    public function __contrsuct()
    {
        $job = new Job();
        $file = new Files();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = [];
        $files = Files::paginate(10);

        return view('job.listing', ['files' => $files]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('job.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $job = new Job();
        $job->fill($input);
        if(!isset($input['day']))
            $input['day'] = null;
        $job->day = $input['day'];
        $job->save();
        return redirect()->route('job.index')->with('message', 'Job added successfully');
    
    }

    public function download(Request $request, $file_name)
    {
        try {
            $file_path = 'jobs/'.$file_name;
            $type = substr($file_name, -3);
            $file_path = storage_path($file_path);

            if(!file_exists($file_path)){
                return redirect()->back()->withErrors('File does not Exist!');
            }
            if($file_path)   {
                return Excel::load($file_path, function($file_path){

                })->download($type); 
            }
        } catch (Exception $e) {
            return null;
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
