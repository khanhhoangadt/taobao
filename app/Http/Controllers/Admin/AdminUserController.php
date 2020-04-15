<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\AdminUserRepositoryInterface;
use App\Http\Requests\Admin\AdminUserRequest;
use App\Http\Requests\PaginationRequest;
use App\Models\AdminUserRole;
use App\Services\FileUploadServiceInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\AdminUserRoleRepositoryInterface;
use App\Repositories\ConfigRepositoryInterface;
use App\Http\Requests\BaseRequest;
use App\Repositories\DeliveryCodeRepositoryInterface;
use App\Models\DeliveryCode;

class AdminUserController extends Controller
{

    /** @var \App\Repositories\AdminUserRepositoryInterface */
    protected $adminUserRepository;

    /** @var \App\Repositories\AdminUserRoleRepositoryInterface */
    protected $adminUserRoleRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;
    protected $configRepo;
    protected $deliveryCode;

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository,
        AdminUserRoleRepositoryInterface $adminUserRoleRepository,
        ConfigRepositoryInterface $configRepo,
        DeliveryCodeRepositoryInterface $deliveryCode
    )
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->fileUploadService = $fileUploadService;
        $this->imageRepository = $imageRepository;
        $this->adminUserRoleRepository = $adminUserRoleRepository;
        $this->configRepo = $configRepo;
        $this->deliveryCode = $deliveryCode;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     *
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $paginate['offset']     = $request->offset();
        $paginate['limit']      = $request->limit();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action('Admin\AdminUserController@index');

        $filter = [];
        $keyword = $request->get('keyword');
        if (!empty($keyword)) {
            $filter['query'] = $keyword;
        }

        $count = $this->adminUserRepository->countByFilter($filter);
        $adminUsers = $this->adminUserRepository->getByFilter($filter, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);
        
        return view(
            'pages.admin.' . config('view.admin') . '.admin-users.index',
            [
                'adminUsers' => $adminUsers,
                'count'      => $count,
                'paginate'   => $paginate,
                'keyword'    => $keyword
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view(
            'pages.admin.' . config('view.admin') . '.admin-users.edit',
            [
                'isNew'     => true,
                'adminUser' => $this->adminUserRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(AdminUserRequest $request)
    {
        $input = $request->only(
            [
                'name',
                'email',
                'password',
                're_password',
                'locale',
                'phone',
                'code'
            ]
        );
        $exist = $this->adminUserRepository->findByEmail($input['email']);
        if (!empty($exist)) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'This Email Is Already In Use'])
                ->withInput();
        }
        if ($input['password'] == '' || $input['password'] != $input['re_password']) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Error, Confirm password is invalid !!!'])
                ->withInput();
        }

        $adminUser = $this->adminUserRepository->create($input);

        if (empty($adminUser)) {
            return redirect()
                ->back()
                ->withErrors(trans('admin.errors.general.save_failed'));
        }

        $this->adminUserRoleRepository->setAdminUserRoles($adminUser->id, $request->input('role', []));

        if ($request->hasFile('profile_image')) {
            $file       = $request->file('profile_image');

            $image = $this->fileUploadService->upload(
                'user_profile_image',
                $file,
                [
                    'entity_type' => 'user_profile_image',
                    'entity_id'   => $adminUser->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($image)) {
                $this->adminUserRepository->update($adminUser, ['profile_image_id' => $image->id]);
            }
        }

        if ($request->get('role')[0] == AdminUserRole::ROLE_CUSTOMER) {
            if ($input['code'] == null) {
                $code = 'KH'.$adminUser->id;
                $this->adminUserRepository->update($adminUser, ['code' => $code]);
            }
        }

        return redirect()
            ->action('Admin\AdminUserController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function show($id)
    {
        $adminUser = $this->adminUserRepository->find($id);
        if (empty($adminUser)) {
            \App::abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.admin-users.edit',
            [
                'isNew'     => false,
                'adminUser' => $adminUser,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     *
     * @return \Response
     */
    public function update($id, AdminUserRequest $request)
    {
        /** @var \App\Models\AdminUser $adminUser */
        $adminUser = $this->adminUserRepository->find($id);
        if (empty($adminUser)) {
            \App::abort(404);
        }
        $input = $request->only(
            [
                'name',
                'email',
                'locale',
                'phone',
                'address',
            ]
        );

        $adminUser = $this->adminUserRepository->update($adminUser, $input);
        $this->adminUserRoleRepository->setAdminUserRoles($id, $request->input('role', []));

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $newImage = $this->fileUploadService->upload(
                'user_profile_image',
                $file,
                [
                    'entity_type' => 'user_profile_image',
                    'entity_id'   => $adminUser->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($newImage)) {
                $oldImage = $adminUser->coverImage;
                if (!empty($oldImage)) {
                    $this->fileUploadService->delete($oldImage);
                }

                $this->adminUserRepository->update($adminUser, ['profile_image_id' => $newImage->id]);
            }
        }

        return redirect()
            ->action('Admin\AdminUserController@show', [$id])
            ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function destroy($id)
    {
        /** @var \App\Models\AdminUser $adminUser */
        $adminUser = $this->adminUserRepository->find($id);
        if (empty($adminUser)) {
            \App::abort(404);
        }
        $this->adminUserRepository->delete($adminUser);

        return redirect()
            ->action('Admin\AdminUserController@index')
            ->with('message-success', trans('admin.messages.general.delete_success'));
    }

    public function payment(BaseRequest $request)
    {
        $code = $request->get('code', null);
        if (!$code) {
            return view(
                'pages.admin.' . config('view.admin') . '.admin-users.payment',
                []
            );
        }
        $customer = $this->adminUserRepository->findByCode($code);
        if (empty($customer)) return redirect()->back()->withErrors('Không có khách hàng phù hợp');

        $deliveryCodes = $this->deliveryCode->allByCustomerIdAndStatus($customer->id, DeliveryCode::STATUS_RECIVED);
        
        $arrWeight = $deliveryCodes->pluck('weight')->toArray();
        $money = $this->adminUserRepository->getMonney($customer->id, $arrWeight);

        return view(
            'pages.admin.' . config('view.admin') . '.admin-users.payment',
            [
                'customer' => $customer,
                'deliveryCodes' => $deliveryCodes,
                'money' => $money,
                'code' => $code
            ]
        ); 
    }

    public function updateStatusAfterPayment($customerId)
    {
        $deliveryCodes = $this->deliveryCode->allByCustomerIdAndStatus($customerId, DeliveryCode::STATUS_RECIVED);
        foreach($deliveryCodes as $deliveryCode) {
            $deliveryCode->status = DeliveryCode::STATUS_PAYED;
            $deliveryCode->save();
        }

        return redirect()->back()->with('message-success', 'Thanh toán thành công');
    }

    public function config()
    {
        $config = $this->configRepo->all();
        if (count($config)) {
            $config = $config->first();
        } else {
            $config = null;
        }
        
        return view(
            'pages.admin.' . config('view.admin') . '.admin-users.config',
            [
                'config' => $config
            ]
        );
    }

    public function storeConfig(BaseRequest $request)
    {
        $value = $request->get('config');
        if ($value == null) {
            return redirect()
                ->back()
                ->withErrors(trans('Bạn phải nhập giá trị'));
        }
        $config = $this->configRepo->all();
        
        if (count($config)) {
            $config = $config->first();
            $config->value = $value;
            $config->save();
        } else {
            $this->configRepo->create(['name' => config('app.monney_per_kg'), 'value' => $value]);
        }

        return redirect()
            ->back()
            ->with('message-success', trans('admin.messages.general.update_success'));
    }
}
