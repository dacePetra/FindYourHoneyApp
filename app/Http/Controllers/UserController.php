<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show($id)
    {
        $user = (DB::select("SELECT name, surname FROM users WHERE id = :id", ['id' => (int)$id]))[0];
        $userProfile = UserProfile::where('id', (int)$id)->first();
        $gallery = DB::table('pictures')->where('user_id', (int)$id)
            ->pluck('picture')->toArray();

        return view('show', [
            'userProfile' => $userProfile,
            'user' => $user,
            'gallery' => $gallery
        ]);
    }
}
