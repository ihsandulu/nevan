<?php echo $this->include("template/header_v"); ?>
<style>
    td {
        white-space: nowrap;
    }
</style>
<?php
$dari = date("Y-m-d");
$ke = date("Y-m-d");
$kas_type = "";
$rekeningnya = "";
if (isset($_GET["dari"])) {
    $dari = $_GET["dari"];
}
if (isset($_GET["ke"])) {
    $ke = $_GET["ke"];
}
if (isset($_GET["kas_type"])) {
    $kas_type = $_GET["kas_type"];
}
if (isset($_GET["rekeningnya"])) {
    $rekeningnya = $_GET["rekeningnya"];
}
?>
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
                                    isset(session()->get("halaman")['108']['act_create'])
                                    && session()->get("halaman")['108']['act_create'] == "1"
                                ) ||
                                (
                                    isset(session()->get("halaman")['120']['act_create'])
                                    && session()->get("halaman")['120']['act_create'] == "1"
                                ) ||
                                (
                                    isset(session()->get("halaman")['121']['act_create'])
                                    && session()->get("halaman")['121']['act_create'] == "1"
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
                                        <select onchange="pilihtype(); listrekening();" required class="form-control" id="kas_type" name="kas_type">
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
                                    <label class="control-label col-sm-12" for="job_dano">DA Number:</label>
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

                                <!-- <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_qty">Qty:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_qty" name="kas_qty" placeholder="" value="<?= $kas_qty; ?>">
                                    </div>
                                </div> -->

                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_nominal">Nominal:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_nominal" name="kas_nominal" placeholder="" value="<?= $kas_nominal; ?>">
                                    </div>
                                </div>
                                <!-- <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <label class="control-label col-sm-12" for="kas_total">Total:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kas_total" name="kas_total" placeholder="" value="<?= $kas_total; ?>">
                                    </div>
                                </div> -->
                                <script>
                                    function listrekening() {
                                        var kas_type = $("#kas_type").val();
                                        var kas_rekdari = $("#kas_rekdari").val();
                                        var kas_rekke = $("#kas_rekke").val();
                                        // alert('<?= base_url("api/listrekening"); ?>?type=' + kas_type + '&asal=from&kas_rekdari=' + kas_rekdari + '&kas_rekke=' + kas_rekke);
                                        $.get("<?= base_url("api/listrekening"); ?>", {
                                                type: kas_type,
                                                asal: 'from',
                                                kas_rekdari: kas_rekdari,
                                                kas_rekke: kas_rekke,
                                                url: '<?= $url; ?>'
                                            })
                                            .done(function(data) {
                                                $("#kas_rekdari").html(data);
                                            });
                                        $.get("<?= base_url("api/listrekening"); ?>", {
                                                type: kas_type,
                                                asal: 'to',
                                                kas_rekdari: kas_rekdari,
                                                kas_rekke: kas_rekke,
                                                url: '<?= $url; ?>'
                                            })
                                            .done(function(data) {
                                                $("#kas_rekke").html(data);
                                            });
                                    }

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
                                        listrekening();
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
                                        <select id="kas_rekdari" name="kas_rekdari" value="<?= $kas_rekdari; ?>" class="form-control select">
                                            <option value="" <?= ($kas_rekdari == "") ? "selected" : ""; ?>>Select Rekening</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("rekening")
                                                ->orderBy("rekening_type", "ASC")
                                                ->orderBy("rekening_an", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->rekening_id; ?>" <?= ($kas_rekdari == $usr->rekening_id) ? "selected" : ""; ?>>
                                                    (<?= $usr->rekening_type; ?>) <?= $usr->rekening_an; ?> - <?= $usr->rekening_no; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-sm-6 col-xs-12 rekke">
                                    <label class="control-label col-sm-12" for="kas_rekke">Rekening Ke:</label>
                                    <div class="col-sm-12">
                                        <select id="kas_rekke" name="kas_rekke" value="<?= $kas_rekke; ?>" class="form-control select">
                                            <option value="" <?= ($kas_rekke == "") ? "selected" : ""; ?>>Select Rekening</option>
                                            <option value="-1" <?= ($kas_rekke == "-1") ? "selected" : ""; ?>>Pettycash</option>
                                            <?php
                                            $usr = $this->db
                                                ->table("rekening")
                                                ->orderBy("rekening_type", "ASC")
                                                ->orderBy("rekening_an", "ASC")
                                                ->get();
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <option value="<?= $usr->rekening_id; ?>" <?= ($kas_rekke == $usr->rekening_id) ? "selected" : ""; ?>>
                                                    (<?= $usr->rekening_type; ?>) <?= $usr->rekening_an; ?> - <?= $usr->rekening_no; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

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

                                <input type="hidden" id="kas_pettyid" name="kas_pettyid" value="<?=$kas_pettyid;?>" />
                                <input type="hidden" id="kas_total" name="kas_total" value="<?=$kas_total;?>" />
                                <input type="hidden" id="kas_qty" name="kas_qty" value="1" />
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


                                <div class="col-4 ">
                                    <div class="row">
                                        <div class="col-12">
                                            <select onchange="pilihrekening()" class="form-control" id="rekeningnya" name="rekeningnya">
                                                <option value="" <?= ($rekeningnya == "") ? "selected" : ""; ?>>Pilih Rekening</option>
                                                <?php $rekening = $this->db
                                                    ->table("rekening")
                                                    ->join("bank", "bank.bank_id = rekening.bank_id", "left")
                                                    ->where("rekening_type", "NKL")
                                                    ->orderBy("rekening_an", "ASC")
                                                    ->get();
                                                foreach ($rekening->getResult() as $rekening) { ?>
                                                    <option value="<?= $rekening->rekening_id; ?>" <?= ($rekeningnya == $rekening->rekening_id) ? "selected" : ""; ?>>
                                                        (<?= $rekening->bank_name; ?>) <?= $rekening->rekening_an; ?> - <?= $rekening->rekening_no; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 tampil">
                                    <div class="row">
                                        <div class="col-12">
                                            <select class="form-control" id="kas_type" name="kas_type">
                                                <option value="" <?= ($kas_type == "") ? "selected" : ""; ?>>Pilih Type</option>
                                                <option value="Debet" <?= ($kas_type == "Debet") ? "selected" : ""; ?>>Debet</option>
                                                <option value="Kredit" <?= ($kas_type == "Kredit") ? "selected" : ""; ?>>Kredit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 tampil">
                                    <div class="row">
                                        <div class="col-12">
                                            <input data-bs-toggle="tooltip" data-bs-placement="top" title="Dari" type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 row tampil">
                                    <div class="row">
                                        <div class="col-12">
                                            <input data-bs-toggle="tooltip" data-bs-placement="top" title="Ke" type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2">
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
                                        <!-- <th>Qty</th> -->
                                        <th>Nominal</th>
                                        <!-- <th>Total</th> -->
                                        <!-- <?php if ($url == "kas") { ?>
                                            <th>Saldo</th>
                                        <?php } ?>
                                        <?php if ($url == "bigcash" || $url == "kas") { ?>
                                            <th>Saldo<br />Big Cash</th>
                                        <?php } ?>
                                        <?php if ($url == "pettycash" || $url == "kas") { ?>
                                            <th>Saldo<br />Petty Cash</th>
                                        <?php } ?> -->
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
                                    if ($rekeningnya != "") {
                                        $build->where("kas.kas_rekdari", $rekeningnya);
                                        $build->orWhere("kas.kas_rekke", $rekeningnya);
                                    }
                                    $build->where("kas_date BETWEEN '" . $dari . "' AND '" . $ke . "'");
                                    $usr = $build->orderBy("kas.kas_date", "ASC")
                                        ->get();

                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    $debettype = array("pettycash" => "Petty Cash", "bigcash" => "Big Cash");
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <?php
                                                    if (($usr->kas_bigid == 0 && $usr->kas_debettype == "pettycash") || $usr->kas_debettype == "bigcash") { ?>
                                                        <?php if ($usr->invpayment_id == 0 && $usr->invvdrp_id == 0) {
                                                            if (
                                                                (
                                                                    isset(session()->get("position_administrator")[0][0])
                                                                    && (
                                                                        session()->get("position_administrator") == "1"
                                                                        || session()->get("position_administrator") == "2"
                                                                    )
                                                                ) ||
                                                                (
                                                                    isset(session()->get("halaman")['108']['act_update'])
                                                                    && session()->get("halaman")['108']['act_update'] == "1"
                                                                ) ||
                                                                (
                                                                    isset(session()->get("halaman")['120']['act_update'])
                                                                    && session()->get("halaman")['120']['act_update'] == "1"
                                                                ) ||
                                                                (
                                                                    isset(session()->get("halaman")['121']['act_update'])
                                                                    && session()->get("halaman")['121']['act_update'] == "1"
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
                                                                    isset(session()->get("halaman")['108']['act_delete'])
                                                                    && session()->get("halaman")['108']['act_delete'] == "1"
                                                                ) ||
                                                                (
                                                                    isset(session()->get("halaman")['120']['act_delete'])
                                                                    && session()->get("halaman")['120']['act_delete'] == "1"
                                                                ) ||
                                                                (
                                                                    isset(session()->get("halaman")['121']['act_delete'])
                                                                    && session()->get("halaman")['121']['act_delete'] == "1"
                                                                )
                                                            ) { ?>
                                                                <form method="post" class="btn-action" style="">
                                                                    <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="kas_id" value="<?= $usr->kas_id; ?>" />
                                                                    <input type="hidden" name="kas_pettyid" value="<?= $usr->kas_pettyid; ?>" />
                                                                </form>
                                                            <?php } ?>
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
                                            <!-- <td><?= number_format($usr->kas_qty, 0, ",", "."); ?></td> -->
                                            <td><?= number_format($usr->kas_nominal, 0, ",", "."); ?></td>
                                            <!-- <td><?= number_format($usr->kas_total, 0, ",", "."); ?></td> -->
                                            <!-- <?php if ($url == "kas") { ?>
                                                <td class="text-right"><?= number_format($usr->kas_saldo, 0, ",", "."); ?></td>
                                            <?php } ?>
                                            <?php if ($url == "bigcash" || $url == "kas") { ?>
                                                <td class="text-right"><?= number_format($usr->kas_bigcash, 0, ",", "."); ?></td>
                                            <?php } ?>
                                            <?php if ($url == "pettycash" || $url == "kas") { ?>
                                                <td class="text-right"><?= number_format($usr->kas_pettycash, 0, ",", "."); ?></td>
                                            <?php } ?> -->
                                            <td class="text-left"><?= ($usr->kas_rekdari == "-1") ? "Pettycash" : $usr->rekdari; ?></td>
                                            <td class="text-left"><?= ($usr->kas_rekke == "-1") ? "Pettycash" : $usr->rekke; ?></td>
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
    <?php
    $banknya = "";
    // if ($rekeningnya != "") {
    $saldon = 0;
    $kas = $this->db
        ->table("kas")
        ->select(" SUM(CASE WHEN kas_type = 'Debet' THEN kas_total WHEN kas_type = 'Kredit' THEN -kas_total ELSE 0 END) AS saldo_akhir")
        ->where("kas_rekdari", $rekeningnya)
        ->orWhere("kas_rekke", $rekeningnya)
        ->get();
    foreach ($kas->getResult() as $s) {
        $saldon = $s->saldo_akhir;
    }
    $rekening = $this->db
        ->table("rekening")
        ->join("bank", "bank.bank_id = rekening.bank_id", "left")
        ->where("rekening_id", $rekeningnya)
        ->get();
    foreach ($rekening->getResult() as $rek) {
        $banknya = $rek->bank_name . " | " . $rek->rekening_an . " - " . $rek->rekening_no . " ";
    }
    /* } else {
        $saldon = $saldo;
    } */
    ?>
    $(".card-title").html(title + ' <span class="text-danger">( Saldo Akhir <?= $banknya; ?>: Rp. <?= number_format($saldon, 0, ",", ".") ?> )</span>');
    $("#page-title").text(title);
    $("#page-title-link").text(title);

    function pilihrekening1() {
        let rekeningnya = $("#rekeningnya").val();
        if (rekeningnya == "") {
            $(".tampil").show();
        } else {
            $(".tampil").hide();
        }
    }
    $(document).ready(function() {
        pilihrekening();
    });
</script>

<?php echo  $this->include("template/footer_v"); ?>