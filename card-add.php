<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/validation.php';

// Store validation errors and submitted values.
$errors = [];
$formData = [
    'cardName' => '',
    'cardType' => '',
    'cardValue' => '',
    'points' => ''
];

// Process submitted form data.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'cardName' => $_POST['cardName'] ?? '',
        'cardType' => $_POST['cardType'] ?? '',
        'cardValue' => $_POST['cardValue'] ?? '',
        'points' => $_POST['points'] ?? ''
    ];

    // Validate the submitted information.
    $errors = validateGiftCard($formData);  
if (empty($errors)) {
    $pdo = getDBConnection();

    $sql = "INSERT INTO GIFTCARD
            (cardName, cardType, cardValue, points)
            VALUES
            (:cardName, :cardType, :cardValue, :points)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':cardName' => trim($formData['cardName']),
        ':cardType' => $formData['cardType'],
        ':cardValue' => $formData['cardValue'],
        ':points' => $formData['points']
    ]);

    header('Location: card-list.php');
    exit;
} else {
    $message = 'Please correct the invalid information.';
}
}

$pageTitle = 'Add Gift Card';
require_once __DIR__ . '/includes/header.php';
?>

<main class="page-container">
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <h2>Add Gift Card</h2>

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
            <form action="card-add.php" method="post">

                <div class="form-group">
                    <label for="cardName">Card Name</label>
                    <input type="text" id="cardName"
                        name="cardName"
                        maxlength="100"
                        value="<?= htmlspecialchars((string) $formData['cardName'], ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="Enter gift card name" required>
                </div>

                <div class="form-group">
                    <label for="cardType">Card Type</label>
                    <select id="cardType" name="cardType" required>
    <option value="">Select card type</option>

    <option value="Digital"
        <?= $formData['cardType'] === 'Digital' ? 'selected' : '' ?>>
        Digital
    </option>

    <option value="Physical"
        <?= $formData['cardType'] === 'Physical' ? 'selected' : '' ?>>
        Physical
    </option>
</select>
                </div>

                <div class="form-group">
                    <label for="cardValue">Card Value ($)</label>
                    <input type="number" id="cardValue"
       name="cardValue"
       min="0.01" step="0.01"
       value="<?= htmlspecialchars((string) $formData['cardValue'], ENT_QUOTES, 'UTF-8') ?>"
       placeholder="Enter card value" required>
                </div>

                <div class="form-group">
                    <label for="points">Points Required</label>
                    <input type="number" id="points"
       name="points"
       min="1" step="1"
       value="<?= htmlspecialchars((string) $formData['points'], ENT_QUOTES, 'UTF-8') ?>"
       placeholder="Enter points required" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        Save Gift Card
                    </button>

                    <a href="card-list.php" class="btn-link btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
