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
include_once '../../objects/Contact.php';

$database = new Database();
$db = $database->getConnection();
$contact = new Contact($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $contact->visit_id = $_GET['visitId'];

    $contacts = $contact->readByVisitId();
    echo json_encode(["contacts" => $contacts]);

} 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $contact->visit_id = $data['visit_id'];
    $contact->email = $data['email'];
    $contact->phone = $data['phone'];

    $contact->add();

    echo json_encode(["answer" => true]);
} 
