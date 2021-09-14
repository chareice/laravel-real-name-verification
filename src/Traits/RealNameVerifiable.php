<?php

namespace Chareice\RealNameVerification\Traits;

use Chareice\RealNameVerification\Data\RealNameData;
use Chareice\RealNameVerification\Exceptions\Exception;
use Chareice\TencentCloud\Service;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ocr\V20181119\Models\IDCardOCRRequest;

trait RealNameVerifiable
{
    /**
     * 进行实名认证
     * @throws Exception
     */
    public function verify(string $frontImgURL, string $backImgURL = null) : bool
    {
        /** @var Service $tencentCloud */
        $tencentCloud = app(Service::class);
        $ocrClient = $tencentCloud->OcrClient();
        $req = new IDCardOCRRequest();
        $params = [
            'ImageUrl' => $frontImgURL,
        ];

        $req->fromJsonString(json_encode($params));

        try {
            $resp = $ocrClient->IDCardOCR($req);

            $data = $resp->serialize();

            $this->updateRealNameData(new RealNameData($data));
            return true;
        } catch (TencentCloudSDKException $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    abstract public function updateRealNameData(RealNameData $data);
}
