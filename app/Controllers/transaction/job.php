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
        $data["ppn"]=0;
        $data["title"]="Job";
        return view('transaction/job_v', $data);
    }


    public function ppn()
    {
        $data = new \App\Models\transaction\job_m();
        $data = $data->data();
        $data["ppn"]=1;
        $data["title"]="Customer PPN";
        return view('transaction/job_v', $data);
    }


    public function nppn()
    {
        $data = new \App\Models\transaction\job_m();
        $data = $data->data();
        $data["ppn"]=2;
        $data["title"]="Customer Non PPN";
        return view('transaction/job_v', $data);
    }
}
