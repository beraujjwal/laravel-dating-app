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

use App\Models\Friend;

class FriendsController extends Controller
{
    protected $table = 'friends';

    /**
     * @desc friends list
     * @param  Request  $request
     * @return void
     */
    public function friendsList(Request $request)  {
        try {
            $userId = $request->user()->id;
            DB::connection()->enableQueryLog();
            $friend = Friend::whereHas('sender', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->orWhereHas('receiver', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->with(['sender', 'receiver'])->get();
            $queries = DB::getQueryLog();
            //return dd($queries);

            return $this->sendWithDataResponse($friend, 'Your friends list.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user friend request send
     * @param  Request  $request
     * @return void
     */
    public function friendRequestSend(Request $request)  {
        DB::beginTransaction();
        try {
            $rules = [
                'friend_id'        => 'required|numeric|exists:users,id'
            ];

            $validator = Validator::make($request->json()->all(), $rules);
            if($validator->fails()){
                $errors = [];
                foreach ($validator->errors()->getMessages() as $item) {
                    array_push($errors, $item);
                }
                
                return $this->sendError($errors, 'Invalid request sent');
    
            }

            $friend = Friend::where('deleted_at', null)->where('user_id', $request->user()->id)->where('friend_id', $request->input( 'friend_id' ))->first();
            if($friend == null) {
                $friend = new Friend;
                $friend->requested_at = Carbon::now();
                $friend->status = false;                
            }
            $friend->user_id = $request->user()->id;
            $friend->friend_id = $request->input( 'friend_id' );
            $friend->save();

            

            DB::commit();
            return $this->sendResponse($friend, 'Your request has been sent successfully!.');
        } catch (Exception $ex) {
            DB::rollback();
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user friend request accept
     * @param  Request  $request
     * @return void
     */
    public function friendRequestAccept(Request $request)  {
        DB::beginTransaction();
        try {
            $rules = [
                'friend_id'        => 'required|numeric|exists:users,id'
            ];

            $validator = Validator::make($request->json()->all(), $rules);
            if($validator->fails()){
                $errors = [];
                foreach ($validator->errors()->getMessages() as $item) {
                    array_push($errors, $item);
                }
                
                return $this->sendError($errors, 'Invalid request sent');
    
            }

            $friend = Friend::where('status', 0)->where('deleted_at', null)->where('friend_id', $request->user()->id)->where('user_id', $request->input( 'friend_id' ))->first();
            if($friend == null) {
                return $this->sendError([], 'Invalid request sent.');
                
            }
            $friend->action_at = Carbon::now();
            $friend->status = 1;
            $friend->save();            

            DB::commit();
            return $this->sendResponse($friend, 'Your request has been sent successfully!.');
        } catch (Exception $ex) {
            DB::rollback();
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user friend request sent
     * @param  Request  $request
     * @return void
     */
    public function friendRequestSent(Request $request)  {
        
        try {
            $userId = $request->user()->id;
            //DB::connection()->enableQueryLog();
            $friend = Friend::whereHas('sender', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->with(['sender', 'receiver'])->get();
            //$queries = DB::getQueryLog();
            //return dd($queries);

            return $this->sendWithDataResponse($friend, 'Your sent friend request list.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user friend request received
     * @param  Request  $request
     * @return void
     */
    public function friendRequestReceived(Request $request)  {
        try {
            $userId = $request->user()->id;
            //DB::connection()->enableQueryLog();
            $friend = Friend::whereHas('receiver', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->with(['sender', 'receiver'])->get();
            //$queries = DB::getQueryLog();
            //return dd($queries);

            return $this->sendWithDataResponse($friend, 'Your received friend request list.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->dbExceptionHandle($ex);
        }
    }
}
