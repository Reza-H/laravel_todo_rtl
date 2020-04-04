<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\SubTask;
use App\Task;
use App\Todo;
use App\User;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Todo $todo, Task $task, Helpers $helpers)
    {


        $todos_user = Todo::find($todo->id)->users;
        //---- Find co-admin's id ------------
        $coadmins = array();

        foreach($todos_user as $user){
            if(boolval($user->pivot->is_co_admin == true)){
                array_push($coadmins, $user->id);
            }
        }
        //----------------------------
// dd($coadmins);
        $sub_tasks = SubTask::all();
        $hasTask = false;
        if($todo->owner_id == auth()->id()){
            $hasTask = true;
        }
            // foreach($sub_tasks as $sub_task){
            //     if($todo->owner_id == auth()->id()){
            //         $hasTask = true;
            //     }
            //     // dump($task->todo->owner_id);
            // }
            // dd('end');
        // Geo Date for time picker
        $startDate_geo = $task->start_at;
        $startDate_geo = explode(' ', $startDate_geo);
        $startDate_geo = explode('-', $startDate_geo[0]);
        $endDate_geo = $task->end_at;
        $endDate_geo = explode(' ', $endDate_geo);
        $endDate_geo = explode('-', $endDate_geo[0]);

        //Jalali Date for info box
        $startDate_jalali = $helpers->getJalai($task->start_at);
        $startDate_jalali = explode(' ', $startDate_jalali);

        $endDate_jalali = $helpers->getJalai($task->end_at);
        $endDate_jalali = explode(' ', $endDate_jalali);
        $participants = $task->users;
        // --------------------------------------------
        $user_id = auth()->id();
        $task_user = $task->users;
        // $tasks = array();
        // dd($todos_user);
        // to check if User is in Todo's users list
        $is_user_found = false;
        if($task_user->count() >= 1){
            for ($i = 0; $task_user->count() > $i; $i++ ){
                if($task_user[$i]->id === $user_id){
                    $is_user_found = true;
                }
            }
        }

        // dd($todo);

        // if User is in Todo's users list
        if($is_user_found === true){

            // If loged in user is the todo's Owner show all tasks to him/her


            // if($hasTask === true ){
            //     $sub_tasks = User::find(auth()->id())->todos()->where('todo_id',$todo->id)->first()->tasks[0]->find($task->id)->sub_tasks()->with('users')->orderBy('name', 'desc')->orderBy('updated_at', 'desc')->get();
            //     // User::find(1)->todos()->where('todo_id',2)->first()->tasks[0]->find(4)->sub_tasks;
            // }else{
            //     $sub_tasks = User::find(auth()->id())->todos()->where('todo_id',$todo->id)->first()->tasks[0]->find($task->id)->sub_tasks()->with('users')->orderBy('name', 'desc')->orderBy('updated_at', 'desc')
            //     ->whereHas('users', function($q)
            //     {
            //         $q->where('user_id',auth()->id());
            //     })->get();
            // }
            $sub_tasks = User::find(auth()->id())->todos()->where('todo_id',$todo->id)->first()->tasks[0]->find($task->id)->sub_tasks()->with('users')->orderBy('updated_at', 'desc')->get();

            // $sub_tasks = $task->sub_tasks;
            // dd($sub_tasks);
            $len = $sub_tasks->count();
            for ($i = 0; $i < $len; $i++) {
                $sub_tasks[$i]->start_at = $helpers->getJalai($sub_tasks[$i]->start_at);
                $start_at_date_array = explode(' ', $sub_tasks[$i]->start_at);
                $sub_tasks[$i]->start_at = $start_at_date_array[0];
                $sub_tasks[$i]->end_at = $helpers->getJalai($sub_tasks[$i]->end_at);
                $end_at_date_array = explode(' ', $sub_tasks[$i]->end_at);
                $sub_tasks[$i]->end_at = $end_at_date_array[0];
            }

            return view('sub_tasks.sub_task', [
                'todo_id' => $todo->id,
                'task_id' => $task->id,
                'task_done' => $task->is_done,
                'task_start_geo' => strval($task->start_at),
                'task_end_geo' => strval($task->end_at),
                'todo_owner' => intval($todo->owner_id),
                'task_start_jalali' => $startDate_jalali[0],
                'task_end_jalali' => $endDate_jalali[0],
                'participants' => $participants,
                'co_admins' => $coadmins,
                'sub_tasks' => $sub_tasks
            ]);
        }else{
            // If user is not in Todo's users list
            return abort(403, 'صفحه مورد نظر یافت نشد');
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Todo $todo, Task $task, Helpers $helpers)
    {
        // dd(request()->all());

        $subtask= request('subtask');
        $user_id = request('user');

        // dd($user_id);

        // dd($task['type']['individual']['id']);
        // $users = $task['type']['individual']['id'];
        // dd($users);
        $start = $helpers->getGeorgian($subtask['start']);
        $end = $helpers->getGeorgian($subtask['end']);
        // $type = $task['type'];
        // if(array_key_first($type) === 'collaborative'){
        //     $type = "collaborative";
        // }elseif(array_key_first($type) === 'individual'){
        //     $type = "individual";
        // }


        $todo_id = $todo->id;
        SubTask::create([
            'task_id' => $task->id,
            'name' =>  $subtask['name'],
            'start_at' => $start,
            'end_at' => $end,

        ]);



         // Find newly added sub task
         $addedSubTask =  SubTask::where('name', $subtask['name'])
         ->where('start_at', $helpers->getGeorgian($subtask['start']))
         ->where('end_at',  $helpers->getGeorgian($subtask['end']))->get();

        // Get newly added todo id
        $addedSubTaskId =  $addedSubTask[0]->id;

        SubTask::find($addedSubTaskId)->users()->syncWithoutDetaching($user_id);


        // Add created todo for other selected users (if its collaborative)
        // if (isset($task['type']['collaborative'])) {
        //     $users = $task['type']['collaborative'];
        //     // array_push($users, auth()->id());
        //     // dd($users);
        //     foreach($users as $user){
        //         Task::find($addedTaskId)->users()->attach($user);
        //         // if(auth()->id() === $user){
        //         //     Task::find($addedTaskId)->users()->attach($user,['permission_id' => '1']);
        //         // }else{
        //         //     Task::find($addedTaskId)->users()->attach($user);
        //         // }
        //     }
        //     // Todo::find($addedTodoId)->users()->attach($users);

        // } else{
        //     // Task::find($addedTaskId)->users()->attach(auth()->id(),['permission_id' => '1']);

        //     Task::find($addedTaskId)->users()->attach($task['type']['individual']['id']);

        // }



        return redirect()->route('subs.index',[$todo,$task]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubTask  $sub_Task
     * @return \Illuminate\Http\Response
     */
    public function show(SubTask $subTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubTask  $sub_Task
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Todo $todo, Task $task, SubTask $sub_task, Helpers $helpers)
    {
        $sub_task_id = request()->get('id');



        if(request()->ajax()){
            // dd(request()->all());
            $sub_task = $sub_task::find($sub_task_id);
            $sub_task_user = $sub_task->users()->first();
            if($sub_task_user->id == auth()->id() or $todo->owner_id == auth()->id()){
                $sub_task_user = [
                    'id' => $sub_task_user->id,
                    'name' => $sub_task_user->name,
                    'email' => $sub_task_user->email,

                ];
                // dd($sub_task_user);
                // if($task->type === 'individual'){
                //     $user_ids = $task->users[0]->pivot->user_id;
                // }else{
                //     $user_ids = array();
                //     $task_user = $task->users;
                //     for($i = 0; $task_user->count() > $i; $i++){
                //         array_push($user_ids, $task_user[$i]->id);
                //     }
                // }

                // dd($user_ids);
                // dd($sub_task->start_at);
                $tStart = explode(' ',$helpers->getJalai($sub_task->start_at));
                $sub_task->start_at = $tStart[0];
                $tEnd = explode(' ', $helpers->getJalai($sub_task->end_at));
                $sub_task->end_at = $tEnd[0];
                $subTask = [
                    'id' => $sub_task->id,
                    'task_id' => $sub_task->task_id,
                    'name' => $sub_task->name,
                    'start_at' =>$sub_task->start_at,
                    'end_at' =>$sub_task->end_at,

                ];
                $task_start = $task->start_at;
                $task_end = $task->end_at;
                $data = [
                    'sub_task' => $subTask,
                    'sub_task_user' => $sub_task_user,
                    'task_start' => $task_start,
                    'task_end' => $task_end,
                ];

                return response()->json(['data' => $data]);

            }else{
                return response()->json([
                    'ERROR' => 'شما دسترسی کافی ندارید، لطفا با صاحب انجام تماس بگیرید!'
                ]);
            }

        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sub_Task  $sub_Task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SubTask $subTask, Todo $todo, Task $task,Helpers $helpers)
    {
        $sub_task_id = request('id');
        $sub_task_req = request('subtask');
        $sub_task_user_id = request('user');
        $start = $helpers->getGeorgian($sub_task_req['start']);
        $end = $helpers->getGeorgian($sub_task_req['end']);
        // dump($start);
        // dd(request()->all());
        $subTask->findOrFail($sub_task_id)->update([
            'name' => $sub_task_req['name'],
            'start_at' => $start,
            'end_at' => $end,
        ]);

        $subTask->find($sub_task_id)->users()->sync($sub_task_user_id);

        return redirect()->route('subs.index',[$todo,$task]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(SubTask $subTask)
    {
        if($subTask->delete() && $subTask->forceDelete()){
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

   /**
     * @param Request $request
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function addParticipant(Request $request, Todo $todo, Task $task)
    {
        // dump($todo->users()->count());
        //    dd($todo->name);
        if($task->type == "individual")
        {
            $task->type = "collaborative";
            $task->save();
            $todo->type = "collaborative";
            $todo->save();
        }

        // $todo_id = $todo->id;
        $id = auth()->id();
        // $user = User::find($id);
        $user_friends = User::find(auth()->id())->friends;
        $email = $request->input('email');
        // dump($email);
        // dump($user);
        // dump($todo_id);

        if (User::where('email', '=', $email)->exists()) {
            $friend = User::where('email', '=', $email)->get();
            // dump($friend);

            $friendID = $friend[0]->id;
            // dump($friendID);
            $participants = $task->users;
            // dump($participants->count());
            $friends_Email_array = array();
            if ($participants->count() > 0) { // Check if user Have any friends at first
                for ($i = 0; $i < $participants->count(); $i++) {
                    if ($request->input('email') === $participants[$i]->email) {
                        return response()->json([
                            'ERROR' => 'کابر مورد نظر در لیست  شرکت کنندگان قرار دارد !'
                        ]);
                    } elseif ($request->input('email') === auth()->user()->email) {
                        return response()->json([
                            'ERROR' => 'کابر مورد نظر خود شما می باشید !'
                        ]);
                    } else {
                        array_push($friends_Email_array, $participants[$i]->email);

                    }
                }// End for
                try {
                    // dd($participants);
                    $find = false;
                    for ($i = 0; $user_friends->count() > $i; $i++) {
                        // dump($user_friends[$i]->id);
                        if ($user_friends[$i]->id === $friendID) {
                            $find = true;
                        }
                    }
                    if ($find === false) {
                        User::find($id)->friends()->syncWithoutDetaching($friendID);
                    }

                    $todo->users()->syncWithoutDetaching($friendID);
                    $task->users()->syncWithoutDetaching($friendID);

                    return response()->json([
                        "SUCCESS" => 'کاربر مورد نظر به لیست  اضافه شد!',
                        "FRIEND" => $friend,
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        "ERROR" => 'عملیات با خطامواجه شد!',
                        'Message' => $e->getMessage(),
                        "FRIEND" => $friend,
                    ]);
                }


            } else { // IF there is no friend
                if ($request->input('email') === auth()->user()->email) {
                    return response()->json([
                        'WARN' => 'کابر مورد نظر خود شما می باشید !'

                    ]);
                } else {
                    try {
                        $todo->users()->syncWithoutDetaching($friendID);
                        $task->users()->syncWithoutDetaching($friendID);
                        User::find($id)->friends()->syncWithoutDetaching($friendID);

                        return response()->json([
                            "SUCCESS" => 'کاربر مورد نظر به لیست  اضافه شد!',
                            "FRIEND" => $friend,
                        ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            "ERROR" => 'عملیات با خطامواجه شد!',
                            'Message' => $e->getMessage(),
                            "FRIEND" => $friend,
                        ]);
                    }
                }
            }

        } else { // IF Email not found in database
            return response()->json([
                'ERROR' => 'کاربر با پست الکترونیکی مورد نظریافت نشد!'
            ]);
        }
    }


    /**
     * @param Todo $todo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteParticipant(Todo $todo, Request $request, Task $task)
    {

        $user_email = request('email');
        $user = User::where('email', $user_email)->get();
        $user_id = $user[0]->id;

        if ($user_id === auth()->id()) {
            return response()->json([
                "WARN" => 'شما نمیتوانید صاحب انجام را حذف کنید!'
            ]);
        } else {
            $task->users()->detach($user_id);
            return response()->json([
                "SUCCESS" => 'کاربر مورد نظر با موفقیت از لیست انجام حذف شد!'
            ]);
        }

    }

    public function updateStatus(SubTask $subTask)
    {
        $status = request('status');
        if($status === 'true'){
            $status = '1';
            $dbState = true;
        }elseif($status === 'false'){
            $status = '0';
            $dbState = false;
        }
        //--update sub task 'is_done'---
        $subTask->is_done = $dbState;
        $subTask->save();

        //--update task 'is_done'---
        $task_id = $subTask->task_id;
        $task = Task::find($task_id);
        $todo_id = $task->todo_id;
        $todo = Todo::find($todo_id);
        $subs = $task->sub_tasks;
        $subs_count = $subs->count();
        $subs_done_count = 0;
        for($i = 0; $subs_count > $i; $i++){
            if($subs[$i]->is_done == 1){
                $subs_done_count =  $subs_done_count + 1;
            }
        }

        if($subs_done_count == $subs_count ){
            $task->is_done = true;
            $task->save();
        }else if($subs_done_count != $subs_count){
            $task->is_done = false;
            $task->save();
            if($todo->is_done == true){
                $todo->is_done = false;
                $todo->save();
            }
            // $todo->is_done = false;

        }

        //-- update todo 'is_done'---
        $tasks = $todo->tasks;
        $tasks_count = $tasks->count();
        $tasks_done_count = 0;
        for($i = 0; $tasks_count > $i; $i++){
            if($tasks[$i]->is_done == 1){
                $tasks_done_count =  $tasks_done_count + 1;
            }
        }

        if($tasks_done_count == $tasks_count ){
            $todo->is_done = true;
            $todo->save();
        }else if($tasks_done_count != $tasks_count){
            $todo->is_done = false;
            $todo->save();
        }

        return response()->json([
            'state' => $status
        ]);


    }
}
