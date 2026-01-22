<?php
//77
include_once "../ui/include_header.php";
include "../data/config/database.php";

$today    = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$soonEnd  = date('Y-m-d', strtotime('+5 days'));

$sql = "SELECT id, rooms_id as room, Client_Name as name, Date_In as checkIn, Date_Out as checkOut
        	FROM hotel_reserv 
        	WHERE Date_Out >= ? AND Date_In <= ?
          		AND (checked_out IS NULL OR checked_out = 0)  
			ORDER BY Date_Out ASC ";


$db_month = new Database();
$db       = $db_month->getConnection();

$stmt = $db->prepare($sql);
$stmt->execute([$today, $soonEnd]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($bookings as &$booking) {
	$booking['checkIn']  = $booking['checkIn'] ?? null;
	$booking['checkOut'] = $booking['checkOut'] ?? null;
	// или можно поставить текущую дату, если нужно
}

echo json_encode($bookings);
