<?php
session_start();
use Dompdf\Dompdf;
require_once '../sw-library/sw-config.php';
require_once '../sw-library/sw-function.php';
include_once '../sw-library/vendor/autoload.php';

if (!isset($_COOKIE['COOKIES_MEMBER']) || !isset($_COOKIE['COOKIES_COOKIES'])) {
    // Kondisi tidak login
} else {
    require_once '../sw-mod/out/sw-cookies.php';
    // kondisi login

    switch (@$_GET['action']) {
        /* -------  CETAK PDF----------*/
        case 'pdf':
            $query = "SELECT employees.id, employees.employees_name, employees.position_id, position.position_name, shift.time_in, shift.time_out FROM employees, position, shift WHERE employees.position_id = position.position_id AND employees.shift_id = shift.shift_id AND employees.id = '$row_user[id]'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $shift_time_in = $row['time_in'];

                if (isset($_GET['from']) || isset($_GET['to'])) {
                    $from = date('Y-m-d', strtotime($_GET['from']));
                    $to = date('Y-m-d', strtotime($_GET['to']));
                    $filter = "presence_date BETWEEN '$from' AND '$to'";
                } else {
                    $filter = "MONTH(presence_date) ='$month'";
                }

                $mpdf = new \Mpdf\Mpdf();
                ob_start();
                // Rest of your code for generating the PDF file
                // ...

                $html = ob_get_contents();
                ob_end_clean();
                $mpdf->WriteHTML($html);

                // Send the PDF as a download
                $mpdf->Output("Absensi-$employees_name-$date.pdf", 'D');
            } else {
                // Handle no data found
            }

            break;

        case 'excel':
            $query = "SELECT employees.id, employees.employees_name, employees.position_id, position.position_name, shift.time_in, shift.time_out FROM employees, position, shift WHERE employees.position_id = position.position_id AND employees.shift_id = shift.shift_id AND employees.id = '$row_user[id]'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $shift_time_in = $row['time_in'];

                if (isset($_GET['from']) || isset($_GET['to'])) {
                    $from = date('Y-m-d', strtotime($_GET['from']));
                    $to = date('Y-m-d', strtotime($_GET['to']));
                    $filter = "presence_date BETWEEN '$from' AND '$to'";
                } else {
                    $filter = "MONTH(presence_date) ='$month'";
                }

                // Send the Excel header
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Data-Absensi-$employees_name-$date.xls");

                // Rest of your code for generating the Excel file
                // ...

            } else {
                // Handle no data found
            }
            break;

        default:
            // Handle default case
            break;
    }
}
?>
