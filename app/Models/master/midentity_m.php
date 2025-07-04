<?php

namespace App\Models\master;

use App\Models\core_m;

class midentity_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek identity
        if ($this->request->getVar("identity_id")) {
            $identityd["identity_id"] = $this->request->getVar("identity_id");
        } else {
            $identityd["identity_id"] = -1;
        }
        $us = $this->db
            ->table("identity")
            ->getWhere($identityd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "identity_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $identity) {
                foreach ($this->db->getFieldNames('identity') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $identity->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('identity') as $field) {
                $data[$field] = "";
            }
        }

        //upload image quotation
        $data['uploadidentity_stempelsj'] = "";
        if (isset($_FILES['identity_stempelsj']) && $_FILES['identity_stempelsj']['name'] != "") {
            // $request = \Config\Services::request();
            $file = $this->request->getFile('identity_stempelsj');
            $name = $file->getName(); // Mengetahui Nama File
            $originalName = $file->getClientName(); // Mengetahui Nama Asli
            $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
            $ext = $file->getClientExtension(); // Mengetahui extensi File
            $type = $file->getClientMimeType(); // Mengetahui Mime File
            $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
            $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb


            //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

            if ($type == 'image/jpg'||$type == 'image/jpeg'||$type == 'image/png') //cek mime file
            {    // File Tipe Sesuai   
                helper('filesystem'); // Load Helper File System
                $direktori = 'images/identity_stempelsj'; //definisikan direktori upload            
                $identity_stempelsj = str_replace(' ', '_', $name);
                $identity_stempelsj = date("H_i_s_") . $identity_stempelsj; //definisikan nama fiel yang baru
                $map = directory_map($direktori, FALSE, TRUE); // List direktori

                //Cek File apakah ada 
                foreach ($map as $key) {
                    if ($key == $identity_stempelsj) {
                        delete_files($direktori, $identity_stempelsj); //Hapus terlebih dahulu jika file ada
                    }
                }
                //Metode Upload Pilih salah satu
                //$path = $this->request->getFile('uploadedFile')->identity($direktori, $namabaru);
                //$file->move($direktori, $namabaru)
                if ($file->move($direktori, $identity_stempelsj)) {
                    $data['uploadidentity_stempelsj'] = "Upload Success !";
                    $input['identity_stempelsj'] = $identity_stempelsj;
                } else {
                    $data['uploadidentity_stempelsj'] = "Upload Gagal !";
                }
            } else {
                // File Tipe Tidak Sesuai
                $data['uploadidentity_stempelsj'] = "Format File Salah !";
            }
        } 
        
        //upload image quotation
        $data['uploadidentity_quotationsign'] = "";
        if (isset($_FILES['identity_quotationsign']) && $_FILES['identity_quotationsign']['name'] != "") {
            // $request = \Config\Services::request();
            $file = $this->request->getFile('identity_quotationsign');
            $name = $file->getName(); // Mengetahui Nama File
            $originalName = $file->getClientName(); // Mengetahui Nama Asli
            $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
            $ext = $file->getClientExtension(); // Mengetahui extensi File
            $type = $file->getClientMimeType(); // Mengetahui Mime File
            $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
            $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb


            //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

            if ($type == 'image/jpg'||$type == 'image/jpeg'||$type == 'image/png') //cek mime file
            {    // File Tipe Sesuai   
                helper('filesystem'); // Load Helper File System
                $direktori = 'images/identity_quotationsign'; //definisikan direktori upload            
                $identity_quotationsign = str_replace(' ', '_', $name);
                $identity_quotationsign = date("H_i_s_") . $identity_quotationsign; //definisikan nama fiel yang baru
                $map = directory_map($direktori, FALSE, TRUE); // List direktori

                //Cek File apakah ada 
                foreach ($map as $key) {
                    if ($key == $identity_quotationsign) {
                        delete_files($direktori, $identity_quotationsign); //Hapus terlebih dahulu jika file ada
                    }
                }
                //Metode Upload Pilih salah satu
                //$path = $this->request->getFile('uploadedFile')->identity($direktori, $namabaru);
                //$file->move($direktori, $namabaru)
                if ($file->move($direktori, $identity_quotationsign)) {
                    $data['uploadidentity_quotationsign'] = "Upload Success !";
                    $input['identity_quotationsign'] = $identity_quotationsign;
                } else {
                    $data['uploadidentity_quotationsign'] = "Upload Gagal !";
                }
            } else {
                // File Tipe Tidak Sesuai
                $data['uploadidentity_quotationsign'] = "Format File Salah !";
            }
        } 

        //upload image
        $data['uploadidentity_logo'] = "";
        if (isset($_FILES['identity_logo']) && $_FILES['identity_logo']['name'] != "") {
            // $request = \Config\Services::request();
            $file = $this->request->getFile('identity_logo');
            $name = $file->getName(); // Mengetahui Nama File
            $originalName = $file->getClientName(); // Mengetahui Nama Asli
            $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
            $ext = $file->getClientExtension(); // Mengetahui extensi File
            $type = $file->getClientMimeType(); // Mengetahui Mime File
            $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
            $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb


            //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

            if ($type == 'image/jpg'||$type == 'image/jpeg'||$type == 'image/png') //cek mime file
            {    // File Tipe Sesuai   
                helper('filesystem'); // Load Helper File System
                $direktori = 'images/identity_logo'; //definisikan direktori upload            
                $identity_logo = str_replace(' ', '_', $name);
                $identity_logo = date("H_i_s_") . $identity_logo; //definisikan nama fiel yang baru
                $map = directory_map($direktori, FALSE, TRUE); // List direktori

                //Cek File apakah ada 
                foreach ($map as $key) {
                    if ($key == $identity_logo) {
                        delete_files($direktori, $identity_logo); //Hapus terlebih dahulu jika file ada
                    }
                }
                //Metode Upload Pilih salah satu
                //$path = $this->request->getFile('uploadedFile')->identity($direktori, $namabaru);
                //$file->move($direktori, $namabaru)
                if ($file->move($direktori, $identity_logo)) {
                    $data['uploadidentity_logo'] = "Upload Success !";
                    $input['identity_logo'] = $identity_logo;
                } else {
                    $data['uploadidentity_logo'] = "Upload Gagal !";
                }
            } else {
                // File Tipe Tidak Sesuai
                $data['uploadidentity_logo'] = "Format File Salah !";
            }
        } 

        //upload image
        $data['uploadidentity_financettd'] = "";
        if (isset($_FILES['identity_financettd']) && $_FILES['identity_financettd']['name'] != "") {
            // $request = \Config\Services::request();
            $file = $this->request->getFile('identity_financettd');
            $name = $file->getName(); // Mengetahui Nama File
            $originalName = $file->getClientName(); // Mengetahui Nama Asli
            $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
            $ext = $file->getClientExtension(); // Mengetahui extensi File
            $type = $file->getClientMimeType(); // Mengetahui Mime File
            $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
            $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb


            //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

            if ($type == 'image/jpg'||$type == 'image/jpeg'||$type == 'image/png') //cek mime file
            {    // File Tipe Sesuai   
                helper('filesystem'); // Load Helper File System
                $direktori = 'images/identity_financettd'; //definisikan direktori upload            
                $identity_financettd = str_replace(' ', '_', $name);
                $identity_financettd = date("H_i_s_") . $identity_financettd; //definisikan nama fiel yang baru
                $map = directory_map($direktori, FALSE, TRUE); // List direktori

                //Cek File apakah ada 
                foreach ($map as $key) {
                    if ($key == $identity_financettd) {
                        delete_files($direktori, $identity_financettd); //Hapus terlebih dahulu jika file ada
                    }
                }
                //Metode Upload Pilih salah satu
                //$path = $this->request->getFile('uploadedFile')->identity($direktori, $namabaru);
                //$file->move($direktori, $namabaru)
                if ($file->move($direktori, $identity_financettd)) {
                    $data['uploadidentity_financettd'] = "Upload Success !";
                    $input['identity_financettd'] = $identity_financettd;
                } else {
                    $data['uploadidentity_financettd'] = "Upload Gagal !";
                }
            } else {
                // File Tipe Tidak Sesuai
                $data['uploadidentity_financettd'] = "Format File Salah !";
            }
        }

        //delete
        if ($this->request->getPost("delete") == "OK") {  
            $identity_id=$this->request->getPost("identity_id");  
            $cek=$this->db->table("user") 
            ->where("identity_id",$identity_id)  
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "Data masih terpakai di menu lain!";
            }else{    
                $this->db
                ->table("identity")
                ->delete(array("identity_id" => $this->request->getPost("identity_id"),"identity_id" =>session()->get("identity_id")));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'identity_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["identity_id"] = session()->get("identity_id");

            $builder = $this->db->table('identity');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $identity_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'identity_logo') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["identity_id"] = session()->get("identity_id");
            $this->db->table('identity')->update($input, array("identity_id" => $this->request->getPost("identity_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
