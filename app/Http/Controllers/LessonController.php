<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLessonRequest;
use App\Http\Requests\GetLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Throwable;

class LessonController extends Controller
{
    public function getLessons(GetLessonRequest $request)
    {
        try {
            $validated = $request->validated();
            if ($validated) {
                $filteredLessons = $this->filterLessonsBySearch($validated);
                return response()->json([
                    'success' => true,
                    'data' => $filteredLessons,
                ]);
            }
            $lessons = Lesson::with('materials')->get();

            return response()->json([
                'success' => true,
                'data' => $lessons,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function filterLessonsBySearch(array $validated)
    {
        try {
            $lessons = Lesson::where('name', 'LIKE', "%{$validated['search_criteria']}%")
                ->with('materials')
                ->get();

            return $lessons;
        } catch (Throwable $th) {
        }
    }

    public function getLessonById(int $lesson_id)
    {
        try {
            $lessons = Lesson::where('id', $lesson_id)
                ->with('materials')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $lessons
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function createLessons(CreateLessonRequest $request)
    {
        try {
            $validated = $request->validated();

            $course = Course::findOrFail($request['course_id']);

            $lesson = new Lesson;
            $lesson->name = $validated['name'];
            // $lesson->course_id = $validated['course_id'];

            $course->lessons()->save($lesson);

            return response()->json([
                'success' => true,
                'message' => 'Successfully stored lesson in database'
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
