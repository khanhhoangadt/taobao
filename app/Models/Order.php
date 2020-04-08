<?php namespace App\Models;



class Order extends Base
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'deliveried_money',
        'total_money',
        'customer_id',
        'time',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['time'];

    protected $presenter = \App\Presenters\OrderPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\OrderObserver);
    }

    // Relations
    public function adminUser()
    {
        return $this->belongsTo(\App\Models\AdminUser::class, 'admin_user_id', 'id');
    }

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
            'code' => $this->code,
            'deliveried_money' => $this->deliveried_money,
            'total_money' => $this->total_money,
            'admin_user_id' => $this->admin_user_id,
            'customer_id' => $this->customer_id,
            'time' => $this->time,
        ];
    }

}
