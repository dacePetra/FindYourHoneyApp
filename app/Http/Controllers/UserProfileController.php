<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserProfileController extends Controller
{
    public function myProfile()
    {
        $authUserId = (int)auth()->user()->id;

        $user = (DB::select("SELECT name, surname, email FROM users WHERE id = {$authUserId}"))[0];
        $userProfile = UserProfile::where('id', $authUserId)->first();
        $gallery = DB::table('pictures')->where('user_id', $authUserId)
            ->pluck('picture')->toArray();

        return view('profile', [
            'userProfile' => $userProfile,
            'user' => $user,
            'gallery' => $gallery
        ]);
    }

    public function edit()
    {
        $authUserId = (int)auth()->user()->id;

        $user = (DB::select("SELECT name, surname, email FROM users WHERE id = {$authUserId}"))[0];
        $userProfile = (DB::select("SELECT user_id, gender, birthday, picture, location, about FROM user_profiles WHERE id = {$authUserId}"))[0];

        return view('edit', [
            'userProfile' => $userProfile,
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $authUserId = (int)auth()->user()->id;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        // update user info in users table
        User::where('id', $authUserId)
            ->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email
            ]);

        if ($request->file('picture') != null) {

            // save picture original and its smaller version, then get paths
            $pathOriginalPicture = $request->file('picture')->store('pictures/'.$authUserId,['disk' => 'public']);
            $picture = Image::make($request->file('picture'))->resize(600, 400);
            $picture->save('storage/'.$request->file('picture')->store('pictures/'.$authUserId.'/small',['disk' => 'public']));
            $pathPicture = explode("/", $picture->basePath());
            unset($pathPicture[0]);
            $pathPicture = implode("/", $pathPicture);

            // delete old profile picture and its original

            $oldOriginalPicturePath = (DB::table('user_profiles')->where('user_id', $authUserId)
                ->pluck('original_picture'))[0];
            unlink(public_path('storage/' . $oldOriginalPicturePath));

            $oldPicturePath = (DB::table('user_profiles')->where('user_id', $authUserId)
                ->pluck('picture'))[0];
            unlink(public_path('storage/' . $oldPicturePath));

            // update information in user_profiles table
            UserProfile::where('id', $authUserId)
                ->update([
                    'original_picture' => $pathOriginalPicture,
                    'picture' => $pathPicture,
                    'location' => $request->location,
                    'about' => $request->about
                ]);

            // delete all dislikes when new picture is uploaded
            DB::table('dislikes')->where('disliked_user_id', '=', $authUserId)->delete();

        } else {
            // update information in user_profiles table
            UserProfile::where('id', $authUserId)
                ->update([
                    'location' => $request->location,
                    'about' => $request->about
                ]);
        }

        return redirect('/my-profile');
    }

}
