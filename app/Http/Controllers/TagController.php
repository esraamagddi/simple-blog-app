<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return TagResource::collection(Tag::all());

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
            'name' => 'required|string|unique:tags,name|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }
        return new TagResource($tag);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:tags,name|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $tag->update([
            'name' => $request->name,
        ]);

        return new TagResource($tag);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        $tag->delete();

        return response()->json(['message' => 'Tag deleted successfully'], 200);

    }
}
