<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Tag::query()->latest()->paginate();
       
        
        // OBJECT_TAGS . DOT . __FUNCTION__ ~ tags.index
        return view(OBJECT_TAGS . DOT . __FUNCTION__, compact(response()->json($data)));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(OBJECT_TAGS . DOT . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tableName = (new Tag())->getTable();
        $this->validate($request, [
            'name' => ['required', 'min:3', 'max:20', Rule::unique($tableName)],
            'img' => ['nullable', 'image', 'max:256']
        ]);

        try {
            $model = new Tag();

            $model->fill($request->except('img'));

            if ($request->hasFile('img')) {
                $model->img = upload_file(OBJECT_TAGS, $request->file('img'));
            }

            $model->save();

            return redirect()->route('tags.index')
                ->with('status', Response::HTTP_OK)
                ->with('msg', 'Thao tác thành công!');
        } catch (\Exception $exception) {
            Log::error('Exception', [$exception]);

            return back()
                ->with('status', Response::HTTP_BAD_REQUEST)
                ->with('msg', 'Thao tác thất bại!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $model)
    {
        return view(OBJECT_TAGS . DOT . __FUNCTION__, compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Tag $model)
    {
        $tableName = $model->getTable();
        $this->validate(\request(), [
            'name' => ['required', 'min:3', 'max:20', Rule::unique($tableName)->ignore($model->id)],
            'img' => ['nullable', 'image', 'max:256']
        ]);

        try {
            $model->fill(\request()->except('img'));

            $oldImg = $model->img;
            if (\request()->hasFile('img')) {
                $model->img = upload_file(OBJECT_TAGS, \request()->file('img'));
            }

            $model->save();

            delete_file($oldImg);

            return back()
                ->with('status', Response::HTTP_OK)
                ->with('msg', 'Thao tác thành công!');
        } catch (\Exception $exception) {
            Log::error('Exception', [$exception]);

            return back()
                ->with('status', Response::HTTP_BAD_REQUEST)
                ->with('msg', 'Thao tác thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();

            delete_file($tag->img);

            return back()
                ->with('status', Response::HTTP_OK)
                ->with('msg', 'Thao tác thành công!');
        } catch (\Exception $exception) {
            Log::error('Exception', [$exception]);

            return back()
                ->with('status', Response::HTTP_BAD_REQUEST)
                ->with('msg', 'Thao tác thất bại!');
        }
    }
}
