<?php

namespace App\Models\transaction;

use App\Models\core_m;

class cost_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek cost
        if ($this->request->getVar("cost_id")) {
            $costd["cost_id"] = $this->request->getVar("cost_id");
        } else {
            $costd["cost_id"] = -1;
        }
        $us = $this->db
            ->table("cost")
            ->getWhere($costd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "cost_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $cost) {
                foreach ($this->db->getFieldNames('cost') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $cost->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('cost') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $cost_id =   $this->request->getPost("cost_id");
            $this->db
                ->table("cost")
                ->delete(array("cost_id" =>  $cost_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'cost_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $cekdano = $this->db
                ->table("cost")
                ->orderBy("cost_dano", "desc")
                ->limit(1)
                ->get();
            $dano = 250001;
            foreach ($cekdano->getResult() as $dano) {
                $dano = $dano->cost_dano + 1;
            }
            $input["cost_dano"] = $dano;

            $cekinv = $this->db
                ->table("cost")
                ->orderBy("cost_invoice", "desc")
                ->limit(1)
                ->get();
            $cost_invoice = 1;
            foreach ($cekinv->getResult() as $cekinv) {
                $acost_invoice = explode("/", $cekinv->cost_invoice);
                $cost_invoice = $acost_invoice[0] + 1;
            }
            $cost_invoice = str_pad($cost_invoice, 3, "0", STR_PAD_LEFT);

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

            $cost_invoice = $cost_invoice . "/INV/NKL-" . $input["customer_singkatan"] . "/" .$romawi[$bulan]."/". date("Y");
            $input["cost_invoice"] = $cost_invoice;
            $input["cost_date"] = date("Y-m-d");
            $builder = $this->db->table('cost');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $cost_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'cost_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('cost')->update($input, array("cost_id" => $this->request->getPost("cost_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
