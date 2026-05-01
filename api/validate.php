<?php
/**
 * api/validate.php
 * POST { nim, password }
 * → Update _status = 'Tervalidasi' di database jika password benar
 */
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Baca body JSON
$body     = json_decode(file_get_contents('php://input'), true);
$nim      = trim($body['nim']      ?? '');
$password = trim($body['password'] ?? '');

// ── Validasi input ────────────────────────────────────────────
if ($nim === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['error' => 'NIM dan password wajib diisi.']);
    exit;
}

// ── Cek password (diambil dari db.php) ───────────────────────

if ($password !== ADMIN_PASSWORD) {
    http_response_code(401);
    echo json_encode(['error' => 'Password salah.']);
    exit;
}

// ── Update status di database ─────────────────────────────────
$sql  = "UPDATE `alumni` SET `_status` = 'Tervalidasi', `_validated_at` = NOW() WHERE `NIM` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $nim);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => "NIM '$nim' tidak ditemukan."]);
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->close();
$conn->close();

echo json_encode([
    'success' => true,
    'message' => "Alumni NIM $nim berhasil divalidasi.",
    'nim'     => $nim,
], JSON_UNESCAPED_UNICODE);
