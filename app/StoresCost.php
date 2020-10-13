<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoresCost extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stores_costs';

    /**
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

    public function storesCostTypes(){
      return $this->belongsTo('App\StoresCostType' , 'stores_cost_type_id');
    }

    public function store(){
      return $this->belongsTo('App\Store');
    }

    public function showStoresCostType($id){
      $storeCostType = DB::table('stores_cost_types')->where('id', $id)->first();
      return $storeCostType;
    }


}
