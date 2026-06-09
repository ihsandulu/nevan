<?php

namespace App\Controllers\transaction;


use App\Controllers\BaseController;

class sjd extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\sjd_m();
        $data = $data->data();
        $data["title"]="Detail SJ";
        return view('transaction/sjd_v', $data);
    }
}
