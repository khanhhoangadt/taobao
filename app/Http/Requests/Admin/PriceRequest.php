<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\PriceRepositoryInterface;

class PriceRequest extends BaseRequest
{

    /** @var \App\Repositories\PriceRepositoryInterface */
    protected $priceRepository;

    public function __construct(PriceRepositoryInterface $priceRepository)
    {
        $this->priceRepository = $priceRepository;
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
        return $this->priceRepository->rules();
    }

    public function messages()
    {
        return $this->priceRepository->messages();
    }

}
