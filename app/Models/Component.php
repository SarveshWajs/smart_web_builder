<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model {
    protected $fillable = ['name', 'html', 'css'];
    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}
