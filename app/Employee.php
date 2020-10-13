<?php

namespace App;

use App\PositionType;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

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

    public function position_type(){
      return $this->belongsTo('App\PositionType' , 'position_id');
    }

    public function showPositionType($id){
      $position = DB::table('position_types')->where('id', $id)->first();
      return $position;
    }

    public function getEmployeeType($keyword){
      if ($keyword == __('translations.seller')) {return $this->type = 0 ;}
      elseif ($keyword == __('translations.worker')) {return $this->type = 1 ;  }
      else{return '';}
    }

    public function getAllEmployees(){
      return $this->all()->count();
    }
}
