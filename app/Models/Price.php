<?php namespace App\Models;



class Price extends Base
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'qty',
        'price',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\PricePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\PriceObserver);
    }

    // Relations
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id', 'id');
    }

    

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'qty' => $this->qty,
            'price' => $this->price,
        ];
    }

}
