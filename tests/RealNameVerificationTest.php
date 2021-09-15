<?php


namespace Tests;


use Chareice\RealNameVerification\Exceptions\Exception;
use Chareice\TencentCloud\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ocr\V20181119\Models\IDCardOCRResponse;
use TencentCloud\Ocr\V20181119\OcrClient;

class RealNameVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function successResponse()
    {
        $data = ' {
    "Name": "石桂圆",
    "Sex": "男",
    "Nation": "汉",
    "Birth": "1998/8/6",
    "Address": "甘肃省陇南市武都区黄坪乡楼房坝行政村133号",
    "IdNum": "622621199808062814",
    "Authority": "",
    "ValidDate": "",
    "AdvancedInfo": "{}",
    "RequestId": "76eef904-5280-4651-b7d4-7b49f7f7792d"
  }';
        $resp = new IDCardOCRResponse();
        $resp->fromJsonString($data);
        return $resp;
    }

    public function test_success_real_name_verify()
    {
        $this->instance(Service::class, \Mockery::mock(Service::class, function (MockInterface $mock) {
            $OcrClient = \Mockery::mock(OcrClient::class);
            $OcrClient->shouldReceive('IDCardOCR')->andReturn($this->successResponse());

            $mock->shouldReceive('OcrClient')->once()->andReturn($OcrClient);
        }));

        /** @var User $user */
        $user = User::query()->create();
        $this->assertFalse($user->realNameVerified());

        $user->verify("test");
        $this->assertTrue($user->realNameVerified());
    }

    public function test_fail_real_name_verify()
    {
        $this->instance(Service::class, \Mockery::mock(Service::class, function (MockInterface $mock) {
            $OcrClient = \Mockery::mock(OcrClient::class);
            $OcrClient->shouldReceive('IDCardOCR')->andThrow(new TencentCloudSDKException('FailedOperation.ImageNoIdCard', '照片未检测到身份证', 'test'));

            $mock->shouldReceive('OcrClient')->once()->andReturn($OcrClient);
        }));

        /** @var User $user */
        $user = User::query()->create();
        $this->assertFalse($user->realNameVerified());

        $this->expectException(Exception::class);
        $user->verify("test");
        $this->assertFalse($user->realNameVerified());
    }
}