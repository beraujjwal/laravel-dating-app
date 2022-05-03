<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Mail;

use App\Models\User;
use App\Models\Profile;
use App\Models\ProfileProfession;
use App\Models\Friend;
use App\Models\ProfileInterest;

class UsersController extends Controller
{
    protected $table = 'users';

    /**
     * @desc user register action
     * @param  Request  $request
     * @return void
     */
    public function doLoginOrRegister(Request $request)  {
        try {

            $rules = [
                'provider_id'   => 'required',
                'provider'      => 'required',
                'name'          => 'required_if:provider,google,facebook',
                'email'         => 'required_if:provider,google,facebook',
                'phone'         => 'required_if:provider,firebase'
            ];
            $validator = Validator::make($request->json()->all(), $rules);
            if($validator->fails()){
                $errors = [];
                foreach ($validator->errors()->getMessages() as $item) {
                    array_push($errors, $item);
                }
                return $this->sendError($errors, 'User login fail');
            }

            $data = [
                'password'      => Hash::make($request->input('provider_id')),
                'status'        => true,
                'online'        => true
            ];

            if($request->input('provider') == 'firebase') {
                $data['phone'] = $request->input('phone');
            } else {
                $data['email'] = $request->input('email');
                $data['name'] = $request->input('name');
            }

            //dd($data);
            $user = User::updateOrCreate([
                'provider_id'   => $request->input('provider_id'),
                'provider'      => $request->input('provider')
            ],$data);

            // Create a Personnal Access Token
            $tokenResult = $user->createToken('Personal Access Token');

            // Store the created token
            $token = $tokenResult->token;

            // Add a expiration date to the token
            $token->expires_at = Carbon::now()->addWeeks(1);

            // Save the token to the user
            $token->save();

            // Return a JSON object containing the token datas
            // You may format this object to suit your needs
            $response = [
                'user' => $user,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ];

            return $this->sendResponse($response, 'You are loggedin successfullyly.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user get profile
     * @param  Request  $request
     * @return void
     */
    public function getProfile(Request $request)  {
        try {
            $user = User::with(['profile' => function ($query) {
                $query->with(['gender','profession', 'interests']);
        }])->where('status', true)->where('id', $request->user()->id)->first();
            return $this->sendResponse($user, 'Profile details');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user get profile
     * @param  Request  $request
     * @return void
     */
    public function updateProfile(Request $request)  {
        DB::beginTransaction();
        try {
            $user = User::where('status', true)->where('id', $request->user()->id)->first();

            $rules = [
                'provider'      => 'required',
                'name'          => 'required_if:provider,google,facebook',
                'gender'        => 'required|numeric|exists:genders,id',
                'age'           => 'required|numeric',
                'interested'    => 'required|array',
                'interested.*'  => 'exists:professions,id',
            ];

            $validator = Validator::make($request->json()->all(), $rules);
            if($validator->fails()){
                $errors = [];
                foreach ($validator->errors()->getMessages() as $item) {
                    array_push($errors, $item);
                }

                return $this->sendError($errors, 'Invalid request sent');

            }

            $user->name = $request->input( 'name' );
            $user->save();

            $profile = Profile::where('status', true)->where('user_id', $request->user()->id)->first();
            if($profile == null) {
                $profile = new Profile;
            }
            $profile->gender_id = $request->input( 'gender' );
            $profile->user_id = $user->id;
            $profile->nickname = $request->input( 'name' );
            $profile->age = $request->input( 'age' );
            $profile->about_me = $request->input( 'about_me' );
            $profile->marital_status = $request->input( 'marital_status' );
            $profile->status = true;
            $profile->save();

            $profileprofession = ProfileProfession::where('status', true)->where('profile_id', $profile->id)->where('profession_id', $request->input( 'profession' ))->first();
            if($profileprofession == null) {
                $profileprofession = new ProfileProfession;
                $profileprofession->profession_id = $request->input( 'profession' );
                $profileprofession->profile_id = $profile->id;
                $profileprofession->status = true;
                $profileprofession->save();
            }

            foreach($request->input( 'interested' ) as $intereste) {
                $interest = ProfileInterest::where('status', true)->where('profile_id', $profile->id)->where('interest_id', $intereste['id'])->first();
                if($interest == null) {
                    $interest = new ProfileInterest;
                    $interest->interest_id = $intereste['id'];
                    $interest->profile_id = $profile->id;
                    $interest->status = true;
                    $interest->save();
                }

            }

            DB::commit();
            return $this->sendResponse($user, 'Your profile was successfully updated!');
        } catch (Exception $ex) {
            DB::rollback();
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc admin login form
     * @param  Request  $request
     * @return void
     */
    public function login(Request $request) {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * @desc admin login action
     * @param  Request  $request
     * @return void
     */
    public function doLogin(Request $request)  {
        //dd($request);
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $data = $request->validate($rules);
        $login_type = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL ) ? 'email' : 'phone';
        $request->merge([ $login_type => $request->input('username') ]);
        $remember_me = $request->has('remember_me') ? true : false;
        if (Auth::guard('web')->attempt($request->only($login_type, 'password'), $remember_me)) {
            //return redirect()->intended($this->redirectPath());
            $request->session()->flash('alert-success', 'User was successfully login!');
            return redirect()->route('admin.dashboard');
        } else {
            $request->session()->flash('alert-danger', 'Invalid Credentials , Please try again.');
            return redirect()->route('admin-login');
        }
    }

    /**
     * @desc admin user list
     * @param  Request  $request
     * @return void
     */
    public function usersList(Request $request) {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        $users = User::whereNotNull('provider')->get();
        return view('admin.users.list', compact('users'));
    }

    /**
     * @desc admin user list by ajax request
     * @param  Request  $request
     * @return void
     */
    public function usersListbyAjax(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        DB::connection()->enableQueryLog();

        // Total records
        $totalRecords = User::select('count(*) as allcount')->whereNotNull('provider')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->whereNotNull('provider')->count();

        // Get records, also we have included search filter as well
        $matchThese = ['users.name', 'like', '%' . $searchValue . '%', 'users.name', 'like', '%' . $searchValue . '%'];
        $records = User::orderBy($columnName, $columnSortOrder)
            ->where(function($query) use ($searchValue){
                return $query
                ->where('users.name', 'like', '%' . $searchValue . '%')
                ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                ->orWhere('users.phone', 'like', '%' . $searchValue . '%');
            })
            ->whereNotNull('provider')
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $queries = DB::getQueryLog();
        //return dd($queries);

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "id"          => $record->id,
                "name"        => $record->name,
                "email"       => $record->email,
                "phone"       => $record->phone,
                "provider"    => $record->provider,
                "status"      => $record->status,
                "created_at"  => $record->created_at,
            );
        }

        $response = array(
            "draw"                  => intval($draw),
            "iTotalRecords"         => $totalRecords,
            "iTotalDisplayRecords"  => $totalRecordswithFilter,
            "aaData"                => $data_arr,
        );

        echo json_encode($response);
    }



    /**
     * @desc admin dashboard
     * @param  Request  $request
     * @return void
     */
    public function dashboard(Request $request) {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin-login');
        }
        return view('admin.users.dashboard');
    }


    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userEdit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $customMessages = [
            'name.regex' => 'Invalid format in User name. Only letters and space.'
        ];
        $request->validate([
            'name' => 'regex:/^[a-zA-Z ]*$/',
            'phone' => 'min:10|max:11|unique:users,phone,'.$user->id.',id',
            'email' => 'unique:users,email,'.$user->id.',id',
            'status' => 'required'
        ]);

        $user->name = $request->input( 'name' );
        $user->phone = $request->input( 'phone' );
        $user->gender_id = $request->input( 'gender' );
        $user->status = $request->input( 'status' );
        $user->save();
        $request->session()->flash('alert-success', 'User was successfully updated!');
        return redirect()->route('admin.users');
    }

     /**
     * Remove the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDelete(Request $request, $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            if ($user->trashed()) {
                //some logic
            }
            $request->session()->flash('alert-success', 'User was successfully deleted!');
        } catch(\Exception $e) {
            $request->session()->flash('alert-error', 'Unable to delete the user. Please try again!');
        }
        return redirect()->route('admin.users');
    }


    /**
    * @desc admin logout
     * @param  Request  $request
     * @return void
    */
    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->flash('success', 'User was successfullyly logged out!');
        return redirect()->route('admin-login');
    }

    /**
     * @desc admin login form
     * @param  Request  $request
     * @return void
     */
    public function accessdeny(Request $request) {
        return response()->json([
            'success' => false,
            'code' => 400,
            'message' => 'Access denied',
        ]);
    }
}
