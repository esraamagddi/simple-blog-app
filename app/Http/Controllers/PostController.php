<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::where('user_id', Auth::id())
        ->with('tags')
        ->orderBy('pinned', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    return PostResource::collection($posts);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'cover_image' => 'required|image',
            'pinned' => 'required|boolean',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'pinned' => $request->pinned,
        ]);

        $post->addMediaFromRequest('cover_image')->toMediaCollection('cover_images');

        $post->tags()->attach($request->tags);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $post = Post::where('user_id', Auth::id())->with('tags')->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return new PostResource($post);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::where('user_id', Auth::id(),)->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'cover_image' => 'nullable|image',
            'pinned' => 'required|boolean',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'pinned' => $request->pinned,
        ]);

        if ($request->hasFile('cover_image')) {
            $post->clearMediaCollection('cover_images');
            $post->addMediaFromRequest('cover_image')->toMediaCollection('cover_images');
        }

        // Sync tags
        $post->tags()->sync($request->tags);

        return new PostResource($post);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $post = Post::where('user_id', Auth::id())->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }

    public function deleted()
    {
        $posts = Post::onlyTrashed()
            ->where('user_id', Auth::id())
            ->with('tags')
            ->orderBy('pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();


        return PostResource::collection($posts);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()
            ->where('user_id', Auth::id())
            ->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->restore();

        return response()->json(['message' => 'Post restored successfully'], 200);

    }



}
