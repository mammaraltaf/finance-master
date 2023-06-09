<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFlow extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $with = ['company', 'supplier', 'typeOfExpense', 'department', 'log_actions','user'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function typeOfExpense()
    {
        return $this->belongsTo(TypeOfExpanse::class, 'expense_type_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function log_actions()
    {
        return $this->hasMany(LogAction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
