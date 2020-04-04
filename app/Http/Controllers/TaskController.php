<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Task;
use App\Todo;
use App\User;
use Exception;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Todo $todo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Todo $todo, Helpers $helpers)
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



        $tasks = Task::all();
        $hasTask = false;
            foreach($tasks as $task){
                if($task->todo->owner_id == auth()->id()){
                    $hasTask = true;
                }
                // dump($task->todo->owner_id);
            }
            // dd('end');
        // Geo Date for time picker
        $startDate_geo = $todo->start_at;
        $startDate_geo = explode(' ', $startDate_geo);
        $startDate_geo = explode('-', $startDate_geo[0]);
        $endDate_geo = $todo->end_at;
        $endDate_geo = explode(' ', $endDate_geo);
        $endDate_geo = explode('-', $endDate_geo[0]);

        //Jalali Date for info box
        $startDate_jalali = $helpers->getJalai($todo->start_at);
        $startDate_jalali = explode(' ', $startDate_jalali);

        $endDate_jalali = $helpers->getJalai($todo->end_at);
        $endDate_jalali = explode(' ', $endDate_jalali);
        $participants = $todo->users;
        // dd($participants[0]->pivot->is_co_admin);
        // --------------------------------------------
        $user_id = auth()->id();

        // $tasks = array();
        // dd($todos_user);
        // to check if User is in Todo's users list
        $is_user_found = false;
        if($todos_user->count() >= 1){
            for ($i = 0; $todos_user->count() > $i; $i++ ){
                if($todos_user[$i]->id === $user_id){
                    $is_user_found = true;
                }
            }
        }


        // if User is in Todo's users list
        if($is_user_found === true){

            // If loged in user is the todo's Owner show all tasks to him/her


            if($hasTask === true ){
                $tasks = User::find(auth()->id())->todos()->where('todo_id',$todo->id)->first()->tasks()->orderBy('updated_at', 'desc')->get();
            }else{
                $tasks = User::find(auth()->id())->todos()->where('todo_id',$todo->id)->first()->tasks()->with('users')->orderBy('updated_at', 'desc')
                ->whereHas('users', function($q)
                {
                    $q->where('user_id',auth()->id());
                })->get();
            }

            // $tasks = Todo::find($todo->id)->tasks;
            // dd($tasks);
            $len = $tasks->count();
            for ($i = 0; $i < $len; $i++) {
                $tasks[$i]->start_at = $helpers->getJalai($tasks[$i]->start_at);
                $start_at_date_array = explode(' ', $tasks[$i]->start_at);
                $tasks[$i]->start_at = $start_at_date_array[0];
                $tasks[$i]->end_at = $helpers->getJalai($tasks[$i]->end_at);
                $end_at_date_array = explode(' ', $tasks[$i]->end_at);
                $tasks[$i]->end_at = $end_at_date_array[0];
            }
            //--------------------- is done state section -----------------------------------
            $done_tasks_count = 0;

            foreach($tasks as $task){
                if($task->is_done == true){
                    $done_tasks_count = $done_tasks_count + 1;
                }

            }
            if($done_tasks_count ==  $len){
                $todo->is_done = true;
                $todo->save();
            }elseif($done_tasks_count !=  $len){
                $todo->is_done = false;
                $todo->save();
            }

            // dump($done_tasks_count);
            return view('tasks.task', [
                'todo_id' => $todo->id,
                'todo_type' => $todo->type,
                'todo_start_geo' => strval($todo->start_at),
                'todo_end_geo' => strval($todo->end_at),
                'todo_owner' => intval($todo->owner_id),
                'todo_start_jalali' => $startDate_jalali[0],
                'todo_end_jalali' => $endDate_jalali[0],
                'participants' => $participants,
                'co_admins' => $coadmins,
                'tasks' => $tasks
            ]);
        }else{
            // If user is not in Todo's users list
            return abort(403, 'صفحه مورد نظر یافت نشد');
        }

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Todo $todo
     * @param Helpers $helpers
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Todo $todo, Helpers $helpers)
    {

        $task = request('task');
        // dd();

        // dd($task['type']['individual']['id']);
        // $users = $task['type']['individual']['id'];
        // dd($users);
        $start = $helpers->getGeorgian($task['start']);
        $end = $helpers->getGeorgian($task['end']);
        $type = "collaborative";
        if(isset($task['type'])){
            $type = $task['type'];
            if(array_key_first($type) === 'collaborative'){
                $type = "collaborative";
            }elseif(array_key_first($type) === 'individual'){
                $type = "individual";
            }
        }



        $todo_id = $todo->id;
        Task::create([
            'todo_id' => $todo_id,
            'name' => $task['name'],
            'start_at' => $start,
            'end_at' => $end,
            'type' => $type
        ]);



         // Find newly added todo
         $addedTask =  Task::where('name', $task['name'])
         ->where('start_at', $helpers->getGeorgian($task['start']))
         ->where('end_at',  $helpers->getGeorgian($task['end']))
         ->where('type', $type)->get();

        // Get newly added todo id
        $addedTaskId =  $addedTask[0]->id;


        // Add created todo for other selected users (if its collaborative)
        if(isset($task['type'])){
            if (isset($task['type']['collaborative'])) {
                $users = $task['type']['collaborative'];
                array_push($users, $todo->owner_id);
                Task::find($addedTaskId)->users()->syncWithoutDetaching($users);
                // foreach($users as $user){
                //     Task::find($addedTaskId)->users()->attach($user);
                //     // if(auth()->id() === $user){
                //     //     Task::find($addedTaskId)->users()->attach($user,['permission_id' => '1']);
                //     // }else{
                //     //     Task::find($addedTaskId)->users()->attach($user);
                //     // }
                // }
                // Todo::find($addedTodoId)->users()->attach($users);

            } else{
                // Task::find($addedTaskId)->users()->attach(auth()->id(),['permission_id' => '1']);

                Task::find($addedTaskId)->users()->syncWithoutDetaching($task['type']['individual']['id']);
                Task::find($addedTaskId)->users()->syncWithoutDetaching($todo->owner_id);

            }
        }else{
            $users = array();
            array_push($users, $todo->owner_id);
            array_push($users, auth()->user()->id);
            Task::find($addedTaskId)->users()->syncWithoutDetaching($users);
        }




        return redirect()->route('tasks.index',$todo_id);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Helpers $helpers, $id)
    {

        // dd(request()->get('id'));
        $task_id = request()->get('id');
        if(request()->ajax()){
            // dd(request()->all());
            $task = Task::findOrFail($task_id);
            $todo_type = $task->todo->type;
            $task_user_name = 0;
            $task_user_email = 0;
            if($task->type === 'individual'){
                $user_ids = $task->users[0]->pivot->user_id;
                $task_user_name = $task->users[0]->name;
                $task_user_email = $task->users[0]->email;

            }else{
                $user_ids = array();
                $task_user = $task->users;
                for($i = 0; $task_user->count() > $i; $i++){
                    array_push($user_ids, $task_user[$i]->id);
                }
            }

            // dd($user_ids);
            // dd($task_user);
            $tStart = explode(' ',$helpers->getJalai($task->start_at));
            $task->start_at = $tStart[0];
            $tEnd = explode(' ', $helpers->getJalai($task->end_at));
            $task->end_at = $tEnd[0];
            $sTask = [
                'id' => $task->id,
                'todo_id' => $task->todo_id,
                'name' => $task->name,
                'start_at' =>$task->start_at,
                'end_at' =>$task->end_at,
                'type' =>$task->type,

            ];
            $todo = $task->todo;
            $todo_start = $todo->start_at;
            $todo_end = $todo->end_at;
            $data = [
                'task' => $sTask,
                'task_users' => $user_ids,
                'todo_start' => $todo_start,
                'todo_end' => $todo_end,
                'todo_type' => $todo_type,
                'task_user_name' => $task_user_name ,
                'task_user_email' => $task_user_email,

            ];

            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Helpers $helpers)
    {
        // dd(request()->all());
        $task_id = request('id');
        $task = request('task');
        // dd($task['type']);
        $start = $helpers->getGeorgian($task['start']);
        $end = $helpers->getGeorgian($task['end']);
        $type = $task['type'];
        if(array_key_first($type) === 'collaborative'){
            $type = "collaborative";
        }elseif(array_key_first($type) === 'individual'){
            $type = "individual";
        }

        Task::findOrFail($task_id)->update([
            'name' => $task['name'],
            'start_at' => $start,
            'end_at' => $end,
            'type' => $type
        ]);

        $taskDB = Task::find($task_id);
        if (isset($task['type']['collaborative'])) {
            $users = $task['type']['collaborative'];
            // array_push($users, auth()->id());
            // dd($users);
            $taskDB->users()->sync($users);
            // foreach($users as $user){
            //    $task->users()->attach($user);
            //     // if(auth()->id() === $user){
            //     //     Task::find($addedTaskId)->users()->attach($user,['permission_id' => '1']);
            //     // }else{
            //     //     Task::find($addedTaskId)->users()->attach($user);
            //     // }
            // }
            // Todo::find($addedTodoId)->users()->attach($users);

        } else{
            // Task::find($addedTaskId)->users()->attach(auth()->id(),['permission_id' => '1']);

            $taskDB->users()->sync($task['type']['individual']['id']);

        }



        return redirect()->route('tasks.index',$taskDB->todo_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {

        if($task->delete() && $task->forceDelete()){
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
    public function addParticipant(Request $request, Todo $todo)
    {
    //    dd($todo->type);
        if($todo->type == "individual")
        {
         $todo->type = "collaborative";
         $todo->save();
        }

        $todo_id = $todo->id;
        $id = auth()->id();
        $user = User::find($id);
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
            $participants = Todo::find($todo_id)->users;
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

                    Todo::find($todo_id)->users()->syncWithoutDetaching($friendID);

                    return response()->json([
                        "SUCCESS" => 'کاربر مورد نظر به لیست  اضافه شد!',
                        "FRIEND" => $friend,
                    ]);
                } catch (Exception $e) {
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
                        Todo::find($todo_id)->users()->syncWithoutDetaching($friendID);
                        User::find($id)->friends()->syncWithoutDetaching($friendID);

                        return response()->json([
                            "SUCCESS" => 'کاربر مورد نظر به لیست  اضافه شد!',
                            "FRIEND" => $friend,
                        ]);
                    } catch (Exception $e) {
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
    public function deleteParticipant(Todo $todo, Request $request)
    {

        $user_email = request('email');
        $user = User::where('email', $user_email)->get();
        $user_id = $user[0]->id;

        if ($user_id === auth()->id()) {
            return response()->json([
                "WARN" => 'شما نمیتوانید صاحب انجام را حذف کنید!'
            ]);
        } else {
            Todo::find($todo->id)->users()->detach($user_id);
            return response()->json([
                "SUCCESS" => 'کاربر مورد نظر با موفقیت از لیست انجام حذف شد!'
            ]);
        }

    }

    public function check_todo_type(Todo $todo)
    {
        return response()->json([
            'type' => $todo->type,
        ]);
        // dd($todo->type);

    }
}
