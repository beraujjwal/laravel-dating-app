<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

use App\Models\Gender;

class GendersController extends Controller
{

    protected $table = 'genders';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gender = Gender::where('status', true)->get();
        return $this->sendWithDataResponse($gender, 'Genders list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gendersList(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $genders = Gender::all();
        return view('admin.genders.list', compact('genders'));
    }

    /**
     * Show the form for creating a new gender.
     *
     * @return \Illuminate\Http\Response
     */
    public function genderAdd()
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        return view('admin.genders.add');
    }

    /**
     * Store a newly created gender.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function genderStore(Request $request)
    {
        
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            $request->validate([
                'name'=>'required|string',
            ]);

            $gender = Gender::create([
                'name' => $request->input('name'),
                'status' => $request->input('status')
            ]);
            $request->session()->flash('alert-success', 'Gender was successful created!');
            return redirect()->route('admin.genders');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.gender-add');
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.gender-add');
        }
        
        
    }


    /**
     * Show the form for editing the specified gender.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function genderEdit(Request $request, $id)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $gender = Gender::findOrFail($id);
        return view('admin.genders.edit', compact('gender'));
    }

    /**
     * Update the specified gender
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function genderUpdate(Request $request, $id)
    {
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            
            $gender = Gender::where('id', $id)->first();

            if(!$gender) {
                $request->session()->flash('alert-danger', 'The gender you are trying to update is not available.');
                return redirect()->route('admin.genders');
            }            
            
            $request->validate([            
                'name'      => 'required|regex:/^[a-zA-Z ]*$/',
                'slug'      => 'required|unique:genders,slug,'.$gender->id.',id',
                'status'    => 'required'
            ]);

            $gender->name = $request->input( 'name' );
            $gender->slug = $request->input( 'slug' );
            $gender->status = $request->input( 'status' );
            $gender->save();
            $request->session()->flash('alert-success', 'User was successful updated!');
            return redirect()->route('admin.genders');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.gender-edit')->with('gender',$gender->id);
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.gender-edit')->with('gender',$gender->id);
        }
    }

     /**
     * Remove the specified gender.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function genderDelete(Request $request, $id)
    {
        DB::beginTransaction();
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $gender = Gender::findOrFail($id);

        try {
            $gender->delete();
            DB::commit();
            $request->session()->flash('alert-success', 'Gender was successful deleted!');
        } catch(\Exception $ex) {
            DB::rollback();
            $request->session()->flash('alert-danger', $ex->getMessage());
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
        }
        return redirect()->route('admin.genders');
        
    }
}
