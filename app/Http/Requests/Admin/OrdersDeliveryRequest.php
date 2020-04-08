<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\OrdersDeliveryRepositoryInterface;

class OrdersDeliveryRequest extends BaseRequest
{

    /** @var \App\Repositories\OrdersDeliveryRepositoryInterface */
    protected $ordersDeliveryRepository;

    public function __construct(OrdersDeliveryRepositoryInterface $ordersDeliveryRepository)
    {
        $this->ordersDeliveryRepository = $ordersDeliveryRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->ordersDeliveryRepository->rules();
    }

    public function messages()
    {
        return $this->ordersDeliveryRepository->messages();
    }

}
