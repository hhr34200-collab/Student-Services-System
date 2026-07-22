<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $primaryKey = 'service_id';

    protected $fillable = [

        'service_name',

        'description',

        'status'

    ];

    /*
    |--------------------------------------------------------------------------
    | الطلبات
    |--------------------------------------------------------------------------
    */

    public function requests()
    {
        return $this->hasMany(
            RequestModel::class,
            'service_id',
            'service_id'
        );
    }
public function getIconAttribute()
{
    return match ($this->service_name) {

        'وقف القيد' =>
        'fa-solid fa-pause-circle',

        'إعادة القيد' =>
        'fa-solid fa-play-circle',

        'التظلم' =>
        'fa-solid fa-scale-balanced',

        'الانسحاب من الدراسة' =>
        'fa-solid fa-person-walking-arrow-right',

        'التحويل بين الكليات' =>
        'fa-solid fa-right-left',

        'بيان حالة' =>
        'fa-solid fa-file-lines',

        'تغيير التخصص' =>
        'fa-solid fa-arrows-rotate',

        default =>
        'fa-solid fa-file'
    };
}
public function getRouteNameAttribute()
{
    return match ($this->service_name) {

        'وقف القيد' => 'stop-enrollment',

        'إعادة القيد' => 'reopen-enrollment',

        'التظلم' => 'appeal',

        default => null,
    };
}
}