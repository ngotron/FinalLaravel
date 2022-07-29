<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'id_product', 'id');
    }
}
