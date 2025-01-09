<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalFieldOffice extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfo',
        'user_id',
        'position',
        'contact_number',
        'reg_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'reg_code', 'reg_code');
    }
}
