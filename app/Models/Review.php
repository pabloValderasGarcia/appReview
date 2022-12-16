<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $table = 'review';
    protected $fillable = ['type', 'rate', 'title', 'excerpt', 'message', 'thumbnail', 'idUser'];
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'idUser');
    }
    
    public function images() {
        return $this->hasMany('App\Models\Image', 'idReview');
    }
    
    function deleteReview() {
        try {
            $this->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    function storeReview() {
        try {
            $this->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    function updateReview($reviewData) {
        try {
            $this->update($reviewData);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
