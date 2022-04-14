<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserProfile extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'gender',
        'birthday',
        'original_picture',
        'picture',
        'location',
        'about'
    ];

    public function getAge(): int
    {
        return Carbon::parse($this->attributes['birthday'])->age;
    }


}
