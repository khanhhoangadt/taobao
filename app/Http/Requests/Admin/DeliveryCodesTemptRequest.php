<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\DeliveryCodesTemptRepositoryInterface;

class DeliveryCodesTemptRequest extends BaseRequest
{

    /** @var \App\Repositories\DeliveryCodesTemptRepositoryInterface */
    protected $deliveryCodesTemptRepository;

    public function __construct(DeliveryCodesTemptRepositoryInterface $deliveryCodesTemptRepository)
    {
        $this->deliveryCodesTemptRepository = $deliveryCodesTemptRepository;
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
        return $this->deliveryCodesTemptRepository->rules();
    }

    public function messages()
    {
        return $this->deliveryCodesTemptRepository->messages();
    }

}
