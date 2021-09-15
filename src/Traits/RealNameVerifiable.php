<?php

namespace Chareice\RealNameVerification\Traits;

use Chareice\RealNameVerification\Data\RealNameData;
use Chareice\RealNameVerification\Exceptions\Exception;
use Chareice\RealNameVerification\VerifyService;

trait RealNameVerifiable
{
    /**
     * 进行实名认证
     * @throws Exception
     */
    public function verify(string $frontImgURL, string $backImgURL = null) : bool
    {
        /** @var VerifyService $verifyService */
        $verifyService = app(VerifyService::class);
        $this->updateRealNameData($verifyService->verifyIDCard($frontImgURL, $backImgURL));
        return true;
    }

    abstract public function updateRealNameData(RealNameData $data);
}
