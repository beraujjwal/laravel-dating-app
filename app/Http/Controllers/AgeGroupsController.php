<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

use App\Models\AgeGroup;
use App\Models\Gender;

class AgeGroupsController extends Controller
{
    protected $table = 'age_groups';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ageGroup = AgeGroup::with(['gender'])->where('status', true)->get();
        return $this->sendWithDataResponse($ageGroup, 'Age group list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function age_groups_by_agegroup(Request $request, string $gender = 'male')
    {
        $ageGroup = AgeGroup::whereHas('gender', function ($query) use($gender) {
                $query->where('slug', $gender);
            })
            ->with([
                'gender' => function($query) use($gender) {
                $query->where('slug', $gender);
            }
        ])->where('status', true)->get();
        return $this->sendWithDataResponse($ageGroup, 'Age group list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agegroupsList(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $agegroups = AgeGroup::whereHas('gender', function ($query) {
            $query->where('status', true);
        })->with(['gender' => function($query) {
            $query->where('status', true);
        }])->get();
        return view('admin.agegroups.list', compact('agegroups'));
    }

    /**
     * Show the form for creating a new agegroup.
     *
     * @return \Illuminate\Http\Response
     */
    public function agegroupAdd()
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $genders = Gender::where('status', true)->get();
        return view('admin.agegroups.add', compact('genders'));
    }

    /**
     * Store a newly created agegroup.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agegroupStore(Request $request)
    {
        
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            $request->validate([
                'min'       => 'required|numeric',
                'max'       => 'required|numeric',
                'gender'    => 'required|numeric'
            ]);

            $agegroup = AgeGroup::create([
                'min'       => $request->input('min'),
                'max'       => $request->input('max'),
                'gender_id' => $request->input('gender'),
                'status'    => $request->input('status')
            ]);
            $request->session()->flash('alert-success', 'Age group was successful created!');
            return redirect()->route('admin.agegroups');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.agegroup-add');
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.agegroup-add');
        }
        
        
    }


    /**
     * Show the form for editing the specified agegroup.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agegroupEdit(Request $request, $id)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $agegroup = AgeGroup::findOrFail($id);
        $genders = Gender::where('status', true)->get();
        return view('admin.agegroups.edit', compact('agegroup', 'genders'));
    }

    /**
     * Update the specified agegroup
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agegroupUpdate(Request $request, $id)
    {
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            
            $agegroup = AgeGroup::where('id', $id)->first();

            if(!$agegroup) {
                $request->session()->flash('alert-danger', 'The agegroup you are trying to update is not available.');
                return redirect()->route('admin.agegroups');
            }            
            
            $request->validate([            
                'min'       => 'required|numeric',
                'max'       => 'required|numeric',
                'gender'    => 'required|numeric'
            ]);

            $agegroup->min = $request->input( 'min' );
            $agegroup->max = $request->input( 'max' );
            $agegroup->gender_id = $request->input( 'gender' );
            $agegroup->status = $request->input( 'status' );
            $agegroup->save();
            $request->session()->flash('alert-success', 'User was successful updated!');
            return redirect()->route('admin.agegroups');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.agegroup-edit')->with('agegroup',$agegroup->id);
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.agegroup-edit')->with('agegroup',$agegroup->id);
        }
    }

     /**
     * Remove the specified agegroup.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agegroupDelete(Request $request, $id)
    {
        DB::beginTransaction();
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $agegroup = AgeGroup::findOrFail($id);

        try {
            $agegroup->delete();
            DB::commit();
            $request->session()->flash('alert-success', 'Age group was successful deleted!');
        } catch(\Exception $ex) {
            DB::rollback();
            $request->session()->flash('alert-danger', $ex->getMessage());
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
        }
        return redirect()->route('admin.agegroups');
        
    }
}
