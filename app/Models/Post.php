<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $guraded = [
        'id'
    ];

    protected $fillable = [
        'title',
        'departure',
        'arrival',
        'distance',
        'time',
        'body',
    ];

    public $appends = [
        'is_liked',
    ];

    public static $rules = [
        'title' => 'nullable|string|max:30',
        'departure' => 'nullable|string|max:20',
        'arrival' => 'nullable|string|max:20',
        'distance' => 'nullable|string|max:100000',
        'time' => 'nullable|string|max:10',
        'body' => 'nullable|string|max:150',
    ];

    //投稿ユーザーのコレクションを取得
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //いいねしたユーザーのコレクションを取得
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    //いいねしたユーザーのコレクションを取得
    public function getIsLikedAttribute()
    {
        return (bool)$this->likes->where('id', Auth::id())->count();
    }

}
