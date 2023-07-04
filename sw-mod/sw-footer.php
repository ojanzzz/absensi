<?php if(empty($connection)){
	header('location:./404');
} else {

if(isset($_COOKIE['COOKIES_MEMBER'])){
echo'
<div class="appBottomMenu">
        <a href="./" class="item">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>

        <a href="#" class="item" data-toggle="dropdown">
            <div class="col">
                <ion-icon name="camera-outline"></ion-icon>
                <strong>Absen</strong>
            </div>
                
        </a><div class="dropdown-menu" x-placement="bottom-start">';
                $query_building  ="SELECT building_id,name FROM building ORDER BY name ASC";
                $result_building = $connection->query($query_building);
                while ($row_building = $result_building->fetch_assoc()) {
                  echo'<a class="dropdown-item" href="./absent&building='.epm_encode($row_building['building_id']).'"><ion-icon name="map"></ion-icon> '.$row_building['name'].'</a>';
                }
                echo'
                </div>

        <a href="./history" class="item">
            <div class="col">
                 <ion-icon name="document-text-outline"></ion-icon>
                <strong>History</strong>
            </div>
        </a>

        <!--<a href="./id-card" class="item">
            <div class="col">
               <ion-icon name="id-card-outline"></ion-icon>
                <strong>ID Card</strong>
            </div>
        </a>-->
        <a href="./profile" class="item">
            <div class="col">
                <ion-icon name="person-outline"></ion-icon>
                <strong>Profil</strong>
            </div>
        </a>
    </div>
<!-- * App Bottom Menu -->';
}

echo'
<!-- ///////////// Js Files ////////////////////  -->
<!-- Jquery -->
<script src="'.$base_url.'sw-mod/sw-assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="'.$base_url.'sw-mod/sw-assets/js/lib/popper.min.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/lib/bootstrap.min.js"></script>
<!-- Ionicons -->
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script src="https://kit.fontawesome.com/0ccb04165b.js" crossorigin="anonymous"></script>
<!-- Base Js File -->
<script src="'.$base_url.'sw-mod/sw-assets/js/base.js"></script>

<script src="'.$base_url.'sw-mod/sw-assets/js/webcamjs/webcam.min.js"></script>';
if($mod =='id-card'){
echo'
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>';?>
<script type="text/javascript">
    /* ---------- Save Id Card ----------*/
var element = $("#divToPrint"); // global variable
var getCanvas; // global variable
         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
             }
         });
    
    $(".btn-Convert-Html2Image").on('click', function () {
        var imgageData = getCanvas.toDataURL("image/png");
        // Now browser starts downloading it instead of just showing it
        var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
        $(".btn-Convert-Html2Image").attr("download", "ID-CARD.jpg").attr("href", newData);
    });
</script>
<?PHP }

if($mod =='history'){
echo'
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="'.$base_url.'sw-mod/sw-assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script>
    $(".datepicker").datepicker({
        format: "dd-mm-yyyy",
        "autoclose": true
    }); 
    
</script>';
}
echo'
<script src="'.$base_url.'/sw-mod/sw-assets/js/sw-script.js"></script>';
if ($mod =='absent'){
if(!empty($_GET['building'])){
    $building     =  mysqli_real_escape_string($connection,epm_decode($_GET['building']));
    $query_building  ="SELECT building_id,latitude_longtitude,radius FROM building WHERE building_id='$building'";
    $result_building = $connection->query($query_building);
    if($result_building->num_rows > 0){
    $row_building = $result_building->fetch_assoc();?>
<script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
<script type="text/javascript">
    var latitude_building =L.latLng(<?php echo $row_building['latitude_longtitude'];?>);
    navigator.geolocation.getCurrentPosition(function(location) {
    var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
    var markerFrom = L.circleMarker(latitude_building, { color: "#F00", radius: 10 });
    var markerTo =  L.circleMarker(latlng);
    var from = markerFrom.getLatLng();
    var to = markerTo.getLatLng();
    var jarak = from.distanceTo(to).toFixed(0);
    var latitude =""+location.coords.latitude+","+location.coords.longitude+"";
    $("#latitude").text(latitude);
    $("#jarak").text(jarak);
    var radius ='<?php echo $row_building['radius'];?>';
     //alert(jarak);
    if (radius < jarak){
        //jika lebih dari radius
      swal({title: 'Oops!', text:'Posisi Anda saat ini di radius '+jarak+'M, tidak ditempat atau Jauh dari Radius!', icon: 'error', timer: 3000,});
    }else{
        swal({title: 'Berhasil.!', text:'Posisi Anda saat ini sesuai titik!', icon: 'success', timer:2000,});
    }
  
     /* ------------------------------------------
        Start Kamera Webcame
    ----------------------------------------------*/
    Webcam.set({
        width: 590,height: 460,
        image_format: 'jpeg',
        jpeg_quality:80,
    });

    var cameras = new Array(); //create empty array to later insert available devices
    navigator.mediaDevices.enumerateDevices() // get the available devices found in the machine
    .then(function(devices) {
        devices.forEach(function(device) {
        var i = 0;
            if(device.kind=== "videoinput"){ //filter video devices only
                cameras[i]= device.deviceId; // save the camera id's in the camera array
                i++;
            }
        });
    })

    /* ----------------------------
        Setting Camera Depan HP
    -------------------------------*/
    Webcam.set('constraints',{
        width: 590,
        height: 460,
        image_format: 'jpeg',
        jpeg_quality:80,
        sourceId: cameras[0]
    });

    Webcam.attach('.webcam-capture');
    // preload shutter audio clip
    var shutter = new Audio();
    //shutter.autoplay = true;
    shutter.src = navigator.userAgent.match(/Firefox/) ? './sw-mod/sw-assets/js/webcamjs/shutter.ogg' : './sw-mod/sw-assets/js/webcamjs/shutter.mp3';

    $(document).on('click', '.absent-capture', function(){ 
        //var latitude = $('.latitude').html();
        // play sound effect
        shutter.play();
        var latitude = $('.latitude').html();
        var building = '<?php echo $row_building['building_id'];?>';
        //var jarak = $('.jarak').html();
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            Webcam.upload(data_uri, './sw-proses?action=absent&latitude='+latitude+'&radius='+jarak+'&building='+building+'',
                function(code,text) {
                    $data       =''+text+'';
                    var results = $data.split("/");
                    $results = results[0];
                    $results2 = results[1];
                    if($results =='success'){
                        swal({title: 'Berhasil!', text:$results2, icon: 'success', timer: 3500,});
                        setTimeout("location.href = './';",3600);
                    }else{
                        swal({title: 'Oops!', text:text, icon: 'error', timer: 3500,});
                    }
            });    
        });
    })
});
</script>
<?php }}}?>
  <!-- </body></html> -->
  </body>
</html><?php }?>

