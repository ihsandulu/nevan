<?php

namespace App\Models\transaction;

use App\Models\core_m;

class cost_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        $data["job_temp"] = $this->request->getVar("temp");



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $cost_id =   $this->request->getPost("cost_id");

            //delete cost
            $this->db
                ->table("cost")
                ->delete(array("cost_id" =>  $cost_id));

            //edit job
            $jobtemp = $this->request->getGet("temp");
            $usr = $this->db->table("cost")->select("SUM(cost_total)AS total")->where("job_temp", $jobtemp)->get();
            $total = 0;
            foreach ($usr->getResult() as $row) {
                $inputjob["job_cost"] = $row->total;
                $this->db->table("job")->where("job_temp", $jobtemp)->update($inputjob);
            }
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'cost_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $this->db->table('cost')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $cost_id = $this->db->insertID();

            //edit job
            $jobtemp = $this->request->getGet("temp");
            $usr = $this->db->table("cost")->select("SUM(cost_total)AS total")->where("job_temp", $jobtemp)->get();
            // echo $this->db->getLastQuery();die;
            $total = 0;
            foreach ($usr->getResult() as $row) {
                $inputjob["job_cost"] = $row->total;
                $this->db->table("job")->where("job_temp", $jobtemp)->update($inputjob);
            }
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

            //edit job
            $jobtemp = $this->request->getGet("temp");
            $usr = $this->db->table("cost")->select("SUM(cost_total)AS total")->where("job_temp", $jobtemp)->get();
            
            $total = 0;
            foreach ($usr->getResult() as $row) {
                $inputjob["job_cost"] = $row->total;
                $this->db->table("job")->where("job_temp", $jobtemp)->update($inputjob);               
            }

            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
