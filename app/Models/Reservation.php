<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'number_people', 'reservation_date', 'start_time', 'end_time'];

    public function rules(){
        $rules = [
            'user_id' => 'exists:users,id',
            'number_people' => 'required',
            'reservation_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];

        return $rules;
    }

    public function feedback(){
        $feedback = [
            'required' => 'O campo :attribute é obrigatório',
        ];

        return $feedback;
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
