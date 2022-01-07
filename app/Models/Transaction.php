<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function SubCategory()
    {
    	return $this->belongsTo(SubCategory::class);
    }

    public function User()
    {
    	return $this->belongsTo(User::class);
    }
 
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
