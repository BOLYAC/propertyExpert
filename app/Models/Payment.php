<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
  use  SoftDeletes;

  protected $guarded = [];

  protected $dates = ['payment_date'];

  /**
   * Get the route key for the model.
   *
   * @return string
   */
  public function getRouteKeyName()
  {
    return 'external_id';
  }


  public function invoice()
  {
    return $this->belongsTo(Invoice::class);
  }

  public static function boot()
  {
    parent::boot();

    static::creating(function ($payment) { // On create() method call this
      $payment->team_id = auth()->user()->currentTeam->id ?? '1';
    });
  }
}
