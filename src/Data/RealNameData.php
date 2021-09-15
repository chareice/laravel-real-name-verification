<?php


namespace Chareice\RealNameVerification\Data;


use Carbon\Carbon;
use Chareice\RealNameVerification\Exceptions\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RealNameData
{
    /**
     * @var string 身份证人像URL
     */
    public string $frontImgURL;

    /**
     * @var string 姓名
     */
    public string $name;

    /**
     * @var string 身份证号码
     */
    public string $idNum;

    /**
     * @var int 性别
     */
    public int $sex;

    /**
     * @var string 民族
     */
    public string $nation;

    /**
     * @var string 生日
     */
    public string $birthday;

    /**
     * @var string 地址
     */
    public string $address;

    /**
     * @throws Exception
     */
    public function __construct(array $params)
    {
        $this->checkParams($params);

        $this->name = $params['Name'];
        $this->idNum = $params['IdNum'];
        $this->sex = $params['Sex'] == '男' ? 1 : 2;
        $this->nation = $params['Nation'];
        $this->birthday = $params['Birth'];
        $this->address = $params['Address'];
    }

    /**
     * @throws Exception
     */
    protected function checkParams($params)
    {
        $validator = Validator::make($params, [
            'Name' => 'required',
            'IdNum' => 'required',
            'Sex' => ['required', Rule::in(['男', '女'])],
            'Nation' => 'required',
            'Birth' => 'required',
            'Address' => 'required'
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}