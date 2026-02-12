<?php
require_once '../config/Database.php';
require_once '../src/DAO/FinancieroDAO.php';

header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $financieroDAO = new \App\DAO\FinancieroDAO($db);

    $id = isset($_POST['idFinanciero']) ? (int)$_POST['idFinanciero'] : null;
    $monto = isset($_POST['monto']) ? (float)$_POST['monto'] : 0;

    if ($id && $monto > 0) {
        $exito = $financieroDAO->registrarPago($id, $monto);
        echo json_encode(['success' => $exito]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    }
}