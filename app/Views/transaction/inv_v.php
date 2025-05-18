<?php echo $this->include("template/header_v");
$identity = $this->db->table("identity")->get()->getRow(); ?>
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
                                    isset(session()->get("halaman")['111']['act_create'])
                                    && session()->get("halaman")['111']['act_create'] == "1"
                                )
                            ) { ?>
                                <form method="get" class="col-md-2" action="<?= base_url("invd"); ?>">
                                    <h1 class="page-header col-md-12">
                                        <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                                        <input type="hidden" name="inv_id" />
                                        <?php
                                        $inv_no = date("dmyhis");
                                        ?>
                                        <input type="hidden" name="inv_no" value="<?= $inv_no; ?>" />
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
                            $dari = date("Y-m-d");
                            $ke = date("Y-m-d");
                            if (isset($_GET["dari"])) {
                                $dari = $_GET["dari"];
                            }
                            if (isset($_GET["ke"])) {
                                $ke = $_GET["ke"];
                            }
                            ?>
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
                                $usr = $build->orderBy("inv.inv_id", "DESC")
                                    ->get();

                                //echo $this->db->getLastquery();
                                $no = 1;
                                $debettype = array("pettycash" => "Petty Cash", "bigcash" => "Big Cash");
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
                                                        isset(session()->get("halaman")['111']['act_update'])
                                                        && session()->get("halaman")['111']['act_update'] == "1"
                                                    )
                                                ) { ?>
                                                    <form method="get" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
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
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="inv_id" value="<?= $usr->inv_id; ?>" />
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->inv_date; ?></td>
                                        <td><?= $usr->inv_no; ?></td>
                                        <td><?php $jobDano = $ainvd[$usr->inv_id]["job_dano"];
                                            $hasil = implode(", ", $jobDano);
                                            echo $hasil; ?></td>
                                        <td class="text-left"><?= $usr->customer_name; ?></td>
                                        <td><?= number_format($usr->inv_tagihan, 0, ",", "."); ?></td>
                                        <td><?= number_format($usr->inv_payment, 0, ",", "."); ?></td>
                                        <td><?= number_format($usr->inv_tagihan - $usr->inv_payment, 0, ",", "."); ?></td>
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
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>