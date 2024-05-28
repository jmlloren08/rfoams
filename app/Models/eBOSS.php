<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class eBOSS extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_of_inspection',
        'city_municipality',
        'province',
        'region',
        'date_submitted',
        'type_of_boss',
        'deadline_of_action_plan',
        'submission_of_action_plan',
        'remarks',
        'bplo_head',
        'contact_no'
    ];
}
