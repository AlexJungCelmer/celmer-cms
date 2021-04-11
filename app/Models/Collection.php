<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    public function apps()
    {
        return $this->belongsToMany(Application::class);
    }

    protected $fillable = [
        'name',
        'label',
        'fields',
        'options',
    ];
}
