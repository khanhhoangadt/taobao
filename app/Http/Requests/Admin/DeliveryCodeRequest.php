<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\DeliveryCodeRepositoryInterface;

class DeliveryCodeRequest extends BaseRequest
{

    /** @var \App\Repositories\DeliveryCodeRepositoryInterface */
    protected $deliveryCodeRepository;

    public function __construct(DeliveryCodeRepositoryInterface $deliveryCodeRepository)
    {
        $this->deliveryCodeRepository = $deliveryCodeRepository;
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
        return $this->deliveryCodeRepository->rules();
    }

    public function messages()
    {
        return $this->deliveryCodeRepository->messages();
    }

}
