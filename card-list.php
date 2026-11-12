<?php
require_once __DIR__ . '/includes/db.php';

// Connect to SQLite and retrieve all gift cards.
$pdo = getDBConnection();

$stmt = $pdo->query(
    'SELECT cardId, cardName, cardType, cardValue, points
     FROM GIFTCARD
     ORDER BY cardId ASC'
);

$giftCards = $stmt->fetchAll();

$pageTitle = 'Gift Card List';
require_once __DIR__ . '/includes/header.php';
?>

<main class="page-container">
    <?php require_once __DIR__ . '/includes/nav.php'; ?>

    <h2>Gift Card List</h2>
    
<section class="gift-card-grid">

    <?php foreach ($giftCards as $card): ?>

        <article class="gift-card">
            <a href="card-details.php?card_id=<?= (int) $card['cardId'] ?>">
                <img
                    src="images/gift-card.svg"
                    alt="<?= htmlspecialchars($card['cardName'], ENT_QUOTES, 'UTF-8') ?>"
                >

                <h3>
                    <?= htmlspecialchars($card['cardName'], ENT_QUOTES, 'UTF-8') ?>
                </h3>
            </a>

            <p><?= (int) $card['points'] ?> Points</p>
        </article>

    <?php endforeach; ?>

</section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
