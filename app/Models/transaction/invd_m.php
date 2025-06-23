<?php

namespace App\Models\transaction;

use App\Models\core_m;

class invd_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek invd
        if ($this->request->getVar("inv_id")) {
            $invdd["inv_id"] = $this->request->getVar("inv_id");
        } else {
            $invdd["inv_id"] = -1;
        }
        $us = $this->db
            ->table("inv")
            ->getWhere($invdd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "invd_id_dep", "trx_id", "trx_code");
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



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $invd_id =   $this->request->getPost("invd_id");
            //update invoice
            $inv_no =   $this->request->getPost("inv_no");
            $invd = $this->db->table('invd')
                ->where("inv_no", $inv_no)
                ->where("invd_id !=", $invd_id)
                ->get();
            $total = 0;
            $jobdano      = array();
            foreach ($invd->getResult() as $rinvd) {
                $total += $rinvd->invd_total;
                if ($rinvd->job_dano !== '' && ! in_array($rinvd->job_dano, $jobdano)) {
                    $jobdano[] = $rinvd->job_dano;
                }
            }
            $jobdanos      = implode(', ', $jobdano);
            $inputi["job_dano"] = $jobdanos;
            $inputi["inv_tagihan"] = $total;
            $this->db->table('inv')->update($inputi, array("inv_no" => $inv_no));
            // echo $this->db->getLastQuery();die;

            //update invoice table job   
            if ($this->request->getPost("job_id") != "0") {
                $job_id = $this->request->getPost("job_id");
                $inputj["inv_no"] = "";
                $this->db->table('job')->update($inputj, array("job_id" => $job_id));
            }

            //delete invd
            $this->db
                ->table("invd")
                ->delete(array("invd_id" =>  $invd_id));

            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'invd_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $this->db->table('invd')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $invd_id = $this->db->insertID();

            $inv_no =   $this->request->getGet("inv_no");
            //update invoice
            if ($this->request->getGet("editinv") == "OK") {
                $invd = $this->db->table('invd')->where("inv_no", $inv_no)->get();
                $total = 0;
                $jobdano      = array();
                foreach ($invd->getResult() as $rinvd) {
                    $total += $rinvd->invd_total;
                    if ($rinvd->job_dano !== '' && ! in_array($rinvd->job_dano, $jobdano)) {
                        $jobdano[] = $rinvd->job_dano;
                    }
                }
                $jobdanos      = implode(', ', $jobdano);
                $inv = $this->db->table('inv')->where("inv_no", $inv_no)->get();
                $diskon = 0;
                foreach ($inv->getResult() as $rinv) {
                    $diskon = $rinv->inv_discount;
                }
                $inputi["job_dano"] = $jobdanos;
                $inputi["inv_tagihan"] = $total;
                $inputi["inv_dtagihan"] = $total - $diskon;
                $this->db->table('inv')->update($inputi, array("inv_no" => $inv_no));
            }

            //update invoice table job   
            if ($this->request->getPost("job_id") != "0") {
                $job_id = $this->request->getPost("job_id");
                $inputj["inv_no"] = $inv_no;
                $this->db->table('job')->update($inputj, array("job_id" => $job_id));
            }
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //insert inv
        if ($this->request->getPost("createinv") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'inv_id' && $e != 'customer_singkatan' && $e != 'createinv') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $invNo = $this->request->getGet('inv_no');
            $invd  = $this->db
                ->table('invd')
                ->where('inv_no', $invNo)
                ->get();
            $total = 0;
            $jobdano      = array();
            foreach ($invd->getResult() as $rinvd) {
                $total += $rinvd->invd_total;
                if ($rinvd->job_dano !== '' && ! in_array($rinvd->job_dano, $jobdano)) {
                    $jobdano[] = $rinvd->job_dano;
                }
            }
            $jobdanos      = implode(', ', $jobdano);
            $input["job_dano"] = $jobdanos;
            $input["inv_tagihan"] = $total;

            $bulan = date("n", strtotime($input["inv_date"])); // angka bulan 1-12

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

            $inv = $this->db->table("inv")->orderBy("inv_id", "DESC")->limit(1)->get();
            $noinv = 1;
            foreach ($inv->getResult() as $row) {
                $invNon = $row->inv_no;
                $inve = explode("/", $invNon);
                $noinv = $inve[0] + 1;
            }
            $noinv   = str_pad($noinv, 3, '0', STR_PAD_LEFT);
            $singkatan = $this->request->getPost("customer_singkatan");
            $invNon = $noinv . "/INV/NKL-" . $singkatan . "/" . $romawi[$bulan] . "/" . date("Y", strtotime($input["inv_date"]));
            $input["inv_no"] = $invNon;

            // $input["inv_dtagihan"] = $input["inv_tagihan"] - $input["inv_discount"];
            
            $dtagihan = $input["inv_tagihan"] - $input["inv_discount"];
            $ppn1k1 = 0;
            $ppn11 = 0;
            $ppn12 = 0;
            $pph = 0;
            $input["inv_dtagihan"] = $dtagihan;
            if (isset($input["inv_ppn1k1"]) && $input["inv_ppn1k1"] > 0) {
                $ppn1k1 = $dtagihan * 1.1 / 100;
            }
            if (isset($input["inv_ppn11"]) && $input["inv_ppn11"] > 0) {
                $ppn11 = $dtagihan * 11 / 100;
            }
            if (isset($input["inv_ppn12"]) && $input["inv_ppn12"] > 0) {
                $ppn12 = $dtagihan * 12 / 100;
            }
            if (isset($input["inv_pph"]) && $input["inv_pph"] > 0) {
                $pph = $dtagihan * 2 / 100;
            }
            $tharga = $dtagihan + $ppn1k1 + $ppn11 + $ppn12;
            $grand = $tharga - $pph;
            $input["inv_grand"] = $grand;

            // dd($input);
            $this->db->table('inv')->insert($input);
            // echo $this->db->getLastQuery(); die;
            $inv_id = $this->db->insertID();

            //updane nomor invoice invd
            $inputad["invd_date"] = $input["inv_date"];
            $inputad["inv_no"] = $input["inv_no"];
            $inputad["inv_id"] = $inv_id;
            $this->db
                ->table('invd')
                ->where('inv_no', $invNo)
                ->update($inputad);
            // echo $this->db->getLastQuery(); die;

            //tambahkan nomor invoice di job
            $inputjob["inv_no"] = $input["inv_no"];
            // dd($jobdano);
            if (!empty($jobdano)) {
                $this->db
                    ->table('job')
                    ->whereIn('job_dano', $jobdano)
                    ->update($inputjob);
                // echo $this->db->getLastQuery(); die;
            }

            $data["message"] = "Insert Data Success";
            header('Location: ' . base_url('inv'));
            exit;
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'invd_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('invd')->update($input, array("invd_id" => $this->request->getPost("invd_id")));

            $inv_no =   $this->request->getGet("inv_no");
            //update invoice
            if ($this->request->getGet("editinv") == "OK") {
                $invd = $this->db->table('invd')->where("inv_no", $inv_no)->get();
                $total = 0;
                $jobdano      = array();
                foreach ($invd->getResult() as $rinvd) {
                    $total += $rinvd->invd_total;
                    if ($rinvd->job_dano !== '' && ! in_array($rinvd->job_dano, $jobdano)) {
                        $jobdano[] = $rinvd->job_dano;
                    }
                }
                $jobdanos      = implode(', ', $jobdano);
                $inputi["job_dano"] = $jobdanos;
                $inputi["inv_tagihan"] = $total;
                $inv = $this->db->table('inv')->where("inv_no", $inv_no)->get();
                $diskon = 0;
                foreach ($inv->getResult() as $rinv) {
                    $diskon = $rinv->inv_discount;
                }
                $inputi["inv_dtagihan"] = $total - $diskon;
                $this->db->table('inv')->update($inputi, array("inv_no" => $inv_no));
            }

            //update invoice table job   
            if ($this->request->getPost("job_id") != "0") {
                $job_id = $this->request->getPost("job_id");
                $inputj["inv_no"] = $inv_no;
                $this->db->table('job')->update($inputj, array("job_id" => $job_id));
            }


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
            $invd  = $this->db
                ->table('invd')
                ->where('inv_no', $invNo)
                ->get();
            $total = 0;
            $jobdano      = array();
            foreach ($invd->getResult() as $rinvd) {
                $total += $rinvd->invd_total;
                if ($rinvd->job_dano !== '' && ! in_array($rinvd->job_dano, $jobdano)) {
                    $jobdano[] = $rinvd->job_dano;
                }
            }

            $jobdanos      = implode(', ', $jobdano);
            $input["job_dano"] = $jobdanos;
            $input["inv_tagihan"] = $total;
            $dtagihan = $input["inv_tagihan"] - $input["inv_discount"];
            $ppn1k1 = 0;
            $ppn11 = 0;
            $ppn12 = 0;
            $pph = 0;
            $input["inv_dtagihan"] = $dtagihan;
            if (isset($input["inv_ppn1k1"]) && $input["inv_ppn1k1"] > 0) {
                $ppn1k1 = $dtagihan * 1.1 / 100;
            }
            if (isset($input["inv_ppn11"]) && $input["inv_ppn11"] > 0) {
                $ppn11 = $dtagihan * 11 / 100;
            }
            if (isset($input["inv_ppn12"]) && $input["inv_ppn12"] > 0) {
                $ppn12 = $dtagihan * 12 / 100;
            }
            if (isset($input["inv_pph"]) && $input["inv_pph"] > 0) {
                $pph = $dtagihan * 2 / 100;
            }
            $tharga = $dtagihan + $ppn1k1 + $ppn11 + $ppn12;
            $grand = $tharga - $pph;
            $input["inv_grand"] = $grand;

            $this->db->table('inv')->update($input, array("inv_id" => $this->request->getPost("inv_id")));


            //updane nomor invoice invd
            $inputad["invd_date"] = $input["inv_date"];
            $this->db
                ->table('invd')
                ->where('inv_no', $invNo)
                ->update($inputad);
            // echo $this->db->getLastQuery(); die;



            //update job
            $inputjob["inv_no"] = $input["inv_no"];
            if (!empty($jobdano)) {
                $this->db
                    ->table('job')
                    ->whereIn('job_dano', $jobdano)
                    ->update($inputjob);
            }

            $data["message"] = "Insert Data Success";
            header('Location: ' . base_url('inv'));
            exit;
        }
        return $data;
    }
}
