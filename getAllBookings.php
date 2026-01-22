<?php
// 222 1
// Включение заголовков CORS и настройки ответа
require_once "../ui/include_header.php";

// Подключение к базе данных и класса для работы с бронированиями
include_once "../data/config/database.php";
include_once "../ui/list-reserv/ListReservAll.php";

try {
	//    Инициализация соединения с БД
	$database = new Database();
	$db       = $database->getConnection();

	// Создание экземпляра класса для работы с бронированиями
	$list = new ListReservAll($db);

	// Получение всех записей
	$stmt = $list->get_all_list();

	// Инициализация структуры ответа
	$response = [
		"status" => "success",
		"data"   => []
	];

	// Проверка наличия записей
	if ($stmt->rowCount() > 0) {
		// Формирование массива записей
		$response["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} else {
		// Если записей нет, возвращаем пустой массив
		$response["message"] = "Нет  12113   3221111 записей";
	}

	// Установка HTTP-кода ответа
	http_response_code(200);
}
catch (PDOException $e) {
	// Обработка ошибок базы данных
	$response = [
		"status"  => "error",
		"message" => "Ошибка при получении данных: " . $e->getMessage()
	];
	http_response_code(500);
}
catch (Exception $e) {
	// Обработка других ошибок
	$response = [
		"status"  => "error",
		"message" => "Внутренняя ошибка сервера: " . $e->getMessage()
	];
	http_response_code(500);
}

// Вывод результата в формате JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
