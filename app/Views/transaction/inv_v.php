<?php echo $this->include("template/header_v");
$identity = $this->db->table("identity")->get()->getRow(); ?>
<style>
    td {
        white-space: nowrap;
    }

    .ftagihan {
        font-size: 12px;
        line-height: 15px !important;
    }

    .uang {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        text-align: left;
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
                                    isset(session()->get("halaman")['111']['act_create'])
                                    && session()->get("halaman")['111']['act_create'] == "1"
                                )
                            ) { ?>
                                <form method="get" class="col-md-2" action="<?= base_url("invd"); ?>">
                                    <h1 class="page-header col-md-12">
                                        <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                                        <input type="hidden" name="inv_id" />
                                        <?php
                                        $inv_temp = date("dmyhis");
                                        ?>
                                        <input type="hidden" name="inv_temp" value="<?= $inv_temp; ?>" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="alert alert-danger">
                        Due date in this week :
                        <?php $due = $this->db
                            ->table("job")
                            ->where("job_duedate >=", date("Y-m-d", strtotime("-3 days")))
                            ->where("job_duedate <=", date("Y-m-d", strtotime("+7 days")))
                            ->groupBy("job_duedate")
                            ->get();
                        //echo $this->db->last_query();
                        foreach ($due->getResult() as $due) { ?>
                            <strong><?= $due->job_dano; ?></strong>,
                        <?php } ?>

                    </div>
                    <?php if ($message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><?= $message; ?></strong>
                        </div>
                    <?php } ?>
                    <form method="get">
                        <div class="row alert alert-dark">
                            <?php
                            $dari = date("Y-m-d", strtotime("-1 week", strtotime(date("Y-m-d"))));
                            $ke = date("Y-m-d");
                            $lunas = "";
                            $customer_id = "";
                            if (isset($_GET["dari"])) {
                                $dari = $_GET["dari"];
                            }
                            if (isset($_GET["ke"])) {
                                $ke = $_GET["ke"];
                            }
                            if (isset($_GET["lunas"])) {
                                $lunas = $_GET["lunas"];
                            }
                            if (isset($_GET["customer_id"])) {
                                $customer_id = $_GET["customer_id"];
                            }
                            ?>
                            <div class="col-2 ">
                                <div class="row">
                                    <div class="col-12">
                                        <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="manual" title="Dari" type="date" class="form-control tooltip-statis" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 row ">
                                <div class="col-12">
                                    <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="manual" title="Ke" type="date" class="form-control tooltip-statis" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                </div>
                            </div>
                            <div class="col-3 row ">
                                <div class="col-12">
                                    <select class="form-control select" name="customer_id" value="<?= $customer_id; ?>">
                                        <option value="" <?= ($customer_id == "") ? "selected" : ""; ?>>Customer</option>
                                        <?php $customer = $this->db->table("customer")->orderBy("customer_name", "ASC")->get();
                                        foreach ($customer->getResult() as $row) { ?>
                                            <option value="<?= $row->customer_id; ?>" <?= ($customer_id == $row->customer_id) ? "selected" : ""; ?>><?= $row->customer_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2 row">
                                <div class="col-12">
                                    <select class="form-control" name="lunas" value="<?= $lunas; ?>">
                                        <option value="">Lunas/Belum</option>
                                        <option value="1" <?= ($lunas == "1") ? "selected" : ""; ?>>Lunas</option>
                                        <option value="0" <?= ($lunas == "0") ? "selected" : ""; ?>>Belum Lunas</option>
                                    </select>
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
                                    <th>INV Number</th>
                                    <th>DA Number</th>
                                    <th>Customer</th>
                                    <th>Tagihan</th>
                                    <th>Pembayaran</th>
                                    <th>Sisa Hutang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $invd = $this->db->table("invd")
                                    ->where("invd_date BETWEEN '" . $dari . "' AND '" . $ke . "'")
                                    ->get();
                                $ainvd = array();
                                foreach ($invd->getResult() as $invd) {
                                    $ainvd[$invd->inv_id]["job_dano"][] = $invd->job_dano;
                                }
                                // dd($ainvd);
                                $build = $this->db
                                    ->table("inv")
                                    ->join("customer", "customer.customer_id=inv.customer_id", "left");
                                $build->where("inv_date BETWEEN '" . $dari . "' AND '" . $ke . "'");
                                if (isset($_GET["lunas"]) && $_GET["lunas"] != "") {
                                    if ($lunas == "1") {
                                        $build->where("inv_payment >= inv_grand");
                                    } else if ($lunas == "0") {
                                        $build->where("inv_payment < inv_grand");
                                    }
                                }
                                if (isset($_GET["customer_id"]) && $_GET["customer_id"] != "") {
                                    $build->where("inv.customer_id", $customer_id);
                                }
                                $usr = $build->orderBy("inv.inv_id", "DESC")
                                    ->get();

                                // echo $this->db->getLastquery();
                                $no = 1;
                                $debettype = array("pettycash" => "Petty Cash", "bigcash" => "Big Cash");
                                $pembayaran = 0;
                                $sisahutangnya = 0;
                                foreach ($usr->getResult() as $usr) {
                                    $pembayaran += $usr->inv_payment;
                                    $sisahutangnya += $usr->inv_grand;
                                ?>
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
                                                        isset(session()->get("halaman")['111']['act_update'])
                                                        && session()->get("halaman")['111']['act_update'] == "1"
                                                    )
                                                ) { ?>
                                                    <form target="_self" method="get" class="btn-action" style="" action="<?= base_url("invd"); ?>">
                                                        <button title="Edit" data-bs-toggle="tooltip" class="btn btn-sm btn-warning " name="editinv" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="inv_id" value="<?= $usr->inv_id; ?>" />
                                                        <input type="hidden" name="inv_temp" value="<?= $usr->inv_temp; ?>" />
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
                                                        isset(session()->get("halaman")['111']['act_delete'])
                                                        && session()->get("halaman")['111']['act_delete'] == "1"
                                                    )
                                                ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button title="Delete" data-bs-toggle="tooltip" class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="inv_id" value="<?= $usr->inv_id; ?>" />
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
                                                        isset(session()->get("halaman")['111']['act_delete'])
                                                        && session()->get("halaman")['111']['act_delete'] == "1"
                                                    )
                                                ) { ?>
                                                    <form method="get" class="btn-action" style="" action="<?= base_url("invpayment"); ?>">
                                                        <button title="Pembayaran" data-bs-toggle="tooltip" class="btn btn-sm btn-success" name="payment" value="OK"><span class="fa fa-money" style="color:white;"></span> </button>
                                                        <input type="hidden" name="inv_id" value="<?= $usr->inv_id; ?>" />
                                                        <input type="hidden" name="inv_no" value="<?= $usr->inv_no; ?>" />
                                                        <input type="hidden" name="customer_id" value="<?= $usr->customer_id; ?>" />
                                                        <input type="hidden" name="customer_name" value="<?= $usr->customer_name; ?>" />
                                                    </form>
                                                <?php } ?>
                                                <form method="get" target="_blank" class="btn-action" style="" action="<?= base_url("invprint"); ?>">
                                                    <button title="Print Invoice" data-bs-toggle="tooltip" class="btn btn-sm btn-warning" name="print" value="OK"><span class="fa fa-print" style="color:white;"></span> </button>
                                                    <input type="hidden" name="inv_id" value="<?= $usr->inv_id; ?>" />
                                                    <input type="hidden" name="inv_no" value="<?= $usr->inv_no; ?>" />
                                                    <input type="hidden" name="customer_id" value="<?= $usr->customer_id; ?>" />
                                                    <input type="hidden" name="customer_name" value="<?= $usr->customer_name; ?>" />
                                                </form>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->inv_date; ?></td>
                                        <td>
                                            <input type="text" class="form-control" id="inv_no<?= $usr->inv_id; ?>" value="<?= $usr->inv_no; ?>" />
                                            <button class="btn btn-sm btn-info" onclick="saveinvno('<?= $usr->inv_id; ?>')">Save</button>
                                        </td>
                                        <td><?= $usr->job_dano; ?></td>
                                        <td class="text-left"><?= $usr->customer_name; ?></td>
                                        <td class="ftagihan">
                                            <?php
                                            $dtagihan = $usr->inv_dtagihan;
                                            $ppn1k1 = 0;
                                            $ppn11 = 0;
                                            $ppn12 = 0;
                                            $pph = 0;
                                            ?>
                                            <span class="uang">
                                                <span>Tagihan:</span>
                                                <span><?= number_format($usr->inv_tagihan, 2, ",", "."); ?></span>
                                            </span>
                                            <span class="uang">
                                                <span>Diskon:</span>
                                                <span><?= number_format($usr->inv_discount, 2, ",", "."); ?></span>
                                            </span>
                                            <span class="uang">
                                                <span>Stlh Diskon:</span>
                                                <span><?= number_format($usr->inv_dtagihan, 2, ",", "."); ?></span>
                                            </span>
                                            <?php if ($usr->inv_ppn1k1 > 0) {
                                                $ppn1k1 = $dtagihan * 1.1 / 100; ?>
                                                <span class="uang">
                                                    <span>PPN1,1:</span>
                                                    <span><?= number_format($ppn1k1, 2, ",", "."); ?></span>
                                                </span>
                                            <?php } ?>
                                            <?php if ($usr->inv_ppn11 > 0) {
                                                $ppn11 = $dtagihan * 11 / 100; ?>
                                                <span class="uang">
                                                    <span>PPN11:</span>
                                                    <span><?= number_format($ppn11, 2, ",", "."); ?></span>
                                                </span>
                                            <?php } ?>
                                            <?php if ($usr->inv_ppn12 > 0) {
                                                $ppn12 = $dtagihan * 12 / 100; ?>
                                                <span class="uang">
                                                    <span>PPN12:</span>
                                                    <span><?= number_format($ppn12, 2, ",", "."); ?></span>
                                                </span>
                                            <?php } ?>
                                            <?php if ($usr->inv_pph > 0) {
                                                $pph = $dtagihan * 2 / 100; ?>
                                                <span class="uang">
                                                    <span>PPH:</span>
                                                    <span><?= number_format($pph, 2, ",", "."); ?></span>
                                                </span>
                                            <?php } ?>
                                            <?php
                                            $tharga = $dtagihan + $ppn1k1 + $ppn11 + $ppn12;
                                            $grand = $tharga - $pph;
                                            ?>
                                            <span class="uang">
                                                <span>Grand Total</span>
                                                <span><?= number_format($grand, 2, ",", "."); ?></span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="uang">
                                                <span>IDR</span>
                                                <span><?= number_format($usr->inv_payment, 2, ",", "."); ?></span>
                                            </span>
                                        </td>
                                        <td><span class="uang">
                                                <span>IDR</span>
                                                <span><?php
                                                        $sisahutang = $grand - $usr->inv_payment;
                                                        echo number_format($sisahutang, 2, ",", "."); ?></span>
                                            </span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "<?= $title; ?>";
    let pembayaran = ". Pembayaran : <?= number_format($pembayaran, 0, ",", "."); ?> , Sisa Hutang : <?= number_format($sisahutangnya, 0, ",", "."); ?>";
    $("title").text(title);
    $(".card-title").text(title + pembayaran);
    $("#page-title").text(title);
    $("#page-title-link").text(title);

    function saveinvno(inv_id) {
        $.get("<?= base_url("api/saveinvno"); ?>", {
                inv_id: inv_id,
                inv_no: $("#inv_no" + inv_id).val()
            })
            .done(function(data) {
                alert("Invoice number saved successfully.");
            });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tooltipTriggerList = document.querySelectorAll('.tooltip-statis');

        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            const tooltip = new bootstrap.Tooltip(tooltipTriggerEl);

            // Menampilkan tooltip secara manual
            tooltip.show();
        });
    });
</script>


<?php echo  $this->include("template/footer_v"); ?>