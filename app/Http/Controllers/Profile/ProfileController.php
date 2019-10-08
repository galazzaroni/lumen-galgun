<?php

namespace App\Http\Controllers\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;
use App\Profile;
use App\Place;
use Illuminate\Support\Facades\DB;

use Laravel\Lumen\Routing\Controller as BaseController;

class ProfileController extends Controller
{
    public function profileByID(Request $request)
    {
        $user = $request->input('user');
        
        //$profile = Profile::where('user_id', $user)->get();
        //$profile = User::find($user)->profile;
        //$profile = User::w('user_id', $user)->pluck('name')->unique()->first();
        $profile = DB::table('users')
                    ->select('users.name', 'users.lastname', 'users.email', 'profiles.image')
                    ->join('profiles', 'profiles.user_id', '=', 'users.id')
                    ->get();

        $place = Place::find(1);
        //$data = $profile->merge(['place' =>$place->toArray()]);
        $data = array_merge(['profile' => $profile], ['place' => $place]);

        if (is_null($profile)){
            return response()->json([
                'data' => ['message' => 'Profile not found']], 200);    
        }

        return response()->json([
            //'data' => ['message' => 'Profile retrieved succesfully', $data]], 200);
            //'data' => ['message' => 'Profile retrieved succesfully', 'profile' => $profile]], 200);
            'data' => $data], 200);
    }
}
