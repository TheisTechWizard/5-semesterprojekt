<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function test_get_all_users_success()
    {
        // Create dummy courses
        $course = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();

        $courseArray = [$course, $course2, $course3];

        // Create dummy user with attached courses
        $user = User::factory()->hasAttached($courseArray)->create();
        Sanctum::actingAs(
            $user,
            ['*'],
        );

        // Make request using the route ->name()
        $response = $this->json('GET', route('getUsers'));

        // Expected assertions 
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data.0.courses');
        $response->assertExactJson(
            [
                "success" => true,
                "data" => [
                    [
                        "id" => $user->id,
                        "fname" => $user->fname,
                        "lname" => $user->lname,
                        "email" => $user->email,
                        "email_verified_at" => $user->email_verified_at,
                        "courses" => [
                            [
                                "id" => $course->id,
                                "name" => $course->name,
                                "description" => $course->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ],
                            [
                                "id" => $course2->id,
                                "name" => $course2->name,
                                "description" => $course2->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ],
                            [
                                "id" => $course3->id,
                                "name" => $course3->name,
                                "description" => $course3->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ]
                        ]
                    ],
                ]
            ]
        );
    }

    public function test_get_user_by_id_success()
    {
        // Create dummy courses
        $course = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();

        $courseArray = [$course, $course2, $course3];

        // Create dummy user with attached courses
        $user = User::factory()->hasAttached($courseArray)->create();

        User::factory()->count(3)->hasAttached(Course::factory()->count(3))->create();

        Sanctum::actingAs(
            $user,
            ['*'],
        );

        // Make request using the route ->name()
        $response = $this->json('GET', route('getUsersById', $user->id));

        // Expected assertions 
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data.0.courses');
        $response->assertExactJson(
            [
                "success" => true,
                "data" => [
                    [
                        "id" => $user->id,
                        "fname" => $user->fname,
                        "lname" => $user->lname,
                        "email" => $user->email,
                        "email_verified_at" => $user->email_verified_at,
                        "courses" => [
                            [
                                "id" => $course->id,
                                "name" => $course->name,
                                "description" => $course->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ],
                            [
                                "id" => $course2->id,
                                "name" => $course2->name,
                                "description" => $course2->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ],
                            [
                                "id" => $course3->id,
                                "name" => $course3->name,
                                "description" => $course3->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ]
                        ]
                    ],
                ]
            ]
        );
    }

    public function test_add_course_to_user_success()
    {
        // Create dummy courses
        $course = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();

        // Create dummy user with attached courses
        $user = User::factory()->create();

        User::factory()->count(3)->hasAttached(Course::factory()->count(3))->create();

        Sanctum::actingAs(
            $user,
            ['*'],
        );

        // Make request using the route ->name()
        $postResponse = $this->json(
            'POST',
            route('addCoursesToUser', $user->id),
            [
                'course_id' => $course->id
            ]
        );

        $postResponse2 = $this->json(
            'POST',
            route('addCoursesToUser', $user->id),
            [
                'course_id' => $course3->id
            ]
        );

        $getResponse = $this->json('GET', route('getUsersById', $user->id));

        // Expected assertions 

        $this->assertDatabaseHas('user_courses', [
            [
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id
                ],
                [
                    'user' => $user->id,
                    'course_id' => $course3->id,
                ]
            ]
        ]);

        $postResponse->assertStatus(200);
        $postResponse2->assertStatus(200);

        $getResponse->assertStatus(200);
        $getResponse->assertJsonCount(2, 'data.0.courses');
        $getResponse->assertExactJson(
            [
                "success" => true,
                "data" => [
                    [
                        "id" => $user->id,
                        "fname" => $user->fname,
                        "lname" => $user->lname,
                        "email" => $user->email,
                        "email_verified_at" => $user->email_verified_at,
                        "courses" => [
                            [
                                "id" => $course->id,
                                "name" => $course->name,
                                "description" => $course->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ],
                            [
                                "id" => $course3->id,
                                "name" => $course3->name,
                                "description" => $course3->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ]
                        ]
                    ],
                ]
            ]
        );
    }

    public function test_update_course_is_complete_success()
    {
        // Create dummy courses
        $course = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();

        $courseArray = [$course, $course2, $course3];

        // Create dummy user with attached courses
        $user = User::factory()->hasAttached($courseArray)->create();

        User::factory()->count(3)->hasAttached(Course::factory()->count(3))->create();

        Sanctum::actingAs(
            $user,
            ['*'],
        );

        // Make request using the route ->name()
        $putResponse = $this->json('PUT', route('updateCourseIsComplete', $user->id), [
            'course_id' => $course2->id,
            'isComplete' => true,
        ]);

        $putResponse->assertStatus(200);

        $response = $this->json('GET', route('getUsersById', $user->id));

        // Expected assertions 
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data.0.courses');
        $response->assertExactJson(
            [
                "success" => true,
                "data" => [
                    [
                        "id" => $user->id,
                        "fname" => $user->fname,
                        "lname" => $user->lname,
                        "email" => $user->email,
                        "email_verified_at" => $user->email_verified_at,
                        "courses" => [
                            [
                                "id" => $course->id,
                                "name" => $course->name,
                                "description" => $course->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ],
                            [
                                "id" => $course2->id,
                                "name" => $course2->name,
                                "description" => $course2->description,
                                "isCompleted" => 1,
                                "deadline_at" => null,
                            ],
                            [
                                "id" => $course3->id,
                                "name" => $course3->name,
                                "description" => $course3->description,
                                "isCompleted" => 0,
                                "deadline_at" => null,
                            ]
                        ]
                    ],
                ]
            ]
        );
    }
}
