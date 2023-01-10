<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../routes/users.php';
require __DIR__ . '/../routes/courses.php';
require __DIR__ . '/../routes/subjects.php';
require __DIR__ . '/../routes/instructors.php';
require __DIR__ . '/../routes/sections.php';
require __DIR__ . '/../routes/roster.php';
require __DIR__ . '/../routes/auth.php';
require __DIR__ . '/../middleware/tokenVerification.php';


$app = AppFactory::create();

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

// Auth group
$app->group('/auth', function ($app) {
    // Verifies a user login and returns their JWT token.
    $app->post('/token', function (Request $request, Response $response) {
        return getToken($request, $response);
    });
});

// User group
$app->group('/users', function ($app) {
    // Return the logged-in user's information
    $app->get('/me', function (Request $request, Response $response, array $args) {
        return getMe($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Gets all users
    $app->get('', function (Request $request, Response $response) {
        return getUsers($request, $response);
    })->setArgument("permissions", "ALL");

    // Gets all users who are a specified role
    $app->get('/role/{role}', function (Request $request, Response $response, array $args) {
        return getUsersInRole($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Gets a user
    $app->get('/{id}', function (Request $request, Response $response, array $args) {
        return getUser($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Gets a user by username
    $app->get('/user/{username}', function (Request $request, Response $response, array $args) {
        return getUserByName($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Adds a user
    $app->post('', function (Request $request, Response $response) {
        return addUser($request, $response);
    })->setArgument("permissions", "ADMIN");

    // Updates a user
    $app->put('/{id}', function (Request $request, Response $response, array $args) {
        return updateUser($request, $response, $args);
    })->setArgument("permissions", "ADMIN");

    // Deletes a user
    $app->delete('/{id}', function (Request $request, Response $response, array $args) {
        return deleteUser($request, $response, $args);
    })->setArgument("permissions", "ADMIN");
})->add($verifyToken);

// Course group
$app->group('/courses', function ($app) {
    // Gets all courses
    $app->get('', function (Request $request, Response $response) {
        return getCourses($request, $response);
    })->setArgument("permissions", "ALL");

    // Gets a course
    $app->get('/{id}', function (Request $request, Response $response, array $args) {
        return getCourse($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Adds a course
    $app->post('', function (Request $request, Response $response) {
        return addCourse($request, $response);
    })->setArgument("permissions", "ADMIN");

    // Updates a course
    $app->put('/{id}', function (Request $request, Response $response, array $args) {
        return updateCourse($request, $response, $args);
    })->setArgument("permissions", "ADMIN");

    // Deletes a course
    $app->delete('/{id}', function (Request $request, Response $response, array $args) {
        return deleteCourse($request, $response, $args);
    })->setArgument("permissions", "ADMIN");
})->add($verifyToken);

// Subjects group
$app->group('/subjects', function ($app) {

    // Gets all Subjects
    $app->get('', function (Request $request, Response $response) {
        return getSubjects($request, $response);
    })->setArgument("permissions", "ALL");

    // Gets an Subject
    $app->get('/{id}', function (Request $request, Response $response, array $args) {
        return getSubject($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Adds an Subject
    $app->post('', function (Request $request, Response $response) {
        return addSubject($request, $response);
    })->setArgument("permissions", "ADMIN");

    // Updates an Subject    
    $app->put('/{id}', function (Request $request, Response $response, array $args) {
        return updateSubject($request, $response, $args);
    })->setArgument("permissions", "ADMIN");
})->add($verifyToken);

// Instructor group
$app->group('/instructors', function ($app) {

    // Gets all instructors
    $app->get('', function (Request $request, Response $response) {
        return getInstructors($request, $response);
    })->setArgument("permissions", "ALL");

    // Gets an instructor
    $app->get('/{id}', function (Request $request, Response $response, array $args) {
        return getInstructor($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Gets an instructor by its user id
    $app->get('/user_id/{user_id}', function (Request $request, Response $response, array $args) {
        return getInstructorByUserID($request, $response, $args);
    })->setArgument("permissions", "ADMIN, INSTRUCTOR");

    // Gets an instructor's sections that they teach
    $app->get('/{id}/sections', function (Request $request, Response $response, array $args) {
        return getInstructorSections($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Adds an instructor
    $app->post('', function (Request $request, Response $response) {
        return addInstructor($request, $response);
    })->setArgument("permissions", "ADMIN");

    // Updates an instrucor
    $app->put('/{id}', function (Request $request, Response $response, array $args) {
        return updateInstructor($request, $response, $args);
    })->setArgument("permissions", "ADMIN, INSTRUCTOR");

    // Deletes an instructor
    $app->delete('/{id}', function (Request $request, Response $response, array $args) {
        return deleteInstructor($request, $response, $args);
    })->setArgument("permissions", "ADMIN");
})->add($verifyToken);

// Group for all sections
$app->group('/sections', function ($app) {

    // Gets all sections
    $app->get('', function (Request $request, Response $response) {
        return getSections($request, $response);
    })->setArgument("permissions", "ALL");
})->add($verifyToken);

// Section group which is attached to one specific Course
$app->group('/courses/{id}/sections', function ($app) {

    // Gets all sections
    $app->get('', function (Request $request, Response $response, array $args) {
        return getCourseSections($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Gets a section
    $app->get('/{sectionID}', function (Request $request, Response $response, array $args) {
        return getSection($request, $response, $args);
    })->setArgument("permissions", "ALL");

    // Adds a section
    $app->post('', function (Request $request, Response $response) {
        return addSection($request, $response);
    })->setArgument("permissions", "ADMIN, INSTRUCTOR");

    // Updates a section
    $app->put('/{sectionID}', function (Request $request, Response $response, array $args) {
        return updateSection($request, $response, $args);
    })->setArgument("permissions", "ADMIN, INSTRUCTOR");

    // Deletes a section
    $app->delete('/{sectionID}', function (Request $request, Response $response, array $args) {
        return deleteSection($request, $response, $args);
    })->setArgument("permissions", "ADMIN, INSTRUCTOR");
})->add($verifyToken);

// Rection group which is attached to one specific section
$app->group('/courses/{id}/sections/{section_id}/roster', function ($app) {

    // Gets the whole roster of the section tied to the request
    $app->get('', function (Request $request, Response $response, array $args) {
        return getRoster($request, $response, $args);
    })->setArgument("permissions", "ADMIN, INSTRUCTOR");;

    // Adds a user to the roster
    $app->post('', function (Request $request, Response $response) {
        return addUserToRoster($request, $response);
    })->setArgument("permissions", "ALL");;

    // Removes a User from the roster
    $app->delete('/{student_id}', function (Request $request, Response $response, array $args) {
        return removeUserFromRoster($request, $response, $args);
    })->setArgument("permissions", "ALL");;
})->add($verifyToken);

$app->run();
