<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInterests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserInterestsController extends Controller
{
    public function preferences()
    {
        $authUserId = (int)auth()->user()->id;

        $userInterests = (DB::select("SELECT interested_in, age_from, age_to FROM user_interests WHERE id = :id", ['id' => $authUserId]))[0];

        return view('preferences', [
            'userInterests' => $userInterests
        ]);
    }

    public function store(Request $request)
    {
        $authUserId = (int)auth()->user()->id;

        if((int)$request->ageFrom >(int)$request->ageTo)
        {
            return redirect('/my-preferences');
        }

        UserInterests::where('id', $authUserId)
            ->update([
                'age_from' => (int)$request->ageFrom,
                'age_to' => (int)$request->ageTo,
                'interested_in' => $request->interestedIn
            ]);

        return redirect('/find-your-honey');
    }
}
