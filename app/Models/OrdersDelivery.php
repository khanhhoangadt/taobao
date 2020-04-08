<?php namespace App\Models;



class OrdersDelivery extends Base
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders_deliveries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'delivery_code_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\OrdersDeliveryPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\OrdersDeliveryObserver);
    }

    // Relations
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id', 'id');
    }

    public function deliveryCode()
    {
        return $this->belongsTo(\App\Models\DeliveryCode::class, 'delivery_code_id', 'id');
    }

    

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'delivery_code_id' => $this->delivery_code_id,
        ];
    }

}
