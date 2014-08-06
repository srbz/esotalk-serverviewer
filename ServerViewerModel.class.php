<?php

if(!defined("IN_ESOTALK")) exit;

class ServerViewerModel extends ETModel
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
}
