<?php
echo $this->include("template/headersaja_v");
function terbilang($angka)
{
    $angka = abs($angka);
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

    if ($angka < 12) {
        return $huruf[$angka];
    } elseif ($angka < 20) {
        return $huruf[$angka - 10] . " Belas";
    } elseif ($angka < 100) {
        return $huruf[floor($angka / 10)] . " Puluh " . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return "Seratus " . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return $huruf[floor($angka / 100)] . " Ratus " . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return "Seribu " . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang(floor($angka / 1000)) . " Ribu " . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang(floor($angka / 1000000)) . " Juta " . terbilang($angka % 1000000);
    } else {
        return "Angka Terlalu Besar";
    }
}


?>
<style>
    .resumeg {
        background-color: aqua !important;
        color: white !important;
    }

    .resumer {
        background-color: indianred !important;
        color: white !important;
    }

    .resumey {
        background-color: beige !important;
        color: white !important;
    }

    .resumebl {
        background-color: aquamarine !important;
        color: white !important;
    }

    .resumeb {
        background-color: darkgrey !important;
        color: white !important;
    }

    td {
        line-height: 20px !important;
        padding: 10px !important;
    }

    .garis {
        height: 0px;
        border-bottom: rgba(57, 56, 56, 0.16) solid 1px;
        margin: 0px 20px 0px -10px !important;
    }


    .scroll-table {
        overflow: hidden;
        cursor: grab;
    }

    .scroll-table:active {
        cursor: grabbing;
    }

    .table-wrapper {
        overflow: auto;
        white-space: nowrap;
    }

    table {
        min-width: 500px;
    }

    .row1 {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: 0px;
        margin-left: 0px;
    }

    @media (min-width: 768px) {
        .col10 {
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col2 {
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
    }

    @media (max-width: 767px) {
        .header {
            position: relative;
            width: 100%;
        }
    }

    @media print {
        .col10 {
            display: inline-block;
            width: 83.333333%;
        }

        .col2 {
            display: inline-block;
            width: 16.666667%;
        }

        .row1 {
            display: flex;
            flex-wrap: wrap;
        }

        body,
        td,
        span,
        div {
            font-size: 16px !important;
        }
    }

    #logotop {
        width: auto;
        height: 100px;
    }

    #perusahaan {
        font-size: 28px;
        font-weight: bold;
    }

    #tagline {
        font-size: 20px;
        font-weight: bold;
        color: grey;
    }

    .uang {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        text-align: left;
    }

    .border-bottom {
        border-bottom: black solid 1px;
        padding-bottom: 30px;
    }

    .judul {
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .atas {
        height: 3.5cm;
    }

    .tengah {
        padding: 10px 50px 20px 50px;
    }

    table,
    thead,
    tbody,
    tr {
        border-color: black !important;
    }

    .table td,
    .table th {
        border-top: 1px solid rgb(0, 0, 0);
    }

    .kotak {
        width: 100px;
        height: 100px;
        background-color: lightblue;
        border: 1px solid #000;
    }
</style>

<div class='container-fluid'>
    <div class='row'>
        <!-- <div class='col-12 border-bottom atas'>
            <div class="row">
                <div class='col-4 text-right'>
                    <?php
                    // $identitypicture=session()->get("identity_logo");
                    $identity_name = session()->get("identity_name");
                    $identity = $this->db->table("identity")->get()->getRow();
                    $identitypicture = $identity->identity_logo;
                    $identity_company = $identity->identity_company;
                    if ($identitypicture != "") {
                        $user_image = "images/identity_logo/" . $identitypicture . "?" . time();
                    } else {
                        $user_image = "images/identity_logo/no_image.png";
                    } ?>
                    <img id="logotop" src="<?= base_url($user_image); ?>" alt="homepage" class="dark-logo" />
                </div>
                <div class='col-8 text-left'>
                    <div id="perusahaan"><?= ($identity_company != "") ? $identity_company : "PT. Nevan Kirana Logistik"; ?></div>
                    <div id="tagline">PROJECT CARGO - INLAND TRUCK - CARGO MOOVING - CONTAINERIZED</div>
                </div>
            </div>
        </div> -->
        <div class='col-12 border-bottom atas' style="height:3.5cm;"></div>

        <?php
        $inv = $this->db->table("inv")
            ->join("customer", "customer.customer_id=inv.customer_id", "left")
            ->where("inv_id", $_GET["inv_id"])->get()->getRow();
        ?>
        <div class='col-12 tengah'>
            <div class="row">
                <div class="col-12 judul text-center">INVOICE</div>
                <div class="col-7">
                    <div class="row">
                        <div class="col-3">
                            Customer
                        </div>
                        <div class="col-9">
                            : <?= $inv->customer_name; ?>
                        </div>
                        <div class="col-3">
                            Address
                        </div>
                        <div class="col-9">
                            : <?= $inv->customer_address; ?>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-3">
                            INV No.
                        </div>
                        <div class="col-9">
                            : <?= $inv->inv_no; ?>
                        </div>
                        <div class="col-3">
                            Date
                        </div>
                        <div class="col-9">
                            : <?= $inv->inv_date; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <div class="scroll-table">
                        <div class="table-wrapper" id="drag-scroll">
                            <div id="areaCetak">
                                <table id="" class="display nowrap table table-hover table-striped " cellspacing="0" width="100%">
                                    <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                    <thead class="">
                                        <tr>
                                            <th>Da No.</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $invd = $this->db->table("invd")
                                            ->join("job", "job.job_id=invd.job_id", "left")
                                            ->where("inv_id", $_GET["inv_id"])->get();
                                        foreach ($invd->getResult() as $invd) { ?>
                                            <tr>
                                                <td class="text-center"><?= strtoupper($invd->job_dano); ?></td>
                                                <td class="text-left"><?= $invd->invd_description; ?></td>
                                                <td class="text-center"><?= number_format($invd->invd_qty, 3, ",", "."); ?> <?= $invd->invd_satuan; ?></td>
                                                <td>
                                                    <span class="uang"><span>IDR</span><span><?= number_format($invd->invd_price, 2, ",", "."); ?></span></span>
                                                </td>
                                                <td>
                                                    <span class="uang"><span>IDR</span><span><?= number_format($invd->invd_total, 2, ",", "."); ?></span></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="text-left" rowspan="8" colspan="3">
                                                <i>Terbilang :</i><br />
                                                <i id="terbilang" style="margin-top:30px;"></i><br /><br />
                                                <div id="norek" style="border-top:black solid 1px; border-bottom:black solid 1px; padding:10px; ">
                                                    <span style="font-weight: bold;"> Tujuan Pembayaran :</span><br />
                                                    <ul>
                                                        <?php
                                                        $build = $this->db->table("rekening")
                                                            ->join("bank", "bank.bank_id=rekening.bank_id", "left");
                                                        if ($inv->customer_type == "PPN") {
                                                            $build->where("rekening_ppn", "PPN");
                                                        }
                                                        if ($inv->customer_type == "NON") {
                                                            $build->where("rekening_ppn", "NON");
                                                        }
                                                        $rekening = $build->where("rekening_type", "NKL")->get();
                                                        foreach ($rekening->getResult() as $row) { ?>
                                                            <li>
                                                                * (<?= $row->bank_name; ?>) <span><?= $row->rekening_no; ?> - <?= $row->rekening_an; ?></span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <i>Note : Harap mencantumkan nomor invoice di setiap pembayaran</i>
                                                <div class="text-center" style="position:relative; left:30px; width:200px; margin-top:25px;">
                                                    <div style="font-weight: bold; font-size:15px; ">AUTHORIZED SIGNATURE</div>
                                                    <div style="height:3.5cm;">
                                                        <img src="<?= base_url("images/identity_financettd/" . $identity->identity_financettd); ?>" style="height:2.5cm; width:auto;" />
                                                    </div>

                                                    <div style="font-weight: bold; font-size:20px; margin-top:0px; border-bottom:1px solid black;">
                                                        <?= $identity->identity_financename; ?>
                                                    </div>
                                                    <div style="font-weight: bold; font-size:20px; margin-top:0px;">
                                                        Finance Advisor
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                Total
                                            </td>
                                            <td>
                                                <span class="uang"><span>IDR</span><span><?= number_format($inv->inv_tagihan, 2, ",", "."); ?></span></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                Discount
                                            </td>
                                            <td>
                                                <span class="uang"><span>IDR</span><span><?= number_format($inv->inv_discount, 2, ",", "."); ?></span></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                Setelah Discount
                                            </td>
                                            <td>
                                                <span class="uang"><span>IDR</span><span><?= number_format($inv->inv_dtagihan, 2, ",", "."); ?></span></span>
                                            </td>
                                        </tr>
                                        <?php
                                        $dtagihan = $inv->inv_dtagihan;
                                        $ppn1k1 = 0;
                                        $ppn11 = 0;
                                        $ppn12 = 0;
                                        $pph = 0;
                                        ?>
                                        <?php if ($inv->inv_ppn1k1 > 0) {
                                            $ppn1k1 = $dtagihan * 1.1 / 100;
                                        ?>
                                            <tr>
                                                <td class="text-left">
                                                    PPN 1,1%
                                                </td>
                                                <td>
                                                    <span class="uang"><span>IDR</span><span><?= number_format($ppn1k1, 2, ",", "."); ?></span></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($inv->inv_ppn11 > 0) {
                                            $ppn11 = $dtagihan * 11 / 100;
                                        ?>
                                            <tr>
                                                <td class="text-left">
                                                    PPN 11%
                                                </td>
                                                <td>
                                                    <span class="uang"><span>IDR</span><span><?= number_format($ppn11, 2, ",", "."); ?></span></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($inv->inv_ppn12 > 0) {
                                            $ppn12 = $dtagihan * 12 / 100;
                                        ?>
                                            <tr>
                                                <td class="text-left">
                                                    PPN 12%
                                                </td>
                                                <td>
                                                    <span class="uang"><span>IDR</span><span><?= number_format($ppn12, 2, ",", "."); ?></span></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($inv->inv_pph > 0) {
                                            $pph = $dtagihan * 2 / 100;
                                        ?>
                                            <tr>
                                                <td class="text-left">
                                                    PPH
                                                </td>
                                                <td>
                                                    <span class="uang"><span>IDR</span><span><?= number_format($pph, 2, ",", "."); ?></span></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="text-left">
                                                Grand Total
                                            </td>
                                            <td>
                                                <?php
                                                $tharga = $dtagihan + $ppn1k1 + $ppn11 + $ppn12;
                                                $grand = $tharga - $pph;
                                                ?>
                                                <span class="uang"><span>IDR</span><span><?= number_format($grand, 2, ",", "."); ?></span></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                Payment
                                            </td>
                                            <td>
                                                <?php
                                                $payment = $inv->inv_payment;
                                                ?>
                                                <span class="uang"><span>IDR</span><span><?= number_format($payment, 2, ",", "."); ?></span></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                Sisa Hutang
                                            </td>
                                            <td>
                                                <?php
                                                $sisa = $grand - $payment;
                                                ?>
                                                <span class="uang"><span>IDR</span><span><?= number_format($sisa, 2, ",", "."); ?></span></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class=" col-12 bg-primary p-3 text-center" style="border-radius:5px; border-top:grey solid 1px;"><div style="font-size:25px; font-weight:bold;"><?= $identity->identity_company; ?></div><?= $identity->identity_address; ?></div> -->
<script>
    $("#terbilang").html('<?= terbilang($sisa); ?> Rupiah');
    $('.select').select2();
    var title = "Tarif <?= $this->session->get("identity_name"); ?>";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo $this->include("template/footersaja_v"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script type="text/javascript">
    function cetakPDF() {
        $('#titlepdf').show();
        $('#btncetakpdf').hide();
        $('.dataTables_filter').hide();
        const element = document.getElementById('areaCetak');
        html2pdf()
            .set({
                margin: 0.5,
                filename: 'export.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            })
            .from(element)
            .save()
            .then(() => {
                // Tampilkan kembali search
                $('#titlepdf').hide();
                $('.dataTables_filter').show();
                $('#btncetakpdf').show();
            });
    }

    $(document).ready(function() {
        $('#titlepdf').hide();
        $('#example2310').DataTable({
            paging: false, // tidak ada pagination
            info: false, // tidak ada info "Showing 1 to 10 of ..."
            lengthChange: false, // tidak ada dropdown jumlah baris
            searching: true
        });
    });
    print();
</script>