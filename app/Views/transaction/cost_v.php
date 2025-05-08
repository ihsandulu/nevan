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
                                        <input type="hidden" name="cost_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update cost";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah cost";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal row" method="post" enctype="multipart/form-data">
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="cost_shipmentdate">SHIPMENT DATE:</label>
                                    <div class="col-sm-12">
                                        <input type="date" autofocus class="form-control" id="cost_shipmentdate" name="cost_shipmentdate" placeholder="" value="<?= $cost_shipmentdate; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="customer_id">SHIPPER NAME:</label>
                                    <div class="col-sm-12">
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

                                <?php if ($ppn != 2) { ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="origin_id">ORIGIN:</label>
                                        <div class="col-sm-12">
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
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="destination_id">DESTINATION:</label>
                                        <div class="col-sm-12">
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
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_descgood">DESCRIPTION OF GOODS:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="cost_descgood" name="cost_descgood" placeholder="" value="<?= $cost_descgood; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        &nbsp;
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_methode">Metode:</label>
                                        <div class="col-sm-12">
                                            <select onchange="metode()" class="form-control select" id="cost_methode" name="cost_methode">
                                                <option value="">--Select--</option>
                                                <option value="lumpsum" <?= ($cost_methode == "lumpsum") ? "selected" : ""; ?>>Lumpsum</option>
                                                <option value="cbm" <?= ($cost_methode == "cbm") ? "selected" : ""; ?>>CBM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_qty">QTY:</label>
                                        <div class="col-sm-12">
                                            <input onchange="totalsell('qty')" type="number" class="form-control" id="cost_qty" name="cost_qty" placeholder="" value="<?= $cost_qty; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_cbm">CBM / KGS:</label>
                                        <div class="col-sm-12">
                                            <input onchange="totalsell('cbm')" type="number" class="form-control" id="cost_cbm" name="cost_cbm" placeholder="" value="<?= $cost_cbm; ?>">
                                        </div>
                                    </div>


                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_satuan">SATUAN:</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select" id="cost_satuan" name="cost_satuan">
                                                <option value="">--Select--</option>
                                                <?php
                                                $usr = $this->db
                                                    ->table("satuan")
                                                    ->orderBy("satuan_name", "ASC")
                                                    ->get();
                                                foreach ($usr->getResult() as $usr) { ?>
                                                    <option value="<?= $usr->satuan_name; ?>" <?= ($cost_satuan == $usr->satuan_name) ? "selected" : ""; ?>><?= $usr->satuan_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="service_id">SERVICE:</label>
                                        <div class="col-sm-12">
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
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="vendortruck_id">TRUCKING:</label>
                                        <div class="col-sm-12">
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
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="vessel_id">VESSEL:</label>
                                        <div class="col-sm-12">
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
                                    <?php if ($ppn == 0) { ?>
                                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                            <label class="control-label col-sm-12" for="vendor_id">VENDOR / PELAYARAN:</label>
                                            <div class="col-sm-12">
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
                                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                            <label class="control-label col-sm-12" for="cost_dooring">DOORING:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select" id="cost_dooring" name="cost_dooring">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    $usr = $this->db
                                                        ->table("vendor")
                                                        ->orderBy("vendor_name", "ASC")
                                                        ->get();
                                                    foreach ($usr->getResult() as $usr) { ?>
                                                        <option value="<?= $usr->vendor_id; ?>" <?= ($cost_dooring == $usr->vendor_id) ? "selected" : ""; ?>><?= $usr->vendor_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    <?php } ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_sell">SELL RPRICE:</label>
                                        <div class="col-sm-12">
                                            <input onchange="totalsell()" type="number" class="form-control" id="cost_sell" name="cost_sell" placeholder="" value="<?= $cost_sell; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_total">TOTAL PRICE:</label>
                                        <div class="col-sm-12">
                                            <input onchange="profit(); totalinv();" type="number" onchange="tprice()" class="form-control" id="cost_total" name="cost_total" placeholder="" value="<?= $cost_total; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_cost">COST:</label>
                                        <div class="col-sm-12">
                                            <input onchange="profit()" type="number" class="form-control" id="cost_cost" name="cost_cost" placeholder="" value="<?= $cost_cost; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_refund">REFUND:</label>
                                        <div class="col-sm-12">
                                            <input onchange="profit()" type="number" class="form-control" id="cost_refund" name="cost_refund" placeholder="" value="<?= $cost_refund; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_fee"> MARKET FEE 15%:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="cost_fee" name="cost_fee" placeholder="" value="<?= $cost_fee; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_profit">PROFIT:</label>
                                        <div class="col-sm-12">
                                            <input onchange="fee()" type="number" class="form-control" id="cost_profit" name="cost_profit" placeholder="" value="<?= $cost_profit; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_gp">GP %:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="cost_gp" name="cost_gp" placeholder="" value="<?= $cost_gp; ?>">
                                        </div>
                                    </div>
                                    <?php if ($ppn == 0) { ?>
                                        <div class="form-group col-md-4 col-sm-6 col-xs-12">&nbsp;
                                        </div>
                                    <?php } ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_ppn1k1">PPN 1.1%:</label>
                                        <div class="col-sm-12">
                                            <input onchange="totalinv()" type="number" class="form-control" id="cost_ppn1k1" name="cost_ppn1k1" placeholder="" value="<?= $cost_ppn1k1; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_ppn11">PPN 11%:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="cost_ppn11" name="cost_ppn11" placeholder="" value="<?= $cost_ppn11; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_ppn12">PPN 12%:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="cost_ppn12" name="cost_ppn12" placeholder="" value="<?= $cost_ppn12; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_pph">PPH 2%:</label>
                                        <div class="col-sm-12">
                                            <input onchange="dp()" type="number" class="form-control" id="cost_pph" name="cost_pph" placeholder="" value="<?= $cost_pph; ?>">
                                        </div>
                                    </div>
                                    <?php if ($ppn == 1) { ?>
                                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                            <label class="control-label col-sm-12" for="vendor_id">Payment Methode:</label>
                                            <div class="col-sm-12">
                                                <input type="number" min="1" class="form-control" id="cost_paynom" name="cost_paynom" placeholder="" value="<?= ($cost_paynom > 0) ? $cost_paynom : 1; ?>">
                                                <select class="form-control select" id="cost_payunit" name="cost_payunit">
                                                    <option value="WEEK" <?= ($cost_payunit == "WEEK") ? "selected" : ""; ?>>WEEK</option>
                                                    <option value="MONTH" <?= ($cost_payunit == "MONTH") ? "selected" : ""; ?>>MONTH</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                            <label class="control-label col-sm-12" for="cost_taxno">Tax Number:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="cost_taxno" name="cost_taxno" placeholder="" value="<?= $cost_taxno; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                            <label class="control-label col-sm-12" for="cost_invdate">Invoice Date:</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="cost_invdate" name="cost_invdate" placeholder="" value="<?= $cost_invdate; ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="cost_invoice">Invoice No:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="cost_invoice" name="cost_invoice" placeholder="" value="<?= $cost_invoice; ?>">
                                    </div>
                                </div>
                                <?php if ($ppn == 1) { ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_bupot">Bupot No:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="cost_bupot" name="cost_bupot" placeholder="" value="<?= $cost_bupot; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_npwp">NPWP:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="cost_npwp" name="cost_npwp" placeholder="" value="<?= $cost_npwp; ?>">
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($ppn != 0) { ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_duedate">Due Date:</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="cost_duedate" name="cost_duedate" placeholder="" value="<?= $cost_duedate; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_totalinv">Total INV:</label>
                                        <div class="col-sm-12">
                                            <input onchange="dp()" type="number" class="form-control" id="cost_totalinv" name="cost_totalinv" placeholder="" value="<?= $cost_totalinv; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_dp">DP:</label>
                                        <div class="col-sm-12">
                                            <input onchange="dp()" type="text" class="form-control" id="cost_dp" name="cost_dp" placeholder="" value="<?= $cost_dp; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="cost_repayment">Repayment:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="cost_repayment" name="cost_repayment" placeholder="" value="<?= $cost_repayment; ?>">
                                        </div>
                                    </div>
                                    <script>
                                        function totalinv() {
                                            let cost_ppn1k1 = $("#cost_ppn1k1").val();
                                            let cost_total = $("#cost_total").val();
                                            let cost_totalinv = parseInt(cost_total) * parseInt(cost_ppn1k1) / 100;
                                            $("#cost_totalinv").val(cost_totalinv);
                                            dp();
                                        }

                                        function dp() {
                                            let cost_dp = $("#cost_dp").val();
                                            let cost_totalinv = $("#cost_totalinv").val();
                                            let cost_pph = $("#cost_pph").val();
                                            let total = parseInt(cost_totalinv) - parseInt(cost_pph) - parseInt(cost_dp);
                                            $("#cost_repayment").val(total);
                                            $("#cost_admission").val(total);
                                        }
                                    </script>
                                <?php } ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="cost_admission">ADMISSION:</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="cost_admission" name="cost_admission" placeholder="" value="<?= $cost_admission; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="cost_explanation">EXPLANATION:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="cost_explanation" name="cost_explanation" placeholder="" value="<?= $cost_explanation; ?>">
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        metode(); // jalankan saat halaman dimuat


                                    });

                                    function metode() {
                                        let metode = $("#cost_methode").val();
                                        if (metode == "cbm") {
                                            $("#cost_qty").attr("readonly", true);
                                            $("#cost_cbm").attr("readonly", false);
                                            setTimeout(function() {
                                                $("#cost_qty").val("0");
                                                $("#cost_cbm").focus();
                                            }, 1000);
                                            totalsell('cbm');
                                        } else if (metode == "lumpsum") {
                                            $("#cost_qty").attr("readonly", false);
                                            $("#cost_cbm").attr("readonly", true);
                                            setTimeout(function() {
                                                $("#cost_cbm").val("0");
                                                $("#cost_qty").focus();
                                            }, 1000);
                                            totalsell('lumpsum');
                                        } else {
                                            $("#cost_qty").attr("readonly", true);
                                            $("#cost_cbm").attr("readonly", true);
                                        }
                                    }

                                    function totalsell(a) {
                                        let cbm = $("#cost_cbm").val();
                                        let qty = $("#cost_qty").val();
                                        let sell = $("#cost_sell").val();
                                        let total = 0;
                                        if (a == "cbm") {
                                            total = cbm * sell;
                                        } else {
                                            total = qty * sell;
                                        }
                                        $("#cost_total").val(total);
                                        tprice();
                                        totalinv();
                                    }

                                    function tprice() {
                                        let cost_total = $("#cost_total").val();
                                        let ppn1k1 = cost_total * 1.1 / 100;
                                        let ppn11 = cost_total * 11 / 100;
                                        let ppn12 = cost_total * 12 / 100;
                                        let pph = cost_total * 2 / 100;
                                        $("#cost_ppn1k1").val(ppn1k1);
                                        $("#cost_ppn11").val(ppn11);
                                        $("#cost_ppn12").val(ppn12);
                                        $("#cost_pph").val(pph);
                                        profit();
                                        totalinv();
                                        dp();
                                    }

                                    function profit() {
                                        let cost_total = $("#cost_total").val();
                                        let cost_cost = $("#cost_cost").val();
                                        let cost_refund = $("#cost_refund").val();
                                        let profit = (parseInt(cost_total) - parseInt(cost_cost) - parseInt(cost_refund));
                                        $("#cost_profit").val(profit);
                                        let gp = 0;
                                        if (cost_total > 0) {
                                            gp = (profit / cost_total) * 100;
                                        }
                                        $("#cost_gp").val(gp);
                                        fee();
                                    }

                                    function fee() {
                                        let cost_profit = $("#cost_profit").val();
                                        let fee = parseInt(cost_profit) * 15 / 100;
                                        $("#cost_fee").val(fee);
                                    }
                                </script>

                                <input type="hidden" name="cost_id" value="<?= $cost_id; ?>" />
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <div class="col-sm-offset-2 col-sm-12">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="javascript:history.back()">Back</a>
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
                                        <?php if ($ppn == 0) { ?>
                                            <th>Methode</th>
                                        <?php } ?>

                                        <th>Shipment Date</th>
                                        <th>DA Number</th>
                                        <th>Shipper Name</th>
                                        <?php if ($ppn != 2) { ?>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Description of Goods</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>CBM/MT</th>
                                            <th>Service</th>
                                            <th>Trucking</th>
                                            <th>Vessel</th>
                                            <?php if ($ppn == 0) { ?>
                                                <th>Vendor/Pelayaran</th>
                                                <th>Dooring</th>
                                            <?php } ?>
                                            <th>Sell Price</th>
                                            <th>Total Price</th>
                                            <th>Cost</th>
                                            <th>Refund</th>
                                            <th>Market Fee 15%</th>
                                            <th>Profit</th>
                                            <th>GP%</th>
                                            <th>PPN 1,1%</th>
                                            <th>PPN 11%</th>
                                            <th>PPN 12%</th>
                                            <th>PPH 2%</th>
                                            <?php if ($ppn == 1) { ?>
                                                <th>Payment Methode</th>
                                                <th>Tax No.</th>
                                                <th>Inv Date</th>
                                            <?php } ?>
                                        <?php } ?>

                                        <th>Invoice No.</th>
                                        <?php if ($ppn == 1) { ?>
                                            <th>Bupot No.</th>
                                            <th>NPWP</th>
                                        <?php } ?>
                                        <?php if ($ppn != 0) { ?>
                                            <th>Due Date</th>
                                            <th>Total INV</th>
                                            <th>DP</th>
                                            <th>Repayment</th>
                                        <?php } ?>
                                        <th>Admission</th>
                                        <th>Explanation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("cost")
                                        ->join("customer", "customer.customer_id = cost.customer_id", "left")
                                        ->join("origin", "origin.origin_id = cost.origin_id", "left")
                                        ->join("destination", "destination.destination_id = cost.destination_id", "left")
                                        ->join("vendor", "vendor.vendor_id = cost.vendor_id", "left")
                                        ->join("vendortruck", "vendortruck.vendortruck_id = cost.vendortruck_id", "left")
                                        ->join("(SELECT vendor_id as vendor_id2, vendor_name AS vendor_name2 FROM vendor) AS v2", "v2.vendor_id2 = vendortruck.vendor_id", "left")
                                        ->join("service", "service.service_id = cost.service_id", "left")
                                        ->join("vessel", "vessel.vessel_id = cost.vessel_id", "left")
                                        ->orderBy("cost_id", "ASC")
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
                                                            <input type="hidden" name="cost_id" value="<?= $usr->cost_id; ?>" />
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
                                                            <input type="hidden" name="cost_id" value="<?= $usr->cost_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <?php if ($ppn == 0) { ?>
                                                <td><?= $usr->cost_methode; ?></td>
                                            <?php } ?>
                                            <td style="white-space:nowrap;"><?= $usr->cost_shipmentdate; ?></td>
                                            <td><?= $usr->cost_dano; ?></td>
                                            <td style="white-space:nowrap;"><?= $usr->customer_name; ?></td>

                                            <?php if ($ppn != 2) { ?>
                                                <td><?= $usr->origin_name; ?></td>
                                                <td><?= $usr->destination_name; ?></td>
                                                <td style="white-space:nowrap;"><?= $usr->cost_descgood; ?></td>
                                                <td><?= number_format($usr->cost_qty, 0, ",", "."); ?></td>
                                                <td><?= $usr->cost_satuan; ?></td>
                                                <td><?= number_format($usr->cost_cbm, 0, ",", "."); ?></td>
                                                <td style="white-space:nowrap;"><?= $usr->service_name; ?></td>
                                                <td style="white-space:nowrap;"><?= $usr->vendortruck_name; ?> - <?= $usr->vendor_name2; ?></td>
                                                <td><?= $usr->vessel_id; ?></td>
                                                <?php if ($ppn == 0) { ?>
                                                    <td><?= $usr->vendor_name; ?></td>
                                                    <td><?= $usr->cost_dooring; ?></td>
                                                <?php } ?>
                                                <td><?= number_format($usr->cost_sell, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_total, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_cost, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_refund, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_fee, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_profit, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_gp, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_ppn1k1, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_ppn11, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_ppn12, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_pph, 0, ",", "."); ?></td>
                                                <?php if ($ppn == 1) { ?>
                                                    <td><?= $usr->cost_paynom; ?> <?= $usr->cost_payunit; ?></td>
                                                    <td><?= $usr->cost_taxno; ?></td>
                                                    <td style="white-space:nowrap;"><?= $usr->cost_invdate; ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                            <td style="white-space:nowrap;"><?= $usr->cost_invoice; ?></td>
                                            <?php if ($ppn == 1) { ?>
                                                <td style="white-space:nowrap;"><?= $usr->cost_bupot; ?></td>
                                                <td style="white-space:nowrap;"><?= $usr->cost_npwp; ?></td>
                                            <?php } ?>
                                            <?php if ($ppn != 0) { ?>
                                                <td style="white-space:nowrap;"><?= $usr->cost_duedate; ?></td>
                                                <td><?= number_format($usr->cost_totalinv, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_dp, 0, ",", "."); ?></td>
                                                <td><?= number_format($usr->cost_repayment, 0, ",", "."); ?></td>
                                            <?php } ?>
                                            <td style="white-space:nowrap;"><?= $usr->cost_admission; ?></td>
                                            <td style="white-space:nowrap;"><?= $usr->cost_explanation; ?></td>
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
    var title = "Master <?= $title; ?>";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>