<?php


namespace Chareice\RealNameVerification;


use Chareice\RealNameVerification\Data\BizLicenseData;
use Chareice\RealNameVerification\Data\RealNameData;
use Chareice\RealNameVerification\Exceptions\Exception;
use Chareice\TencentCloud\Service;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ocr\V20181119\Models\BizLicenseOCRRequest;
use TencentCloud\Ocr\V20181119\Models\IDCardOCRRequest;

class VerifyService
{
    private Service $tencentCloud;

    public function __construct(Service $tencentCloud)
    {
        $this->tencentCloud = $tencentCloud;
    }

    /**
     * @throws Exception
     */
    public function verifyIDCard(string $frontImgURL, string $backImgURL = null) :RealNameData
    {
        $ocrClient = $this->tencentCloud->OcrClient();

        $req = new IDCardOCRRequest();
        $params = [
            'ImageUrl' => $frontImgURL,
        ];
        $req->fromJsonString(json_encode($params));

        try {
            $resp = $ocrClient->IDCardOCR($req);
            $data = $resp->serialize();
            return new RealNameData($data);
        } catch (TencentCloudSDKException $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @throws Exception
     */
    public function verifyBizLicense(string $licenseImgURL) : BizLicenseData
    {
        /** @var Service $tencentCloud */
        $tencentCloud = app(Service::class);
        $ocrClient = $tencentCloud->OcrClient();

        $req = new BizLicenseOCRRequest();

        $params = [
            'ImageUrl' => $licenseImgURL,
        ];

        $req->fromJsonString(json_encode($params));

        try {
            $resp = $ocrClient->BizLicenseOCR($req);

            $data = $resp->serialize();

            return new BizLicenseData($data);
        } catch (TencentCloudSDKException $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}