<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $table = 'school';
    protected $primaryKey = 'id';

    public function teacher()
    {
        return $this->hasMany(User::class, 'school_id', 'id');
    }

    // # of licenses currently in use i.e. non-deleted
    public function activelicences() 
    {
        return $this->teacher->where('is_deleted', 0)->count();
    }

}
