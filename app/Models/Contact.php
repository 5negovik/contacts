<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Contact
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $tel
 * @property string|null $email
 * @property Carbon|null $birthday
 */


class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'tel',
        'email',
        'birthday',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
    ];


    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
