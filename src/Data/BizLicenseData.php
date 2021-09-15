<?php


namespace Chareice\RealNameVerification\Data;

class BizLicenseData extends BaseData
{
    /**
     * @var string 社会信用代码
     */
    public string $reg_num;

    /**
     * @var string 企业名称
     */
    public string $name;

    /**
     * @var string 注册资本
     */
    public string $capital;

    /**
     * @var string 企业法人
     */
    public string $person;

    /**
     * @var string 成立日期
     */
    public string $setDate;

    public function __construct(array $params)
    {
        parent::__construct($params);

        $this->name = $params['Name'];
        $this->reg_num = $params['RegNum'];
        $this->capital = $params['Capital'];
        $this->person = $params['Person'];
        $this->setDate = $params['SetDate'];
    }

    protected function verifyRules(): array
    {
        return [
            'Name' => 'required',
            'RegNum' => 'required',
            'Capital' => 'required',
            'Person' => 'required',
            'SetDate' => 'required'
        ];
    }
}