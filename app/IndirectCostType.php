<?php

namespace App;

use App\IndirectCost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndirectCostType extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'indirect_cost_types';

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

    public function indirect_cost(){
      return $this->hasMany('App\IndirectCost');
    }

    public function hasIndirectCosts()
    {
      return IndirectCost::where('indirect_cost_type_id',$this->id)->count();
    }


}
