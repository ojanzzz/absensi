<?php
if ($mod == '') {
    header('location:../404');
    echo 'kosong';
} else {
    include_once 'sw-mod/sw-header.php';
    if (!isset($_COOKIE['COOKIES_MEMBER']) && !isset($_COOKIE['COOKIES_COOKIES'])) {
        setcookie('COOKIES_MEMBER', '', 0, '/');
        setcookie('COOKIES_COOKIES', '', 0, '/');
        // Login tidak ditemukan
        setcookie("COOKIES_MEMBER", "", time() - $expired_cookie);
        setcookie("COOKIES_COOKIES", "", time() - $expired_cookie);
        session_destroy();
        header("location:./");
    } else {
        if (!empty($_GET['building'])) {
            $building = mysqli_real_escape_string($connection, epm_decode($_GET['building']));
            $query_building = "SELECT building_id,latitude_longtitude,radius FROM building WHERE building_id='$building'";
            $result_building = $connection->query($query_building);
            if ($result_building->num_rows > 0) {
                $row_building = $result_building->fetch_assoc();
?>
                <!-- App Capsule -->
                <div id="appCapsule">
                    <!-- Wallet Card -->
                    <div class="section wallet-card-section pt-1">
                        <div class="wallet-card">
                            <div class="balance">
                                <div class="left">
                                    <span class="title"> Selamat <?= $salam ?></span>
                                    <h4><?= ucfirst($row_user['employees_name']) ?></h4>
                                </div>
                                <div class="right">
                                    <span class="title"><?= tgl_ind($date) ?> </span>
                                    <h4><span class="clock"></span></h4>
                                </div>
                            </div>
                            <!-- * Balance -->
                            <div class="text-center">
                                <!--<h3><?= tgl_ind($date) ?> - <span class="clock"></span></h3>-->
                                <p>Lat-Long: <span class="latitude" id="latitude"></span></p>
                            </div>
                            <div class="wallet-footer text-center">
                                <div class="webcam-capture-body text-center">
                                    <div class="webcam-capture"></div>
                                    <div class="form-group basic">
                                        <?php if ($result_absent->num_rows > 0) { ?>
                                            <button class="btn btn-success absent-capture btn-lg btn-block"><ion-icon name="camera-outline"></ion-icon>Absen Pulang</button>
                                        <?php } else { ?>
                                            <button class="btn btn-success absent-capture btn-lg btn-block"><ion-icon name="camera-outline"></ion-icon>Absen Masuk</button>
                                        <?php } ?>
                                    </div>
                                    <?php
                                    echo '
                                </div>
                            </div>
                            <!-- * Wallet Footer -->
                        </div>
                    </div>
                    <!-- Card -->
                </div>
                <!-- * App Capsule -->';
           
            } else {
            ?>
                <script type="text/javascript">
                    function warning() {
                        swal({
                            title: 'Oops!',
                            text: 'Lokasi Tidak ditemukan, Silahkan Pilih kembali.!',
                            icon: 'error',
                            timer: 3500,
                        });
                        setTimeout("location.href = './';", 3500);
                    };
                    warning();
                </script>
<?php
            }
        }
    }
    include_once 'sw-mod/sw-footer.php';
}
?>
