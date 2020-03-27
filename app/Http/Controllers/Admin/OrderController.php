<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\OrderRepositoryInterface;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Requests\PaginationRequest;

class OrderController extends Controller
{
    /** @var  \App\Repositories\OrderRepositoryInterface */
    protected $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
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
        $paginate['baseUrl']    = action('Admin\OrderController@index');

        $filter = [];
        $keyword = $request->get('keyword');
        if (!empty($keyword)) {
            $filter['query'] = $keyword;
        }

        $count = $this->orderRepository->countByFilter($filter);
        $orders = $this->orderRepository->getByFilter($filter, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);

        return view(
            'pages.admin.' . config('view.admin') . '.orders.index',
            [
                'orders'    => $orders,
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
            'pages.admin.' . config('view.admin') . '.orders.edit',
            [
                'isNew'     => true,
                'order' => $this->orderRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    $request
     * @return  \Response
     */
    public function store(OrderRequest $request)
    {
        $input = $request->only(
            [
                            'code',
                            'deliveried_money',
                            'total_money',
                            'admin_user_id',
                            'customer_id',
                            'time',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $order = $this->orderRepository->create($input);

        if( empty($order) ) {
            return redirect()->back()->with('message-error', trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\OrderController@index')
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
        $order = $this->orderRepository->find($id);
        if( empty($order) ) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.orders.edit',
            [
                'isNew' => false,
                'order' => $order,
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
    public function update($id, OrderRequest $request)
    {
        /** @var  \App\Models\Order $order */
        $order = $this->orderRepository->find($id);
        if( empty($order) ) {
            abort(404);
        }

        $input = $request->only(
            [
                            'code',
                            'deliveried_money',
                            'total_money',
                            'admin_user_id',
                            'customer_id',
                            'time',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->orderRepository->update($order, $input);

        return redirect()->action('Admin\OrderController@show', [$id])
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
        /** @var  \App\Models\Order $order */
        $order = $this->orderRepository->find($id);
        if( empty($order) ) {
            abort(404);
        }
        $this->orderRepository->delete($order);

        return redirect()->action('Admin\OrderController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
