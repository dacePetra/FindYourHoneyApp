<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
        $authUserId = (int) auth()->user()->id;

        // Find all matches (since 1 match is one row, two queries are made).

        $firstMatchedUserIds = DB::table('honey_matches')->where('first_user_id', $authUserId)
            ->pluck('second_user_id')->toArray();

        $secondMatchedUserIds = DB::table('honey_matches')->where('second_user_id', $authUserId)
            ->pluck('first_user_id')->toArray();

        $matchedUserIds =[...$firstMatchedUserIds, ... $secondMatchedUserIds];

        $matchedUsers = DB::table('users')->whereIn('id',  $matchedUserIds)->get();

        return view('matches', [
            'matchedUsers' =>  $matchedUsers
        ]);
    }

    public function revertMatch($id)
    {
        // Find and delete entry from likes table and from match table.

        $authUserId = (int)auth()->user()->id;
        $revertMatchUserId = (int)$id;

        // Find id of entry in like table
        $likeEntry = DB::table('likes')->where('user_id', '=', "{$authUserId}")
            ->where('liked_user_id', '=', "$revertMatchUserId")
            ->pluck('id')->toArray();

        // If there is not such an entry, redirect to 'page-not-found'
        if (count($likeEntry) == 0) {
            return redirect('/page-not-found');
        }

        // Delete entry form like table
        DB::table('likes')->where('id', '=', $likeEntry[0])->delete();

        // Find match entry in two ways, delete the one which exists,
        $matchEntryFirstWay = DB::table('honey_matches')->where('first_user_id', '=', "{$authUserId}")
            ->where('second_user_id', '=', "$revertMatchUserId")
            ->pluck('id')->toArray();

        if (count($matchEntryFirstWay) == 1) {
            DB::table('honey_matches')->where('id', '=', $matchEntryFirstWay[0])->delete();
            return redirect('/my-honey-matches');
        }

        $matchEntrySecondWay = DB::table('honey_matches')->where('second_user_id', '=', "{$authUserId}")
            ->where('first_user_id', '=', "$revertMatchUserId")
            ->pluck('id')->toArray();

        if (count($matchEntrySecondWay) == 1) {
            DB::table('honey_matches')->where('id', '=', $matchEntrySecondWay[0])->delete();
            return redirect('/my-honey-matches');
        }

        return redirect('/my-honey-matches');
    }
}
