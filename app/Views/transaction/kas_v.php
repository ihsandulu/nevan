<?php echo $this->include("template/header_v"); ?>
<style>
    td {
        white-space: nowrap;
    }
</style>

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
                                        <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                                        <input type="hidden" name="kas_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Kas";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Kas";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal row" method="post" enctype="multipart/form-data">



                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_date">DATE:</label>
                                    <div class="col-sm-12">
                                        <input required type="date" autofocus class="form-control" id="kas_date" name="kas_date" placeholder="" value="<?= ($kas_date == "") ? date("Y-m-d") : $kas_date; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_type">Type:</label>
                                    <div class="col-sm-12">
                                        <select onchange="pilihtype()" required class="form-control" id="kas_type" name="kas_type">
                                            <option value="" <?= ($kas_type == "") ? "selected" : ""; ?>>Pilih Type</option>
                                            <option value="Debet" <?= ($kas_type == "Debet") ? "selected" : ""; ?>>Debet</option>
                                            <option value="Kredit" <?= ($kas_type == "Kredit") ? "selected" : ""; ?>>Kredit</option>
                                        </select>
                                    </div>
                                </div>
                                <?php if ($url == "kas") { ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <label class="control-label col-sm-12" for="kas_debettype">Petty/Big Cash:</label>
                                        <div class="col-sm-12">
                                            <select onchange="pilihtype()" required class="form-control" id="kas_debettype" name="kas_debettype">
                                                <option value="" <?= ($kas_debettype == "") ? "selected" : ""; ?>>Pilih Type</option>
                                                <option value="pettycash" <?= ($kas_debettype == "pettycash") ? "selected" : ""; ?>>Petty Cash</option>
                                                <option value="bigcash" <?= ($kas_debettype == "bigcash") ? "selected" : ""; ?>>Big Cash</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } else {
                                    $kas_debettype = $url;
                                ?>
                                    <input type="hidden" name="kas_debettype" value="<?= $kas_debettype; ?>" />
                                <?php } ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_type">DA Number:</label>
                                    <div class="col-sm-12">
                                        <select name="job_dano" value="<?= $job_dano; ?>" class="form-control select">
                                            <option value="" <?= ($job_dano == "") ? "selected" : ""; ?>>Select DA Number</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("job")
                                                ->orderBy("job_dano", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->job_dano; ?>" <?= ($job_dano == $usr->job_dano) ? "selected" : ""; ?>><?= $usr->job_dano; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_uraian">Uraian:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_uraian" name="kas_uraian" placeholder="" value="<?= $kas_uraian; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_qty">Qty:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_qty" name="kas_qty" placeholder="" value="<?= $kas_qty; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_nominal">Nominal:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_nominal" name="kas_nominal" placeholder="" value="<?= $kas_nominal; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_total">Total:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_total" name="kas_total" placeholder="" value="<?= $kas_total; ?>">
                                    </div>
                                </div>
                                <script>
                                    function pilihtype() {
                                        var kas_type = $("#kas_type").val();
                                        var kas_debettype = $("#kas_debettype").val();
                                        if (kas_type == "Debet") {
                                            $(".kredit").hide();
                                            $(".debet").show();
                                            $("#vendor_id").val("");
                                        } else {
                                            $(".kredit").show();
                                            $(".debet").hide();
                                        }
                                        if (kas_type == "Debet" && kas_debettype == "pettycash") {
                                            $(".rekke").hide();
                                        } else {
                                            $(".rekke").show();
                                        }
                                    }
                                    $(document).ready(function() {
                                        pilihtype();
                                        $("#kas_qty, #kas_nominal, #kas_total").on("keyup", function() {
                                            var kas_qty = $("#kas_qty").val();
                                            var kas_nominal = $("#kas_nominal").val();
                                            var kas_total = kas_qty * kas_nominal;
                                            $("#kas_total").val(kas_total);
                                        });
                                    });
                                </script>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_rekdari">Rekening Dari:</label>
                                    <div class="col-sm-12">
                                        <select name="kas_rekdari" value="<?= $kas_rekdari; ?>" class="form-control select">
                                            <option value="" <?= ($kas_rekdari == "") ? "selected" : ""; ?>>Select Rekening</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("rekening")
                                                ->orderBy("rekening_an", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->rekening_id; ?>" <?= ($kas_rekdari == $usr->rekening_id) ? "selected" : ""; ?>><?= $usr->rekening_an; ?> - <?= $usr->rekening_no; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if ($url != "pettycash") { ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12 rekke">
                                        <label class="control-label col-sm-12" for="kas_rekke">Rekening Ke:</label>
                                        <div class="col-sm-12">
                                            <select name="kas_rekke" value="<?= $kas_rekke; ?>" class="form-control select">
                                                <option value="" <?= ($kas_rekke == "") ? "selected" : ""; ?>>Select Rekening</option>
                                                <?php
                                                $usr = $this->db
                                                    ->table("rekening")
                                                    ->orderBy("rekening_an", "ASC")
                                                    ->get();
                                                foreach ($usr->getResult() as $usr) { ?>
                                                    <option value="<?= $usr->rekening_id; ?>" <?= ($kas_rekke == $usr->rekening_id) ? "selected" : ""; ?>><?= $usr->rekening_an; ?> - <?= $usr->rekening_no; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_keterangan">Keterangan:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_keterangan" name="kas_keterangan" placeholder="" value="<?= $kas_keterangan; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 kredit">
                                    <label class="control-label col-sm-12" for="vendor_id">Vendor:</label>
                                    <div class="col-sm-12">
                                        <select id="vendor_id" name="vendor_id" value="<?= $vendor_id; ?>" class="form-control select">
                                            <option value="" <?= ($vendor_id == "") ? "selected" : ""; ?>>Select Vendor</option>
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

                                <input type="hidden" name="kas_id" value="<?= $kas_id; ?>" />
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-sm-offset-2 col-sm-12">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url($url); ?>">Back</a>
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
                        <form method="get">
                            <div class="row alert alert-dark">
                                <?php
                                $dari = date("Y-m-d");
                                $ke = date("Y-m-d");
                                $kas_type = "";
                                if (isset($_GET["dari"])) {
                                    $dari = $_GET["dari"];
                                }
                                if (isset($_GET["ke"])) {
                                    $ke = $_GET["ke"];
                                }
                                if (isset($_GET["kas_type"])) {
                                    $kas_type = $_GET["kas_type"];
                                }
                                ?>
                                <div class="col-3 ">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="text-dark">Type :</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" id="kas_type" name="kas_type">
                                                <option value="" <?= ($kas_type == "") ? "selected" : ""; ?>>Pilih Type</option>
                                                <option value="Debet" <?= ($kas_type == "Debet") ? "selected" : ""; ?>>Debet</option>
                                                <option value="Kredit" <?= ($kas_type == "Kredit") ? "selected" : ""; ?>>Kredit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 ">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="text-dark">Dari :</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 row ">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="text-dark">Ke :</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="submit" class="btn btn-block btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <th>Date</th>
                                        <th>Type</th>
                                        <?php if ($url == "kas") { ?>
                                            <th>Petty/Big Cash</th>
                                        <?php } ?>
                                        <th>DA Number</th>
                                        <th>Uraian</th>
                                        <th>Qty</th>
                                        <th>Nominal</th>
                                        <th>Total</th>
                                        <?php if ($url == "kas") { ?>
                                            <th>Saldo</th>
                                        <?php } ?>
                                        <?php if ($url == "bigcash" || $url == "kas") { ?>
                                            <th>Saldo<br />Big Cash</th>
                                        <?php } ?>
                                        <?php if ($url == "pettycash" || $url == "kas") { ?>
                                            <th>Saldo<br />Petty Cash</th>
                                        <?php } ?>
                                        <th>Dari Rek</th>
                                        <th>Ke Rek</th>
                                        <th>Keterangan</th>
                                        <?php if (isset($_GET["kas_type"]) &&  $_GET["kas_type"] != "Debet") { ?>
                                            <th>Vendor</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $build = $this->db
                                        ->table("kas")
                                        ->select("kas.*, rekdari.rekening_an AS rekdari, rekke.rekening_an AS rekke, kas.kas_id AS kas_id, vendor.vendor_name AS vendor_name")
                                        ->join("vendor", "vendor.vendor_id = kas.vendor_id", "left")
                                        ->join("rekening AS rekdari", "rekdari.rekening_id = kas.kas_rekdari", "left")
                                        ->join("rekening AS rekke", "rekke.rekening_id = kas.kas_rekke", "left");
                                    if (isset($_GET["kas_type"]) &&  $_GET["kas_type"] != "") {
                                        $build->where("kas_type", $_GET["kas_type"]);
                                    }
                                    if ($url == "bigcash") {
                                        $build->where("kas_debettype", "bigcash");
                                    }
                                    if ($url == "pettycash") {
                                        $build->where("kas_debettype", "pettycash");
                                    }
                                    $build->where("kas_date BETWEEN '" . $dari . "' AND '" . $ke . "'");
                                    $usr = $build->orderBy("kas.kas_id", "DESC")
                                        ->get();

                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    $debettype = array("pettycash" => "Petty Cash", "bigcash" => "Big Cash");
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <?php
                                                    if ($usr->invpayment_id == 0 && $usr->invvdrp_id == 0) {
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
                                                                <input type="hidden" name="kas_id" value="<?= $usr->kas_id; ?>" />
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
                                                                <input type="hidden" name="kas_id" value="<?= $usr->kas_id; ?>" />
                                                            </form>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td><?= $usr->kas_date; ?></td>
                                            <td><?= $usr->kas_type; ?></td>
                                            <?php if ($url == "kas") { ?>
                                                <td><?= $debettype[$usr->kas_debettype]; ?></td>
                                            <?php } ?>
                                            <td><?= $usr->job_dano; ?></td>
                                            <td class="text-left"><?= $usr->kas_uraian; ?></td>
                                            <td><?= number_format($usr->kas_qty, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->kas_nominal, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->kas_total, 0, ",", "."); ?></td>
                                            <?php if ($url == "kas") { ?>
                                                <td class="text-right"><?= number_format($usr->kas_saldo, 0, ",", "."); ?></td>
                                            <?php } ?>
                                            <?php if ($url == "bigcash" || $url == "kas") { ?>
                                                <td class="text-right"><?= number_format($usr->kas_bigcash, 0, ",", "."); ?></td>
                                            <?php } ?>
                                            <?php if ($url == "pettycash" || $url == "kas") { ?>
                                                <td class="text-right"><?= number_format($usr->kas_pettycash, 0, ",", "."); ?></td>
                                            <?php } ?>
                                            <td class="text-left"><?= ($usr->rekdari == "") ? "Pettycash" : $usr->rekdari; ?></td>
                                            <td class="text-left"><?= ($usr->rekke == "") ? "Pettycash" : $usr->rekke; ?></td>
                                            <td class="text-left"><?= $usr->kas_keterangan; ?></td>
                                            <?php if (isset($_GET["kas_type"]) &&  $_GET["kas_type"] != "Debet") { ?>
                                                <td class="text-left"><?= $usr->vendor_name; ?></td>
                                            <?php } ?>
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
    var title = "<?= $title; ?>";
    $("title").text(title);
    $(".card-title").html(title + ' <span class="text-danger">( Saldo Akhir: Rp. <?= number_format($saldo, 0, ",", ".") ?> )</span>');
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>