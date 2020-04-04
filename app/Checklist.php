<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    protected $date = ['deleted_at'];
    use SoftDeletes;
    protected $fillable = ['sub_task_id','text','is_done'];

    public function subtask()
    {
        return $this->belongsTo(SubTask::class);
    }
}
