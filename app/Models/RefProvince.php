<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RefProvince extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'psgcCode',
        'provDesc',
        'regCode',
        'provCode'
    ];

    public function refregion()
    {
        return $this->belongsTo(RefRegionV2::class);
    }
}
