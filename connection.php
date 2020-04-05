<?php

error_reporting( 1 );
mysqli_connect( 'localhost', 'root', '','' ) or die( mysqli_error() );
mysqli_select_db( 'poll' ) or die( mysqli_error() );

?>