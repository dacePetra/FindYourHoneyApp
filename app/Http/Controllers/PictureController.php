<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PictureController extends Controller
{
    public function index()
    {
        $authUserId = (int)auth()->user()->id;

        $gallery = DB::table('pictures')->where('user_id', $authUserId)
            ->pluck('picture')->toArray();

        return view('gallery', [
            'gallery' => $gallery
        ]);
    }

    public function manage()
    {
        $authUserId = (int)auth()->user()->id;

        $gallery = DB::table('pictures')->where('user_id', $authUserId)
            ->pluck('picture')->toArray();

        return view('manage',[
            'gallery' => $gallery
        ]);
    }

    public function upload()
    {
        $authUserId = (int)auth()->user()->id;

        $gallery = DB::table('pictures')->where('user_id', $authUserId)
            ->pluck('picture')->toArray();

        return view('upload',[
            'gallery' => $gallery
        ]);
    }

    public function store(Request $request)
    {
        $authUserId = (int)auth()->user()->id;

        if ($request->file('picture') != null) {
            $pathOriginalPicture = $request->file('picture')->store('pictures/'.$authUserId,['disk' => 'public']);
            $picture = Image::make($request->file('picture'))->resize(600, 400);
            $picture->save('storage/'.$request->file('picture')->store('pictures/'.$authUserId.'/small',['disk' => 'public']));
            $pathPicture = explode("/", $picture->basePath());
            unset($pathPicture[0]);
            $pathPicture = implode("/", $pathPicture);

            DB::table('pictures')->insert([
                'user_id' => $authUserId,
                'original_picture' => $pathOriginalPicture,
                'picture' => $pathPicture
            ]);
        }

        return redirect('/gallery');
    }

    public function delete(Request $request)
    {
        if($request->path1 != null) {
            // In pictures table find entry id and original picture's path of picture selected for delete
            $pictureEntry = (DB::select("SELECT id, original_picture FROM pictures WHERE picture = '{$request->path1}'"))[0];

            // Delete picture and its original
            unlink(public_path('storage/' . $request->path1));   // delete picture
            unlink(public_path('storage/' . $pictureEntry->original_picture));   // delete original picture

            // Remove entry from pictures table
            DB::table('pictures')->where('id', '=', $pictureEntry->id)->delete();
        }
        if($request->path2 != null) {
            // In pictures table find entry id and original picture's path of picture selected for delete
            $pictureEntry = (DB::select("SELECT id, original_picture FROM pictures WHERE picture = '{$request->path2}'"))[0];

            // Delete picture and its original
            unlink(public_path('storage/' . $request->path2));   // delete picture
            unlink(public_path('storage/' . $pictureEntry->original_picture));   // delete original picture

            // Remove entry from pictures table
            DB::table('pictures')->where('id', '=', $pictureEntry->id)->delete();
        }
        if($request->path3 != null) {
            // In pictures table find entry id and original picture's path of picture selected for delete
            $pictureEntry = (DB::select("SELECT id, original_picture FROM pictures WHERE picture = '{$request->path3}'"))[0];

            // Delete picture and its original
            unlink(public_path('storage/' . $request->path3));   // delete picture
            unlink(public_path('storage/' . $pictureEntry->original_picture));   // delete original picture

            // Remove entry from pictures table
            DB::table('pictures')->where('id', '=', $pictureEntry->id)->delete();
        }
        if($request->path4 != null) {
            // In pictures table find entry id and original picture's path of picture selected for delete
            $pictureEntry = (DB::select("SELECT id, original_picture FROM pictures WHERE picture = '{$request->path4}'"))[0];

            // Delete picture and its original
            unlink(public_path('storage/' . $request->path4));   // delete picture
            unlink(public_path('storage/' . $pictureEntry->original_picture));   // delete original picture

            // Remove entry from pictures table
            DB::table('pictures')->where('id', '=', $pictureEntry->id)->delete();
        }

        return redirect('/manage-gallery');
    }
}
