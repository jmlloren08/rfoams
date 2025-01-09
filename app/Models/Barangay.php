<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brgy_code',
        'brgy_desc',
        'reg_code',
        'prov_code',
        'citymun_code'
    ];
    
    public function refregion()
    {
        return $this->belongsTo(Region::class);
    }
    public function refprovince()
    {
        return $this->belongsTo(Province::class);
    }
    public function refcitymun()
    {
        return $this->belongsTo(CitiesMunicipalities::class);
    }
}
