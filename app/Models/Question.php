<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Question
 *
 * @property $id
 * @property $title
 * @property $body
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Question extends Model
{
    use HasFactory;
    
    static $rules = [
		'title' => 'required',
		'body' => 'required',
		'status' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title','body','status','user_id'];
    public function poster()
    {
        return $this->belongsTo(User::class);
    }
    
    public function repliers()
    {
        return $this->hasMany(User::class);
    }


}
