<?php
include '../components/connect.php';

// Ontvang de POST-data met de geselecteerde naam
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];

// Zoek de bijbehorende postcode op basis van de naam
$select_postcode = $conn->prepare("SELECT postcode FROM messages WHERE name = ?");
$select_postcode->execute([$name]);
$postcode = $select_postcode->fetchColumn();

// Retourneer de postcode als JSON
header('Content-Type: application/json');
echo json_encode(['postcode' => $postcode]);
?>
