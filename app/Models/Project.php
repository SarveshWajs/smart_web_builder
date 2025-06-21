<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'theme_id', 'user_id'];

    public function components()
    {
        return $this->belongsToMany(Component::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // Users who have favorited this project
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
