
<?php
require_once __DIR__ . '/includes/db.php';

// Retrieve and validate the gift card ID from the URL.
$cardId = filter_input(
    INPUT_GET,
    'card_id',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

// Reject missing or invalid gift card IDs.
if ($cardId === false || $cardId === null) {
    http_response_code(400);
    exit('Invalid gift card ID.');
}

// Connect to SQLite.
$pdo = getDBConnection();

// Retrieve the selected gift card using a prepared statement.
$stmt = $pdo->prepare(
    'SELECT cardId, cardName, cardType, cardValue, points
     FROM GIFTCARD
     WHERE cardId = :cardId'
);

$stmt->execute([':cardId' => $cardId]);

$card = $stmt->fetch();

// Handle gift cards that do not exist.
if (!$card) {
    http_response_code(404);
    exit('Gift card not found.');
}

// Load the shared page header.
$pageTitle = 'Gift Card Details';
require_once __DIR__ . '/includes/header.php';
?>

<main class="page-container">

    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <h2>Gift Card Details</h2>

    <section class="details-card">

        <img
            src="images/gift-card.svg"
            alt="AirAsia Rewards Gift Card"
            class="details-image"
        >

        <h3>
            <?= htmlspecialchars(
                $card['cardName'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </h3>

        <div class="details-info">

            <p>
                <strong>Card ID:</strong>
                <?= (int) $card['cardId'] ?>
            </p>

            <p>
                <strong>Card Name:</strong>
                <?= htmlspecialchars(
                    $card['cardName'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>

            <p>
                <strong>Card Type:</strong>
                <?= htmlspecialchars(
                    $card['cardType'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>

            <p>
                <strong>Card Value:</strong>
                $<?= number_format(
                    (float) $card['cardValue'],
                    2
                ) ?>
            </p>

            <p>
                <strong>Points Required:</strong>
                <?= number_format(
                    (int) $card['points']
                ) ?>
            </p>

        </div>

        <nav class="details-actions">

            <a
                href="card-update.php?card_id=<?= (int) $card['cardId'] ?>"
                class="btn-link"
            >
                Update Gift Card
            </a>

            <a
                href="card-delete.php?card_id=<?= (int) $card['cardId'] ?>"
                class="btn-link btn-secondary"
            >
                Delete Gift Card
            </a>

            <a
                href="card-list.php"
                class="btn-link btn-secondary"
            >
                Back to Gift Card List
            </a>

        </nav>

    </section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
