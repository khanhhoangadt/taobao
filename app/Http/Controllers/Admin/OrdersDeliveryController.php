<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\OrdersDeliveryRepositoryInterface;
use App\Http\Requests\Admin\OrdersDeliveryRequest;
use App\Http\Requests\PaginationRequest;

class OrdersDeliveryController extends Controller
{
    /** @var  \App\Repositories\OrdersDeliveryRepositoryInterface */
    protected $ordersDeliveryRepository;

    public function __construct(
        OrdersDeliveryRepositoryInterface $ordersDeliveryRepository
    ) {
        $this->ordersDeliveryRepository = $ordersDeliveryRepository;
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
        $paginate['baseUrl']    = action('Admin\OrdersDeliveryController@index');

        $filter = [];
        $keyword = $request->get('keyword');
        if (!empty($keyword)) {
            $filter['query'] = $keyword;
        }

        $count = $this->ordersDeliveryRepository->countByFilter($filter);
        $ordersDeliveries = $this->ordersDeliveryRepository->getByFilter($filter, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);

        return view(
            'pages.admin.' . config('view.admin') . '.orders-deliveries.index',
            [
                'ordersDeliveries'    => $ordersDeliveries,
                'count'         => $count,
                'paginate'      => $paginate,
                'keyword'       => $keyword
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
        return view(
            'pages.admin.' . config('view.admin') . '.orders-deliveries.edit',
            [
                'isNew'     => true,
                'ordersDelivery' => $this->ordersDeliveryRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    $request
     * @return  \Response
     */
    public function store(OrdersDeliveryRequest $request)
    {
        $input = $request->only(
            [
                            'order_id',
                            'delivery_code_id',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $ordersDelivery = $this->ordersDeliveryRepository->create($input);

        if( empty($ordersDelivery) ) {
            return redirect()->back()->with('message-error', trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\OrdersDeliveryController@index')
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
        $ordersDelivery = $this->ordersDeliveryRepository->find($id);
        if( empty($ordersDelivery) ) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.orders-deliveries.edit',
            [
                'isNew' => false,
                'ordersDelivery' => $ordersDelivery,
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
    public function update($id, OrdersDeliveryRequest $request)
    {
        /** @var  \App\Models\OrdersDelivery $ordersDelivery */
        $ordersDelivery = $this->ordersDeliveryRepository->find($id);
        if( empty($ordersDelivery) ) {
            abort(404);
        }

        $input = $request->only(
            [
                            'order_id',
                            'delivery_code_id',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->ordersDeliveryRepository->update($ordersDelivery, $input);

        return redirect()->action('Admin\OrdersDeliveryController@show', [$id])
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
        /** @var  \App\Models\OrdersDelivery $ordersDelivery */
        $ordersDelivery = $this->ordersDeliveryRepository->find($id);
        if( empty($ordersDelivery) ) {
            abort(404);
        }
        $this->ordersDeliveryRepository->delete($ordersDelivery);

        return redirect()->action('Admin\OrdersDeliveryController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
