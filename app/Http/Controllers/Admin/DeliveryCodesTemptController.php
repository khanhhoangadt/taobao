<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\DeliveryCodesTemptRepositoryInterface;
use App\Http\Requests\Admin\DeliveryCodesTemptRequest;
use App\Http\Requests\PaginationRequest;

class DeliveryCodesTemptController extends Controller
{
    /** @var  \App\Repositories\DeliveryCodesTemptRepositoryInterface */
    protected $deliveryCodesTemptRepository;

    public function __construct(
        DeliveryCodesTemptRepositoryInterface $deliveryCodesTemptRepository
    ) {
        $this->deliveryCodesTemptRepository = $deliveryCodesTemptRepository;
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
        $paginate['baseUrl']    = action('Admin\DeliveryCodesTemptController@index');

        $filter = [];
        $keyword = $request->get('keyword');
        if (!empty($keyword)) {
            $filter['code'] = $keyword;
        }

        $count = $this->deliveryCodesTemptRepository->countByFilter($filter);
        $deliveryCodesTempts = $this->deliveryCodesTemptRepository->getByFilter($filter, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);

        return view(
            'pages.admin.' . config('view.admin') . '.delivery-codes-tempts.index',
            [
                'deliveryCodesTempts'    => $deliveryCodesTempts,
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
            'pages.admin.' . config('view.admin') . '.delivery-codes-tempts.edit',
            [
                'isNew'     => true,
                'deliveryCodesTempt' => $this->deliveryCodesTemptRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    $request
     * @return  \Response
     */
    public function store(DeliveryCodesTemptRequest $request)
    {
        $input = $request->only(
            [
                            'name',
                            'code',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $deliveryCodesTempt = $this->deliveryCodesTemptRepository->create($input);

        if( empty($deliveryCodesTempt) ) {
            return redirect()->back()->with('message-error', trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\DeliveryCodesTemptController@index')
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
        $deliveryCodesTempt = $this->deliveryCodesTemptRepository->find($id);
        if( empty($deliveryCodesTempt) ) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.delivery-codes-tempts.edit',
            [
                'isNew' => false,
                'deliveryCodesTempt' => $deliveryCodesTempt,
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
    public function update($id, DeliveryCodesTemptRequest $request)
    {
        /** @var  \App\Models\DeliveryCodesTempt $deliveryCodesTempt */
        $deliveryCodesTempt = $this->deliveryCodesTemptRepository->find($id);
        if( empty($deliveryCodesTempt) ) {
            abort(404);
        }

        $input = $request->only(
            [
                            'name',
                            'code',
                        ]
        );

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->deliveryCodesTemptRepository->update($deliveryCodesTempt, $input);

        return redirect()->action('Admin\DeliveryCodesTemptController@show', [$id])
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
        /** @var  \App\Models\DeliveryCodesTempt $deliveryCodesTempt */
        $deliveryCodesTempt = $this->deliveryCodesTemptRepository->find($id);
        if( empty($deliveryCodesTempt) ) {
            abort(404);
        }
        $this->deliveryCodesTemptRepository->delete($deliveryCodesTempt);

        return redirect()->action('Admin\DeliveryCodesTemptController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
