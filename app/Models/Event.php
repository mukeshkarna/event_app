<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'end_date',
        'created_by',
        'start_date',
        'description',
    ];

    /**
     * Relation with user.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
