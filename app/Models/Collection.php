<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'Description',
        'AuthorID',
        'DatePublished',
        'PubID',
        'GenID',
    ];
    protected $primaryKey = 'BookID';
    
}
