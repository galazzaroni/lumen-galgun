<?php

namespace App\Http\Controllers\Profile;
use App\Http\Controllers\Controller;
use App\Http\Controllers\S3\S3Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        $profile = User::where('id', $user)->get();

        if ($profile->isEmpty()){
            return response()->json(['error' => 'Profile not found'], 404);    
        }

        /*return response()->json([
            'data' => ['message' => 'Profile retrieved succesfully', 'profile' => $profile->toArray()]], 200);*/
        return response()->json($profile, 200);
    }

    public function addProfile(Request $request)
    {
        $input = $request->all();

        if (Profile::where('user_id', $input['user'])->exists()){
            $user = Profile::where('user_id', $input['user']);
        
            /** valido el tipo de image */
            if (strpos($input['image'], ';base64') !== false) {
                $result = S3Controller::store_64($input['image']);
                $s3 = json_decode($result->getContent(), true);
            } else {
                $result = S3Controller::store_file($input['image']);
                $s3 = json_decode($result->getContent(), true);
            }
            
            $user->update([
                'image' => $s3['url'],
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json(['message' => 'Profile Updated'], 200);
        }
        
        

        
    }
}
