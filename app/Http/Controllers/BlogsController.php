<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BlogsController extends Controller
{
    public function index(){
        return ['blogs' => Blogs::all()];
    }
    public function deleteBlog(Request $request) {
        Blogs::where('id',$request->id)->delete();
    }
    public function create(Request $request) {
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
    }

}
