<?php

namespace App\Models\transaction;

use App\Models\core_m;

class kas_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek kas
        if ($this->request->getVar("kas_id")) {
            $kasd["kas_id"] = $this->request->getVar("kas_id");
        } else {
            $kasd["kas_id"] = -1;
        }
        $us = $this->db
            ->table("kas")
            ->getWhere($kasd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "kas_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $kas) {
                foreach ($this->db->getFieldNames('kas') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $kas->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('kas') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $kas_id =   $this->request->getPost("kas_id");
            $kas_pettyid =   $this->request->getPost("kas_pettyid");
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

            if ($kas_pettyid > 0) {
                $this->db
                    ->table("kas")
                    ->delete(array("kas_id" =>  $kas_pettyid));
            }
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'kas_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $kas = $this->db->table("kas")->orderBy("kas_id", "desc")->limit("1")->get();
            $saldo = 0;
            $bigcash = 0;
            $pettycash = 0;

            if ($kas->getNumRows() > 0) {
                foreach ($kas->getResult() as $kas) {
                    if ($input["kas_type"] == "Debet") {
                        $saldo = $kas->kas_saldo + $input["kas_total"];
                        if ($input["kas_debettype"] == "bigcash") {
                            $bigcash = $kas->kas_bigcash + $input["kas_total"];
                            $pettycash = $kas->kas_pettycash;
                        }
                        if ($input["kas_debettype"] == "pettycash") {
                            $pettycash = $kas->kas_pettycash + $input["kas_total"];
                            $bigcash = $kas->kas_bigcash;
                        }
                    } else {
                        $saldo = $kas->kas_saldo - $input["kas_total"];
                        if ($input["kas_debettype"] == "bigcash") {
                            $bigcash = $kas->kas_bigcash - $input["kas_total"];
                            $pettycash = $kas->kas_pettycash;
                        }
                        if ($input["kas_debettype"] == "pettycash") {
                            $pettycash = $kas->kas_pettycash - $input["kas_total"];
                            $bigcash = $kas->kas_bigcash;
                        }
                    }
                }
            } else {
                if ($input["kas_type"] == "Debet") {
                    $saldo = 0 + $input["kas_total"];
                    if ($input["kas_debettype"] == "bigcash") {
                        $bigcash = 0 + $input["kas_total"];
                        $pettycash = 0;
                    }
                    if ($input["kas_debettype"] == "pettycash") {
                        $pettycash = 0 + $input["kas_total"];
                        $bigcash = 0;
                    }
                } else {
                    $saldo = 0 - $input["kas_total"];
                    if ($input["kas_debettype"] == "bigcash") {
                        $bigcash = 0 - $input["kas_total"];
                        $pettycash = 0;
                    }
                    if ($input["kas_debettype"] == "pettycash") {
                        $pettycash = 0 - $input["kas_total"];
                        $bigcash = 0;
                    }
                }
            }
            $input["kas_saldo"] = $saldo;
            $input["kas_bigcash"] = $bigcash;
            $input["kas_pettycash"] = $pettycash;

            $builder = $this->db->table('kas');
            $builder->insert($input);
            // echo $this->db->getLastQuery(); die;
            $kas_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'kas_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $kas_id = $this->request->getPost("kas_id");
            $kas = $this->db->table("kas")->where("kas_id", $kas_id)->get();

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
                    // echo $kas_saldo." - ".$kas_totalawal;die;
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

            if($input["kas_rekke"]!="-1"){
                $input["kas_pettyid"] = 0;
            }

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

        //transfer ke pettycash
        if (($this->request->getPost("kas_debettype") == "bigcash" && $this->request->getPost("kas_rekke") == "-1" && $this->request->getPost("kas_type") == "Kredit") || $this->request->getPost("kas_pettyid") > 0) {
            if ($this->request->getPost("kas_debettype") == "bigcash" && $this->request->getPost("kas_rekke") == "-1" && $this->request->getPost("kas_type") == "Kredit") {
                foreach ($this->request->getPost() as $e => $f) {
                    if ($e != 'change' && $e != 'create' && $e != 'kas_picture' && $e != 'kas_id') {
                        $inputp[$e] = $this->request->getPost($e);
                    }
                }
                $inputp["kas_bigid"] = $kas_id;
                $inputp["kas_type"] = "Debet";
                $inputp["kas_debettype"] = "pettycash";
                // dd($this->request->getPost());
                if ($this->request->getPost("create") == "OK" || $this->request->getPost("kas_pettyid") == 0) {
                    $this->db->table("kas")->insert($inputp);
                    $inserted_id = $this->db->insertID();
                    $inputpbigcash["kas_pettyid"] = $inserted_id;
                    $this->db->table("kas")->where("kas_id", $kas_id)->update($inputpbigcash);
                }

                $where["kas_id"] = $this->request->getPost("kas_pettyid");
                if ($this->request->getPost("change") == "OK" && $this->request->getPost("kas_pettyid") > 0) {

                    $this->db->table("kas")->where($where)->update($inputp);
                }
            } else {
                $this->db
                    ->table("kas")
                    ->delete(array("kas_id" =>  $this->request->getPost("kas_pettyid")));
            }
        }
        return $data;
    }
}
