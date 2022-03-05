<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;

class GooglesController extends Controller
{
    
    /**
     * Return google Login url.
     *
     * @return void
     */
    public function googleLoginUrl(Request $request)
    {
        $object = new \stdClass();
        $object->url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return $this->sendResponse($object, 'Google login url');
    }
    
    /**
     * Create or update a user and login.
     *
     * @return void
     */
    public function googleLoginCallback(Request $request)
    {
        
        try {
    
            $auth = Socialite::driver('google')->stateless()->user();
            //$auth = Socialite::driver('google')->user();
            $user = null;

            $user = User::updateOrCreate([
                'provider_id'   => $auth->getId(),
            ],[
                'provider_id'   => $auth->getId(),
                'provider'      => 'google',
                'name'          => $auth->getName(),
                'email'         => $auth->getEmail(),
                'password'      => Hash::make($auth->getName().'@'.$auth->getId())
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
            'id' => $user->id,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
            ]);
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unauthorized - Can\'t parse the token: ' . $e->getMessage()
            ], 201);
        }
    }
}
