<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $id = auth()->id();
        $friends = User::find($id)->friends;
        $user = auth()->user();
        $gravemail = md5(strtolower(trim($user->email)));
        $gravsrc = "http://www.gravatar.com/avatar/" . $gravemail . '?s=150';
        $gravcheck = "http://www.gravatar.com/avatar/" . $gravemail . "?d=404";
        if(get_headers($gravcheck)){
            $response = get_headers($gravcheck);
            if ($response[0] != "HTTP/1.0 404 Not Found") {
                $img = $gravsrc;
            } else {
                $img = '/img/avatar/default/2.svg';
                // $img = 'https://joeschmoe.io/api/v1/random';
            }
        } else{
            $img = '/img/avatar/default/2.svg';
        }
        return view('users.profile', [
            'user' => $user,
            'friends' => $friends,
            'user_img' => $img
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function add_friend(Request $request)
    {
        // request()->validate([
        //     'email'=> 'required'
        // ]);

        $id = auth()->id();
        $user = User::find($id);
        $email = $request->input('email');

        if (User::where('email', '=', $email)->exists()) {
            $friend = User::where('email', '=', $email)->get();
            $friendID = $friend[0]->id;
            $friends = User::find($id)->friends;
            $friends_Email_array = array();
            if ($friends->count() > 0) { // Check if user Have any friends at first
                for ($i = 0; $i < $friends->count(); $i++) {
                    if ($request->input('email') === $friends[$i]->email) {
                        return response()->json([
                            'ERROR' => 'کابر مورد نظر در لیست دوستان شما قرار دارد !'
                        ]);
                    } elseif ($request->input('email') === auth()->user()->email) {
                        return response()->json([
                            'ERROR' => 'کابر مورد نظر خود شما می باشید !'
                        ]);
                    } else {
                        array_push($friends_Email_array, $friends[$i]->email);

                    }
                }// End for
                $user->friends()->attach($friendID);


                return response()->json([
                    "SUCCESS" => 'کاربر مورد نظر به لیست دوستان اضافه شد!',
                    "FRIEND" => $friend,
                ]);

            } else { // IF there is no friend
                if ($request->input('email') === auth()->user()->email) {
                    return response()->json([
                        'WARN' => 'کابر مورد نظر خود شما می باشید !'

                    ]);
                } else {
                    $user->friends()->attach($friendID);

                    return response()->json([

                        "SUCCESS" => 'کاربر مورد نظر به لیست دوستان شما اضافه شد!',

                        "FRIEND" => $friend,
                    ]);
                }
            }

        } else { // IF Email not found in database
            return response()->json([
                'ERROR' => 'کاربر با پست الکترونیکی مورد نظریافت نشد!'
            ]);
        }

    }


    /**
     * @param $friend
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove_friend($friend)
    {
        $id = auth()->id();
        $user = User::find($id);
        $user->friends()->detach($friend);
        return response()->json([
            "SUCCESS" => 'کاربر مورد نظر با موفقیت از لیست دوستان حذف شد!'
        ]);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateName()
    {
        $new_Name = request('user_name');
        $id = auth()->id();
        $user = User::find($id);
        $user->name = $new_Name;
        $user->save();
        return response()->json([
            'name' => $user->name,
            'SUCCESS' => 'نام شما با موفقیت تغییر کرد!'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
