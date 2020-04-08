<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\OrderRepositoryInterface;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\AdminUserServiceInterface;
use \App\Repositories\OrdersDeliveryRepositoryInterface;
use \App\Repositories\DeliveryCodeRepositoryInterface;
use App\Http\Requests\BaseRequest;
use DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /** @var  \App\Repositories\OrderRepositoryInterface */
    protected $orderRepository;
    protected $adminService;
    protected $orderDeliveryRepo;
    protected $deliveryCodeRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        AdminUserServiceInterface $adminService,
        OrdersDeliveryRepositoryInterface $orderDeliveryRepo,
        DeliveryCodeRepositoryInterface $deliveryCodeRepo
    ) {
        $this->orderRepository = $orderRepository;
        $this->adminService = $adminService;
        $this->orderDeliveryRepo = $orderDeliveryRepo;
        $this->deliveryCodeRepo = $deliveryCodeRepo;
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
        $userLogin = $this->adminService->getUser();
        $filter['customer_id'] = $userLogin->id;
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
                'time',
            ]
        );
        $userLogin = $this->adminService->getUser();
        $input['customer_id'] = $userLogin->id;
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

    public function listDeliveryCode($orderId)
    {
        $deliveryIds = $this->orderDeliveryRepo->allByOrderId($orderId)->pluck('delivery_code_id')->toArray();
        $deliveryCodes = $this->deliveryCodeRepo->allByIds($deliveryIds);
        
        return view(
            'pages.admin.' . config('view.admin') . '.orders.delivery_codes',
            [
                'deliveryCodes' => $deliveryCodes,
                'orderId' => $orderId
            ]
        );
    }

    public function createDeliveryCode($orderId)
    {
        return view(
            'pages.admin.' . config('view.admin') . '.orders.create-delivery-code',
            [
                'orderId' => $orderId
            ]
        );
    }

    public function saveDeliveryCode(BaseRequest $request)
    {
        $orderId = $request->get('order_id');
        $deliveryCode = $request->get('delivery_code');
        /**
         * tạo delivery code trong bảng delivery
         * tạo bản ghi trong  bảng order delivery
        */
        try {
            DB::beginTransaction();
            $order = $this->orderRepository->find($orderId);
            $deliveryInput = [];
            $deliveryInput['code'] = $deliveryCode;
            $deliveryInput['customer_id'] = $order->customer_id;
            $deliveryCreated = $this->deliveryCodeRepo->create($deliveryInput);
            $deliveryOrderInput = [];
            $deliveryOrderInput['order_id'] = $orderId;
            $deliveryOrderInput['delivery_code_id'] = $deliveryCreated->id;
            $this->orderDeliveryRepo->create($deliveryOrderInput);
            DB::commit();

            return redirect()->action('Admin\OrderController@listDeliveryCode', $orderId)
            ->with('message-success', trans('admin.messages.general.create_success'));

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('OrderController@saveDeliveryCode'. $e->getMessage().$e->getLine());
        }
    }

    public function destroyDeliveryCode($deliveryCodeId)
    {
        try {
            DB::beginTransaction();
            $deliveryCodeOrder = $this->orderDeliveryRepo->findByDeliveryCodeId($deliveryCodeId);
            $deliveryCode = $deliveryCodeOrder->deliveryCode;
            $userLogin = $this->adminService->getUser();
            if ($deliveryCode->customer_id != $userLogin->id) { //Ma van don khong thuoc ve user dang dang nhap
                return false;
            }
            $deliveryCode->delete();
            $deliveryCodeOrder->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('OrderController@destroyDeliveryCode'. $e->getMessage().$e->getLine());
        }
    }
}
