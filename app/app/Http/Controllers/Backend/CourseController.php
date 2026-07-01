<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use App\Models\Course_goal;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class CourseController extends Controller
{
    public function AllCourse(){
        $id = Auth::user()->id;
        $courses = Course::where('instructor_id', $id)->orderBy('id', 'desc')->get();
         return view('instructor.backend.course.all-course', compact('courses'));
    }

    public function AddCourse(){
        $categories = Category::latest()->get();
        return view('instructor.backend.course.add-course', compact('categories'));
    }

    public function GetSubCategory($category_id){
        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name', 'ASC')->get();
        return json_encode($subcat);
    }

    public function StoreCourse(Request $request){
         $request->validate([
            'course_name' => 'required',
            'course_title' => 'required',
            'course_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // <-- Add this
            'video' => 'required|mimes:mp4,mkv,avi,flv|max:10000',
        ]);

        // --- IMAGE UPLOAD ---
        $image = $request->file('course_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $thumbPath = 'images/instructor/course/thumbnail/'.$name_gen;

        $manager = new ImageManager(new Driver());
        $manager->read($image)
            ->resize(370, 246)
            ->save(public_path($thumbPath));

        $save_image_url = $thumbPath; // <-- Rename this

        // --- VIDEO UPLOAD ---
        $video = $request->file('video');
        $name_gen_vid = hexdec(uniqid()).'.'.$video->getClientOriginalExtension();
        $video->move(public_path('images/instructor/course/video/'), $name_gen_vid);
        $save_video_url = 'images/instructor/course/video/'.$name_gen_vid; // <-- Rename this

        $course_id = Course::insertGetId([
            'instructor_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'course_name' => $request->course_name,
            'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),
            'course_description' => $request->course_description,
            'label' => $request->label,
            'duration' => $request->duration,
            'resources' => $request->resources,
            'certificate' => $request->certificate,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'prerequisites' => $request->prerequisites,
            'bestseller' => $request->bestseller ? 1 : 0,
            'featured' => $request->featured ? 1 : 0,
            'highestrated' => $request->highestrated ? 1 : 0,
            'course_title' => $request->course_title,
            'course_image' => $save_image_url, // <-- Use image var
            'video' => $save_video_url,        // <-- Use video var
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);

        $goals = Count($request->course_goals);
        if($goals != NULL){
            for($i=0; $i<$goals; $i++){
                $gcount = new Course_goal();
                $gcount->course_id = $course_id;
                $gcount->goal_name = $request->course_goals[$i];
                $gcount->save();
            }
        }

        $notification = array(
            'message' => 'Course Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.course')->with($notification);

    }

    public function EditCourse($id){
        $course = Course::findOrFail($id);
        $categories = Category::latest()->get();
        $subcategories = SubCategory::where('category_id', $course->category_id)->get();
        $goals = Course_goal::where('course_id', $id)->get();
        return view('instructor.backend.course.edit-course', compact('course', 'categories', 'subcategories', 'goals'));
    }

    public function UpdateCourse(Request $request){
        $cid = $request->course_id;
        $course = Course::findOrFail($cid);

        $request->validate([
            'course_name' => 'required',
            'course_title' => 'required',
            'course_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mkv,avi,flv|max:10000',
        ]);

        // --- OPTIONAL IMAGE UPDATE ---
        $save_image_url = $course->course_image;
        if ($request->hasFile('course_image')) {
            $image = $request->file('course_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $thumbPath = 'images/instructor/course/thumbnail/'.$name_gen;

            // Resize and save new image
            $manager = new ImageManager(new Driver());
            $manager->read($image)
                ->resize(370, 246)
                ->save(public_path($thumbPath));

            // Delete old image if exists
            if ($course->course_image && file_exists(public_path($course->course_image))) {
                @unlink(public_path($course->course_image));
            }
            $save_image_url = $thumbPath;
        }

        // --- OPTIONAL VIDEO UPDATE ---
        $save_video_url = $course->video;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $name_gen_vid = hexdec(uniqid()).'.'.$video->getClientOriginalExtension();
            $videoPath = 'images/instructor/course/video/'.$name_gen_vid;
            $video->move(public_path('images/instructor/course/video/'), $name_gen_vid);

            // Delete old video if exists
            if ($course->video && file_exists(public_path($course->video))) {
                @unlink(public_path($course->video));
            }
            $save_video_url = $videoPath;
        }

        // Update Course Record
        $course->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'course_name' => $request->course_name,
            'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),
            'course_description' => $request->course_description,
            'label' => $request->label,
            'duration' => $request->duration,
            'resources' => $request->resources,
            'certificate' => $request->certificate,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'prerequisites' => $request->prerequisites,
            'bestseller' => $request->bestseller ? 1 : 0,
            'featured' => $request->featured ? 1 : 0,
            'highestrated' => $request->highestrated ? 1 : 0,
            'course_title' => $request->course_title,
            'course_image' => $save_image_url,
            'video' => $save_video_url,
            'updated_at' => Carbon::now(),
        ]);

        // --- UPDATE COURSE GOALS ---
        // Delete old goals
        Course_goal::where('course_id', $cid)->delete();

        // Save new goals
        if ($request->course_goals && count($request->course_goals) > 0) {
            foreach ($request->course_goals as $goal_name) {
                if ($goal_name != NULL) {
                    $gcount = new Course_goal();
                    $gcount->course_id = $cid;
                    $gcount->goal_name = $goal_name;
                    $gcount->save();
                }
            }
        }

        $notification = array(
            'message' => 'Course Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.course')->with($notification);
    }

    public function DeleteCourse($id){
        $course = Course::findOrFail($id);

        // Delete physical files
        if ($course->course_image && file_exists(public_path($course->course_image))) {
            @unlink(public_path($course->course_image));
        }
        if ($course->video && file_exists(public_path($course->video))) {
            @unlink(public_path($course->video));
        }

        // Delete related course goals
        Course_goal::where('course_id', $id)->delete();

        // Delete the course
        $course->delete();

        $notification = array(
            'message' => 'Course Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AddCourseLecture($id){
        $course = Course::findOrFail($id);
        $section = CourseSection::where('course_id', $id)->orderBy('id', 'asc')->get();
        return view('instructor.backend.course.lecture.add-course-lecture', compact('course', 'section'));
    }

    public function AddCourseSection(Request $request){
        $cid = $request->course_id;
        CourseSection::insert([
            'course_id' => $cid,
            'section_title' => $request->section_title,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Course Section Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function SaveLecture(Request $request){
        $lecture = new CourseLecture();
        $lecture->course_id = $request->course_id;
        $lecture->section_id = $request->section_id;
        $lecture->lecture_title = $request->lecture_title;
        $lecture->url = $request->lecture_url;
        $lecture->content = $request->content;
        $lecture->save();

        return response()->json(['success' => 'Lecture saved successfully']);
    }

    public function EditLecture($id){
        $clecture = CourseLecture::find($id);
        return view('instructor.backend.course.lecture.edit-course-lecture', compact('clecture'));
    }

    public function UpdateLecture(Request $request){
        $lecture_id = $request->id;
        CourseLecture::findOrFail($lecture_id)->update([
            'lecture_title' => $request->lecture_title,
            'url' => $request->lecture_url,
            'content' => $request->content,
        ]);

        $notification = array(
            'message' => 'Course Lecture Updated Successfully',
            'alert-type' => 'success'
        );

        $clecture = CourseLecture::findOrFail($lecture_id);
        return redirect()->route('add.course.lecture', $clecture->course_id)->with($notification);
    }

    public function DeleteLecture($id){
        $lecture = CourseLecture::findOrFail($id);
        $course_id = $lecture->course_id;
        $lecture->delete();

        $notification = array(
            'message' => 'Course Lecture Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('add.course.lecture', $course_id)->with($notification);
    }

    public function DeleteSection($id){
        $section = CourseSection::findOrFail($id);

        CourseLecture::where('section_id', $id)->delete();


        $section->delete();

        $notification = array(
            'message' => 'Course Section Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
