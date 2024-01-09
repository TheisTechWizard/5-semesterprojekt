<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\GetCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Throwable;

class CourseController extends Controller
{
    public function getCourses(GetCourseRequest $request)
    {
        try {
            $validated = $request->validated();
            if ($validated) {
                $filteredCourses = $this->filterCoursesBySearch($validated, $request);
                return response()->json([
                    'success' => true,
                    'data' => $filteredCourses,
                ]);
            }

            $courses = Course::with('lessons.materials')->get();

            return response()->json([
                'success' => true,
                'data' => $courses,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function getCoursesByLoggedInUser(GetCourseRequest $request)
    {
        try {
            $validated = $request->validated();

            // dd($request);
            $courses = $request->user()->courses()->with('lessons.materials')->get();

            return response()->json([
                'success' => true,
                'data' => $courses
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function filterCoursesBySearch(array $validated)
    {
        try {
            $courses = Course::where('name', 'LIKE', "%{$validated['search_criteria']}%")
                ->with('lessons.materials')
                ->get();
            // $courses = Course::where('name', 'LIKE', "%{$validated['search_criteria']}%")
            //     ->with('lessons.materials')
            //     ->get();

            return $courses;
        } catch (Throwable $th) {
        }
    }

    public function getCourseById(int $course_id)
    {
        try {
            $courses = Course::where('id', $course_id)
                ->with('lessons.materials')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $courses
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function createCourse(CreateCourseRequest $request)
    {
        try {
            $validated = $request->validated();
            $course = new Course;
            $course->name = $validated['name'];
            $course->description = $validated['description'];

            $course->save();

            return response()->json([
                'success' => true,
                'message' => 'Successfully stored course in database',
                'course_id' => $course->id
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
