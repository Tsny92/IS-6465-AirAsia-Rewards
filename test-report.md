
# Homework 3 - Test Report
## AirAsia Rewards Gift Card Management System

**Course:** IS 6465 - Web Based Applications  
**Assignment:** Homework 3  
**Testing Environment:** GitHub Codespaces, PHP, PDO, SQLite  
**Database:** database/rewards.db

---

## 1. Testing Overview

The purpose of testing was to verify that the AirAsia Rewards Gift Card Management System correctly implements Create, Read, Update, and Delete (CRUD) operations using PHP, PDO, and SQLite.

Testing included:
- Browser-based functional testing
- Server-side input validation
- SQL database verification
- PHP syntax checks
- Automated validation tests

The application uses prepared SQL statements for database operations and validates user input before processing requests.

---

## 2. Functional Test Cases

The following tests correspond to the eight required test cases in the Homework 3 assignment.

### T01 - Validation Test Harness

**Test Steps and Input:**
1. Open the Codespaces terminal.
2. Execute `php -d xdebug.mode=off tests/validation-tests.php`.
3. Review the PASS/FAIL output for six validation scenarios.

**Expected Result:** All six tests pass without modifying database records.

**Actual Result:** All six validation tests passed with zero failures.

**Status:** PASS

### T02 - View Gift Card List

**Test Steps and Input:**
1. Open `card-list.php` in the browser.
2. Examine the displayed gift cards.
3. Verify that each card displays its name, image, and points required.

**Expected Result:** All 20 seeded gift cards display correctly with links to their details.

**Actual Result:** The page retrieved and displayed 20 gift cards from SQLite with their names, images, and points required.

**Status:** PASS

### T03 - View Gift Card Details

**Test Steps and Input:**
1. Open `card-details.php?card_id=1`.
2. Verify the displayed Card ID, name, type, value, and points.
3. Open another existing gift card to confirm that the page displays the selected record.

**Expected Result:** The page displays the correct attributes for the selected gift card.

**Actual Result:** The Details page displayed the selected gift card's attributes correctly.

**Status:** PASS

### T04 - Add Gift Card

**Test Steps and Input:**
1. Open `card-add.php`.
2. Enter the following information:
   - Card Name: Test Visa $30 Gift Card
   - Card Type: Digital
   - Card Value: 30.00
   - Points Required: 3000
3. Click Save Gift Card.
4. Query SQLite to verify the new record.

**Expected Result:** A new gift card is inserted and the user returns to the Gift Card List.

**Actual Result:** SQLite confirmed that the gift card was inserted with Card ID 21, Digital type, $30.00 value, and 3000 points.

**Status:** PASS

### T05 - Update Gift Card

**Test Steps and Input:**
1. Open `card-update.php?card_id=1`.
2. Change the existing Amazon $10 Gift Card to:
   - Card Name: Amazon $15 Gift Card
   - Card Type: Digital
   - Card Value: 15.00
   - Points Required: 1500
3. Submit the form.
4. Verify the changes using SQLite.

**Expected Result:** The selected gift card is updated and the user returns to its Details page.

**Actual Result:** SQLite confirmed that Card ID 1 contained the updated name, value, and points. The original values were restored after testing.

**Status:** PASS

### T06 - Delete Gift Card

**Test Steps and Input:**
1. Open `card-delete.php?card_id=21`.
2. Review the selected gift card information.
3. Submit the confirmation form.
4. Query SQLite for Card ID 21.
5. Verify the remaining gift card count.

**Expected Result:** The record is deleted only after POST confirmation, and the user returns to the Gift Card List.

**Actual Result:** SQLite returned no record for Card ID 21. The remaining gift card count was 20.

**Status:** PASS

### T07 - Invalid or Altered Input Handling

**Test Steps and Input:**
1. Open `card-add.php`.
2. Temporarily add the `novalidate` attribute to the HTML form to bypass browser validation.
3. Enter:
   - Card Name: Test Gift Card
   - Card Type: Digital
   - Card Value: -10
   - Points Required: 1000
4. Submit the form.
5. Observe the validation messages and retained values.
6. Remove the temporary `novalidate` attribute.

**Expected Result:** Server-side validation rejects the negative value, displays an error, and preserves entered information.

**Actual Result:** PHP rejected the negative card value, displayed validation feedback, and preserved the submitted form values.

**Status:** PASS

### T08 - Invalid Gift Card Identifier Handling

**Test Steps and Input:**
1. Open `card-details.php` with a missing or invalid `card_id`.
2. Open the page with a nonexistent positive integer ID.
3. Verify the application's responses.

**Expected Result:** Invalid IDs return an appropriate error, and nonexistent gift cards are handled safely without exposing database information.

**Actual Result:** Invalid IDs were rejected with HTTP 400, and nonexistent gift cards were handled with HTTP 404.

**Status:** PASS

### Functional Testing Summary

| Test ID | Test | Status |
|---|---|---|
| T01 | Validation test harness | PASS |
| T02 | View Gift Card List | PASS |
| T03 | View Gift Card Details | PASS |
| T04 | Add Gift Card | PASS |
| T05 | Update Gift Card | PASS |
| T06 | Delete Gift Card | PASS |
| T07 | Invalid or altered input handling | PASS |
| T08 | Invalid Gift Card identifier handling | PASS |

**Total: 8 passed, 0 failed.**

All temporary database changes made during testing were reversed or removed.

---

## 3. Automated Validation Tests

**Test File:** tests/validation-tests.php

**Execution Command:**

```bash
php tests/validation-tests.php
```

| Test | Expected Behavior | Result |
|---|---|---|
| Valid gift card | Accept valid input | PASS |
| Blank card name | Reject missing name | PASS |
| Invalid card type | Reject unsupported type | PASS |
| Zero card value | Reject zero value | PASS |
| Negative card value | Reject negative value | PASS |
| Invalid points | Reject noninteger points | PASS |

**Automated Test Results:**

```text
PASS: Valid gift card
PASS: Blank card name
PASS: Invalid card type
PASS: Zero card value
PASS: Negative card value
PASS: Invalid points

Validation Test Summary
Passed: 6
Failed: 0
```

All six automated validation tests passed.

These tests call the shared validation function directly and do not modify the database.

---

## 4. Database Verification

### Initial Database Setup

The SQLite database was initialized with:

| Table | Seeded Records |
|---|---:|
| ACCOUNT | 5 |
| GIFTCARD | 20 |

### Create Operation

A new gift card was inserted successfully:

```text
cardId: 21
cardName: Test Visa $30 Gift Card
cardType: Digital
cardValue: 30.0
points: 3000
```

### Update Operation

The following record was updated successfully:

```text
cardId: 1
cardName: Amazon $15 Gift Card
cardType: Digital
cardValue: 15.0
points: 1500
```

### Delete Operation

After deleting cardId 21, the following query returned no matching records:

```sql
SELECT cardId, cardName
FROM GIFTCARD
WHERE cardId = 21;
```

The final gift card count was verified using:

```sql
SELECT COUNT(*) FROM GIFTCARD;
```

Result:

```text
20
```

This confirms that the test record was removed successfully.

---

## 5. Security and Validation

The application implements the following safeguards:

- PDO prepared statements for database queries
- Positive integer validation for gift card IDs
- Required gift card name with a 100-character limit
- Restricted card types (Digital and Physical)
- Positive numeric gift card values
- Positive integer points requirements
- HTML output escaping using htmlspecialchars()
- POST requests for database-changing form operations
- A confirmation screen before deleting gift cards

Authentication, authorization, and CSRF protection are not implemented in this homework version.

---

## 6. PHP Syntax Verification

PHP syntax checks were performed during development using:

```bash
php -l filename.php
```

Syntax checks passed for the pages and components tested during implementation.

---

## 7. Testing Conclusion

The AirAsia Rewards Gift Card Management System successfully implements the required CRUD functionality using PHP, PDO, and SQLite.

Browser testing and SQL verification confirmed that gift cards can be created, retrieved, updated, and deleted.

All six automated validation tests passed with zero failures.

The application is ready for final documentation review and submission checks.
