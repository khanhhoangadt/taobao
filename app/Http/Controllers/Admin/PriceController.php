<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\PriceRepositoryInterface;
use App\Http\Requests\Admin\PriceRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\AdminUserRepositoryInterface;
use App\Models\AdminUserRole;

class PriceController extends Controller
{
    /** @var  \App\Repositories\PriceRepositoryInterface */
    protected $priceRepository;
    protected $adminUserRepository;

    public function __construct(
        PriceRepositoryInterface $priceRepository,
        AdminUserRepositoryInterface $adminUserRepository
    ) {
        $this->priceRepository = $priceRepository;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param    \App\Http\Requests\PaginationRequest $request
     * @return  \Response
     */
    public function index(PaginationRequest $request)
    {
        $paginate['limit']      = $request->limit();
        $paginate['offset']     = $request->offset();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action('Admin\PriceController@index');

        $filter = [];
        $code = $request->get('keyword');
        $customer = $this->adminUserRepository->findByCode($code);
        if (!empty($customer)) {
            $filter['customer_id'] = $customer->id;
        }

        $count = $this->priceRepository->countByFilter($filter);
        $prices = $this->priceRepository->getByFilter($filter, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);

        return view(
            'pages.admin.' . config('view.admin') . '.prices.index',
            [
                'prices'    => $prices,
                'count'         => $count,
                'paginate'      => $paginate,
                'keyword'       => $code
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Response
     */
    public function create()
    {
        $customers = $this->adminUserRepository->allByRole(AdminUserRole::ROLE_CUSTOMER);
        
        return view(
            'pages.admin.' . config('view.admin') . '.prices.edit',
            [
                'isNew'     => true,
                'price' => $this->priceRepository->getBlankModel(),
                'customers' => $customers
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    $request
     * @return  \Response
     */
    public function store(PriceRequest $request)
    {
        $input = $request->only(
            [
                            'customer_id',
                            'qty',
                            'price',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $price = $this->priceRepository->create($input);

        if( empty($price) ) {
            return redirect()->back()->with('message-error', trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\PriceController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Response
     */
    public function show($id)
    {
        $price = $this->priceRepository->find($id);
        if( empty($price) ) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.prices.edit',
            [
                'isNew' => false,
                'price' => $price,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int $id
     * @return  \Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    int $id
     * @param            $request
     * @return  \Response
     */
    public function update($id, PriceRequest $request)
    {
        /** @var  \App\Models\Price $price */
        $price = $this->priceRepository->find($id);
        if( empty($price) ) {
            abort(404);
        }

        $input = $request->only(
            [
                            'customer_id',
                            'qty',
                            'price',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->priceRepository->update($price, $input);

        return redirect()->action('Admin\PriceController@show', [$id])
                    ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Response
     */
    public function destroy($id)
    {
        /** @var  \App\Models\Price $price */
        $price = $this->priceRepository->find($id);
        if( empty($price) ) {
            abort(404);
        }
        $this->priceRepository->delete($price);

        return redirect()->action('Admin\PriceController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
