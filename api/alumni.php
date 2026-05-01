<?php
/**
 * api/alumni.php
 * GET  ?page=1&limit=30&search=nama&status=Tervalidasi
 * Returns: { data: [...], total, page, totalPages }
 */
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$page   = max(1, intval($_GET['page']   ?? 1));
$limit  = max(1, min(100, intval($_GET['limit'] ?? 30)));
$offset = ($page - 1) * $limit;
$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');

// Build WHERE clause
$conditions = ["TRIM(`Nama Lulusan`) != '-' AND TRIM(`Nama Lulusan`) != ''"];
$params     = [];
$types      = '';

if ($search !== '') {
    $conditions[] = "(`Nama Lulusan` LIKE ? OR `NIM` LIKE ? OR `Fakultas` LIKE ? OR `Program Studi` LIKE ?)";
    $s = "%$search%";
    $params = array_merge($params, [$s, $s, $s, $s]);
    $types .= 'ssss';
}

if ($status !== '') {
    $conditions[] = "`_status` = ?";
    $params[] = $status;
    $types   .= 's';
}

$where = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';

// ── Count total rows ──────────────────────────────────────────
$countSQL = "SELECT COUNT(*) AS total FROM `alumni` $where";
$stmt = $conn->prepare($countSQL);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$total = (int) $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

// ── Fetch page data ───────────────────────────────────────────
$dataSQL = "SELECT * FROM `alumni` $where ORDER BY `Nama Lulusan` ASC LIMIT ? OFFSET ?";
$pageParams = array_merge($params, [$limit, $offset]);
$pageTypes  = $types . 'ii';

$stmt = $conn->prepare($dataSQL);
$stmt->bind_param($pageTypes, ...$pageParams);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
$stmt->close();
$conn->close();

echo json_encode([
    'data'       => $rows,
    'total'      => $total,
    'page'       => $page,
    'limit'      => $limit,
    'totalPages' => (int) ceil($total / $limit),
], JSON_UNESCAPED_UNICODE);
