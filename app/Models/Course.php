<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'total_videos'
    ];

    protected $visible = [
        'id',
        'user_id',
        'title',
        'description',
        'total_videos'
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
