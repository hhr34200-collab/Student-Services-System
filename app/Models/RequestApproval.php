<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestApproval extends Model
{
    use HasFactory;

    protected $primaryKey = 'approval_id';

    protected $fillable = [

        'request_id',

        'employee_id',

        'stage',

        'approval_text',

        'approval_status',

        'is_locked',

        'approved_at'

    ];

    /*
    |--------------------------------------------------------------------------
    | العلاقات
    |--------------------------------------------------------------------------
    */

    // كل إفادة تتبع طلبًا واحدًا
    public function request()
    {
       return $this->belongsTo(
    RequestModel::class,
    'request_id',
    'request_id'
);
    }

    // كل إفادة كتبها موظف واحد
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    protected $casts = [
    'approved_at' => 'datetime',
];

}