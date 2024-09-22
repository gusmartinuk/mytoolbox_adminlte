<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Bir tag birçok nota ait olabilir
    public function notes()
    {
        return $this->belongsToMany(Note::class);
    }
}
