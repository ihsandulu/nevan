<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar hidebar" style="overflow:auto;">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li>
                    <a class="" href="<?= base_url("utama"); ?>" aria-expanded="false">
                        <i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span>
                    </a>

                </li>
                <?php
                // dd(session()->get("position_id")[0][0]);
                if (
                    (
                        isset(session()->get("position_id")[0][0])
                        && (
                            session()->get("position_id") == "1"
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['1']['act_read'])
                        && session()->get("halaman")['1']['act_read'] == "1"
                    )
                ) { ?>
                    <li class="nav-label">Master</li>
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['28']['act_read'])
                            && session()->get("halaman")['28']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'midentity' ? 'active' : ''; ?>" href="<?= base_url("midentity"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Identitas</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['2']['act_read'])
                            && session()->get("halaman")['2']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="has-arrow  " href="#" aria-expanded="false" data-toggle="collapse" data-target="#demo"><i class="fa fa-user"></i><span class="hide-menu">Manajemen Karyawan <span class="label label-rouded label-warning pull-right">2</span></span></a>
                            <ul aria-expanded="false" id="demo" class="collapse">
                                <?php
                                if (
                                    (
                                        isset(session()->get("position_id")[0][0])
                                        && (
                                            session()->get("position_id") == "1"
                                            || session()->get("position_id") == "2"
                                        )
                                    ) ||
                                    (
                                        isset(session()->get("halaman")['3']['act_read'])
                                        && session()->get("halaman")['3']['act_read'] == "1"
                                    )
                                ) { ?>
                                    <li><a href="<?= base_url("mposition"); ?>"><i class="fa fa-caret-right"></i> &nbsp;Posisi</a></li>
                                <?php } ?>
                                <?php
                                if (
                                    (
                                        isset(session()->get("position_id")[0][0])
                                        && (
                                            session()->get("position_id") == "1"
                                            || session()->get("position_id") == "2"
                                        )
                                    ) ||
                                    (
                                        isset(session()->get("halaman")['5']['act_read'])
                                        && session()->get("halaman")['5']['act_read'] == "1"
                                    )
                                ) { ?>
                                    <li><a href="<?= base_url("muser"); ?>"><i class="fa fa-caret-right"></i> &nbsp;Karyawan</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['50']['act_read'])
                            && session()->get("halaman")['50']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mdepartemen' ? 'active' : ''; ?>" href="<?= base_url("mdepartemen"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Departemen</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['96']['act_read'])
                            && session()->get("halaman")['96']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mvendor' ? 'active' : ''; ?>" href="<?= base_url("mvendor"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Vendor</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['97']['act_read'])
                            && session()->get("halaman")['97']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mcustomer' ? 'active' : ''; ?>" href="<?= base_url("mcustomer"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Customer</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['98']['act_read'])
                            && session()->get("halaman")['98']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'morigin' ? 'active' : ''; ?>" href="<?= base_url("morigin"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Origin</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['99']['act_read'])
                            && session()->get("halaman")['99']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mdestination' ? 'active' : ''; ?>" href="<?= base_url("mdestination"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Destination</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['100']['act_read'])
                            && session()->get("halaman")['100']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'msatuan' ? 'active' : ''; ?>" href="<?= base_url("msatuan"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Satuan</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['100']['act_read'])
                            && session()->get("halaman")['100']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mvessel' ? 'active' : ''; ?>" href="<?= base_url("mvessel"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Vessel</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['103']['act_read'])
                            && session()->get("halaman")['103']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mservice' ? 'active' : ''; ?>" href="<?= base_url("mservice"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Service</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['106']['act_read'])
                            && session()->get("halaman")['106']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'msatuantarif' ? 'active' : ''; ?>" href="<?= base_url("msatuantarif"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Satuan Tarif</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['110']['act_read'])
                            && session()->get("halaman")['110']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mbank' ? 'active' : ''; ?>" href="<?= base_url("mbank"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Bank</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['109']['act_read'])
                            && session()->get("halaman")['109']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mrekening' ? 'active' : ''; ?>" href="<?= base_url("mrekening"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Rekening</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['112']['act_read'])
                            && session()->get("halaman")['112']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mmethodpayment' ? 'active' : ''; ?>" href="<?= base_url("mmethodpayment"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Payment Methode</span></a>
                        </li>
                    <?php } ?>

                <?php } ?>




                <!-- //Transaction// -->
                <?php
                if (
                    (
                        isset(session()->get("position_id")[0][0])
                        && (
                            session()->get("position_id") == "1"
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['9']['act_read'])
                        && session()->get("halaman")['9']['act_read'] == "1"
                    )
                ) { ?>
                    <li class="nav-label">Transaksi</li>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['105']['act_read'])
                            && session()->get("halaman")['105']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mtarif' ? 'active' : ''; ?>" href="<?= base_url("mtarif"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Price List</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['113']['act_read'])
                            && session()->get("halaman")['113']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'quotation' ? 'active' : ''; ?>" href="<?= base_url("quotation"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Quotation</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['102']['act_read'])
                            && session()->get("halaman")['102']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'job' ? 'active' : ''; ?>" href="<?= base_url("job"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Job</span></a>
                        </li>
                    <?php } ?>

                    <!-- <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['104']['act_read'])
                            && session()->get("halaman")['104']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'cppn' ? 'active' : ''; ?>" href="<?= base_url("cppn"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Customer PPN</span></a>
                        </li>
                    <?php } ?> -->

                    <!-- <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['107']['act_read'])
                            && session()->get("halaman")['107']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'nppn' ? 'active' : ''; ?>" href="<?= base_url("nppn"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Customer Non PPN</span></a>
                        </li>
                    <?php } ?> -->

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['108']['act_read'])
                            && session()->get("halaman")['108']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'kas' ? 'active' : ''; ?>" href="<?= base_url("kas"); ?>" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Kas</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['111']['act_read'])
                            && session()->get("halaman")['111']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == ('inv'||'invd') ? 'active' : ''; ?>" href="<?= base_url("inv"); ?>" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Invoice</span></a>
                        </li>
                    <?php } ?>



                <?php } ?>











                <!-- //Report// -->
                <?php

                // dd(session()->get("halaman")) ;
                if (
                    (
                        isset(session()->get("position_id")[0][0])
                        && (
                            session()->get("position_id") == "1"
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['14']['act_read'])
                        && session()->get("halaman")['14']['act_read'] == "1"
                    )
                ) { ?>
                    <li class="nav-label">Laporan</li>


                    <!-- <?php
                            if (
                                (
                                    isset(session()->get("position_id")[0][0])
                                    && (
                                        session()->get("position_id") == "1"
                                        || session()->get("position_id") == "2"
                                    )
                                ) ||
                                (
                                    isset(session()->get("halaman")['74']['act_read'])
                                    && session()->get("halaman")['74']['act_read'] == "1"
                                )
                            ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'rabsend' ? 'active' : ''; ?>" href="<?= base_url("rabsend"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Rangkuman Absensi</span></a>
                        </li>
                    <?php } ?> -->

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['114']['act_read'])
                            && session()->get("halaman")['114']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'job' ? 'active' : ''; ?>" href="<?= base_url("job?report=OK"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Sales Report</span></a>
                        </li>
                    <?php } ?>

                <?php } ?>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>