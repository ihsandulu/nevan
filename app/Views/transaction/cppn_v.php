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
                                $judul = "Update Customer PPN";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Customer PPN";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_id">DA NO.:</label>
                                    <div class="col-sm-10">
                                        <select onchange="isidata()" class="form-control select" id="job_id" name="job_id">
                                            <option value="">--Select--</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("job")
                                                ->orderBy("job_name", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option data-cbm="<?= $usr->job_cbm; ?>" data-sell="<?= $usr->job_sell; ?>" data-total="<?= $usr->job_total; ?>"  value="<?= $usr->job_id; ?>" <?= ($job_id == $usr->job_id) ? "selected" : ""; ?>><?= $usr->job_dano; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            function isidata() {
                                                let ppn = $("#job_id option:selected").data("total");
                                                ppn = ppn * 0.11;
                                                // alert(singkatan);
                                                $("#job_ppn").val(ppn);

                                                
                                                let sell = $("#job_id option:selected").data("sell");
                                                $("#job_sell").val(sell);

                                                let cbm = $("#job_id option:selected").data("cbm");
                                                $("#job_cbm").val(cbm);

                                                let totalsell = cbm*sell;
                                                $("#job_totalsell").val(totalsell);
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_cbm">CBM:</label>
                                    <div class="col-sm-10">
                                        <input readonly type="number" class="form-control" id="job_cbm" name="job_cbm" placeholder="" value="<?= $job_cbm; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_sell">Price:</label>
                                    <div class="col-sm-10">
                                        <input readonly type="number" class="form-control" id="job_sell" name="job_sell" placeholder="" value="<?= $job_sell; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_ppn">PPN:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_ppn" name="job_ppn" placeholder="" value="<?= $job_ppn; ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="job_totalsell">TOTAL SELL:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="job_totalsell" name="job_totalsell" placeholder="" value="<?= $job_totalsell; ?>">
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
    var title = "Master Customer PPN";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>