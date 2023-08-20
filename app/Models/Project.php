<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'creator',
        'description'
    ];

    public function _creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'project_users')->withPivot('type');
    }
}
