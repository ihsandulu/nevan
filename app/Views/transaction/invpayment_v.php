<?php echo $this->include("template/header_v");
$identity = $this->db->table("identity")->get()->getRow(); ?>
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
                            <input type="date"
                                class="form-control"
                                style="width:100px;"
                                id="invpayment_date"
                                name="invpayment_date"
                                placeholder="Tanggal Invoice"
                                data-bs-toggle="popover"
                                data-bs-content="Pilih tanggal invoice"
                                data-bs-trigger="manual"
                                data-bs-placement="top"
                                value="">
                        </div>
                        <script>
                            $(function() {
                                $('#invpayment_date')
                                    .popover({
                                        content: 'Pilih Tanggal Pembayaran',
                                        trigger: 'manual',
                                        placement: 'top',
                                        template: '<div class="popover bs-popover-top" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>'
                                    })
                                    .popover('show');
                            });
                        </script>
                        <div class="form-group">
                            <input onkeyup="kali()" type="text" class="form-control" style="width: 80px;" id="invpayment_qty" name="invpayment_qty" placeholder="QTY">
                        </div>
                        <div class="form-group">
                            <input onkeyup="kali()" type="text" class="form-control" style="width: 120px;" id="invpayment_price" name="invpayment_price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" style="width: 120px;" id="invpayment_total" name="invpayment_total" placeholder="Total">
                        </div>
                        <div class="form-group">
                            <select required class="form-control" id="methodpayment_id" name="methodpayment_id">
                                <option value="">Payment Methode</option>
                                <?php $methodpayment = $this->db->table("methodpayment")
                                    ->orderBy("methodpayment_name", "ASC")
                                    ->get();
                                foreach ($methodpayment->getResult() as $methodpayment) {
                                ?>
                                    <option value="<?= $methodpayment->methodpayment_id; ?>"><?= $methodpayment->methodpayment_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select style="width: 100px;" class="form-control" id="invpayment_from" name="invpayment_from" placeholder="From"
                                data-bs-toggle="popover"
                                data-bs-content="Asal"
                                data-bs-trigger="manual"
                                data-bs-placement="top">
                                <option value="">From</option>
                                <option value="-1">Pettycash</option>
                                <?php $rekening = $this->db->table("rekening")
                                    ->orderBy("rekening_no", "ASC")
                                    ->get();
                                foreach ($rekening->getResult() as $rekening) {
                                ?>
                                    <option value="<?= $rekening->rekening_id; ?>"><?= $rekening->rekening_no; ?> <?= $rekening->rekening_an; ?></option>
                                <?php } ?>
                            </select>
                            <script>
                                $(function() {
                                    $('#invpayment_from')
                                        .popover({
                                            content: 'Asal',
                                            trigger: 'manual',
                                            placement: 'top',
                                            template: '<div class="popover bs-popover-top" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>'
                                        })
                                        .popover('show');
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <select style="width: 100px;" class="form-control" id="invpayment_to" name="invpayment_to" placeholder="To"
                                data-bs-toggle="popover"
                                data-bs-content="Tujuan"
                                data-bs-trigger="manual"
                                data-bs-placement="top">
                                <option value="">To</option>
                                <option value="-1">Pettycash</option>
                                <?php $rekening = $this->db->table("rekening")
                                    ->orderBy("rekening_no", "ASC")
                                    ->get();
                                foreach ($rekening->getResult() as $rekening) {
                                ?>
                                    <option value="<?= $rekening->rekening_id; ?>"><?= $rekening->rekening_no; ?> <?= $rekening->rekening_an; ?></option>
                                <?php } ?>
                            </select>
                            <script>
                                $(function() {
                                    $('#invpayment_to')
                                        .popover({
                                            content: 'Tujuan',
                                            trigger: 'manual',
                                            placement: 'top',
                                            template: '<div class="popover bs-popover-top" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>'
                                        })
                                        .popover('show');
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" style="width: 200px;" id="invpayment_keterangan" name="invpayment_keterangan" placeholder="Keterangan">
                        </div>
                        <script>
                            function kali() {
                                let qty = $("#invpayment_qty").val();
                                let price = $("#invpayment_price").val();
                                let total = qty * price;
                                $("#invpayment_total").val(total);
                            }
                        </script>
                        <input type="hidden" id="inv_no" name="inv_no" value="<?= $inv_no; ?>" />
                        <input type="hidden" id="customer_id" name="customer_id" value="<?= $customer_id; ?>" />
                        <input type="hidden" id="customer_name" name="customer_name" value="<?= $customer_name; ?>" />
                        <input type="hidden" id="invpayment_id" name="invpayment_id" value="" />

                        &nbsp;&nbsp;<button id="btninvpayment" type="submit" name="create" value="OK" class="btn btn-primary">Submit</button>
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
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Methode</th>
                                    <th>Rek.Asal</th>
                                    <th>Rek.Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("invpayment")
                                    ->join("methodpayment","methodpayment.methodpayment_id=invpayment.methodpayment_id","left")
                                    ->join("(SELECT rekening_id as asalid, rekening_no as asalno from rekening) As asal","asal.asalid=invpayment.invpayment_from","left")
                                    ->join("(SELECT rekening_id as tujuanid, rekening_no as tujuanno from rekening) As tujuan","tujuan.tujuanid=invpayment.invpayment_to","left");
                                if (isset($_GET["inv_no"])) {
                                    $build->where("inv_no", $inv_no);
                                }
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
                                                        isset(session()->get("halaman")['111']['act_update'])
                                                        && session()->get("halaman")['111']['act_update'] == "1"
                                                    )
                                                ) { ?>
                                                    <form method="post" class="btn-action">
                                                        <button type="button" onclick="editinvpayment('<?= $usr->invpayment_id; ?>')" class="btn btn-sm btn-warning " name="edit" value="OK">
                                                            <span class="fa fa-edit" style="color:white;"></span>
                                                        </button>
                                                        
                                                        <input type="hidden" id="inv_no<?= $usr->invpayment_id; ?>" name="inv_no" value="<?= $usr->inv_no; ?>" />
                                                        <input type="hidden" id="invpayment_total<?= $usr->invpayment_id; ?>" name="invpayment_total" value="<?= $usr->invpayment_total; ?>" />
                                                        <input type="hidden" id="invpayment_price<?= $usr->invpayment_id; ?>" name="invpayment_price" value="<?= $usr->invpayment_price; ?>" />
                                                        <input type="hidden" id="invpayment_qty<?= $usr->invpayment_id; ?>" name="invpayment_qty" value="<?= $usr->invpayment_qty; ?>" />
                                                        <input type="hidden" id="invpayment_keterangan<?= $usr->invpayment_id; ?>" name="invpayment_keterangan" value="<?= $usr->invpayment_keterangan; ?>" />
                                                        <input type="hidden" id="invpayment_id<?= $usr->invpayment_id; ?>" name="invpayment_id" value="<?= $usr->invpayment_id; ?>" />
                                                        <input type="hidden" id="invpayment_date<?= $usr->invpayment_id; ?>" name="invpayment_date" value="<?= $usr->invpayment_date; ?>" />
                                                        <input type="hidden" id="invpayment_from<?= $usr->invpayment_id; ?>" name="invpayment_from" value="<?= $usr->invpayment_from; ?>" />
                                                        <input type="hidden" id="invpayment_to<?= $usr->invpayment_id; ?>" name="invpayment_to" value="<?= $usr->invpayment_to; ?>" />
                                                        <input type="hidden" id="methodpayment_id<?= $usr->invpayment_id; ?>" name="methodpayment_id" value="<?= $usr->methodpayment_id; ?>" />
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
                                                        <input type="hidden" name="invpayment_id" value="<?= $usr->invpayment_id; ?>" />
                                                        <input type="hidden" name="inv_no" value="<?= $inv_no; ?>" />
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                        <!-- <td><?= $no++; ?></td> -->
                                        <td><?= $usr->invpayment_date; ?></td>
                                        <td><?= $usr->invpayment_keterangan; ?></td>
                                        <td><?= number_format($usr->invpayment_qty, 0, ",", "."); ?></td>
                                        <td><?= number_format($usr->invpayment_price, 0, ",", "."); ?></td>
                                        <td><?= number_format($usr->invpayment_total, 0, ",", "."); ?></td>
                                        <td><?= $usr->methodpayment_name; ?></td>
                                        <td><?= $usr->asalno; ?></td>
                                        <td><?= $usr->tujuanno; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <script>
                            function editinvpayment(invpayment_id) {
                                let job_dano = $("#job_dano" + invpayment_id).val();
                                let inv_no = $("#inv_no" + invpayment_id).val();
                                let inv_id = $("#inv_id" + invpayment_id).val();
                                let invpayment_total = $("#invpayment_total" + invpayment_id).val();
                                let invpayment_price = $("#invpayment_price" + invpayment_id).val();
                                let invpayment_satuan = $("#invpayment_satuan" + invpayment_id).val();
                                let invpayment_qty = $("#invpayment_qty" + invpayment_id).val();
                                let invpayment_keterangan = $("#invpayment_keterangan" + invpayment_id).val();
                                let job_id = $("#job_id" + invpayment_id).val();
                                let invpaymentid = $("#invpayment_id" + invpayment_id).val();
                                let invpayment_date = $("#invpayment_date" + invpayment_id).val();
                                let invpayment_from = $("#invpayment_from" + invpayment_id).val();
                                let invpayment_to = $("#invpayment_to" + invpayment_id).val();
                                let methodpayment_id = $("#methodpayment_id" + invpayment_id).val();

                                $("#job_dano").val(job_dano);
                                $("#inv_no").val(inv_no);
                                $("#inv_id").val(inv_id);
                                $("#invpayment_total").val(invpayment_total);
                                $("#invpayment_price").val(invpayment_price);
                                $("#invpayment_satuan").val(invpayment_satuan);
                                $("#invpayment_qty").val(invpayment_qty);
                                $("#invpayment_keterangan").val(invpayment_keterangan);
                                $("#job_id").val(job_id);
                                $("#invpayment_id").val(invpaymentid);
                                $("#invpayment_date").val(invpayment_date);
                                $("#invpayment_from").val(invpayment_from);
                                $("#invpayment_to").val(invpayment_to);
                                $("#methodpayment_id").val(methodpayment_id);

                                $("#btninvpayment").attr("name", "change");
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let pagetitle = '&nbsp;&nbsp;<a href="<?= base_url("inv"); ?>" class="btn btn-warning"><i class="fa fa-undo"></i> Back to Invoice</a>';
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