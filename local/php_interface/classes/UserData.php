<?php
use Bitrix\Highloadblock as HL;


class UserData
{
    protected function getDataClass()
    {
        $hlblock   = HL\HighloadBlockTable::getById(HLB_USER_DATA_ID)->fetch();
        $entity   = HL\HighloadBlockTable::compileEntity( $hlblock );
        return $entity->getDataClass();
    }

    public function insert($data)
    {
        if(is_array($data) && !empty($data)){
            $entity = $this->getDataClass();
            $res = $entity::add($data);
            return $res;
        }
        return NULL;
    }

    public function update($id , $data)
    {
        if(is_array($data) && !empty($data)){
            $entity = $this->getDataClass();
            $res = $entity::update($id , $data);
            return $res;
        }
        return NULL;
    }

    public function delete($id)
    {
        $entity = $this->getDataClass();
        $res = $entity::delete($id);
        return $res;
    }

    public function getList($params)
    {
        $entity = $this->getDataClass();
        $res = $entity::getList($params);
        return $res;
    }
}
