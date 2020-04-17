<?php

namespace App\Imports;

use App\Models\DeliveryCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\DeliveryCodesTempt;
use DB;
use Illuminate\Support\Facades\Log;
use App\Services\AdminUserServiceInterface;

class DeliveryCodeImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   
    public function model(array $row)
    {
        try {
            DB::beginTransaction();
            ini_set('memory_limit', -1);
            $code = $row[1];
            $name = $row[3];
            $weight = $row[4];
            
            if (is_int($code)) intval($code);
            
            $data = DeliveryCode::where('code', $code)->first();
            $userService = app()->make(AdminUserServiceInterface::class);
            $staff = $userService->getUser();
            if (!empty($data)) {
                $data->weight = $weight;
                $data->status = DeliveryCode::STATUS_RECIVED;
                $data->staff_id = $staff->id;
                $data->save();

            } else {
                if ($code || $name) {
                    $data = DeliveryCodesTempt::firstOrCreate([
                        'name' => $name,
                        'code' => $code
                    ]);
                }
            }
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('DeliveryCodeImport@model'. $e->getMessage().$e->getLine());
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
