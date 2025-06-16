<?php

namespace App\Models\transaction;

use App\Models\core_m;

class invvdrp_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek invvdrp
        if ($this->request->getVar("invvdr_id")) {
            $invvdrpd["invvdr_id"] = $this->request->getVar("invvdr_id");
        } else {
            $invvdrpd["invvdr_id"] = -1;
        }
        $us = $this->db
            ->table("invvdr")
            ->getWhere($invvdrpd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "invvdrp_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $invvdr) {
                foreach ($this->db->getFieldNames('invvdr') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $invvdr->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('invvdr') as $field) {
                $data[$field] = "";
            }
        }
        $data["invvdr_no"] = $this->request->getGet("invvdr_no");
        $data["invvdr_id"] = $this->request->getGet("invvdr_id");
        $data["vendor_name"] = $this->request->getGet("vendor_name");
        $data["vendor_id"] = $this->request->getGet("vendor_id");



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $invvdrp_id =   $this->request->getPost("invvdrp_id");

            //delete invvdrp
            $this->db
                ->table("invvdrp")
                ->delete(array("invvdrp_id" =>  $invvdrp_id));


            // Hitung total pembayaran dari invvdrp
            $invvdr_no = $this->request->getGet("invvdr_no");
            $invvdrp_nominal = $this->db
                ->table("invvdrp")
                ->select("SUM(invvdrp_nominal) AS invvdr_payment")
                ->where("invvdr_no", $invvdr_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $invvdr_payment = $invvdrp_nominal ? $invvdrp_nominal->invvdr_payment : 0;

            // Siapkan data update
            $inputi = [
                "invvdr_payment" => $invvdr_payment
            ];

            // Lakukan update pada tabel invvdr
            $this->db
                ->table("invvdr")
                ->where("invvdr_no", $invvdr_no)
                ->update($inputi);

            //delete kas
            $kas = $this->db->table('kas')
                ->where("invvdrp_id", $invvdrp_id)
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
                if ($e != 'create' && $e != 'invvdrp_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $this->db->table('invvdrp')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $invvdrp_id = $this->db->insertID();


            // Hitung total pembayaran dari invvdrp
            $invvdr_no = $this->request->getGet("invvdr_no");
            $invvdrptotal = $this->db
                ->table("invvdrp")
                ->select("SUM(invvdrp_nominal) AS invvdrptotal")
                ->where("invvdr_no", $invvdr_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $invvdr_payment = $invvdrptotal ? $invvdrptotal->invvdrptotal : 0;

            // Siapkan data update
            $inputi = [
                "invvdr_payment" => $invvdr_payment
            ];

            // Lakukan update pada tabel invvdr
            $this->db
                ->table("invvdr")
                ->where("invvdr_no", $invvdr_no)
                ->update($inputi);

            //input kas
            $invvdrd = $this->db->table('invvdrd')
                ->where("invvdr_no", $invvdr_no)
                ->get();
            $jobdano      = array();
            foreach ($invvdrd->getResult() as $rinvvdrd) {
                if ($rinvvdrd->job_dano !== '' && ! in_array($rinvvdrd->job_dano, $jobdano)) {
                    $jobdano[] = $rinvvdrd->job_dano;
                }
            }
            $jobdanos      = implode(', ', $jobdano);
            if ($input["invvdrp_from"] == "-1") {
                $kas_debettype = "pettycash";
            } else {
                $kas_debettype = "bigcash";
            }
            $kas = $this->db->table("kas")->orderBy("kas_id", "desc")->limit("1")->get();
            $saldo = 0;
            $bigcash = 0;
            $pettycash = 0;
            foreach ($kas->getResult() as $kas) {
                $saldo = $kas->kas_saldo - $input["invvdrp_nominal"];
                if ($kas_debettype == "bigcash") {
                    $bigcash = $kas->kas_bigcash - $input["invvdrp_nominal"];
                    $pettycash = $kas->kas_pettycash;
                }
                if ($kas_debettype == "pettycash") {
                    $pettycash = $kas->kas_pettycash - $input["invvdrp_nominal"];
                    $bigcash = $kas->kas_bigcash;
                }
            }
            $inputkas[] = array(
                "kas_date" => $input["invvdrp_date"],
                "job_dano" => $jobdanos,
                "kas_uraian" => $invvdr_no,
                "kas_qty" => 1,
                "kas_nominal" => $input["invvdrp_nominal"],
                "kas_total" => $input["invvdrp_nominal"],
                "kas_rekdari" => $input["invvdrp_from"],
                "kas_rekke" => $input["invvdrp_to"],
                "kas_keterangan" => $input["invvdrp_keterangan"],
                "kas_type" => "Kredit",
                "kas_debettype" => $kas_debettype,
                "kas_saldo" => $saldo,
                "kas_bigcash" => $bigcash,
                "kas_pettycash" => $pettycash,
                "vendor_id" => 0,
                "kas_vendorsaldo" => 0,
                "invvdrp_id" => $invvdrp_id,
            );
            $this->db->table('kas')->insertBatch($inputkas);


            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;



        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'invvdrp_picture') {
                    $inputp[$e] = $this->request->getPost($e);
                }
            }

            if ($inputp["invvdrp_from"] == "-1") {
                $kas_debettype = "pettycash";
            } else {
                $kas_debettype = "bigcash";
            }
            $input["kas_debettype"]=$kas_debettype;
            $input["kas_type"]="Kredit";
            $input["kas_total"]=$inputp["invvdrp_nominal"];

            // dd($inputp);
            $invvdrp_id = $this->request->getPost("invvdrp_id");
            $this->db->table('invvdrp')->update($inputp, array("invvdrp_id" => $invvdrp_id));

            // Hitung total pembayaran dari invvdrp
            $invvdr_no = $this->request->getGet("invvdr_no");
            $invvdrptotal = $this->db
                ->table("invvdrp")
                ->select("SUM(invvdrp_nominal) AS invvdrptotal")
                ->where("invvdr_no", $invvdr_no)
                ->get()
                ->getRow();

            // Pastikan hasil tidak null
            $invvdr_payment = $invvdrptotal ? $invvdrptotal->invvdrptotal : 0;

            // Siapkan data update
            $inputi = [
                "invvdr_payment" => $invvdr_payment
            ];

            // Lakukan update pada tabel invvdr
            $this->db
                ->table("invvdr")
                ->where("invvdr_no", $invvdr_no)
                ->update($inputi);

            //input kas
            $kas = $this->db->table('kas')
                ->where("invvdrp_id", $invvdrp_id)
                ->get();

            $saldo = 0;
            $bigcash = 0;
            $pettycash = 0;
            foreach ($kas->getResult() as $kas) {
                $kas_id = $kas->kas_id;
                $kas_totalawal = $kas->kas_total;
                $kas_saldo = $kas->kas_saldo;
                $kas_bigcash = $kas->kas_bigcash;
                $kas_pettycash = $kas->kas_pettycash;
                $kas_type = $kas->kas_type;
                $kas_debettype = $kas->kas_debettype;
                if ($kas_type == "Debet") {
                    $saldoawal = $kas_saldo - $kas_totalawal;
                    if ($kas_debettype == "bigcash") {
                        $bigcashawal = $kas_bigcash - $kas_totalawal;
                        $pettycashawal = $kas_pettycash;
                    } else {
                        $bigcashawal = $kas_bigcash;
                        $pettycashawal = $kas_pettycash - $kas_totalawal;
                    }
                    // echo $bigcashawal." - ".$pettycashawal;die;
                } else {
                    $saldoawal = $kas_saldo + $kas_totalawal;
                    if ($kas_debettype == "bigcash") {
                        $bigcashawal = $kas_bigcash + $kas_totalawal;
                        $pettycashawal = $kas_pettycash;
                    } else {
                        $bigcashawal = $kas_bigcash;
                        $pettycashawal = $kas_pettycash + $kas_totalawal;
                    }
                    // echo $kas_saldo." + ".$kas_totalawal;die;
                }
                // echo $saldoawal."==".$bigcashawal."==".$pettycashawal;die;
                // dd($inputp);
                if ($input["kas_type"] == "Debet") {
                    $saldo = $saldoawal + $input["kas_total"];
                    if ($input["kas_debettype"] == "bigcash") {
                        $bigcash = $bigcashawal + $input["kas_total"];
                        $pettycash = $pettycashawal;
                    } else {
                        $bigcash = $bigcashawal;
                        $pettycash = $pettycashawal + $input["kas_total"];
                    }
                    // echo $bigcash."==".$pettycash;die;
                } else {
                    $saldo =  $saldoawal - $input["kas_total"];
                    if ($input["kas_debettype"] == "bigcash") {
                        $bigcash = $bigcashawal - $input["kas_total"];
                        $pettycash = $pettycashawal;
                    }
                    if ($input["kas_debettype"] == "pettycash") {
                        $bigcash = $bigcashawal;
                        $pettycash = $pettycashawal - $input["kas_total"];
                    }
                    //  echo $saldo."==".$bigcash."==".$pettycash;die;
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
