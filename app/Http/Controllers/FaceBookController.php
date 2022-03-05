<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;

class FaceBookController extends Controller
{
   
   /**
    * Return facebook Login url.
    *
    * @return void
    */
   public function facebookLoginUrl(Request $request)
   {
      $object = new \stdClass();
      $object->url = Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
      return $this->sendResponse($object, 'Facebook login url');
   }
    
   public function facebookLoginCallback(Request $request)
   {
      try {
         $auth = Socialite::driver('facebook')->stateless()->user();
         //$auth = Socialite::driver('facebook')->user();

         $user = User::updateOrCreate([
            'provider_id' => $auth->getId(),
         ],[
            'provider_id'  => $auth->id,
            'provider'     => 'facebook',
            'name'         => $auth->getName(),
            'email'        => $auth->getEmail(),
            'password'     => Hash::make($auth->getName().'@'.$auth->getId())
               ]);

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
         return response()->json([
            'id' => $saveUser->id,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
            $tokenResult->token->expires_at
            )->toDateTimeString()
         ]);

         } catch (\Throwable $th) {
            return response()->json([
               'message' => 'Unauthorized - Can\'t parse the token: ' . $th->getMessage()
           ], 201);
         }
   }
}