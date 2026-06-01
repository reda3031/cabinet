<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory ;
    protected $fillable = ["name" , "email","password","role","phone"];
public function appointmentsAsPatient()
{
    return $this->hasMany(Appointment::class, 'patient_id');
}

public function appointmentsAsMedecin()
{
    return $this->hasMany(Appointment::class, 'medecin_id');
}
    
}
