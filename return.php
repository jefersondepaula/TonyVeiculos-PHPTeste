<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");
header("Content-Type: application/json; charset=utf8");
echo json_encode($array);
exit;