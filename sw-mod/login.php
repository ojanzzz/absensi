<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE); // Disable warnings and notices

if ($mod == '') {
    header('location: ../404');
    echo 'kosong';
} else {
    include_once 'sw-mod/sw-header.php';
    if (!isset($_COOKIE['COOKIES_MEMBER'])) {

        $query = mysqli_query($connection, "SELECT max(employees_code) as kodeTerbesar FROM employees");
        $data = mysqli_fetch_array($query);
        $kode_karyawan = $data['kodeTerbesar'];
        $urutan = (int) substr($kode_karyawan, 3, 3);
        $urutan++;
        $huruf = "OM";
        $kode_karyawan = $huruf . sprintf("%03s", $urutan);
?>

        <!-- App Capsule -->
        <div id="appCapsule">
            <div class="section mt-2 text-center">
                <h1>Masuk</h1>
                <h4>Isi formulir untuk masuk</h4>
            </div>
            <div class="section mb-5 p-2">
                <form id="form-login">
                    <?php
                    if (isset($_GET['error']) && $_GET['error'] === '1') {
                        echo '<div class="alert alert-danger">Username or password is incorrect.</div>';
                    }
                    ?>
                    <div class="card">
                        <div class="card-body pb-1">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="employees_code">Nomor Hp</label>
                                    <input type="employees_code" class="form-control" id="employees_code" name="employees_code" placeholder="Nomor Hp Anda">
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="password1">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Kata sandi Anda">
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-links mt-2">
                        <div>
                            <a href="registrasi">Mendaftar</a>
                        </div>
                        <div><a href="forgot" class="text-muted">Lupa Password?</a></div> -->
                </form>
                <?php
                if (isset($_GET['error']) && $_GET['error'] === '1') {
                    echo '<div class="alert alert-danger mt-2">Username or password is incorrect.</div>';
                }
                ?>
            </div>
        </div>
<?php
    }
}
?>
