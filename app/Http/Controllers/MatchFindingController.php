<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MatchFindingController extends Controller
{
    public function find()
    {
        $authUserId = (int)auth()->user()->id;

        // In order to select random user id from array of user ids that can NOT be shown (authenticated user or already liked/matched user):
        // Make array ($unfitUserIds) of user ids who active user has already disliked or liked(includes matched) and add authenticated user id.

        $dislikedUserIds = DB::table('dislikes')->where('user_id', $authUserId)
            ->pluck('disliked_user_id')->toArray();

        $likedUserIds = DB::table('likes')->where('user_id', $authUserId)
            ->pluck('liked_user_id')->toArray();

        $unfitUserIds = [...$dislikedUserIds, ...$likedUserIds, $authUserId];

        // Get age range converted to birthday dates

        $interestedInAgeFrom = (int)DB::table('user_interests')->where('user_id', $authUserId)
            ->get()->pluck('age_from')->implode(',');

        $interestedInAgeTo = (int)DB::table('user_interests')->where('user_id', $authUserId)
            ->get()->pluck('age_to')->implode(',');

        $interestedInBirthdayFrom = (Carbon::now()->subYears($interestedInAgeFrom))->format('Y-m-d');
        $interestedInBirthdayTo = (Carbon::now()->subYears($interestedInAgeTo))->format('Y-m-d');

        // Get preference gender/both

        $interestedIn = DB::table('user_interests')->where('user_id', $authUserId)
            ->get()->pluck('interested_in')->implode(',');

        // Get list of user ids who match preferences

        if ($interestedIn == "both") {
            $interestedInUserIds = DB::table('user_profiles')
                ->whereBetween('birthday', [$interestedInBirthdayTo, $interestedInBirthdayFrom])
                ->get()->pluck('user_id')->toArray();
        } else {
            $interestedInUserIds = DB::table('user_profiles')
                ->where('gender', $interestedIn)
                ->whereBetween('birthday', [$interestedInBirthdayTo, $interestedInBirthdayFrom])
                ->get()->pluck('user_id')->toArray();
        }

        // Loop through users who match active user's preferences and get rid of those who are in $unfitUserIds array

        $suitableUserIds = [];
        foreach ($interestedInUserIds as $interestedInUserId) {
            if (!in_array($interestedInUserId, $unfitUserIds)) {
                $suitableUserIds [] = $interestedInUserId;
            }
        }

        // In order to check weather random user's preferences match active users profile
        // Get active users gender and age

        $authUsersGender = DB::table('user_profiles')->where('user_id', $authUserId)
            ->get()->pluck('gender')->implode(',');

        $authUsersBirthday = DB::table('user_profiles')->where('user_id', $authUserId)
            ->get()->pluck('birthday')->implode(',');

        $authUsersAge = Carbon::parse($authUsersBirthday)->diff(Carbon::now())->y;

        // while loop will loop until we find random user (break), who's preferences match active user's profile

        while (true) {

            // if there is no users to select from, return redirect to '/cannot-find'

            if (count($suitableUserIds) === 0) {
                return redirect('/cannot-find');
            }

            // Select random user id from $suitableUserIds array
            $randomKeyFromSuitableUserIds = array_rand($suitableUserIds, 1);
            $randomUsersId = $suitableUserIds[$randomKeyFromSuitableUserIds];

            // Get random user's preferences

            $randomUsersGenderPreference = DB::table('user_interests')->where('user_id', $randomUsersId)
                ->get()->pluck('interested_in')->implode(',');

            $randomUsersAgeFromPreference = DB::table('user_interests')->where('user_id', $randomUsersId)
                ->get()->pluck('age_from')->implode(',');

            $randomUsersAgeToPreference = DB::table('user_interests')->where('user_id', $randomUsersId)
                ->get()->pluck('age_to')->implode(',');

            // Check weather random user's preferences match active users profile,
            // if not then remove this random user's id from $suitableUserIds and select another random user's id

            if ($randomUsersGenderPreference === "both" || $randomUsersGenderPreference === $authUsersGender &&
                $authUsersAge >= $randomUsersAgeFromPreference && $authUsersAge <= $randomUsersAgeToPreference) {
                break;
            } else {
                unset($suitableUserIds[array_search($randomUsersId, $suitableUserIds)]);
            }
        }

        // get info to show about the random user who matches active users preferences and the other way around

        $user = (DB::select("SELECT * FROM users WHERE id = {$randomUsersId}"))[0];
        $userProfile = UserProfile::where('id', $randomUsersId)->first();
        $gallery = DB::table('pictures')->where('user_id', $randomUsersId)
            ->pluck('picture')->toArray();

        return view('find', [
            'userProfile' => $userProfile,
            'user' => $user,
            'gallery' => $gallery
        ]);

    }
}
