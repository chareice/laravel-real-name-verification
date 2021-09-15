# Laravel Real Name Verification
使用腾讯云的OCR接口对证照图片进行识别

安装方法：
```bash
composer require chareice/laravel-real-name-verification
```
## 个人实名认证
对身份证图片进行OCR识别

```php
class User extends Model implements RealNameVerifiableContract
{
    use RealNameVerifiable;
    
    // 传入 updateRealNameData 的参数为识别到的数据
    public function updateRealNameData(RealNameData $data)
    {
        ...
    }

    // 返回用户是否已经进行了实名认证
    public function realNameVerified(): bool
    {
        ...
    }
}

$user = User::first();

// 验证成功，调用 $user 的 updateRealNameData 方法
// 验证失败，抛出异常
$user->verify($frontImageURL);

```
或者直接调用 
```php
app(VerifyService::class)->verifyIDCard($frontImgURL, $backImgURL);
```

## 企业营业执照认证
对营业执照图片进行OCR识别

```php
class Company extends Model implements BizLicenseVerifiableContract
{
    use BizLicenseVerifiable;

    public function updateBizLicenseData(BizLicenseData $data)
    {
        ...
    }

    public function bizLicenseVerified(): bool
    {
        ...
    }
}

$company = Company::first();

$company->verify($licenseImgURL);
```

或者直接调用
```php
app(VerifyService::class)->verifyBizLicense($licenseImgURL);
```