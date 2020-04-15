<?php namespace App\Models;

class DeliveryCode extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'delivery_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'weight',
        'customer_id',
        'status',
        'staff_id',
        'order_code',
        'note'
    ];

    const STATUS_NOT_RECIVE = 1;
    const STATUS_RECIVED = 2;
    const STATUS_PAYED = 3;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\DeliveryCodePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\DeliveryCodeObserver);
    }

    // Relations
    public function customer()
    {
        return $this->belongsTo(\App\Models\AdminUser::class, 'customer_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(\App\Models\AdminUser::class, 'staff_id', 'id');
    }

    

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'weight' => $this->weight,
            'customer_id' => $this->customer_id,
            'status' => $this->status,
        ];
    }

}
