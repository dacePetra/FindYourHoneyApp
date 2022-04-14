<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInterests;
use App\Models\UserProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }

    /** Handle an incoming registration request.
     * @throws \Illuminate\Validation\ValidationException */

    public function store(Request $request)
    {
        $adultFromDate = now()->subYears(18)->format('Y-m-d');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date', 'max:255', 'before_or_equal:' . $adultFromDate],
            'interested_in' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $pathOriginalPicture = $request->file('picture')->store('pictures/'.$user->id,['disk' => 'public']);
        $picture = Image::make($request->file('picture'))->resize(600, 400);
        $picture->save('storage/'.$request->file('picture')->store('pictures/'.$user->id.'/small',['disk' => 'public']));
        $pathPicture = explode("/", $picture->basePath());
        unset($pathPicture[0]);
        $pathPicture = implode("/", $pathPicture);

        UserProfile::create([
            'user_id' => $user->id,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'original_picture' => $pathOriginalPicture,
            'picture' => $pathPicture,
            'location' => $request->location,
            'about' => $request->about
        ]);

        UserInterests::create([
            'user_id' => $user->id,
            'interested_in' => $request->interested_in,
            'age_from' => 18, // when registering the default age_from is 18, when logged in, age range can be changed
            'age_to' => 100 // when registering the default age_from is 100, when logged in, age range can be changed
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


}
