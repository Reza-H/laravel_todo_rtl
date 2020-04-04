<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\SubTask;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Checklist $checklist
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Checklist $checklist)
    {

        $sub_id = request('id');
        // $checklists = $checklist->all()->where('sub_task_id', $sub_id);

        $checklists = SubTask::find($sub_id)->ckecklists;
        // dd($subs);

        return response()->json([
            'checklists' => $checklists
        ]);
        // dd($checklists);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request,SubTask $subTask)
    {
        $sub_id = request('sub_id');
        $text = request('text');
        // dump($sub_id);
        // dump($text);
        // dd(request()->all());
        Checklist::create([
            'sub_task_id' => $sub_id,
            'text' => $text,
        ]);
        $added_checklist = Checklist::all()->where('text',$text)->first();

        return response()->json([
            "SUCCESS" => 'اضافه شد!',
            "text" => $text,
            'item' => $added_checklist
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Checklist $checklist
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Checklist $checklist)
    {
        // dd($checklist->is_done);
        if($checklist->is_done == 0 ){
            if($checklist->update(['is_done'=> 1])){
                return response()->json([
                    "SUCCESS" => 'کامل شد!',
                    "done" => true
                ]);
            }
        }elseif($checklist->is_done == 1){
            if($checklist->update(['is_done'=> 0])){
                return response()->json([
                    "SUCCESS" => 'از کاملی در آمد *ـ*!',
                    "done" => false
                ]);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Checklist $checklist
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Checklist $checklist)
    {
        if($checklist->delete() && $checklist->forceDelete()){
            return response()->json([
                "SUCCESS" => 'باموفقیت حذف شد!',
                'ok' => true
            ]);
        }
    }
}
