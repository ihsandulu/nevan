<?php

namespace App\Models\master;

use App\Models\core_m;

class mcustomer_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek customer
        if ($this->request->getVar("customer_id")) {
            $customerd["customer_id"] = $this->request->getVar("customer_id");
        } else {
            $customerd["customer_id"] = -1;
        }
        $us = $this->db
            ->table("customer")
            ->getWhere($customerd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "customer_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $customer) {
                foreach ($this->db->getFieldNames('customer') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $customer->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('customer') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $customer_id =   $this->request->getPost("customer_id");
            $this->db
                ->table("customer")
                ->delete(array("customer_id" =>  $customer_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'customer_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('customer');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $customer_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'customer_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('customer')->update($input, array("customer_id" => $this->request->getPost("customer_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
