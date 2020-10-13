<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
  use SoftDeletes;
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'stocks';

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

  public function products()
  {
      return $this->belongsToMany('App\Product', 'store_product', 'store_id' , 'product_id')->withPivot('quantity' , 'code_number')->withTimestamps();
  }

  // public function hasProducts()
  // {
  //   return Product::where('id',$this->product_id)->count();
  // }

  public function getAllStores(){
    return $this->all()->count();
  }


// all stores to replace except the exit one
  public function allStoresToCanceled($id){
   $cancelreason = Store::whereNotNull('cancel_reason')->pluck('cancel_reason');
   $stores = $this->where('id','!=',$id)->whereNull('cancel_reason')->whereNotIn('process_number' , $cancelreason)->where('created_at','>',$this->created_at)->get();
   return $stores ;
  }

//  product name
  public function productName($id){
    return Product::where('id',$id)->first();
  }

  public function hasProducts(){
    $relatedProducts = [];
    foreach ($this->products as $value) {
      $relatedProducts[] = $value->id;
    }
    return Product::whereIn('id',$relatedProducts)->count();
  }


}
