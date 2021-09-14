<?php


namespace Chareice\RealNameVerification\Contracts;


use Chareice\RealNameVerification\Data\RealNameData;

interface RealNameVerifiableContract
{
    /**
     *
     * @param string $frontImgURL 身份证人像面图片
     * @param string|null $backImgURL  身份证国徽面图片
     * @return bool
     */
    public function verify(string $frontImgURL, string $backImgURL = null) : bool;

    /**
     * 获取实名认证状态
     * @return string
     */
    public function realNameStatus() : string;

    /**
     * 更新实名认证信息
     * @param RealNameData $data
     * @return void
     */
    public function updateRealNameData(RealNameData $data);
}