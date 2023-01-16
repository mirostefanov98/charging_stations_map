<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ChargingStation extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'charging_stations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'images' => 'array'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($obj) {
            if (count((array)$obj->images)) {
                foreach ($obj->images as $file_path) {
                    Storage::disk('public')->delete($file_path);
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // One-Many inverse
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-Many inverse
    public function chargingStationType()
    {
        return $this->belongsTo(ChargingStationType::class);
    }

    // Many-Many
    public function plugTypes()
    {
        return $this->belongsToMany(PlugType::class);
    }

    // Many-Many
    public function paymentTypes()
    {
        return $this->belongsToMany(PaymentType::class);
    }

    // One-Many
    public function likes()
    {
        return $this->hasMany(ChargingStationLike::class)->where('like_type', 'true')->count();
    }

    // One-Many
    public function dislikes()
    {
        return $this->hasMany(ChargingStationLike::class)->where('like_type', 'false')->count();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setImagesAttribute($value)
    {
        $attribute_name = "images";
        $disk = "public";
        $destination_path = "images/stations";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
