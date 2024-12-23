<?php

/**
 * 
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Origin: *");

/**
 * 
 */

include_once '../../config/Database.php';
include_once '../../objects/Visit.php';

/**
 * 
 */

$database = new Database();
$db = $database->getConnection();
$visit = new Visit($db);

/**
 * 
*/

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $visits = $visit->read();
    echo json_encode(["visits" => $visits]);
    
} 

/**
 * 
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $visit->ip = $ip = $_SERVER['REMOTE_ADDR'];
    $visit->page = $data['page'];
    $visit->user_agent = $data['user_agent'];
    $visit->browser = $data['browser'];
    $visit->device = $data['device'];
    $visit->platform = $data['platform'];

    $visitId = $visit->add();

    echo json_encode(["visitId" => $visitId]);
} 
