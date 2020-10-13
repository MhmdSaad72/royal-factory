<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndirectCost extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'indirect_costs';

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

    public function indirect_cost_types(){
      return $this->belongsTo('App\IndirectCostType' , 'indirect_cost_type_id');
    }

    public function showIndirectCostType($id){
      $indirectCostType = DB::table('indirect_cost_types')->where('id', $id)->first();
      return $indirectCostType;
    }


}
