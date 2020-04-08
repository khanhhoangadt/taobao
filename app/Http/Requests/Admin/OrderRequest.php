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
        $id = ($this->method() == 'PUT') ? $this->route('order') : 0;

        return [
            'code' => 'required|unique:orders,code,'.$id,
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'Mã hoá đơn đã tồn tại',
            'code.required' => 'Mã hoá đơn là bắt buộc'
        ];
    }

}
