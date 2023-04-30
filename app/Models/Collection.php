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
            public function publisher()
        {
            return $this->belongsTo(Publisher::class, 'PubID');
        }

            public function author()
        {
            return $this->belongsTo(Author::class, 'AuthorID');
        }
            public function genre()
        {
            return $this->belongsTo(Genre::class, 'GenID');
        }

    protected $rules = [
            'Description' => 'required',
            // other rules here...
        ];
        

    
}
