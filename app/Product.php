<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use SoftDeletes;
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'products';

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

  public function outcomes()
  {
      return $this->belongsToMany('App\Outcome', 'outcome_product', 'product_id' , 'outcome_id')->withPivot('quantity')->withTimestamps();
  }

  public function stores()
  {
      return $this->belongsToMany('App\Store', 'store_product', 'product_id' , 'store_id')->withPivot('quantity' , 'code_number')->withTimestamps();
  }

  public function hasOutcomes(){
    $relatedOutcomes = [];
    foreach ($this->outcomes as $value) {
      $relatedOutcomes[] = $value->id;
    }
    return Outcome::whereIn('id',$relatedOutcomes)->count();
  }
  public function hasStores(){
    $relatedStores = [];
    foreach ($this->stores as $value) {
      $relatedStores[] = $value->id;
    }
    return Store::whereIn('id',$relatedStores)->count();
  }

  public function hasOutcome(){
    $relatedOutcomes = [];
    foreach ($this->outcomes as $value) {
      if (is_null($value->cancel_reason)) {
        $relatedOutcomes[] = $value->id;
      }
    }
    return Outcome::whereIn('id',$relatedOutcomes)->get();
  }

  public function getAllProducts(){
    $products = Product::all()->count();
    return $products;
  }

  //  all quantites used in outcomes for one product
    public function allOutcomeQuantitiesForOneProduct($id){
      $product = $this->findOrFail($id);
      $quantity = 0;
      if (!is_null($product->outcomes)){
        foreach ($product->outcomes as $value) {
          if (is_null($value->cancel_reason)) {
            $quantity += $value->pivot->quantity;
          }
        }
        return $quantity;
      }
    }

  //  all quantites used in outcomes for one product
    public function allStoreQuantitiesForOneProduct($id){
      $product = $this->findOrFail($id);
      $quantity = 0;
      if (!is_null($product->stores)){
        foreach ($product->stores as $value) {
          if (is_null($value->cancel_reason)) {
            $quantity += $value->pivot->quantity;
          }
        }
        return $quantity;
      }
    }

  // Remaining Quantity
   public function remainingQuantity($id){
     $storeQuantity = $this->allStoreQuantitiesForOneProduct($id);
     $outcomeQuantity = $this->allOutcomeQuantitiesForOneProduct($id);
     $remain = $outcomeQuantity - $storeQuantity ;
     return $remain;
   }

}
