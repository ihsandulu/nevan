<?php

namespace App\Controllers\transaction;


use App\Controllers\BaseController;

class job extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\job_m();
        $data = $data->data();
        return view('transaction/job_v', $data);
    }
}
