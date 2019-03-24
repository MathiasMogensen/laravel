<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table Name (Optional: Uses plural class name if not set)
    protected $table = 'posts';
    // Primary Key (Optional: Uses 'id' if not set)
    public $primaryKey = 'id';
    // Timestamps (Optional: is true if not set)
    public $timestamps = true;

    // Relation
    public function user() {
        return $this->belongsTo('App\User');
    }
}
