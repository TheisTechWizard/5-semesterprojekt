<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Laravel\Sanctum\Sanctum;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_expected_courses_as_authenticated_user_expect_200()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
        );

        // Create dummy courses
        $course = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();
        $course4 = Course::factory()->create();

        // Make request using the route ->name()
        $response = $this->json('GET', route('getCourses'));

        // Expected assertions 
        $response->assertStatus(200);
        $response->assertJsonCount(4, 'data');
        $response->assertExactJson(
            [
                "success" => true,
                "data" => [
                    [
                        "id" => $course->id,
                        "name" => $course->name,
                        "description" => $course->description,
                        "lessons" => []
                    ],
                    [
                        "id" => $course2->id,
                        "name" => $course2->name,
                        "description" => $course2->description,
                        "lessons" => []
                    ],
                    [
                        "id" => $course3->id,
                        "name" => $course3->name,
                        "description" => $course3->description,
                        "lessons" => []
                    ],
                    [
                        "id" => $course4->id,
                        "name" => $course4->name,
                        "description" => $course4->description,
                        "lessons" => []
                    ]
                ]
            ]
        );
    }

    public function test_create_course_as_authenticated_user_success()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
        );

        $name = 'giga name';
        $description = 'omega description';

        $response = $this->json(
            'POST',
            route('createCourse'),
            [
                'name' => $name,
                'description' => $description,
            ]
        );

        $this->assertDatabaseHas('courses', [
            'name' => $name,
            'description' => $description,
        ]);

        $response->assertStatus(200);
    }

    public function test_get_course_by_id_as_authenticated_user_success()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
        );

        // Create dummy courses
        $course = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();

        // Make request using the route ->name()
        $response = $this->json('GET', route('getCourseById', $course3->id));

        // Expected assertions 
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertExactJson(
            [
                "success" => true,
                "data" => [
                    [
                        "id" => $course3->id,
                        "name" => $course3->name,
                        "description" => $course3->description,
                        "lessons" => []
                    ]
                ]
            ]
        );
    }

    public function test_get_courses_by_logged_in_user_success()
    {
        // Create dummy courses
        $course = Course::factory()->create();
        $course2 = Course::factory()->create();
        $course3 = Course::factory()->create();
        $course4 = Course::factory()->create();
        $course5 = Course::factory()->create();
        $course6 = Course::factory()->create();
        $course7 = Course::factory()->create();

        $courseArray = [$course, $course3, $course7];

        // Create dummy user with attached courses
        $user = User::factory()->hasAttached($courseArray)->create();
        Sanctum::actingAs(
            $user,
            ['*'],
        );

        // Make request using the route ->name()
        $response = $this->json('GET', route('getCoursesByLoggedInUser'));

        // Expected assertions 
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertExactJson(
            [
                "success" => true,
                "data" => [
                    [
                        "id" => $course->id,
                        "name" => $course->name,
                        "description" => $course->description,
                        "lessons" => []
                    ],
                    [
                        "id" => $course3->id,
                        "name" => $course3->name,
                        "description" => $course3->description,
                        "lessons" => []
                    ],
                    [
                        "id" => $course7->id,
                        "name" => $course7->name,
                        "description" => $course7->description,
                        "lessons" => []
                    ]
                ]
            ]
        );
    }
}
