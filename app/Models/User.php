<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function send(User $user, string $content){
        return $this->sent()->create(['receiver_id' => $user->id, 'content' => $content]);
    }

    public function sent(){
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function received(){
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function messagedWith(User $user){
        $sent = $this->sent->count() > 0 ?
                    $this->sent->toQuery()->where('receiver_id', $user->id)->get():
                    $this->sent;
        $received = $this->received->count() > 0 ?
                    $this->received->toQuery()->where('sender_id', $user->id)->get():
                    $this->received;
        $messages =  $sent->merge($received);
        return $messages->count() > 0 ?
                $messages->toQuery()->orderBy('created_at')->get():
                $messages;
    }

    public function conversations(){
        $sentIds = $this->sent->count() > 0 ?
                    $this->sent->toQuery()->select('receiver_id')->get()->unique()->toArray() : $this->sent->toArray();
        $receivedIds = $this->received->count() > 0 ?
                    $this->received->toQuery()->select('sender_id')->get()->unique()->toArray() : $this->received->toArray();

        return User::find(array_unique(array_merge($sentIds, $receivedIds)));
    }
}
