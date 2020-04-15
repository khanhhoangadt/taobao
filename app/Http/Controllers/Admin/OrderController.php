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
use App\Models\DeliveryCode;
use App\Models\AdminUserRole;
use Illuminate\Support\Facades\Log;
use App\Repositories\AdminUserRepositoryInterface;

class OrderController extends Controller
{
    /** @var  \App\Repositories\OrderRepositoryInterface */
    protected $orderRepository;
    protected $adminService;
    protected $orderDeliveryRepo;
    protected $deliveryCodeRepo;
    protected $adminRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        AdminUserServiceInterface $adminService,
        OrdersDeliveryRepositoryInterface $orderDeliveryRepo,
        DeliveryCodeRepositoryInterface $deliveryCodeRepo,
        AdminUserRepositoryInterface $adminRepo
    ) {
        $this->orderRepository = $orderRepository;
        $this->adminService = $adminService;
        $this->orderDeliveryRepo = $orderDeliveryRepo;
        $this->deliveryCodeRepo = $deliveryCodeRepo;
        $this->adminRepo = $adminRepo;
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

    public function listDeliveryCode(PaginationRequest $request)
    {
        $paginate['limit']      = $request->limit();
        $paginate['offset']     = $request->offset();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action('Admin\OrderController@listDeliveryCode');

        $filter = [];
        $keyword = $request->get('keyword');
        $userLogin = $this->adminService->getUser();
        if ($userLogin->hasRole(AdminUserRole::ROLE_CUSTOMER)) {
            $filter['customer_id'] = $userLogin->id;
        }

        if (!empty($keyword)) {
            $filter['code'] = $keyword;
        }
        $strDeliveryCode = "";
        $totalMoney = 0;
        if ($userLogin->hasRole(AdminUserRole::ROLE_CUSTOMER)) {
            $deliveryCodesReciveds = $this->deliveryCodeRepo->allByStatusAndCustomerId(DeliveryCode::STATUS_RECIVED, $userLogin->id);
            $arrWeight = $deliveryCodesReciveds->pluck('weight')->toArray();
            $totalMoney = $this->adminRepo->getMonney($userLogin->id, $arrWeight);
            foreach($deliveryCodesReciveds as $key => $deliveryCodesRecived) {
                if ($key != 0) {
                    $strDeliveryCode .= ', ';
                }
                $strDeliveryCode .= $deliveryCodesRecived->code;
            }
        }

        $count = $this->deliveryCodeRepo->countByFilter($filter);
        $deliveryCodes = $this->deliveryCodeRepo->getByFilter($filter, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);

        return view(
            'pages.admin.' . config('view.admin') . '.orders.delivery_codes',
            [
                'deliveryCodes' => $deliveryCodes,
                'count'         => $count,
                'paginate'      => $paginate,
                'keyword'       => $keyword,
                'totalMoney' => $totalMoney,
                'strDeliveryCode' => $strDeliveryCode
            ]
        );
    }

    public function createDeliveryCode()
    {
        return view(
            'pages.admin.' . config('view.admin') . '.orders.create-delivery-code',
            [
            ]
        );
    }

    public function saveDeliveryCode(BaseRequest $request)
    {
        $input = $request->only(['code', 'order_code', 'note']);
        $userLogin = $this->adminService->getUser();
        /**
         * tạo delivery code trong bảng delivery
         * tạo bản ghi trong  bảng order delivery
        */
        try {
            $deliveryCodeCreated = $this->deliveryCodeRepo->findByCode($input['code']);
            if (!empty($deliveryCodeCreated)) {
                return redirect()->back()->withErrors('Mã vận đơn đã tồn tại');
            }
            $input['customer_id'] = $userLogin->id;
            $this->deliveryCodeRepo->create($input);
    
            return redirect()->action('Admin\OrderController@listDeliveryCode')
            ->with('message-success', trans('admin.messages.general.create_success'));

        } catch (\Exception $e) {
            Log::error('OrderController@saveDeliveryCode'. $e->getMessage().$e->getLine());
            return redirect()->back()->withErrors('Tạo mã vận đơn thất bại');
        }
    }

    public function destroyDeliveryCode($deliveryCodeId)
    {
        try {
            $deliveryCode = $this->deliveryCodeRepo->findById($deliveryCodeId);
            $userLogin = $this->adminService->getUser();
            if ($deliveryCode->customer_id != $userLogin->id) { //Ma van don khong thuoc ve user dang dang nhap
                return false;
            }

            if ($deliveryCode->status == DeliveryCode::STATUS_PAYED) {
                return false;
            }
            $deliveryCode->delete();
        } catch (\Exception $e) {
            Log::error('OrderController@destroyDeliveryCode'. $e->getMessage().$e->getLine());
        }
    }
}
