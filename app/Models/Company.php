<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function requestFlows()
    {
        return $this->hasMany(RequestFlow::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
//        return $this->belongsToMany(User::class,'companies_users','companies_id','users_id');
    }
    public function departmentss()
    {
        return $this->hasMany(Department::class);
    }
}
