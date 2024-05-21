<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RefBrgy extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brgyCode',
        'brgyDesc',
        'regCode',
        'provCode',
        'citymunCode'
    ];
    public function refregion()
    {
        return $this->belongsTo(RefRegion::class);
    }
    public function refprovince()
    {
        return $this->belongsTo(RefProvince::class);
    }
    public function refcitymun()
    {
        return $this->belongsTo(RefCityMun::class);
    }
}
