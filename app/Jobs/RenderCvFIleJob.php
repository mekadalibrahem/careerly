<?php

namespace App\Jobs;

use App\Events\CvRenderEndEvent;
use App\Models\User;
use App\Modules\Exports\Entities\Download;
use App\Modules\Exports\Enums\ExportTypesEnum;
use App\Modules\Exports\ExportManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RenderCvFIleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public  $user_id,
        public $tempData
    )
    {
    }

    public function handle(ExportManager $exportManager): void
    {
        try {
            $data = $this->preperData();
            $fileName = "CV_".$this->user_id . "_" . time() .".pdf";

            $exportManager->exprot($data, $fileName);
            $saved = Download::create([
                "user_id" => $this->user_id,
                "path" => $fileName,
                "type" =>  ExportTypesEnum::CV(),
            ]);
            if($saved){
              event(new CvRenderEndEvent($this->user_id, $saved->id));
            }else{
                event(new CvRenderEndEvent($this->user_id , 0 , [0 =>"Something wrong to save your file"]));
            }
        }catch (\Throwable $th){
            event(new CvRenderEndEvent($this->user_id , 0 , [0 =>$th->getMessage()]));
            logger()->error(__CLASS__ . " ERROR :  "  . $th->getMessage());
        }


    }

    private function preperData() : array {
        $user = User::where('id' , $this->user_id)
            ->with(['skills' , 'projects' ,'educations' , 'courses'])
            ->first();
        $tempData = $this->tempData;
        $title = $user->title;
        $bio  = $user->bio;
        $projects = $user->projects;
        $skills = $user->skills;
        $educations = $user->educations;
        $courses = $user->courses;
        $phone = $user->phone;

        if(array_key_exists('title' , $tempData)){
            $title = $tempData['title'];
        }
        if(array_key_exists('bio', $tempData)){
            $bio = $tempData['bio'];
        }
        if(array_key_exists('project_ids', $tempData)){
            $ids = array_filter($tempData['project_ids'],fn($id) => is_numeric($id) && $id>0);
            $projects = $projects->only($ids);
        }
        if(array_key_exists('skill_ids', $tempData)){
            $ids = array_filter($tempData['skill_ids'],fn($id) => is_numeric($id) && $id>0);
            $skills = $skills->only($ids);

        }
        if(array_key_exists('course_ids', $tempData)){
            $ids = array_filter($tempData['course_ids'],fn($id) => is_numeric($id) && $id>0);
            $courses = $courses->only($ids);

        }
        if(array_key_exists('education_ids', $tempData)){
            $ids = array_filter($tempData['education_ids'],fn($id) => is_numeric($id) && $id>0);
            $educations =  $educations->only($ids);
        }


        return [
            "type" => $tempData['type'],
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                "title" => $title,
                "phone"=> $phone,
                'bio' => $bio,
                "courses" => $courses,
                'educations' => $educations,
                "projects"=> $projects,
                "skills" => $skills
            ]
        ];
    }

}
