<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'type'
    ];

    public function projectId()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function userId()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
