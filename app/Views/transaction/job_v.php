<?php echo $this->include("template/header_v"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php if (!isset($_GET['user_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "col-md-10";
                        } else {
                            $coltitle = "col-md-8";
                        } ?>
                        <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>

                        <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                            <?php if (isset($_GET["user_id"])) { ?>
                                <form action="<?= base_url("user"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>
                            <?php
                            if (
                                (
                                    isset(session()->get("position_administrator")[0][0])
                                    && (
                                        session()->get("position_administrator") == "1"
                                        || session()->get("position_administrator") == "2"
                                    )
                                ) ||
                                (
                                    isset(session()->get("halaman")['49']['act_create'])
                                    && session()->get("halaman")['49']['act_create'] == "1"
                                )
                            ) { ?>
                                <form method="post" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                        <input type="hidden" name="job_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Job";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Job";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_shipmentdate">SHIPMENT DATE:</label>
                                    <div class="col-sm-10">
                                        <input type="date" autofocus class="form-control" id="job_shipmentdate" name="job_shipmentdate" placeholder="" value="<?= $job_shipmentdate; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="customer_id">SHIPPER NAME:</label>
                                    <div class="col-sm-10">
                                        <select onchange="isisingkatan()" class="form-control select" id="customer_id" name="customer_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("customer")
                                                ->orderBy("customer_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option data-singkatan="<?= $usr->customer_singkatan; ?>" value="<?= $usr->customer_id; ?>" <?= ($customer_id == $usr->customer_id) ? "selected" : ""; ?>><?= $usr->customer_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            function isisingkatan() {
                                                let singkatan = $("#customer_id option:selected").data("singkatan");
                                                // alert(singkatan);
                                                $("#customer_singkatan").val(singkatan);
                                            }
                                        </script>
                                        <input type="hidden" id="customer_singkatan" name="customer_singkatan" value="<?= $customer_singkatan; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="origin_id">ORIGIN:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="origin_id" name="origin_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("origin")
                                                ->orderBy("origin_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->origin_id; ?>" <?= ($origin_id == $usr->origin_id) ? "selected" : ""; ?>><?= $usr->origin_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="destination_id">DESTINATION:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="destination_id" name="destination_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("destination")
                                                ->orderBy("destination_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->destination_id; ?>" <?= ($destination_id == $usr->destination_id) ? "selected" : ""; ?>><?= $usr->destination_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_descgood">DESCRIPTION OF GOODS:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="job_descgood" name="job_descgood" placeholder="" value="<?= $job_descgood; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_qty">QTY:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_qty" name="job_qty" placeholder="" value="<?= $job_qty; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_satuan">SATUAN:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="job_satuan" name="job_satuan">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("satuan")
                                                ->orderBy("satuan_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->satuan_name; ?>" <?= ($job_satuan == $usr->satuan_name) ? "selected" : ""; ?>><?= $usr->satuan_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_cbm">CBM / KGS:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="job_cbm" name="job_cbm" placeholder="" value="<?= $job_cbm; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="service_id">SERVICE:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="service_id" name="service_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("service")
                                                ->orderBy("service_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->service_id; ?>" <?= ($service_id == $usr->service_id) ? "selected" : ""; ?>><?= $usr->service_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="vendortruck_id">TRUCKING:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="vendortruck_id" name="vendortruck_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("vendortruck")
                                                ->join("vendor", "vendor.vendor_id = vendortruck.vendor_id", "left")
                                                ->orderBy("vendortruck_name", "ASC")
                                                ->orderBy("vendor_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->vendortruck_id; ?>" <?= ($vendortruck_id == $usr->vendortruck_id) ? "selected" : ""; ?>><?= $usr->vendortruck_name; ?> - <?= $usr->vendor_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="vessel_id">VESSEL:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="vessel_id" name="vessel_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("vessel")
                                                ->orderBy("vessel_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->vessel_id; ?>" <?= ($vessel_id == $usr->vessel_id) ? "selected" : ""; ?>><?= $usr->vessel_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="vendor_id">VENDOR / PELAYARAN:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="vendor_id" name="vendor_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("vendor")
                                                ->orderBy("vendor_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->vendor_id; ?>" <?= ($vendor_id == $usr->vendor_id) ? "selected" : ""; ?>><?= $usr->vendor_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_dooring">DOORING:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select" id="job_dooring" name="job_dooring">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("vendor")
                                                ->orderBy("vendor_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->vendor_id; ?>" <?= ($job_dooring == $usr->vendor_id) ? "selected" : ""; ?>><?= $usr->vendor_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_sell">SELL RPRICE:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_sell" name="job_sell" placeholder="" value="<?= $job_sell; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_total">TOTAL PRICE:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_total" name="job_total" placeholder="" value="<?= $job_total; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_cost">COST:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_cost" name="job_cost" placeholder="" value="<?= $job_cost; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_refund">REFUND:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_refund" name="job_refund" placeholder="" value="<?= $job_refund; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_fee"> MARKET FEE 15%:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_fee" name="job_fee" placeholder="" value="<?= $job_fee; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_profit">PROFIT:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_profit" name="job_profit" placeholder="" value="<?= $job_profit; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_gp">GP %:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_gp" name="job_gp" placeholder="" value="<?= $job_gp; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_sell2">SELL2:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_sell2" name="job_sell2" placeholder="" value="<?= $job_sell2; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_vat">VAT:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_vat" name="job_vat" placeholder="" value="<?= $job_vat; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_pph">PPH 2%:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_pph" name="job_pph" placeholder="" value="<?= $job_pph; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_admission">ADMISSION:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_admission" name="job_admission" placeholder="" value="<?= $job_admission; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_explanation">EXPLANATION:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="job_explanation" name="job_explanation" placeholder="" value="<?= $job_explanation; ?>">
                                    </div>
                                </div>

                                <input type="hidden" name="job_id" value="<?= $job_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("mjob"); ?>">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong>
                            </div>
                        <?php } ?>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <th>Shipment Date</th>
                                        <th>DA Number</th>
                                        <th>Shipper Name</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Description of Goods</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>CBM/MT</th>
                                        <th>Service</th>
                                        <th>Trucking</th>
                                        <th>Vessel</th>
                                        <th>Vendor/Pelayaran</th>
                                        <th>Dooring</th>
                                        <th>Sell Price</th>
                                        <th>Total Price</th>
                                        <th>Cost</th>
                                        <th>Refund</th>
                                        <th>Market Fee 15%</th>
                                        <th>Profit</th>
                                        <th>GP%</th>
                                        <th>Invoice No.</th>
                                        <th>Sell2</th>
                                        <th>Vat</th>
                                        <th>PPH2%</th>
                                        <th>Admission</th>
                                        <th>Explanation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("job")
                                        ->join("customer", "customer.customer_id = job.customer_id", "left")
                                        ->join("origin", "origin.origin_id = job.origin_id", "left")
                                        ->join("destination", "destination.destination_id = job.destination_id", "left")
                                        ->join("vendor", "vendor.vendor_id = job.vendor_id", "left")
                                        ->join("vendortruck", "vendortruck.vendortruck_id = job.vendortruck_id", "left")
                                        ->join("(SELECT vendor_id as vendor_id2, vendor_name AS vendor_name2 FROM vendor) AS v2", "v2.vendor_id2 = vendortruck.vendor_id", "left")
                                        ->join("service", "service.service_id = job.service_id", "left")
                                        ->join("vessel", "vessel.vessel_id = job.vessel_id", "left")
                                        ->orderBy("job_id", "ASC")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <?php
                                                    if (
                                                        (
                                                            isset(session()->get("position_administrator")[0][0])
                                                            && (
                                                                session()->get("position_administrator") == "1"
                                                                || session()->get("position_administrator") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['49']['act_update'])
                                                            && session()->get("halaman")['49']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="job_id" value="<?= $usr->job_id; ?>" />
                                                        </form>
                                                    <?php } ?>

                                                    <?php
                                                    if (
                                                        (
                                                            isset(session()->get("position_administrator")[0][0])
                                                            && (
                                                                session()->get("position_administrator") == "1"
                                                                || session()->get("position_administrator") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['49']['act_delete'])
                                                            && session()->get("halaman")['49']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="job_id" value="<?= $usr->job_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td><?= $usr->job_shipmentdate; ?></td>
                                            <td><?= $usr->job_dano; ?></td>
                                            <td><?= $usr->customer_name; ?></td>
                                            <td><?= $usr->origin_name; ?></td>
                                            <td><?= $usr->destination_name; ?></td>
                                            <td><?= $usr->job_descgood; ?></td>
                                            <td><?= $usr->job_qty; ?></td>
                                            <td><?= $usr->job_satuan; ?></td>
                                            <td><?= $usr->job_cbm; ?></td>
                                            <td><?= $usr->service_name; ?></td>
                                            <td><?= $usr->vendortruck_name; ?> - <?= $usr->vendor_name2; ?></td>
                                            <td><?= $usr->vessel_id; ?></td>
                                            <td><?= $usr->vendor_name; ?></td>
                                            <td><?= $usr->job_dooring; ?></td>
                                            <td><?= $usr->job_sell; ?></td>
                                            <td><?= $usr->job_total; ?></td>
                                            <td><?= $usr->job_cost; ?></td>
                                            <td><?= $usr->job_refund; ?></td>
                                            <td><?= $usr->job_fee; ?></td>
                                            <td><?= $usr->job_profit; ?></td>
                                            <td><?= $usr->job_gp; ?></td>
                                            <td><?= $usr->job_invoice; ?></td>
                                            <td><?= $usr->job_sell2; ?></td>
                                            <td><?= $usr->job_vat; ?></td>
                                            <td><?= $usr->job_pph; ?></td>
                                            <td><?= $usr->job_admission; ?></td>
                                            <td><?= $usr->job_explanation; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "Master Job";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>