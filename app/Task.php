<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    protected $date = ['deleted_at'];
    use SoftDeletes;
    protected $fillable = ['name','start_at','end_at','type','todo_id'];

    public function todo()
    {
        return $this->belongsTo(Todo::class,'todo_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('user_id','task_id');
        // return $this->belongsToMany(User::class)->withPivot('permission_id');
    }

    function sub_tasks()
    {
        return $this->hasMany(SubTask::class,'task_id');
    }
}
