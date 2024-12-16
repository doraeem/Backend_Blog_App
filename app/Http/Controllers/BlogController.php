<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    // This method will return all blogs
    public function index(Request $request)
    {
        $blogs = Blog::orderBy('created_at', 'DESC');

        if (!empty($request->keyword)) {
            $blogs = $blogs->where('title', 'like', '%' . $request->keyword . '%');
        }

        $blogs = $blogs->get();

        return response()->json([
            'status' => true,
            'data' => $blogs
        ]);
    }

    // This method will return a specific blog for editing
    public function show($id)
    {
        $blog = Blog::find($id);

        if ($blog == null) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found.',
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $blog
        ]);
    }

    // This method will store a new blog
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'image_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'errors' => $validator->errors()
            ]);
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->shortDesc = $request->shortDesc;
        $blog->save();

        // Handle image upload
        $tempImage = TempImage::find($request->image_id);

        if ($tempImage != null) {
            $imageExtArray = explode('.', $tempImage->name);
            $ext = last($imageExtArray);
            $imageName = time() . '-' . $blog->id . '.' . $ext;

            $blog->image = $imageName;
            $blog->save();

            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $destPath = public_path('uploads/blogs/' . $imageName);

            File::copy($sourcePath, $destPath);

            $tempImage->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Blog added successfully.',
            'data' => $blog
        ]);
    }

    // This method will update an existing blog
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            // No need to validate 'image_id' as it's optional for update
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'errors' => $validator->errors()
            ]);
        }

        $blog = Blog::find($id);

        if ($blog == null) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found.',
            ]);
        }

        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->shortDesc = $request->shortDesc;

        // Handle image upload if a new image is provided
        if ($request->has('image_id') && $request->image_id != $blog->image_id) {
            $tempImage = TempImage::find($request->image_id);

            if ($tempImage != null) {
                $imageExtArray = explode('.', $tempImage->name);
                $ext = last($imageExtArray);
                $imageName = time() . '-' . $blog->id . '.' . $ext;

                $blog->image = $imageName;

                $sourcePath = public_path('uploads/temp/' . $tempImage->name);
                $destPath = public_path('uploads/blogs/' . $imageName);

                File::copy($sourcePath, $destPath);

                $tempImage->delete();
            }
        }

        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully.',
            'data' => $blog
        ]);
    }

    // This method will delete a blog
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if ($blog == null) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found.',
            ]);
        }

        // Delete blog image
        File::delete(public_path('uploads/blogs/' . $blog->image));

        $blog->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully.'
        ]);
    }
}
