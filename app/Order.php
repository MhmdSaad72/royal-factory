<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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

    public function material()
    {
          return $this->belongsTo('App\Material', 'material_id');
    }
    public function supplier()
    {
          return $this->belongsTo('App\Supplier' , 'supplier_id');
    }

    public function allQuantitesForOneMaterial($id){
      $material = Material::findOrFail($id);
      $quantities = Order::where('material_id' , $material->id)->sum('quantity');
      return $quantities;

    }

    public function hasMaterial()
    {
      return Material::where('id',$this->material_id)->count();
    }
    public function hasSupplier()
    {
      return Supplier::where('id',$this->supplier_id)->count();
    }

    public function getAllOrders(){
      return $this->all()->count();
    }

// all orders to replace except the exit one
    public function allOrdersToCanceled($id){

       $cancelreason = Order::whereNotNull('cancel_reason')->pluck('cancel_reason');
       $orders = $this->where('id','!=',$id)->whereNull('cancel_reason')->whereNotIn('process_number',$cancelreason)->where('created_at','>',$this->created_at)->get();
       return $orders ;
    }
//  remaining quantity for order
  public function remainQuantityOrder($id ,$procesNumber){
    $orderQuantity  = $this->where('process_number',$procesNumber)->first('quantity');
    $outcomeIds = Outcome::whereNull('cancel_reason')->pluck('id');
    $outcomeQuantity = DB::table('material_outcome')->where('order_number' ,$procesNumber)
    ->where('material_id' ,$id)->whereIn('outcome_id' ,$outcomeIds )->sum('quantity');

      $quantity1 = $orderQuantity->quantity;
      $remain =  $quantity1 - $outcomeQuantity;
      return $remain;
  }

  // order related with outcomes
    public function hasOutcomes($id){
      $procesNumber = $this->where('id',$id)->pluck('process_number');
      $outcomes = DB::table('material_outcome')->where('order_number' ,$procesNumber )->count();
      return $outcomes;
    }


}
