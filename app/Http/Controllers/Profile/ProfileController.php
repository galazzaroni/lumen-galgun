<?php

namespace App\Http\Controllers\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Profile;

use Laravel\Lumen\Routing\Controller as BaseController;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = $request->input('user');
        $profile = Profile::where('user_id', $user)->get();

        if (is_null($profile)){
            return response()->json([
                'data' => ['message' => 'Profile not found']], 200);    
        }

        return response()->json([
            'data' => ['message' => 'Profile retrieved succesfully', 'profile' => $profile->toArray()]], 200);
    }
}
