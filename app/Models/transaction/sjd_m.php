<?php

namespace App\Models\transaction;

use App\Models\core_m;

class sjd_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        $data["job_temp"] = $this->request->getVar("temp");



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $sjd_id =   $this->request->getPost("sjd_id");

            //delete sjd
            $this->db
                ->table("sjd")
                ->delete(array("sjd_id" =>  $sjd_id));

            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'sjd_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $this->db->table('sjd')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $sjd_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'sjd_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('sjd')->update($input, array("sjd_id" => $this->request->getPost("sjd_id")));


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
