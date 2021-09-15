<?php


namespace Chareice\RealNameVerification\Data;


use Chareice\RealNameVerification\Exceptions\Exception;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

abstract class BaseData
{
    /**
     * @throws Exception
     */
    public function __construct(array $params)
    {
        $this->verifyData($params);
    }

    /**
     * @throws Exception
     */
    protected function verifyData(array $params) {
        $validator = \Illuminate\Support\Facades\Validator::make($params, $this->verifyRules());

        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    abstract protected function verifyRules(): array;
}