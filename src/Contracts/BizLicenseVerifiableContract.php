<?php


namespace Chareice\RealNameVerification\Contracts;


use Chareice\RealNameVerification\Data\BizLicenseData;

interface BizLicenseVerifiableContract
{
    /**
     * @param string $licenseImg 营业执照图片
     * @return bool
     */
    public function verify(string $licenseImg) : bool;

    /**
     * 是否已认证
     * @return bool
     */
    public function bizLicenseVerified() :bool;


    /**
     * 更新营业执照认证数据
     * @return void
     */
    public function updateBizLicenseData(BizLicenseData $data);
}