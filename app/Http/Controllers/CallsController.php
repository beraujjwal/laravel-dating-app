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

use App\Models\Call;

class CallsController extends Controller
{
    protected $table = 'calls';

    /**
     * @desc calls list
     * @param  Request  $request
     * @return void
     */
    public function allCallList(Request $request)  {
        try {
            $userId = $request->user()->id;
            //DB::connection()->enableQueryLog();
            $call = Call::whereHas('caller', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->orWhereHas('receiver', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->with(['caller', 'receiver'])->get();
            //$queries = DB::getQueryLog();
            //return dd($queries);

            return $this->sendWithDataResponse($call, 'Your calls list.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user call request send
     * @param  Request  $request
     * @return void
     */
    public function called(Request $request)  {
        DB::beginTransaction();
        try {
            $rules = [
                'receiver_id'   => 'required|numeric|exists:users,id',
                'started_at'    => 'required|date',
                'ended_at'      => 'required|date',
                'status'        => 'required|boolean',
            ];

            $validator = Validator::make($request->json()->all(), $rules);
            if($validator->fails()){
                $errors = [];
                foreach ($validator->errors()->getMessages() as $item) {
                    array_push($errors, $item);
                }
                
                return $this->sendError($errors, 'Invalid request sent');
    
            }

            $call = Call::create([
                'caller_id' => $request->user()->id,
                'receiver_id' => $request->input('receiver_id'),
                'started_at' => $request->input('started_at'),
                'ended_at' => $request->input('ended_at'),
                'status' => $request->input('status')
            ]);

            /*$call = new Call;
            $call->requested_at = Carbon::now();
            $call->status = false;
            $call->caller_id = $request->user()->id;
            $call->receiver_id = $request->input( 'receiver_id' );
            $call->save();*/            

            DB::commit();
            return $this->sendResponse($call, 'Your request has been sent successfully!.');
        } catch (Exception $ex) {
            DB::rollback();
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user call request accept
     * @param  Request  $request
     * @return void
     */
    public function receivedCallList(Request $request)  {
        
        try {
            $userId = $request->user()->id;
            //DB::connection()->enableQueryLog();
            $call = Call::whereHas('receiver', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', true);
            })->with(['caller', 'receiver'])->get();
            //$queries = DB::getQueryLog();
            //return dd($queries);  
            
            return $this->sendWithDataResponse($call, 'Your all received call list.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user call request sent
     * @param  Request  $request
     * @return void
     */
    public function dialedCallList(Request $request)  {
        
        try {
            $userId = $request->user()->id;
            //DB::connection()->enableQueryLog();
            $call = Call::whereHas('caller', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->with(['caller', 'receiver'])->get();
            //$queries = DB::getQueryLog();
            //return dd($queries);

            return $this->sendWithDataResponse($call, 'Your all dialed call list.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->dbExceptionHandle($ex);
        }
    }

    /**
     * @desc user call request received
     * @param  Request  $request
     * @return void
     */
    public function missedCallList(Request $request)  {
        try {
            $userId = $request->user()->id;
            //DB::connection()->enableQueryLog();
            $call = Call::whereHas('receiver', function ($query) use ($userId) {
                $query->where('id', $userId)->where('status', false);
            })->with(['caller', 'receiver'])->get();
            //$queries = DB::getQueryLog();
            //return dd($queries);  
            
            return $this->sendWithDataResponse($call, 'Your all missed call list.');
        } catch (Exception $ex) {
            return $this->exceptionHandle($ex);
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->dbExceptionHandle($ex);
        }
    }
}
