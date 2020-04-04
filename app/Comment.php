<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $date = ['deleted_at'];
    protected $fillable = ['sub_task_id','user_id','text'];

    public function subtask()
    {
        return $this->belongsTo(SubTask::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
