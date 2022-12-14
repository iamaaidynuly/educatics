<?php

namespace App\Http\Resources;

use App\Models\CourseVideo;
use App\Models\CourseDoc;
use App\Models\Test;
use App\Models\Translate;
use App\Models\UserCourseIntro;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseIntroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = auth()->user();

        return [
            'id'    =>  $this->id,
            'type'  =>  $this->type,
            'title' => isset($request->lang) ? Translate::whereId($this->title)->value($request->lang) : Translate::find($this->title),
            'course_id' =>  $this->course_id,
            'videos'    =>  CourseVideoResource::collection(CourseVideo::where('course_intro_id', $this->id)->get()),
            'tests'     =>  new TestResource(Test::whereCourseIntroId($this->id)->first()),
            'docs'      =>  CourseDocResource::collection(CourseDoc::where('course_intro_id', $this->id)->get()),
            'status'    =>  isset($user) ? UserCourseIntro::where('course_intro_id', $this->id)->where('user_id', $user->id)->value('status') : false,
        ];
    }
}
