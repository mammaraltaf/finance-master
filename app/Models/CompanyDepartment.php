<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    use HasFactory;
    public $table = 'company_departments';
    protected $fillable = ['company_id', 'department_id'];
}
