<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialRequest;
use App\Models\Lesson;
use App\Models\Material;
use Illuminate\Http\Request;
use Throwable;

class MaterialController extends Controller
{
    public function createMaterials(CreateMaterialRequest $request)
    {
        try {
            $validated = $request->validated();

            $lesson = Lesson::findOrFail($request['lesson_id']);

            $material = new Material;
            $material->name = $validated['name'];
            $material->type = $validated['type'];
            $material->description = $validated['description'];

            $lesson->materials()->save($material);

            return response()->json([
                'success' => true,
                'message' => 'Successfully stored material in database'
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }
}
