<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'requirement_id'
    ];

    public function taskId()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function requirementId()
    {
        return $this->belongsTo(Task::class, 'requirement_id');
    }
}
