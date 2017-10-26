<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberEditRequest;

class MemberController extends Controller
{
    public function getlist($id = null)
    {
        if ($id == null) {
            return Member::orderBy('id', 'asc')->get();
        } else {
            return $this->show($id);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('list');
       
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
    public function store(MemberCreateRequest $request)
    {
        // dd($request->all());
        $members = new Member;
        $members->name = $request->name;
        $members->address = $request->address;
        $members->age = $request->age;
        if (!empty($request->photo)) {
            if ($request->hasFile('photo')) {
                $photo = $request->photo;

                $photo_name = $photo->getClientOriginalName();

                $photo->move('photo',$photo_name);
            }
            $members->photo = 'photo/' .$photo_name;
        }
        

        $members->save();
        // dd($members);
        // return 'success add';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Member::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $member = Member::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberEditRequest $request, $id)
    {

        $members = Member::where('id',$id);

        

        if (!empty($request->photo)) {
            if ($request->hasFile('photo')) {
            
                $photo = $request->photo;

                $photo_name = $photo->getClientOriginalName();

                $photo->move('photo',$photo_name);
                
            }
                $request->photo = 'photo/' .$photo_name;
                
                $members->update(['name' => $request->name, 'address' => $request->address, 'age' => $request->age,'photo' =>$request->photo]);
                
            }
        
        else{
            
            $members->update(['name' => $request->name, 'address' => $request->address, 'age' => $request->age]);
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
        $member = Member::find($id)->delete();

    }
}
