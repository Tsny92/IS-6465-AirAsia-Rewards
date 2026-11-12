<?php
require_once __DIR__ . '/includes/db.php';

// Determine whether the request is GET or POST.
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

// Retrieve the gift card ID from the appropriate source.
$cardId = filter_input(
    $isPost ? INPUT_POST : INPUT_GET,
    'card_id',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

// Reject missing or invalid IDs.
if ($cardId === false || $cardId === null) {
    http_response_code(400);
    exit('Invalid gift card ID.');
}

// Connect to the SQLite database.
$pdo = getDBConnection();

// Retrieve the selected gift card.
$stmt = $pdo->prepare(
    'SELECT cardId, cardName, cardType, cardValue, points
     FROM GIFTCARD
     WHERE cardId = :cardId'
);

$stmt->execute([':cardId' => $cardId]);
$card = $stmt->fetch();

// Handle nonexistent gift cards.
if (!$card) {
    http_response_code(404);
    exit('Gift card not found.');
}

// Delete only after a POST request.
if ($isPost) {
    $deleteStmt = $pdo->prepare(
        'DELETE FROM GIFTCARD WHERE cardId = :cardId'
    );

    $deleteStmt->execute([
        ':cardId' => $cardId
    ]);

    // Return to the gift card list.
    header('Location: card-list.php');
    exit;
}

// Display the confirmation page for GET requests.
$pageTitle = 'Delete Gift Card';
require_once __DIR__ . '/includes/header.php';
?>

<main class="page-container">
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <h2>Delete Gift Card</h2>

    <section class="form-card">

        <h3>Confirm Gift Card Deletion</h3>

        <p>
            Are you sure you want to permanently delete
            the following gift card?
        </p>

        <div class="form-group">
            <strong>Card Name:</strong>
            <?= htmlspecialchars(
                $card['cardName'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </div>

        <div class="form-group">
            <strong>Card Type:</strong>
            <?= htmlspecialchars(
                $card['cardType'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </div>

        <div class="form-group">
            <strong>Card Value:</strong>
            $<?= number_format(
                (float) $card['cardValue'],
                2
            ) ?>
        </div>

        <div class="form-group">
            <strong>Points Required:</strong>
            <?= number_format(
                (int) $card['points']
            ) ?>
        </div>

        <p>
            <strong>Warning:</strong>
            This action cannot be undone.
        </p>

        <form action="card-delete.php" method="post">

            <input
                type="hidden"
                name="card_id"
                value="<?= (int) $card['cardId'] ?>"
            >

            <div class="form-actions">

                <button
                    type="submit"
                    class="btn-primary"
                >
                    Confirm Delete
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
