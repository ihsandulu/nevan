<?php

namespace App\Controllers\transaction;


use App\Controllers\BaseController;

class kas extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\kas_m();
        $data = $data->data();
        $data["title"]="Kas";
        return view('transaction/kas_v', $data);
    }
}
