<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\OrderRepositoryInterface;

class OrderRequest extends BaseRequest
{

    /** @var \App\Repositories\OrderRepositoryInterface */
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
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
        return $this->orderRepository->rules();
    }

    public function messages()
    {
        return $this->orderRepository->messages();
    }

}
