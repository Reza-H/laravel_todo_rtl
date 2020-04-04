<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Helpers\Helpers;
use App\SubTask;
use Helper;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sub_id = request('id');
        $comments = SubTask::find($sub_id)->comments()->with('user')->get();
        return response()->json([
            'comments' => $comments,
        ]);
//        dd(request()->all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Helpers $helpers
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request,Helpers $helpers)
    {

        // dd('store');
        $sub_id = request('sub_id');
        $comment_text = request('comment_text');
        $user_id = auth()->id();
        // dump($sub_id);
        // dump($comment_text);
        // dump($user_id);
        // dd(request()->all());
        Comment::create([
            'sub_task_id' => $sub_id,
            'user_id' => $user_id,
            'text' => $comment_text
        ]);
        $user_name = auth()->user()->name;
        $user_email = auth()->user()->email;
        $added_comment = Comment::all()->where('text',$comment_text)->first();
        $added_coment_Jdate = $added_comment->updated_at;
        $added_coment_Jdate = $helpers->getJalai($added_coment_Jdate);
        $added_coment_Jdate_arr = explode(' ', $added_coment_Jdate);
        $added_coment_Jdate_date = $added_coment_Jdate_arr[0];
        $added_coment_Jdate_time = $added_coment_Jdate_arr[2];

            // dd($added_coment_Jdate_time);
        return response()->json([
            "SUCCESS" => 'اضافه شد!',
            "text" => $comment_text,
            "user_name" => $user_name,
            "user_email" => $user_email,
            "added_date_full" => $added_coment_Jdate,
            "added_date_date" => $added_coment_Jdate_date,
            "added_date_time" => $added_coment_Jdate_time,
            'item' => $added_comment
        ]);
    //    dd(request()->all());
    }




    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $text = request('comment_text');
        if($comment->update([ 'text' => $text ])){
            return response()->json([
                "SUCCESS" => 'باموفقیت ویرایش شد!',
                'ok' => true,
                'comment' => $comment
            ]);
        }
        return response()->json([
            "ERROR" => 'عملیات موفقیت آمیز نبود لطفا مجددا تلاش کنید!',
            'ok' => false
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        if($comment->delete() && $comment->forceDelete()){
            return response()->json([
                "SUCCESS" => 'باموفقیت حذف شد!',
                'ok' => true
            ]);
            return response()->json([
                "ERROR" => 'لطفا مجددا تلاش کنید!',
                'ok' => false
            ]);
        }
    }
}
