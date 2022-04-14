<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DislikeController extends Controller
{
    public function index()
    {
        $authUserId = (int) auth()->user()->id;

        // Find all likes active user has made

        $dislikedUserIds = DB::table('dislikes')->where('user_id', $authUserId)
            ->pluck('disliked_user_id')->toArray();

        $dislikedUsers = DB::table('users')->whereIn('id',  $dislikedUserIds)->get();

        return view('dislikes', [
            'dislikedUsers' =>  $dislikedUsers
        ]);
    }

    public function dislike($id)
    {
        DB::table('dislikes')->insert([
            'user_id' => (int) auth()->user()->id,
            'disliked_user_id' => (int)$id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect(RouteServiceProvider::HOME);
    }

    public function revertDislike($id)
    {
        // Find and delete entry from dislikes table.

        $authUserId = (int)auth()->user()->id;
        $revertDislikeUserId = (int)$id;

        // Find id of entry in dislike table
        $dislikeEntry = DB::table('dislikes')->where('user_id', '=', "{$authUserId}")
            ->where('disliked_user_id', '=', "$revertDislikeUserId")
            ->pluck('id')->toArray();

        // If there is not such an entry, redirect to 'page-not-found'
        if (count($dislikeEntry) == 0) {
            return redirect('/page-not-found');
        }

        // Delete entry form dislike table
        DB::table('dislikes')->where('id', '=', $dislikeEntry[0])->delete();

        return redirect('/my-dislikes');
    }
}
