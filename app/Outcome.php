<?php

namespace App;

use App\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outcome extends Model
{
  use SoftDeletes;
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'outcomes';

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

  public function materials()
  {
      return $this->belongsToMany('App\Material', 'material_outcome', 'outcome_id' , 'material_id')->withPivot('quantity' , 'order_number')->withTimestamps();;
  }
  public function products()
  {
      return $this->belongsToMany('App\Product', 'outcome_product', 'outcome_id' , 'product_id')->withPivot('quantity')->withTimestamps();
  }

  public function hasProducts(){
    $relatedProducts = [];
    foreach ($this->products as $value) {
      $relatedProducts[] = $value->id;
    }
    return Product::whereIn('id',$relatedProducts)->count();
  }

  public function hasMaterials(){
    $relatedMaterials = [];
    foreach ($this->materials as $value) {
      $relatedMaterials[] = $value->id;
    }
    return Material::whereIn('id',$relatedMaterials)->count();
  }

  public function getAllOutcomes(){
    return $this->all()->count();
  }
// Date Of Created Material In Outcome
  public function materialDateCreated($id){
    $outcome  = Outcome::findOrFail($id);
    if (is_null($outcome->materials)) {
      $created = null;
      return $created;
    }else {
      foreach ($outcome->materials as $value) {
        $created = $value->pivot->created_at;
        return $created;
      }
    }
  }
// Date Of Created Material In Outcome
  public function productDateCreated($id){
    $outcome  = Outcome::findOrFail($id);
    if (is_null($outcome->products)) {
       $created = null;
       return $created;
    }else {
      foreach ($outcome->products as $value) {
        if($outcome->products->last() === $value){
            $created = $value->pivot->created_at;
            return $created;
        }
      }
    }
  }

//  Outcome Period
public function outcomePeriod($id){
  $forProduct = $this->productDateCreated($id) ;
  $forMaterial = $this->materialDateCreated($id) ;
  if (!is_null($this->productDateCreated($id)) && !is_null($this->materialDateCreated($id))) {
        $start = Carbon::parse($forMaterial);
        $end = Carbon::parse($forProduct);
        $hours = $end->diffInHours($start);
        $minutes = $end->diffInMinutes($start);
        if ($minutes%60 == 0) {
          $outcomePeriod = $hours . ' ' . __('translations.hour');
        }else {
          $m = $minutes%60 ;
          $outcomePeriod = $hours .' '.__('translations.hour').' '.__('translations.and').' '.$m.' '.  __('translations.minutes');
        }

    return $outcomePeriod;
  }
}

// all outcomes to replace except the exit one
    public function allOutcomesToCanceled($id){
       $cancelreason = Outcome::whereNotNull('cancel_reason')->pluck('cancel_reason');
       $outcomes = $this->where('id','!=',$id)->whereNull('cancel_reason')->whereNotIn('process_number' , $cancelreason)->where('created_at','>',$this->created_at)->get();
       return $outcomes ;
    }
//  remaining quantity for order
  public function remainQuantityOutcome( $product_id , $procesNumber){
    $id = Outcome::where('process_number' , $procesNumber)->pluck('id');

    $outcomeQuantity = DB::table('outcome_product')->where('outcome_id',$id)->where('product_id',$product_id)->sum('quantity');
    $storeIds = Store::whereNull('cancel_reason')->pluck('id');

    $storeQuantity = DB::table('store_product')->where('code_number' ,$procesNumber)
    ->where('product_id' ,$product_id)->whereIn('store_id', $storeIds)->sum('quantity');
    $remain =  $outcomeQuantity - $storeQuantity;
    return $remain;
  }
  // outcome related with stores
    public function hasStores($id){
      $procesNumber = $this->where('id',$id)->pluck('process_number');
      $stores = DB::table('store_product')->where('code_number' ,$procesNumber )->count();
      return $stores;
    }

}
