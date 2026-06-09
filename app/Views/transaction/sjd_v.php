<?php echo $this->include("template/header_v");
$identity = $this->db->table("identity")->get()->getRow();
if (isset($_GET["tbl"])) {
    $tbl = $_GET["tbl"];
} else {
    $tbl = "";
}

$key = getenv('encryptionKey');  // bebas asal panjang minimal 16
$method = "AES-256-CBC";
$iv = substr(hash('sha256', $key), 0, 16);
?>
<style>
    td {
        white-space: nowrap;
    }

    .popover-body {
        color: #fff !important;
    }

    .bs-popover-top {
        background: #000;
    }

    .bs-popover-top .arrow::before {
        border-top-color: #000;
        color: #000 !important;
    }

    .text-black {
        color: #000 !important;
    }
</style>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">

                    <?php if ($message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><?= $message; ?></strong>
                        </div>
                    <?php } ?>


                    <form method="post" class="form-inline alert alert-info" action="">
                        <div class="form-group">
                            <select required onchange="metoden()" class="form-control" id="sjd_methode" name="sjd_methode">
                                <option value="">--Methode--</option>
                                <option value="lumpsum">Lumpsum (Koli)</option>
                                <option value="cbm">CBM</option>
                                <option value="kgs">KGS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" style="width: 400px;" id="sjd_descgood" name="sjd_descgood" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <input onkeyup="kali(); isiotom();" type="text" class="form-control" style="width: 80px;" id="sjd_qty" name="sjd_qty" placeholder="QTY">
                        </div>
                        <div class="form-group" id="kolian">
                            <input type="text" class="form-control" style="width: 80px;" id="sjd_koli" name="sjd_koli" placeholder="Koli" title="Koli" data-bs-toggle="tooltip">
                        </div>
                        <div class="form-group" id="cbman">
                            <input type="text" class="form-control" style="width: 80px;" id="sjd_cbm" name="sjd_cbm" placeholder="CBM/KGS" title="CBM/KGS" data-bs-toggle="tooltip">
                        </div>
                        <script>
                            function isiotom() {
                                let qty = $("#sjd_qty").val();
                                let metode = $("#sjd_methode").val();
                                if (metode == "lumpsum") {
                                    $("#sjd_koli").val(qty);
                                    $("#sjd_cbm").val("");
                                } else if (metode == "cbm") {
                                    $("#sjd_cbm").val(qty);
                                    $("#sjd_koli").val("");
                                } else if (metode == "kgs") {
                                    $("#sjd_cbm").val(qty);
                                    $("#sjd_koli").val("");
                                } else {
                                    $("#sjd_koli").val("");
                                    $("#sjd_cbm").val("");
                                }
                            }

                            function metoden() {
                                let metode = $("#sjd_methode").val();
                                if (metode == "lumpsum") {
                                    $("#kolian").hide();
                                    $("#cbman").show();
                                    $("#sjd_qty").attr("placeholder", "Koli");
                                } else if (metode == "cbm") {
                                    $("#kolian").show();
                                    $("#cbman").hide();
                                    $("#sjd_qty").attr("placeholder", "CBM/KGS");
                                } else if (metode == "kgs") {
                                    $("#kolian").show();
                                    $("#cbman").hide();
                                    $("#sjd_qty").attr("placeholder", "CBM/KGS");
                                } else {
                                    $("#kolian").hide();
                                    $("#cbman").hide();
                                    $("#sjd_qty").attr("placeholder", "QTY");
                                }
                            }
                            $(document).ready(function() {
                                $("#kolian").hide();
                                $("#cbman").hide();
                                metoden();
                            });
                        </script>
                        <div class="form-group">
                            <select class="form-control" id="sjd_satuan" name="sjd_satuan">
                                <option value="">--Satuan--</option>
                                <?php
                                $usr = $this->db
                                    ->table("satuan")
                                    ->orderBy("satuan_name", "ASC")
                                    ->get();
                                foreach ($usr->getResult() as $usr) { ?>
                                    <option value="<?= $usr->satuan_name; ?>"><?= $usr->satuan_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <script>
                            function kali() {
                                let qty = $("#sjd_qty").val();
                                let price = $("#sjd_sell").val();
                                let total = qty * price;
                                $("#sjd_total").val(total);
                            }
                        </script>
                        <input onkeyup="kali()" type="hidden" class="form-control" style="width: 120px;" id="sjd_sell" name="sjd_sell" placeholder="Price">
                        <input type="hidden" class="form-control" style="width: 120px;" id="sjd_total" name="sjd_total" placeholder="Total">
                        <input type="hidden" id="job_temp" name="job_temp" value="<?= $job_temp; ?>" />
                        <input type="hidden" id="sjd_id" name="sjd_id" value="" />

                        &nbsp;&nbsp;<button id="btnsjd" type="submit" name="create" value="OK" class="btn btn-primary">Submit</button>
                    </form>

                    <div class="table-responsive ">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <?php if (!isset($_GET["report"])) { ?>
                                        <th>Action</th>
                                    <?php } ?>
                                    <!-- <th>No.</th> -->
                                    <th>Methode</th>
                                    <th>Description</th>
                                    <th>Koli</th>
                                    <th>CBM/KGS</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("sjd");
                                $build->where("job_temp", $job_temp);
                                $usr = $build->get();

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
                                                        isset(session()->get("halaman")['102']['act_update'])
                                                        && session()->get("halaman")['102']['act_update'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['115']['act_update'])
                                                        && session()->get("halaman")['115']['act_update'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['116']['act_update'])
                                                        && session()->get("halaman")['116']['act_update'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['118']['act_update'])
                                                        && session()->get("halaman")['118']['act_update'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['119']['act_update'])
                                                        && session()->get("halaman")['119']['act_update'] == "1"
                                                    )
                                                ) { ?>
                                                    <form method="post" class="btn-action">
                                                        <button type="button" onclick="editsjd('<?= $usr->sjd_id; ?>')" class="btn btn-sm btn-warning " name="edit" value="OK">
                                                            <span class="fa fa-edit" style="color:white;"></span>
                                                        </button>
                                                        <input type="hidden" id="job_temp<?= $usr->sjd_id; ?>" name="job_temp" value="<?= $usr->job_temp; ?>" />
                                                        <input type="hidden" id="sjd_total<?= $usr->sjd_id; ?>" name="sjd_total" value="<?= $usr->sjd_total; ?>" />
                                                        <input type="hidden" id="sjd_sell<?= $usr->sjd_id; ?>" name="sjd_sell" value="<?= $usr->sjd_sell; ?>" />
                                                        <input type="hidden" id="sjd_satuan<?= $usr->sjd_id; ?>" name="sjd_satuan" value="<?= $usr->sjd_satuan; ?>" />
                                                        <input type="hidden" id="sjd_methode<?= $usr->sjd_id; ?>" name="sjd_methode" value="<?= $usr->sjd_methode; ?>" />

                                                        <input type="hidden" id="sjd_qty<?= $usr->sjd_id; ?>" name="sjd_qty" value="<?= $usr->sjd_qty; ?>" />
                                                        <input type="hidden" id="sjd_descgood<?= $usr->sjd_id; ?>" name="sjd_descgood" value="<?= $usr->sjd_descgood; ?>" />
                                                        <input type="hidden" id="sjd_id<?= $usr->sjd_id; ?>" name="sjd_id" value="<?= $usr->sjd_id; ?>" />


                                                        <input type="hidden" id="sjd_koli<?= $usr->sjd_id; ?>" name="sjd_koli" value="<?= $usr->sjd_koli; ?>" />
                                                        <input type="hidden" id="sjd_cbm<?= $usr->sjd_id; ?>" name="sjd_cbm" value="<?= $usr->sjd_cbm; ?>" />
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
                                                        isset(session()->get("halaman")['102']['act_delete'])
                                                        && session()->get("halaman")['102']['act_delete'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['115']['act_delete'])
                                                        && session()->get("halaman")['115']['act_delete'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['116']['act_delete'])
                                                        && session()->get("halaman")['116']['act_delete'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['118']['act_delete'])
                                                        && session()->get("halaman")['118']['act_delete'] == "1"
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['119']['act_delete'])
                                                        && session()->get("halaman")['119']['act_delete'] == "1"
                                                    )
                                                ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="sjd_id" value="<?= $usr->sjd_id; ?>" />
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->sjd_methode; ?></td>
                                        <td><?= $usr->sjd_descgood; ?></td>
                                        <td><?= number_format($usr->sjd_koli, 0, ",", "."); ?></td>
                                        <td><?= number_format($usr->sjd_cbm, 3, ",", "."); ?></td>
                                        <td><?= $usr->sjd_satuan; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <script>
                            function editsjd(sjd_id) {
                                let job_temp = $("#job_temp" + sjd_id).val();
                                let sjd_total = $("#sjd_total" + sjd_id).val();
                                let sjd_sell = $("#sjd_sell" + sjd_id).val();
                                let sjd_qty = $("#sjd_qty" + sjd_id).val();
                                let sjd_satuan = $("#sjd_satuan" + sjd_id).val();
                                let sjd_methode = $("#sjd_methode" + sjd_id).val();
                                let sjd_descgood = $("#sjd_descgood" + sjd_id).val();
                                let sjdid = $("#sjd_id" + sjd_id).val();
                                let sjd_koli = $("#sjd_koli" + sjd_id).val();
                                let sjd_cbm = $("#sjd_cbm" + sjd_id).val();

                                $("#job_temp").val(job_temp);
                                $("#sjd_total").val(sjd_total);
                                $("#sjd_sell").val(sjd_sell);
                                $("#sjd_satuan").val(sjd_satuan);
                                $("#sjd_methode").val(sjd_methode);

                                $("#sjd_descgood").val(sjd_descgood);
                                $("#sjd_id").val(sjdid);

                                $("#btnsjd").attr("name", "change");
                                $("#sjd_qty").val(sjd_qty);

                                metoden();

                                if (sjd_methode == "lumpsum") {
                                    sjd_koli = sjd_qty;
                                } else if (sjd_methode == "cbm" || sjd_methode == "kgs") {
                                    sjd_cbm = sjd_qty;
                                }
                                $("#sjd_koli").val(sjd_koli);
                                $("#sjd_cbm").val(sjd_cbm);





                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    <?php if (isset($_GET["t"]) && $_GET["t"] == "jc") {
        $urin = base_url($_GET["url"]);
        $enc = $this->request->getGet('enc');
        if ($enc) {
            $cipher = base64_decode(urldecode($enc));
            $enc = openssl_decrypt($cipher, $method, $key, 0, $iv);
        }
        $urin = $enc;
    } else {
        $urin = base_url($_GET["url"] . "?t=" . $_GET["t"] . "&temp=" . $job_temp . "&tbl=" . $tbl);
        $enc = $this->request->getGet('enc');
        if ($enc) {
            $enc = $this->request->getGet("enc");
        } else {
            $enc = "";
        }
        $urin .= "&enc=" . $enc;
    }
    ?>
    let pagetitle = '&nbsp;&nbsp;<a href="<?= $urin; ?>" class="btn btn-warning"><i class="fa fa-undo"></i> Back to sj</a>';
    $(document).ready(function() {
        $("#page-title").append(pagetitle);
    });

    $('.select').select2();
    var title = "<?= $title; ?>";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>