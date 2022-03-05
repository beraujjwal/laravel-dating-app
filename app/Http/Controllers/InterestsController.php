<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

use App\Models\Interest;

class InterestsController extends Controller
{
    protected $table = 'interests';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $interest = Interest::where('status', true)->get();
        return $this->sendWithDataResponse($interest, 'Interests list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function interestsList(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $interests = Interest::all();
        return view('admin.interests.list', compact('interests'));
    }

    /**
     * Show the form for creating a new interest.
     *
     * @return \Illuminate\Http\Response
     */
    public function interestAdd()
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        return view('admin.interests.add');
    }

    /**
     * Store a newly created interest.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function interestStore(Request $request)
    {
        
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            $request->validate([
                'name'=>'required|string',
            ]);

            $interest = Interest::create([
                'name' => $request->get('name'),
                'status' => $request->get('status')
            ]);
            $request->session()->flash('alert-success', 'Interest was successful created!');
            return redirect()->route('admin.interests');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.interest-add');
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.interest-add');
        }
        
        
    }


    /**
     * Show the form for editing the specified interest.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function interestEdit(Request $request, $id)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $interest = Interest::findOrFail($id);
        return view('admin.interests.edit', compact('interest'));
    }

    /**
     * Update the specified interest
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function interestUpdate(Request $request, $id)
    {
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            
            $interest = Interest::where('id', $id)->first();

            if(!$interest) {
                $request->session()->flash('alert-danger', 'The interest you are trying to update is not available.');
                return redirect()->route('admin.interests');
            }            
            
            $request->validate([            
                'name'      => 'required|regex:/^[a-zA-Z ]*$/',
                'slug'      => 'required|unique:interests,slug,'.$interest->id.',id',
                'status'    => 'required'
            ]);

            $interest->name = $request->input( 'name' );
            $interest->slug = $request->input( 'slug' );
            $interest->status = $request->input( 'status' );
            $interest->save();
            $request->session()->flash('alert-success', 'User was successful updated!');
            return redirect()->route('admin.interests');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.interest-edit')->with('interest',$interest->id);
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.interest-edit')->with('interest',$interest->id);
        }
    }

     /**
     * Remove the specified interest.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function interestDelete(Request $request, $id)
    {
        DB::beginTransaction();
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $interest = Interest::findOrFail($id);

        try {
            $interest->delete();
            DB::commit();
            $request->session()->flash('alert-success', 'Interest was successful deleted!');
        } catch(\Exception $ex) {
            DB::rollback();
            $request->session()->flash('alert-danger', $ex->getMessage());
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
        }
        return redirect()->route('admin.interests');
        
    }
}
