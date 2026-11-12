<?php
require_once __DIR__ . '/../includes/validation.php';

// Track test results.
$passed = 0;
$failed = 0;

// Run a validation test and display its result.
function runTest(string $name, array $data, bool $shouldPass): void
{
    global $passed, $failed;

    $errors = validateGiftCard($data);
    $actualPass = empty($errors);

    if ($actualPass === $shouldPass) {
        echo "PASS: $name\n";
        $passed++;
    } else {
        echo "FAIL: $name\n";
        echo "Errors: " . json_encode($errors) . "\n";
        $failed++;
    }
}

// Test 1: Valid gift card.
runTest('Valid gift card', [
    'cardName' => 'Amazon $25 Gift Card',
    'cardType' => 'Digital',
    'cardValue' => '25.00',
    'points' => '2500'
], true);

// Test 2: Blank card name.
runTest('Blank card name', [
    'cardName' => '',
    'cardType' => 'Digital',
    'cardValue' => '25.00',
    'points' => '2500'
], false);

// Test 3: Invalid card type.
runTest('Invalid card type', [
    'cardName' => 'Test Gift Card',
    'cardType' => 'InvalidType',
    'cardValue' => '25.00',
    'points' => '2500'
], false);

// Test 4: Zero card value.
runTest('Zero card value', [
    'cardName' => 'Test Gift Card',
    'cardType' => 'Physical',
    'cardValue' => '0',
    'points' => '2500'
], false);

// Test 5: Negative card value.
runTest('Negative card value', [
    'cardName' => 'Test Gift Card',
    'cardType' => 'Digital',
    'cardValue' => '-10',
    'points' => '2500'
], false);

// Test 6: Invalid points.
runTest('Invalid points', [
    'cardName' => 'Test Gift Card',
    'cardType' => 'Digital',
    'cardValue' => '25.00',
    'points' => 'abc'
], false);

// Display summary.
echo "\nValidation Test Summary\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";

exit($failed === 0 ? 0 : 1);
