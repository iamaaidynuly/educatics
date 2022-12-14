<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseIntro;
use App\Models\Translate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Tests;

class CourseIntroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        dd($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $course = Course::find($request['course_id']);

        return view('admin.course-intro.create', [
            'course'    =>  $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = Translate::create([
            'ru'    =>  $request['title_ru'],
            'kz'    =>  $request['title_kz'],
            'en'    =>  $request['title_en'],
        ]);

        CourseIntro::create([
            'title' =>  $title['id'],
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
            'course_id' =>  $request['course_id'],
            'type'  =>  $request['type'],
        ]);

        return redirect()->route('course-intros.show', $request['course_id'])->with('success', 'Успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $intros = CourseIntro::whereCourseId($id)->get();
        $course = Course::find($id);

        return view('admin.course-intro.index', [
            'intros'    =>  $intros,
            'course'    =>  $course,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $intro = CourseIntro::find($id);

        return view('admin.course-intro.edit', ['intro' => $intro]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $intro = CourseIntro::find($id);
        Translate::find($intro->title)->update([
            'ru'    =>  $request['title_ru'],
            'kz'    =>  $request['title_kz'],
            'en'    =>  $request['title_en'],
        ]);

        $intro->update([
            'type'  =>  $request['type'],
        ]);

        return redirect()->route('course-intros.show', $intro->course_id)->with('success', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = CourseIntro::whereId($id)->value('course_id');
        CourseIntro::find($id)->delete();

        return redirect()->route('course-intros.show', $course)->with('success', 'deleted');
    }

    public function get($id)
    {
        dd('123');
    }
}
