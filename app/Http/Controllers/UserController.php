<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCoursesToUserRequest;
use App\Http\Requests\GetUsersRequest;
use App\Http\Requests\UpdateCourseIsCompleteRequest;
use App\Mail\NotifyUserOfNewAssignments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Throwable;

class UserController extends Controller
{
    public function getUsers(GetUsersRequest $request)
    {
        // if (!Auth::user()) {
        //     return response()->json(['error' => 'Unorthorized bitch'], 401);
        // }

        try {
            $validated = $request->validated();
            if ($validated) {
                $filteredUsers = $this->filterUsersBySearch($validated)
                    ->with(['courses' => function ($q) {
                        $q->select()->addSelect('courses.id');
                    }])
                    ->get();
                return response()->json([
                    'success' => true,
                    'data' => $filteredUsers,
                ]);
            }

            $users = User::with('courses')
                ->with(['courses' => function ($q) {
                    $q->select()->addSelect('courses.id');
                }])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function filterUsersBySearch(array $validated)
    {
        try {
            $users = User::where('fname', 'LIKE', "%{$validated['search_criteria']}%")
                ->orWhere('lname', 'LIKE', "%{$validated['search_criteria']}%")
                ->orWhere('email', 'LIKE', "%{$validated['search_criteria']}%");

            return $users;
        } catch (Throwable $th) {
        }
    }

    public function getUsersById(int $user_id)
    {
        try {
            $users = User::where('id', $user_id)
                ->with(['courses' => function ($q) {
                    $q->select()->addSelect('courses.id');
                }])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function addCoursesToUser(int $user_id, AddCoursesToUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = User::findOrFail($user_id);
            $user->courses()->attach($validated['course_id']);

            // dd($user->email);
            // Mail::to($user->email)->send(new NotifyUserOfNewAssignments());

            return response()->json([
                'success' => true,
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $th,
            ]);
        }
    }

    public function updateCourseIsComplete(int $user_id, UpdateCourseIsCompleteRequest $request)
    {
        try {
            $validated = $request->validated();
            $isComplete = ($validated['isComplete']) ? 1 : 0;

            $user = User::findOrFail($user_id);
            $user->courses()->updateExistingPivot(
                $validated['course_id'],
                ['isCompleted' => $isComplete]
            );

            return response()->json([
                'success' => true,
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
