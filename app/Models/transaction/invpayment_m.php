<?php

namespace App\Models\transaction;

use App\Models\core_m;

class invpayment_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek invpayment
        if ($this->request->getVar("inv_id")) {
            $invpaymentd["inv_id"] = $this->request->getVar("inv_id");
        } else {
            $invpaymentd["inv_id"] = -1;
        }
        $us = $this->db
            ->table("inv")
            ->getWhere($invpaymentd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "invpayment_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $inv) {
                foreach ($this->db->getFieldNames('inv') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $inv->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('inv') as $field) {
                $data[$field] = "";
            }
        }
        $data["inv_no"] = $this->request->getGet("inv_no");
        $data["inv_id"] = $this->request->getGet("inv_id");
        $data["customer_name"] = $this->request->getGet("customer_name");
        $data["customer_id"] = $this->request->getGet("customer_id");



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $invpayment_id =   $this->request->getPost("invpayment_id");

            //delete invpayment
            $this->db
                ->table("invpayment")
                ->delete(array("invpayment_id" =>  $invpayment_id));


            // Hitung total pembayaran dari invpayment
            $inv_no = $this->request->getGet("inv_no");
            $invpayment_total = $this->db
                ->table("invpayment")
                ->select("SUM(invpayment_total) AS inv_payment")
                ->where("inv_no", $inv_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $inv_payment = $invpayment_total ? $invpayment_total->inv_payment : 0;

            // Siapkan data update
            $inputi = [
                "inv_payment" => $inv_payment
            ];

            // Lakukan update pada tabel inv
            $this->db
                ->table("inv")
                ->where("inv_no", $inv_no)
                ->update($inputi);

            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'invpayment_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $this->db->table('invpayment')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $invpayment_id = $this->db->insertID();


            // Hitung total pembayaran dari invpayment
            $inv_no = $this->request->getGet("inv_no");
            $invpayment_total = $this->db
                ->table("invpayment")
                ->select("SUM(invpayment_total) AS inv_payment")
                ->where("inv_no", $inv_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $inv_payment = $invpayment_total ? $invpayment_total->inv_payment : 0;

            // Siapkan data update
            $inputi = [
                "inv_payment" => $inv_payment
            ];

            // Lakukan update pada tabel inv
            $this->db
                ->table("inv")
                ->where("inv_no", $inv_no)
                ->update($inputi);


            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;



        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'invpayment_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('invpayment')->update($input, array("invpayment_id" => $this->request->getPost("invpayment_id")));

            // Hitung total pembayaran dari invpayment
            $inv_no = $this->request->getGet("inv_no");
            $invpayment_total = $this->db
                ->table("invpayment")
                ->select("SUM(invpayment_total) AS inv_payment")
                ->where("inv_no", $inv_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $inv_payment = $invpayment_total ? $invpayment_total->inv_payment : 0;

            // Siapkan data update
            $inputi = [
                "inv_payment" => $inv_payment
            ];

            // Lakukan update pada tabel inv
            $this->db
                ->table("inv")
                ->where("inv_no", $inv_no)
                ->update($inputi);




            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }

        //update invoice
        if ($this->request->getPost("changeinv") == "OK") {
            $input["inv_ppn1k1"] = 0;
            $input["inv_ppn11"] = 0;
            $input["inv_ppn12"] = 0;
            $input["inv_pph"] = 0;
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'changeinv' && $e != 'customer_singkatan') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);die;
            $invNo = $input["inv_no"];
            $invpayment  = $this->db
                ->table('invpayment')
                ->where('inv_no', $invNo)
                ->get();
            $total = 0;
            $jobdano      = array();
            foreach ($invpayment->getResult() as $rinvpayment) {
                $total += $rinvpayment->invpayment_total;
                if ($rinvpayment->job_dano !== '' && ! in_array($rinvpayment->job_dano, $jobdano)) {
                    $jobdano[] = $rinvpayment->job_dano;
                }
            }

            $jobdanos      = implode(', ', $jobdano);
            $input["job_dano"] = $jobdanos;
            $input["inv_tagihan"] = $total;

            $this->db->table('inv')->update($input, array("inv_id" => $this->request->getPost("inv_id")));


            //updane nomor invoice invpayment
            $inputad["invpayment_date"] = $input["inv_date"];
            $this->db
                ->table('invpayment')
                ->where('inv_no', $invNo)
                ->update($inputad);
            // echo $this->db->getLastQuery(); die;



            //update job
            $inputjob["inv_no"] = $input["inv_no"];
            $this->db
                ->table('job')
                ->whereIn('job_dano', $jobdano)
                ->update($inputjob);


            $data["message"] = "Insert Data Success";
            header('Location: ' . base_url('inv'));
            exit;
        }
        return $data;
    }
}
