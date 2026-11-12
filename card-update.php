
<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/validation.php';
// Retrieve and validate the gift card ID from the URL.
$cardId = filter_input(
    INPUT_GET,
    'card_id',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

// Reject missing or invalid IDs.
if ($cardId === false || $cardId === null) {
    http_response_code(400);
    exit('Invalid gift card ID.');
}

// Connect to SQLite.
$pdo = getDBConnection();

// Retrieve the selected gift card.
$stmt = $pdo->prepare(
    'SELECT cardId, cardName, cardType, cardValue, points
     FROM GIFTCARD
     WHERE cardId = :cardId'
);

$stmt->execute(['cardId' => $cardId]);

$card = $stmt->fetch();

// Handle nonexistent gift cards.

if (!$card) {
    http_response_code(404);
    exit('Gift card not found.');
}

// Store validation errors.
$errors = [];

// Validate submitted form data.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateGiftCard($_POST);
 
if (empty($errors)) {
    // Update the selected gift card using a prepared statement.
    $updateStmt = $pdo->prepare(
        'UPDATE GIFTCARD
         SET cardName = :cardName,
             cardType = :cardType,
             cardValue = :cardValue,
             points = :points
         WHERE cardId = :cardId'
    );

    $updateStmt->execute([
        'cardName' => trim($_POST['cardName']),
        'cardType' => $_POST['cardType'],
        'cardValue' => (float) $_POST['cardValue'],
        'points' => (int) $_POST['points'],
        'cardId' => $cardId
    ]);

    // Redirect to the updated gift card's details page.
    header('Location: card-details.php?card_id=' . $cardId);
    exit;
} else {
    $message = 'Please correct the invalid information.';
}

    // Preserve submitted values when validation fails.
    $card = array_merge($card, $_POST);
}
?>

<?php
$pageTitle = 'Update Gift Card';
require_once __DIR__ . '/includes/header.php';
?>

<main class="page-container">
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <h2>Update Gift Card</h2>

        <section class="form-card">  
            <?php if (!empty($message)): ?>
    <p role="status">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div role="alert">
        <p><strong>Please fix the following errors:</strong></p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>         
            <form action="card-update.php?card_id=<?= (int) $card['cardId'] ?>" method="post">

    <div class="form-group">
        <label for="cardName">Card Name</label>
        <input
            type="text"
            id="cardName"
            name="cardName"
            maxlength="100"
            value="<?= htmlspecialchars($card['cardName'], ENT_QUOTES, 'UTF-8') ?>"
            required
        >
    </div>

    <div class="form-group">
        <label for="cardType">Card Type</label>
        <select id="cardType" name="cardType" required>
            <option value="Digital"
                <?= $card['cardType'] === 'Digital' ? 'selected' : '' ?>>
                Digital
            </option>

            <option value="Physical"
                <?= $card['cardType'] === 'Physical' ? 'selected' : '' ?>>
                Physical
            </option>
        </select>
    </div>

    <div class="form-group">
        <label for="cardValue">Card Value ($)</label>
        <input
            type="number"
            id="cardValue"
            name="cardValue"
            min="0.01"
            step="0.01"
            value="<?= htmlspecialchars((string) $card['cardValue'], ENT_QUOTES, 'UTF-8') ?>"
            required
        >
    </div>

    <div class="form-group">
        <label for="points">Points Required</label>
        <input
            type="number"
            id="points"
            name="points"
            min="1"
            step="1"
            value="<?= (int) $card['points'] ?>"
            required
        >
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">
            Update Gift Card
        </button>

        <a
            href="card-details.php?card_id=<?= (int) $card['cardId'] ?>"
            class="btn-link btn-secondary"
        >
            Cancel
        </a>
    </div>

</form>
        </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
