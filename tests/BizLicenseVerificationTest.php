<?php


namespace Tests;


use Chareice\RealNameVerification\Exceptions\Exception;
use Chareice\TencentCloud\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ocr\V20181119\Models\BizLicenseOCRResponse;
use TencentCloud\Ocr\V20181119\Models\IDCardOCRResponse;
use TencentCloud\Ocr\V20181119\OcrClient;

class BizLicenseVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function successResponse()
    {
        $data = ' {
    "RegNum": "110000012345678",
    "Person": "艾米",
    "Capital": "人民币600000万元整",
    "Name": "深圳市腾讯计算机系统有限公司",
    "Address": "深圳市南山区高新区高新南一路飞亚达大厦",
    "Period": "1998年11月至长期",
    "Business": "计算机软、硬件的设计、技术开发、销售(不含专营、专控、专卖商品及限制项目);数据库及计算机网络服务;国内商业、物资供销业(不含专营、专控、专卖商品)",
    "Type": "有限责任公司",
    "ComposingForm": "",
    "SetDate": "1998年11月",
    "RequestId": "c3025c22-e159-44fe-9850-91f30b2e2593"
  }';
        $resp = new BizLicenseOCRResponse();
        $resp->fromJsonString($data);
        return $resp;
    }

    public function test_verify_biz_license()
    {
        $this->instance(Service::class, \Mockery::mock(Service::class, function (MockInterface $mock) {
            $OcrClient = \Mockery::mock(OcrClient::class);
            $OcrClient->shouldReceive('BizLicenseOCR')->andReturn($this->successResponse());

            $mock->shouldReceive('OcrClient')->once()->andReturn($OcrClient);
        }));

        /** @var Company $company */
        $company = Company::query()->create();
        $this->assertFalse($company->bizLicenseVerified());
        $company->verify('test');

        $this->assertTrue($company->bizLicenseVerified());
    }

    public function test_failed_verify_biz_license()
    {
        $this->instance(Service::class, \Mockery::mock(Service::class, function (MockInterface $mock) {
            $OcrClient = \Mockery::mock(OcrClient::class);
            $OcrClient->shouldReceive('BizLicenseOCR')->andThrow(new TencentCloudSDKException('FailedOperation.OcrFailed', 'OCR识别失败。', 'test'));

            $mock->shouldReceive('OcrClient')->once()->andReturn($OcrClient);
        }));

        /** @var Company $company */
        $company = Company::query()->create();
        $this->assertFalse($company->bizLicenseVerified());
        $this->expectException(Exception::class);
        $company->verify('test');

        $this->assertFalse($company->realNameVerified());
    }
}