<?php
// Shared gift card validation for AirAsia Rewards.

/**
 * Validate submitted gift card information.
 *
 * Returns an array of error messages.
 * An empty array means the submitted data is valid.
 */
function validateGiftCard(array $data): array
{
    $errors = [];

    // Validate card name.
    $cardName = trim((string) ($data['cardName'] ?? ''));

    if ($cardName === '') {
        $errors['cardName'] = 'Card name is required.';
    } elseif (strlen($cardName) > 100) {
        $errors['cardName'] = 'Card name cannot exceed 100 characters.';
    }

    // Validate card type.
    $allowedTypes = ['Digital', 'Physical'];
    $cardType = $data['cardType'] ?? '';

    if (!is_string($cardType) || !in_array($cardType, $allowedTypes, true)) {
        $errors['cardType'] = 'Select a valid card type.';
    }

    // Validate card value.
    $cardValue = $data['cardValue'] ?? '';

    if (
        !is_scalar($cardValue) ||
        !is_numeric($cardValue) ||
        !is_finite((float) $cardValue) ||
        (float) $cardValue <= 0
    ) {
        $errors['cardValue'] = 'Card value must be greater than zero.';
    }

    // Validate required points.
    $points = filter_var(
        $data['points'] ?? null,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    if ($points === false) {
        $errors['points'] = 'Points must be a positive whole number.';
    }

    return $errors;
}
