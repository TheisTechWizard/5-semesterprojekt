<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteAuthProtectionTest extends TestCase
{
    // Check that no route is usable as an unauthorized user

    public function test_get_users_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('GET', route('getUsers'));

        $response->assertStatus(401);
    }

    public function test_get_users_by_id_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('GET', route('getUsersById', 1));

        $response->assertStatus(401);
    }

    public function test_add_courses_to_user_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('POST', route('addCoursesToUser', 1));

        $response->assertStatus(401);
    }

    public function test_update_course_is_complete_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('PUT', route('updateCourseIsComplete', 1));

        $response->assertStatus(401);
    }

    public function test_get_courses_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('GET', route('getCourses'));

        $response->assertStatus(401);
    }

    public function test_get_courses_by_id_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('GET', route('getCourseById', 1));

        $response->assertStatus(401);
    }

    public function test_create_course_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('POST', route('createCourse'));

        $response->assertStatus(401);
    }

    public function test_get_courses_by_logged_in_user_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('GET', route('getCoursesByLoggedInUser'));

        $response->assertStatus(401);
    }

    public function test_get_lessons_as_unauthenticated_user_expect_401()
    {
        $response = $this->json('GET', route('getLessons'));

        $response->assertStatus(401);
    }
}
