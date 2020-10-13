<?php

namespace App;

use App\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

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

    // public function materials()
    // {
    //       return $this->belongsToMany('App\Material', 'materials_orders_suppliers', 'supplier_id' , 'material_id');
    // }
    public function orders()
    {
          return $this->hasMany('App\Order');
    }

    public function hasOrders(){
      return Order::where('supplier_id' , $this->id)->count();
    }

    public function getAllSuppliers(){
      $suppliers = Supplier::all()->count();
      return $suppliers;
    }

}
