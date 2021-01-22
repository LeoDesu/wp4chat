<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
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

    public function send(int $user_id, string $content){
        return $this->sent()->create(['receiver_id' => $user_id, 'content' => $content]);
    }

    public function sent(){
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function received(){
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function messagedWith(int $user_id, int $limit = null){
        $sent = $this->sent->count() > 0 ?
                    $this->sent->toQuery()->where('receiver_id', $user_id)->get():
                    $this->sent;
        $received = $this->received->count() > 0 ?
                    $this->received->toQuery()->where('sender_id', $user_id)->get():
                    $this->received;
        $messages =  $sent->merge($received);
        if($sent->merge($received)->count() <= 0){
            return collect();
        }else{
            if($limit){
                return $messages->toQuery()->orderBy('created_at', 'desc')->get()->take($limit);
            }else{
                return $messages->toQuery()->orderBy('created_at', 'desc')->get();
            }
        }
    }

    public function conversations(){
        $sentIds = $this->fetchUniqueOnly('receiver_id', $this->sent);
        $receivedIds = $this->fetchUniqueOnly('sender_id', $this->received);

        return User::find(array_unique(array_merge($sentIds, $receivedIds)));
    }

    public function fetchUniqueOnly($key, Collection $collection){
        $res = [];
        if($collection->count() > 0){
            foreach($collection->toQuery()->get($key)->unique($key)->toArray() as $i){
                array_push($res, $i[$key]);
            }
        }
        return $res;
    }
}
