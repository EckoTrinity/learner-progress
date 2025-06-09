<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];

    /**
     * Get the enrolments for the learner.
     *
     * This defines a one-to-many relationship between Learner and Enrolment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrolments()
    {
        return $this->hasMany(Enrolment::class, 'learner_id');
    }
}
