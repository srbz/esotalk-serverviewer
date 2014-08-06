<?php

if(!defined("IN_ESOTALK")) exit;

class ServerViewerAdminModel extends ETModel
{
    public function __construct()
    {
        parent::__construct("serverviewer", "id");
    }
    public function getServers()
    {
        $res = ET::SQL()->select("*")
            ->from($this->table)
            ->exec()
            ->allRows();
        return $res;
    }
    public function cleanFormData($formData)
    {
        //the array which form gives back is dirty... we have to clear it first
        unset($formData['token']);
        unset($formData['save']);
        unset($formData['cancel']);
        //return the not so dirty array
        return $formData;
    }
    public function addTransaction($values)
    {
        return ET::SQL()->insert($this->table)
                ->set($values)
                ->exec();
    }
    public function editTransaction($id,$values)
    {
        return ET::SQL()->update($this->table)
                ->set($values)
                ->where("id = ".$id)
                ->exec();
    }
}
