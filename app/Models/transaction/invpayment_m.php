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

            //delete kas
            $kas = $this->db->table('kas')
                ->where("invpayment_id", $invpayment_id)
                ->get();
            if ($kas->getNumRows() > 0) {
                foreach ($kas->getResult() as $kas) {
                    $kas_id =   $kas->kas_id;
                    $this->db
                        ->table("kas")
                        ->delete(array("kas_id" =>  $kas_id));

                    $kassebelumnya = $this->db->table("kas")->where("kas_id <", $kas_id)->limit(1)->orderBy("kas_id", "DESC")->get();
                    // echo $this->db->getLastQuery(); die;
                    $saldo = 0;
                    $bigcash = 0;
                    $pettycash = 0;
                    foreach ($kassebelumnya->getResult() as $kas) {
                        $saldo = $kas->kas_saldo;
                        $bigcash = $kas->kas_bigcash;
                        $pettycash = $kas->kas_pettycash;
                    }

                    // echo $saldo;die;
                    $kas = $this->db->table("kas")->where("kas_id >", $kas_id)->orderBy("kas_id", "ASC")->get();
                    // echo $this->db->getLastQuery(); die;
                    foreach ($kas->getResult() as $kas) {
                        if ($kas->kas_type == "Debet") {
                            $saldo = $saldo + $kas->kas_total;
                            if ($kas->kas_debettype == "bigcash") {
                                $bigcash = $bigcash + $kas->kas_total;
                            }
                            if ($kas->kas_debettype == "pettycash") {
                                $pettycash = $pettycash + $kas->kas_total;
                            }
                        } else {
                            $saldo = $saldo - $kas->kas_total;
                            if ($kas->kas_debettype == "bigcash") {
                                $bigcash = $bigcash - $kas->kas_total;
                            }
                            if ($kas->kas_debettype == "pettycash") {
                                $pettycash = $pettycash - $kas->kas_total;
                            }
                        }
                        $input2["kas_saldo"] = $saldo;
                        $input2["kas_bigcash"] = $bigcash;
                        $input2["kas_pettycash"] = $pettycash;
                        $kas_id = $kas->kas_id;
                        $this->db->table('kas')->update($input2, array("kas_id" => $kas_id));
                        // echo $this->db->getLastQuery(); die;
                    }
                }
            }

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
            $invpaymenttotal = $this->db
                ->table("invpayment")
                ->select("SUM(invpayment_total) AS invpaymenttotal")
                ->where("inv_no", $inv_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $inv_payment = $invpaymenttotal ? $invpaymenttotal->invpaymenttotal : 0;

            // Siapkan data update
            $inputi = [
                "inv_payment" => $inv_payment
            ];

            // Lakukan update pada tabel inv
            $this->db
                ->table("inv")
                ->where("inv_no", $inv_no)
                ->update($inputi);

            //input kas
            $invd = $this->db->table('invd')
                ->where("inv_no", $inv_no)
                ->get();
            $jobdano      = array();
            foreach ($invd->getResult() as $rinvd) {
                if ($rinvd->job_dano !== '' && ! in_array($rinvd->job_dano, $jobdano)) {
                    $jobdano[] = $rinvd->job_dano;
                }
            }
            $jobdanos      = implode(', ', $jobdano);
            if ($input["invpayment_to"] == "-1") {
                $kas_debettype = "pettycash";
            } else {
                $kas_debettype = "bigcash";
            }
            $kas = $this->db->table("kas")->orderBy("kas_id", "desc")->limit("1")->get();
            $saldo = 0;
            $bigcash = 0;
            $pettycash = 0;
            foreach ($kas->getResult() as $kas) {
                $saldo = $kas->kas_saldo + $input["invpayment_total"];
                if ($kas_debettype == "bigcash") {
                    $bigcash = $kas->kas_bigcash + $input["invpayment_total"];
                    $pettycash = $kas->kas_pettycash;
                }
                if ($kas_debettype == "pettycash") {
                    $pettycash = $kas->kas_pettycash + $input["invpayment_total"];
                    $bigcash = $kas->kas_bigcash;
                }
            }
            $inputkas[] = array(
                "kas_date" => $input["invpayment_date"],
                "job_dano" => $jobdanos,
                "kas_uraian" => $inv_no,
                "kas_qty" => $input["invpayment_qty"],
                "kas_nominal" => $input["invpayment_price"],
                "kas_total" => $input["invpayment_total"],
                "kas_rekdari" => $input["invpayment_from"],
                "kas_rekke" => $input["invpayment_to"],
                "kas_keterangan" => $input["invpayment_keterangan"],
                "kas_type" => "Debet",
                "kas_debettype" => $kas_debettype,
                "kas_saldo" => $saldo,
                "kas_bigcash" => $bigcash,
                "kas_pettycash" => $pettycash,
                "vendor_id" => 0,
                "kas_vendorsaldo" => 0,
                "invpayment_id" => $invpayment_id,
            );
            $this->db->table('kas')->insertBatch($inputkas);


            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;



        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'invpayment_picture') {
                    $inputp[$e] = $this->request->getPost($e);
                }
            }
            // dd($inputp);
            $invpayment_id = $this->request->getPost("invpayment_id");
            $this->db->table('invpayment')->update($inputp, array("invpayment_id" => $invpayment_id));

            // Hitung total pembayaran dari invpayment
            $inv_no = $this->request->getGet("inv_no");
            $invpaymenttotal = $this->db
                ->table("invpayment")
                ->select("SUM(invpayment_total) AS invpaymenttotal")
                ->where("inv_no", $inv_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $inv_payment = $invpaymenttotal ? $invpaymenttotal->invpaymenttotal : 0;

            // Siapkan data update
            $inputi = [
                "inv_payment" => $inv_payment
            ];

            // Lakukan update pada tabel inv
            $this->db
                ->table("inv")
                ->where("inv_no", $inv_no)
                ->update($inputi);

            //input kas
            $kas = $this->db->table('kas')
                ->where("invpayment_id", $invpayment_id)
                ->get();
            $saldo = 0;
            $bigcash = 0;
            $pettycash = 0;
            $kas_id = 0;
            $invpayment_total = $inputp["invpayment_total"];
            foreach ($kas->getResult() as $kas) {
                $kas_id = $kas->kas_id;
                $kas_totalawal = $kas->kas_total;
                $kas_saldo = $kas->kas_saldo;
                $kas_bigcash = $kas->kas_bigcash;
                $kas_pettycash = $kas->kas_pettycash;

                $saldoawal = $kas_saldo - $kas_totalawal;
                $saldo = $saldoawal + $invpayment_total;

                if ($input["invpayment_to"] == "-1") {
                    $kas_debettype = "pettycash";
                } else {
                    $kas_debettype = "bigcash";
                }

                if ($kas_debettype == "bigcash") {
                    $bigcashawal = $kas_bigcash - $kas_totalawal;
                    $bigcash = $bigcashawal + $invpayment_total;
                    $pettycash = $kas->kas_pettycash;
                }
                if ($kas_debettype == "pettycash") {
                    $pettycashawal = $kas_pettycash - $kas_totalawal;
                    $pettycash = $pettycashawal + $invpayment_total;
                    $bigcash = $kas->kas_bigcash;
                }
            }
            $input["kas_saldo"] = $saldo;
            $input["kas_bigcash"] = $bigcash;
            $input["kas_pettycash"] = $pettycash;

            $this->db->table('kas')->update($input, array("kas_id" => $kas_id));

            $kas = $this->db->table("kas")->where("kas_id >", $kas_id)->orderBy("kas_id", "ASC")->get();
            // echo $this->db->getLastQuery(); die;
            foreach ($kas->getResult() as $kas) {
                if ($kas->kas_type == "Debet") {
                    $saldo = $saldo + $kas->kas_total;
                    if ($kas->kas_debettype == "bigcash") {
                        $bigcash = $bigcash + $kas->kas_total;
                    }
                    if ($kas->kas_debettype == "pettycash") {
                        $pettycash = $pettycash + $kas->kas_total;
                    }
                } else {
                    $saldo = $saldo - $kas->kas_total;
                    if ($kas->kas_debettype == "bigcash") {
                        $bigcash = $bigcash - $kas->kas_total;
                    }
                    if ($kas->kas_debettype == "pettycash") {
                        $pettycash = $pettycash - $kas->kas_total;
                    }
                }
                $input2["kas_saldo"] = $saldo;
                $input2["kas_bigcash"] = $bigcash;
                $input2["kas_pettycash"] = $pettycash;
                $kas_id = $kas->kas_id;
                $this->db->table('kas')->update($input2, array("kas_id" => $kas_id));
                // echo $this->db->getLastQuery(); die;
            }


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }


        return $data;
    }
}
