<?php

namespace App\Models\transaction;

use App\Models\core_m;

class job_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek job
        if ($this->request->getVar("job_id")) {
            $jobd["job_id"] = $this->request->getVar("job_id");
        } else {
            $jobd["job_id"] = -1;
        }
        $us = $this->db
            ->table("job")
            ->getWhere($jobd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "job_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $job) {
                foreach ($this->db->getFieldNames('job') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $job->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('job') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $job_id =   $this->request->getPost("job_id");
            $this->db
                ->table("job")
                ->delete(array("job_id" =>  $job_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'job_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $cekdano = $this->db
                ->table("job")
                ->orderBy("job_dano", "desc")
                ->limit(1)
                ->get();
            $dano = 250001;
            foreach ($cekdano->getResult() as $dano) {
                $dano = $dano->job_dano + 1;
            }
            $input["job_dano"] = $dano;

            $cekinv = $this->db
                ->table("job")
                ->orderBy("job_invoice", "desc")
                ->limit(1)
                ->get();
            $job_invoice = 1;
            foreach ($cekinv->getResult() as $cekinv) {
                $ajob_invoice = explode("/", $cekinv->job_invoice);
                $job_invoice = $ajob_invoice[0] + 1;
            }
            $job_invoice = str_pad($job_invoice, 3, "0", STR_PAD_LEFT);

            $bulan = date("n"); // angka bulan 1-12

            $romawi = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII',
            ];

            $job_invoice = $job_invoice . "/INV/NKL-" . $input["customer_singkatan"] . "/" .$romawi[$bulan]."/". date("Y");
            $input["job_invoice"] = $job_invoice;
            $input["job_date"] = date("Y-m-d");
            $builder = $this->db->table('job');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $job_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'job_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('job')->update($input, array("job_id" => $this->request->getPost("job_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
