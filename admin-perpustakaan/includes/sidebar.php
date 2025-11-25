<?php
$bookPages = ['daftar-buku', 'tambah-buku', 'edit-buku'];
$categoryPages = ['daftar-kategori', 'tambah-kategori'];
$memberPages = ['daftar-anggota', 'tambah-anggota'];
$loanPages = ['peminjaman'];
$returnPages = ['pengembalian'];
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?php echo ($page === "dashboard") ? 'active' : ''; ?>" href="index.php?hal=dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Manajemen</div>
                <a class="nav-link <?php echo isActiveMenu($bookPages, $page) ? '' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#menuBuku" aria-expanded="<?php echo isActiveMenu($bookPages, $page) ? 'true' : 'false'; ?>" aria-controls="menuBuku">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Data Buku
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php echo isActiveMenu($bookPages, $page) ? 'show' : ''; ?>" id="menuBuku" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?php echo ($page === 'daftar-buku') ? 'active' : ''; ?>" href="index.php?hal=daftar-buku">Daftar Buku</a>
                        <a class="nav-link <?php echo ($page === 'tambah-buku') ? 'active' : ''; ?>" href="index.php?hal=tambah-buku">Tambah Buku</a>
                    </nav>
                </div>
                <a class="nav-link <?php echo isActiveMenu($categoryPages, $page) ? '' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#menuKategori" aria-expanded="<?php echo isActiveMenu($categoryPages, $page) ? 'true' : 'false'; ?>" aria-controls="menuKategori">
                    <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                    Kategori
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php echo isActiveMenu($categoryPages, $page) ? 'show' : ''; ?>" id="menuKategori" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?php echo ($page === 'daftar-kategori') ? 'active' : ''; ?>" href="index.php?hal=daftar-kategori">Daftar Kategori</a>
                        <a class="nav-link <?php echo ($page === 'tambah-kategori') ? 'active' : ''; ?>" href="index.php?hal=tambah-kategori">Tambah Kategori</a>
                    </nav>
                </div>

                <a class="nav-link <?php echo isActiveMenu($memberPages, $page) ? '' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#menuAnggota" aria-expanded="<?php echo isActiveMenu($memberPages, $page) ? 'true' : 'false'; ?>" aria-controls="menuAnggota">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Anggota
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php echo isActiveMenu($memberPages, $page) ? 'show' : ''; ?>" id="menuAnggota" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?php echo ($page === 'daftar-anggota') ? 'active' : ''; ?>" href="index.php?hal=daftar-anggota">Daftar Anggota</a>
                        <a class="nav-link <?php echo ($page === 'tambah-anggota') ? 'active' : ''; ?>" href="index.php?hal=tambah-anggota">Tambah Anggota</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Transaksi</div>
                <a class="nav-link <?php echo isActiveMenu($loanPages, $page) ? 'active' : ''; ?>" href="index.php?hal=peminjaman">
                    <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                    Peminjaman
                </a>
                <a class="nav-link <?php echo isActiveMenu($returnPages, $page) ? 'active' : ''; ?>" href="index.php?hal=pengembalian">
                    <div class="sb-nav-link-icon"><i class="fas fa-undo"></i></div>
                    Pengembalian
                </a>
                <a class="nav-link" href="logout.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo e($_SESSION['admin_name'] ?? 'Administrator'); ?>
        </div>
    </nav>
</div>
