<?php namespace App\Models;



class OderDelivery extends Base
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oder_deliveries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\OderDeliveryPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\OderDeliveryObserver);
    }

    // Relations
    

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id' => $this->id,
            
        ];
    }

}
