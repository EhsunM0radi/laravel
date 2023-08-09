<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'creator',
        'description',
        'project_id'
    ];

    public function _creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
