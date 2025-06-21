<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model {
    protected $fillable = ['name', 'html', 'css', 'js', 'images'];

    protected $casts = [
        'images' => 'array', // Automatically cast images to array (JSON)
    ];

    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}
