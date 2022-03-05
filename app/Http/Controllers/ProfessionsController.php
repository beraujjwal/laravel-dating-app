<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

use App\Models\Profession;

class ProfessionsController extends Controller
{
    protected $table = 'professions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $profession = Profession::where('status', true)->get();
        return $this->sendWithDataResponse($profession, 'Professions list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function professionsList(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $professions = Profession::all();
        return view('admin.professions.list', compact('professions'));
    }

    /**
     * Show the form for creating a new profession.
     *
     * @return \Illuminate\Http\Response
     */
    public function professionAdd()
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        return view('admin.professions.add');
    }

    /**
     * Store a newly created profession.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function professionStore(Request $request)
    {
        
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            $request->validate([
                'name'=>'required|string',
            ]);

            $profession = Profession::create([
                'name' => $request->get('name'),
                'status' => $request->get('status')
            ]);
            $request->session()->flash('alert-success', 'Profession was successful created!');
            return redirect()->route('admin.professions');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.profession-add');
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.profession-add');
        }
        
        
    }


    /**
     * Show the form for editing the specified profession.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function professionEdit(Request $request, $id)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $profession = Profession::findOrFail($id);
        return view('admin.professions.edit', compact('profession'));
    }

    /**
     * Update the specified profession
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function professionUpdate(Request $request, $id)
    {
        try {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('admin-login');
            }
            
            $profession = Profession::where('id', $id)->first();

            if(!$profession) {
                $request->session()->flash('alert-danger', 'The profession you are trying to update is not available.');
                return redirect()->route('admin.professions');
            }            
            
            $request->validate([            
                'name'      => 'required|regex:/^[a-zA-Z ]*$/',
                'slug'      => 'required|unique:professions,slug,'.$profession->id.',id',
                'status'    => 'required'
            ]);

            $profession->name = $request->input( 'name' );
            $profession->slug = $request->input( 'slug' );
            $profession->status = $request->input( 'status' );
            $profession->save();
            $request->session()->flash('alert-success', 'User was successful updated!');
            return redirect()->route('admin.professions');
        } catch (Exception $ex) {
            $request->session()->flash('alert-danger', $ex->getMessages());
            return redirect()->route('admin.profession-edit')->with('profession',$profession->id);
        } catch(\Illuminate\Database\QueryException $ex){
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
            return redirect()->route('admin.profession-edit')->with('profession',$profession->id);
        }
    }

     /**
     * Remove the specified profession.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function professionDelete(Request $request, $id)
    {
        DB::beginTransaction();
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $profession = Profession::findOrFail($id);

        try {
            $profession->delete();
            DB::commit();
            $request->session()->flash('alert-success', 'Profession was successful deleted!');
        } catch(\Exception $ex) {
            DB::rollback();
            $request->session()->flash('alert-danger', $ex->getMessage());
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            $request->session()->flash('alert-danger', 'Some exceptions occurred from the DB server. Please contact the administrator.');
        }
        return redirect()->route('admin.professions');
        
    }
}
