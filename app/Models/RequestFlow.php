<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFlow extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function log_actions()
    {
        return $this->hasMany(LogAction::class);
    }
}
