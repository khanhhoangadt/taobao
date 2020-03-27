<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\DeliveryCodeRepositoryInterface;
use App\Http\Requests\Admin\DeliveryCodeRequest;
use App\Http\Requests\PaginationRequest;

class DeliveryCodeController extends Controller
{
    /** @var  \App\Repositories\DeliveryCodeRepositoryInterface */
    protected $deliveryCodeRepository;

    public function __construct(
        DeliveryCodeRepositoryInterface $deliveryCodeRepository
    ) {
        $this->deliveryCodeRepository = $deliveryCodeRepository;
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
        $paginate['baseUrl']    = action('Admin\DeliveryCodeController@index');

        $filter = [];
        $keyword = $request->get('keyword');
        if (!empty($keyword)) {
            $filter['query'] = $keyword;
        }

        $count = $this->deliveryCodeRepository->countByFilter($filter);
        $deliveryCodes = $this->deliveryCodeRepository->getByFilter($filter, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);

        return view(
            'pages.admin.' . config('view.admin') . '.delivery-codes.index',
            [
                'deliveryCodes'    => $deliveryCodes,
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
            'pages.admin.' . config('view.admin') . '.delivery-codes.edit',
            [
                'isNew'     => true,
                'deliveryCode' => $this->deliveryCodeRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    $request
     * @return  \Response
     */
    public function store(DeliveryCodeRequest $request)
    {
        $input = $request->only(
            [
                            'code',
                            'weight',
                            'customer_id',
                            'status',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $deliveryCode = $this->deliveryCodeRepository->create($input);

        if( empty($deliveryCode) ) {
            return redirect()->back()->with('message-error', trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\DeliveryCodeController@index')
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
        $deliveryCode = $this->deliveryCodeRepository->find($id);
        if( empty($deliveryCode) ) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.delivery-codes.edit',
            [
                'isNew' => false,
                'deliveryCode' => $deliveryCode,
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
    public function update($id, DeliveryCodeRequest $request)
    {
        /** @var  \App\Models\DeliveryCode $deliveryCode */
        $deliveryCode = $this->deliveryCodeRepository->find($id);
        if( empty($deliveryCode) ) {
            abort(404);
        }

        $input = $request->only(
            [
                            'code',
                            'weight',
                            'customer_id',
                            'status',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->deliveryCodeRepository->update($deliveryCode, $input);

        return redirect()->action('Admin\DeliveryCodeController@show', [$id])
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
        /** @var  \App\Models\DeliveryCode $deliveryCode */
        $deliveryCode = $this->deliveryCodeRepository->find($id);
        if( empty($deliveryCode) ) {
            abort(404);
        }
        $this->deliveryCodeRepository->delete($deliveryCode);

        return redirect()->action('Admin\DeliveryCodeController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
