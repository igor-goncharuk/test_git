<?php
//44
include_once "../ui/include_header.php";
include "../data/config/database.php";


$db_month = new Database();
$db       = $db_month->getConnection();

$data = json_decode(file_get_contents("php://input"), true);
$id   = (int)$data['id'];

$stmt = $db->prepare("UPDATE hotel_reserv SET checked_out = 1 WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['success' => true]);

