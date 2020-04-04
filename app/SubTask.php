<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTask extends Model
{
    protected $date = ['deleted_at'];
    use SoftDeletes;
    protected $fillable = ['name','start_at','end_at','task_id'];

    public function task()
    {
        return $this->belongsTo(Task::class,'task_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'subTasks_user')->withPivot('user_id','sub_task_id');
        // return $this->belongsToMany(User::class)->withPivot('permission_id');
    }

    public function ckecklists()
    {
        return $this->hasMany(Checklist::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
