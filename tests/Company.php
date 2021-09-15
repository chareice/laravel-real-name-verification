<?php


namespace Tests;


use Chareice\RealNameVerification\Contracts\BizLicenseVerifiableContract;
use Chareice\RealNameVerification\Data\BizLicenseData;
use Chareice\RealNameVerification\Traits\BizLicenseVerifiable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model implements BizLicenseVerifiableContract
{
    use BizLicenseVerifiable;

    public function updateBizLicenseData(BizLicenseData $data)
    {
        $this->reg_num = $data->reg_num;
        $this->save();
    }

    public function bizLicenseVerified(): bool
    {
        return isset($this->reg_num);
    }
}