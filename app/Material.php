<?php

namespace App;

use App\Supplier;
use App\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'materials';

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
    //protected $guarded =[];
    public function outcomes()
    {
        return $this->belongsToMany('App\Outcome', 'material_outcome', 'material_id' , 'outcome_id')->withPivot('quantity' , 'order_number')->withTimestamps();
    }

    public function material_type()
    {
        return $this->belongsTo('App\MaterialType' , 'material_type_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function hasOrders()
    {
      return Order::where('material_id',$this->id)->count();
    }
    public function hasOutcomes(){
      $relatedOutcomes = [];
      foreach ($this->outcomes as $value) {
        $relatedOutcomes[] = $value->id;
      }
      return Outcome::whereIn('id',$relatedOutcomes)->count();
    }

    public function hasOrdersDetaisl(){
      return Order::where('material_id',$this->id)->whereNull('cancel_reason')->get();
    }

    public function getType($keyword){
      if ($keyword == __('translations.primary') ) {
        return $this->type = 0 ;
      }elseif ($keyword == __('translations.secondary') ) {
        return $this->type = 1 ;
      }else{
        return '';
      }
    }

    public function getQuantityType($keyword){
      if ($keyword == __('translations.kilo')) {
        return $this->quantity_type = 0 ;
      }elseif ($keyword == __('translations.piece')) {
        return $this->quantity_type = 1 ;
      }else{
        return '';
      }
    }
    // all materials existed
    public function getAllMaterials(){
      $materials = $this->all()->count();
      return $materials;
    }

    public function getAllPrimaryMaterials(){
      $materialtypes = $this->all()->where('type',0)->count();
      return $materialtypes;
    }
    public function getAllSecondaryMaterials(){
      $materialtypes = $this->all()->where('type',1)->count();
      return $materialtypes;
    }

  //  all quantites used in orders for one material
    public function allOrderQuantitiesForOneMaterial($id){
      $material = $this->findOrFail($id);
      $quantity = 0;
      if (!is_null($material->orders)){
        foreach ($material->orders as $value) {
          if (is_null($value->cancel_reason)) {
            $quantity += $value->quantity;
          }
        }
        return $quantity;
      }
    }

  //  all quantites used in outcomes for one material
    public function allOutcomeQuantitiesForOneMaterial($id){
      $material = $this->findOrFail($id);
      $quantity = 0;
      if (!is_null($material->outcomes)){
        foreach ($material->outcomes as $value) {
          if (is_null($value->cancel_reason)) {
            $quantity += $value->pivot->quantity;
          }
        }
        return $quantity;
      }
    }

// Remaining Quantity
 public function remainingQuantity($id){
   $orderQuantity = $this->allOrderQuantitiesForOneMaterial($id);
   $outcomeQuantity = $this->allOutcomeQuantitiesForOneMaterial($id);
   $remain = $orderQuantity - $outcomeQuantity ;
   return $remain;
 }

public function allMaxOrders($id){
  $x= $this->remainingQuantity($id);
  return $this->where('id', $id)->where('max_order' , '<=' , $x)->pluck('max_order');
}

}
