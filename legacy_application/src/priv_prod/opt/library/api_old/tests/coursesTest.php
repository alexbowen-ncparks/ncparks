<?php
class coursesTest extends Slim_Framework_TestCase {
    public function testGetCourses() {
        $this->get('/courses');
        $this->assertEquals(200, $this->response->status());
        //$this->assertEquals($this->app->config('version'), $this->response->body());
    }
}