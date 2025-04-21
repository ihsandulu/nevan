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
                            <a class="  " href="<?= base_url("midentity"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Identitas</span></a>
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
                            <a class="  " href="<?= base_url("mdepartemen"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Departemen</span></a>
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
                            <a class="  " href="<?= base_url("mvendor"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Vendor</span></a>
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
                            <a class="  " href="<?= base_url("mcustomer"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Customer</span></a>
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
                            <a class="  " href="<?= base_url("morigin"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Origin</span></a>
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
                            <a class="  " href="<?= base_url("mdestination"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Destination</span></a>
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
                    
                   <!--  <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['95']['act_read'])
                            && session()->get("halaman")['95']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="  " href="<?= base_url("cutihutang"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Hutang Cuti</span></a>
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
                            isset(session()->get("halaman")['92']['act_read'])
                            && session()->get("halaman")['92']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="  " href="<?= base_url("lembur"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Lembur</span></a>
                        </li>
                    <?php } ?> -->



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
                            <a class="  " href="<?= base_url("rabsend"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Rangkuman Absensi</span></a>
                        </li>
                    <?php } ?> -->

                <?php } ?>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>