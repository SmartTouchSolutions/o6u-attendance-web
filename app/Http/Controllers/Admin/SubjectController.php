<?php

namespace App\Http\Controllers\Admin;

use App\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        {
            $allsubject = Subject::when($request->search , function($que) use ($request) {
                $que->where('name' , 'LIKE' , '%'.$request->search.'%');
            })->select('id' , 'name' , 'subject_code' , 'created_at')->orderBy('id','desc')->paginate(3);

            return view('admin.subjects.index' , ['allsubject' => $allsubject]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subjects.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all() ,[

            'name'              => 'required',
            'subject_code'      => 'required',


        ])->validate();

        $insertData = new Subject();
        $insertData->name               = $request->name;
        $insertData->subject_code       = $request->subject_code;

        $insertData->save();

        return redirect('/subject');

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

            $subjectDetails = Subject::find($id);

        return view('admin.subjects.edit', compact('subjectDetails'));

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
        $validator = \Validator::make($request->all() , [
            'name'              => 'required|unique:subjects,name,'.$id,
            'subject_code'              => 'required',
        ])->validate();
        $subject = Subject::find($id);

        $startUpdate = $subject->update(['name' => $request->name , 'subject_code' => $request->subject_code]);

        \Session::flash('success' , 'Record Updated Success');
        return redirect('subject');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        \Session::flash('success' , 'Doctor Deleted Success');
        return redirect('subject')->with('error' , 'subject Deleted Success');
    }
}
