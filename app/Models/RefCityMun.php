<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RefCityMun extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'psgcCode',
        'citymunDesc',
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
}
