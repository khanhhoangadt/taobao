<?php namespace App\Models;



class DeliveryCodesTempt extends Base
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'delivery_codes_tempts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\DeliveryCodesTemptPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\DeliveryCodesTemptObserver);
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
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

}
