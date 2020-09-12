<?php

use App\Models\blogs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user()->name;
});
Route::middleware('auth:api')->group(function () {
    Route::get('/blogs', function () {
        return ['blogs' => Blogs::all()];
    });
    Route::post('/blog/delete', function (Request $request) {
        Blogs::where('id',$request->id)->delete();
    });

    Route::post('/blog/create', function (Request $request) {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $folder = '/blogs/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $name = !is_null($name) ? $name : Str::random(25);

            Image::make($image)->save(public_path($folder . $name));
            Blogs::create([
                'title' => $request->name,
                'description' => $request->name,
                'image' => $name,
            ]);
            return ['status' => 'success'];
        }
        return ['status' => 'failed'];
    });

});

