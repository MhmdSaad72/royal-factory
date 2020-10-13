<?php

namespace App;

use App\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialType extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'material_types';

    /**;
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function materials()
    {
        return $this->hasMany('App\Material');
    }

    public function hasMaterials()
    {
      return Material::where('material_type_id',$this->id)->count();
    }

    // protected static function boot() {
    //   parent::boot();
    //
    //   static::deleted(function ($material) {
    //     $material->materials()->delete();
    //   });
    // }


}
