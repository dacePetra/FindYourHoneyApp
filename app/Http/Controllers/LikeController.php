<?php

namespace App\Http\Controllers;

use App\Mail\MatchMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LikeController extends Controller
{
    public function index()
    {
        $authUserId = (int)auth()->user()->id;

        // Find all likes active user has made

        $likedUserIds = DB::table('likes')->where('user_id', $authUserId)
            ->pluck('liked_user_id')->toArray();

        $likedUsers = DB::table('users')->whereIn('id', $likedUserIds)->get();

        return view('likes', [
            'likedUsers' => $likedUsers
        ]);
    }

    public function like($id)
    {
        // Check if liked user has already liked active user.
        // If there is this entry, then add liked entry the other way around in likes table
        // and add entry to hone honey-matches table.

        $authUserId = (int)auth()->user()->id;
        $likedUserId = (int)$id;

        $mutualLikes = DB::select(
            "SELECT id FROM likes WHERE user_id = :user_id AND liked_user_id = :liked_user_id "
            , ['user_id' => $likedUserId, 'liked_user_id' => $authUserId]);

        if (count($mutualLikes) != 0) {
            // there is a match
            DB::table('honey_matches')->insert([
                'first_user_id' => $likedUserId,
                'second_user_id' => $authUserId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            //send email to both match users
            $matchedUsers = DB::table('users')->whereIn('id',  [$authUserId, $likedUserId])->pluck('email')->toArray();
            Mail::to($matchedUsers[0])->send(new MatchMail());
            Mail::to($matchedUsers[1])->send(new MatchMail());
        }

        DB::table('likes')->insert([
            'user_id' => $authUserId,
            'liked_user_id' => $likedUserId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect(RouteServiceProvider::HOME);
    }

    public function revertLike($id)
    {
        // Find and delete entry from likes table.
        // If there was a match then delete entry from match table.

        $authUserId = (int)auth()->user()->id;
        $revertLikeUserId = (int)$id;

        // Find id of entry in like table
        $likeEntry = DB::table('likes')->where('user_id', '=', "{$authUserId}")
            ->where('liked_user_id', '=', "$revertLikeUserId")
            ->pluck('id')->toArray();

        // If there is not such an entry, redirect to 'page-not-found'
        if (count($likeEntry) == 0) {
            return redirect('/page-not-found');
        }

        // Delete entry form like table
        DB::table('likes')->where('id', '=', $likeEntry[0])->delete();

        // Check for match entry in two ways, delete the one which exists,
        $matchEntryFirstWay = DB::table('honey_matches')->where('first_user_id', '=', "{$authUserId}")
            ->where('second_user_id', '=', "$revertLikeUserId")
            ->pluck('id')->toArray();

        if (count($matchEntryFirstWay) == 1) {
            DB::table('honey_matches')->where('id', '=', $matchEntryFirstWay[0])->delete();
            return redirect('/my-likes');
        }

        $matchEntrySecondWay = DB::table('honey_matches')->where('second_user_id', '=', "{$authUserId}")
            ->where('first_user_id', '=', "$revertLikeUserId")
            ->pluck('id')->toArray();

        if (count($matchEntrySecondWay) == 1) {
            DB::table('honey_matches')->where('id', '=', $matchEntrySecondWay[0])->delete();
            return redirect('/my-likes');
        }

        return redirect('/my-likes');
    }
}
