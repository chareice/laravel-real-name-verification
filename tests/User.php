<?php


namespace Tests;


use Chareice\RealNameVerification\Contracts\RealNameVerifiableContract;
use Chareice\RealNameVerification\Data\RealNameData;
use Chareice\RealNameVerification\Traits\RealNameVerifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model implements RealNameVerifiableContract
{
    use RealNameVerifiable;


    public function updateRealNameData(RealNameData $data)
    {
        $userRealNameInfo = new UserRealNameInfo();
        $userRealNameInfo->name = $data->params['Name'];

        $this->realNameInfo()->save($userRealNameInfo);
    }

    public function realNameStatus(): string
    {
        return $this->realNameInfo()->exists() ? "finished" : "pending";
    }

    public function realNameInfo() : HasOne
    {
        return $this->hasOne(UserRealNameInfo::class);
    }
}