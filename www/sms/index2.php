<?php

require_once( '/sysscript/sms/vendor/autoload.php' );
date_default_timezone_set( 'Europe/Kiev' );
// Подключеие к бд

$mysql_param = [
	'host'     => '127.0.0.1',
	'login'    => 'sysadmin1',
	'password' => 'rfmd2EAA1997',
	'dbname'   => 'asterisk'
];
$mysqli      = new mysqli( $mysql_param['host'], $mysql_param['login'], $mysql_param['password'], $mysql_param['dbname'] );
if ( $mysqli->connect_errno ) {
	echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
} else {
if ( isset( $_GET['page'] ) && ! empty( $_GET['page'] && $_GET['page'] > 0 ) ) {
	$page   = $_GET['page'];
	$offset = $page * 50;
} else {
	$offset = 0;
}
$count_rows_query = $mysqli->query( "SELECT COUNT(*) FROM sms" );
$count_rows       = $count_rows_query->fetch_row()[0];
$res              = $mysqli->query( "SELECT * FROM sms LIMIT 50 OFFSET $offset" );
$page_count       = ceil($count_rows / 50);
print_r($page_count);
//while ( $row = $res->fetch_assoc() ) {
//	print_r( $row );//id  from1 hash dt textsms
//}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
          crossorigin="anonymous">

    <title>SMS</title>
</head>
<body>
<div class="jumbotron container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">От</th>
            <th scope="col">Дата время</th>
            <th scope="col">Текст</th>
        </tr>
        </thead>
        <tbody>
		<?php while ( $row = $res->fetch_assoc() ) {
			?>
            <tr>
                <th scope="row"><?= $row['id'] ?></th>
                <td><?= $row['from1'] ?></td>
                <td><?= $row['dt'] ?></td>
                <td><?= $row['textsms'] ?></td>
            </tr>
		<?php } ?>
        </tbody>
    </table>
<nav aria-label="...">
    <ul class="pagination pagination-sm">
		<?php $i = 0;
		while ( $page_count != $i ){
		    $i++;
		?>
        <li class="page-item"><a class="page-link" href="/?page=<?=$i?>"><?=$i?></a></li>
        <?php } ?>
    </ul>
</nav>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
</body>
</html>

<?php
}

?>
