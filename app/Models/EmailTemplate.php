<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    public $table = 'email_templates';

    public $fillable = ['emp_id', 'subject', 'message', 'image'];

    public static function getAllEmployee()
    {
        return User::pluck('name', 'id')->toArray();
    }

    public function getEmployeeName()
    {
        return $this->belongsTo(User::class,'emp_id');
    }
}
