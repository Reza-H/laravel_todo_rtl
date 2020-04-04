<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Todo;
use App\User;
use App\UserFriend;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Helpers $helpers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Helpers $helpers)
    {
        //        dd(Todo::findOrFail(1)->permissions[0]->permission);

        $user_id = auth()->id();
        //        $todos = Todo::where('owner_id', '=', $user_id)->get();
        $todos = User::find($user_id)->todos()->orderBy('updated_at', 'desc')->get();
        $friends = User::find($user_id)->friends;


        $len = $todos->count();
        for ($i = 0; $i < $len; $i++) {
            $todos[$i]->start_at = $helpers->getJalai($todos[$i]->start_at);
            $start_at_date_array = explode(' ', $todos[$i]->start_at);
            $todos[$i]->start_at = $start_at_date_array[0];
            $todos[$i]->end_at = $helpers->getJalai($todos[$i]->end_at);
            $end_at_date_array = explode(' ', $todos[$i]->end_at);
            $todos[$i]->end_at = $end_at_date_array[0];
        }
        //        dd($todos[0]->start_at);
        return view('todos.todo', [
            'todos' => $todos,
            'friends' => $friends,
            'auth' => $user_id ,

        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Helpers $helpers
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Helpers $helpers)
    {

        $todo = request('todo');
        $type = 'collaborative';
        $owner_id = auth()->id();
        $user = User::find($owner_id);
        // dd($owner_id);
        if (isset($todo['type']['individual'])) {
            $type = 'individual';
        } elseif (isset($todo['type']['collaborative'])) {
            $type = 'collaborative';
        }

        // dd($todo);
        Todo::create([
            'name' => $todo['title'],
            'start_at' => $helpers->getGeorgian($todo['start']),
            'end_at' => $helpers->getGeorgian($todo['end']),
            'type' => $type,
            'owner_id' => $owner_id
        ]);

        // Find newly added todo
        $addedTodo =  Todo::where('name', $todo['title'])
            ->where('start_at', $helpers->getGeorgian($todo['start']))
            ->where('end_at',  $helpers->getGeorgian($todo['end']))
            ->where('type', $type)->where('owner_id', $owner_id)->get();

        // Get newly added todo id
        $addedTodoId =  $addedTodo[0]->id;


        // Add created todo for other selected users (if its collaborative)
        if (isset($todo['type']['collaborative'])) {
            $users = $todo['type']['collaborative'];
            array_push($users, auth()->id());
            // dd($users);
            foreach($users as $user){
                if(auth()->id() === $user){
                    Todo::find($addedTodoId)->users()->syncWithoutDetaching($user,['permission_id' => '1']);
                }else{
                    Todo::find($addedTodoId)->users()->syncWithoutDetaching($user);
                }
            }
            // Todo::find($addedTodoId)->users()->attach($users);

        } else{
            Todo::find($addedTodoId)->users()->syncWithoutDetaching(auth()->id(),['permission_id' => '1']);

        }

        return redirect('/todos');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo,Helpers $helpers)
    {

        $todo_id = request()->get('id');
        if(request()->ajax()){
            // dd(request()->all());
            $todo = Todo::findOrFail($todo_id);

            if($todo->type === 'individual'){
                $user_ids = $todo->users[0]->pivot->user_id;
            }else{
                $user_ids = array();
                $todo_user = $todo->users;
                for($i = 0; $todo_user->count() > $i; $i++){
                    array_push($user_ids, $todo_user[$i]->id);
                }
            }

            // dd($user_ids);
            // dd($todo_user);
            $tStart = explode(' ',$helpers->getJalai($todo->start_at));
            $start_at_jalai = $tStart[0];
            $tEnd = explode(' ', $helpers->getJalai($todo->end_at));
            $end_at_jalali = $tEnd[0];
            $stodo = [
                'id' => $todo->id,
                'name' => $todo->name,
                'start_at' => $todo->start_at,
                'end_at' => $todo->end_at,
                'type' => $todo->type,
                'start_at_j' => $helpers->getJalai($todo->start_at),
                'end_at_j' => $helpers->getJalai($todo->end_at),

            ];

            $data = [
                'todo' => $stodo,
                'todo_users' => $user_ids,

            ];

            return response()->json(['data' => $data]);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo ,Helpers $helpers)
    {
        // use Todo;
        // dd($todo);
        // dd(request()->all());
        $todo_id = request('id');
        $todoN = request('todo');
        $start = $helpers->getGeorgian($todoN['start']);
        $end = $helpers->getGeorgian($todoN['end']);
        $type = $todoN['type'];
        if(array_key_first($type) === 'collaborative'){
            $type = "collaborative";
        }elseif(array_key_first($type) === 'individual'){
            $type = "individual";
        }

        $todo->update([
            'name' => $todoN['name'],
            'start_at' => $start,
            'end_at' => $end,
            'type' => $type
        ]);

        $todoDB = Todo::find($todo_id);
        if (isset($todoN['type']['collaborative'])) {
            $users = $todoN['type']['collaborative'];
            $todo->users()->sync($users);
            $todo->users()->syncWithoutDetaching(auth()->id(),['permission_id' => '1']);

        } else{
            $todo->users()->sync(auth()->id(),['permission_id' => '1']);
            $tasks = $todo->tasks;
            foreach($tasks as $task){
                if($task->type === 'collaborative'){
                    $task->type = 'individual';
                    $task->save();
                    $task->users()->sync(auth()->id());
                }
            }
        }



        return redirect()->route('todos.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Todo $todo)
    {
        // dd($todo);
        if($todo->delete() && $todo->forceDelete()){
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

    public function addCoAdmin(Todo $todo){
        $todo_id = request('todo_id');
        $user_id =  request('user_id');
        // $state = request('state');
        $mes = '';
        if(intval(auth()->user()->id) !== intval($todo->owner_id))
        {
            return response()->json([
                'ok' => '0',
                'ERROR' => 'دسترسی غیرمجاز'
            ]);
        }
        if(intval($user_id) === intval($todo->owner_id)){
            return response()->json([
                'ok' => '0',
                'ERROR' => 'کاربر مورد نظر صاحب انجام است!'
            ]);
        }
        $dbState = $todo->users->where('id', $user_id)->first()->pivot->is_co_admin;
        // dump($dbState);
        // dump(gettype(boolval('0')));
        // dump(boolval(intval('1')));
        if(boolval(intval($dbState)) === true){
            $state = false;
            $mes = 'کاربر مورد نظر اکنون کاربر عادی است';
        }elseif(boolval(intval($dbState)) === false){
            $state = true;
            $mes = 'کاربر مورد نظر به همیار مدیر ارتقاع پیداکرد';
        }
        // dump(gettype());
        if($todo->users()->syncWithoutDetaching([$user_id => ['is_co_admin' => $state]])){
            return response()->json([
                'ok' => '1',
                'state' => $state,
                'SUCCESS' => $mes
            ]);
        }
        return response()->json([
            'ok' => '0',
            'ERROR' => 'خطا،لطفا دوباره تلاش کنید یا با پشتیبان تماس بگیرید!',
        ]);

    }
}
