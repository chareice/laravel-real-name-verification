<?php

namespace Chareice\RealNameVerification\Traits;

use Chareice\RealNameVerification\Data\BizLicenseData;
use Chareice\RealNameVerification\Exceptions\Exception;
use Chareice\RealNameVerification\VerifyService;
use Chareice\TencentCloud\Service;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ocr\V20181119\Models\BizLicenseOCRRequest;

trait BizLicenseVerifiable
{
    /**
     * 进行企业营业执照认证
     * @throws Exception
     */
    public function verify(string $licenseImg) : bool
    {
        /** @var VerifyService $verifyService */
        $verifyService = app(VerifyService::class);
        $this->updateBizLicenseData($verifyService->verifyBizLicense($licenseImg));
        return true;
    }

    abstract public function updateBizLicenseData(BizLicenseData $data);
}
