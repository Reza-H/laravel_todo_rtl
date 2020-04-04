<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class,'user_friends','friend_id','user_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class,'user_friends','user_id','friend_id');
    }


    public function todos()
    {
        return $this->belongsToMany(Todo::class)->withPivot('user_id','todo_id');
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('user_id','task_id');
    }
    public function sub_tasks()
    {
        return $this->belongsToMany(SubTask::class,'subTasks_user')->withPivot('user_id','sub_task_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
