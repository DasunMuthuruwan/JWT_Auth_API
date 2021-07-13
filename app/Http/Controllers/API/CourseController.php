<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // COURSE ENROLMENT API - POST REQUEST
    public function courseEnrolment(Request $request){

        // VALIDATION
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'total_videos' => 'required|numeric'
        ]);

        // SAVE DATA
        $course = new Course();

        $course->title = $request->title;
        $course->description = $request->description;
        $course->user_id = auth()->user()->id;
        $course->total_videos = $request->total_videos;

        $course->save();

        // SEND RESPONSE
        return response()->json([
            'status' => 1,
            'message' => 'Course enrollment successfully'
        ]);

    }

    // TOTAL COURSES API - GET REQUEST
    public function totalCourses(){

        // GET LOGIN USER
        $login_user = auth()->user();

        // GET NUMBER OF COURSES
        $total_courses = count($login_user->courses);

        // SEND RESPONSE
        if($total_courses > 0){
            return response()->json([
                'status' => 1,
                'message' => 'Get number of courses',
                'courses' => $total_courses
            ]);
        }

         return response()->json([
             'status' => 0,
             'message' => 'Courses not found'
         ]);

    }

    // DELETE COURSE API - GET REQUEST
    public function deleteCourse($id){
        // GET LOGIN USER
        $user = auth()->user();

        // FIND COURSE EXISTS
        $course_exists = Course::where(['user_id' => $user->id, 'id' => $id])->exists();

        // DELETE & SEND RESPONSE
        if($course_exists){
            Course::where(['user_id' => $user->id, 'id' => $id])->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Course deleted successfully'
            ]);
        }
        return response()->json([
            'status' => 0,
            'message' => 'Course not found'
        ],404);
    }
}
