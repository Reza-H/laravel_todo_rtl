<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    protected $date = ['deleted_at'];
    use SoftDeletes;

    protected $fillable = ['name','start_at','end_at','type','owner_id'];


    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('permission_id','user_id','todo_id','is_co_admin');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'todo_user','todo_id','permission_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
