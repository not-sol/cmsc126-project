<?php
    session_start();
    include "includes/connect_db.php";
    include "actions/get_data_action.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<h1>Hello, <?php echo $_SESSION['username'];?></h1>
<div class="container p-3" style="max-width: 1000px;">
    <div class="container">
        <div class="row gx-3">
            <div class="col-auto">
                <h3>Balance: ₱<?php echo number_format($_SESSION['balance'], 2); ?></h3>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#add-balance-modal">+</button>
            </div>
        </div>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $transactionData->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td><?= htmlspecialchars($row['transaction_amount']) ?></td>
                    <td><?= htmlspecialchars($row['transaction_date']) ?></td>
                    <td><?= htmlspecialchars($row['transaction_description']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <div class="row g-3">
            <?php foreach ($categories as $row): ?>
                <div class="col-2">
                    <div class="p-2 rounded text-center" style="border: 3px solid <?= htmlspecialchars($row['category_color']) ?>; color: <?= htmlspecialchars($row['category_color']) ?>;">
                        <p><?= htmlspecialchars($row['category_name']) ?></p>
                        <p class="">₱<?= htmlspecialchars(number_format($row['category_amount'], 2)) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#make-expense-modal">+</button>
</div>

<div class="modal fade" id="add-balance-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form novalidate action="actions/add_balance_action.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Enter Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" placeholder="Amount" name="amount" onkeydown="return isNumber(event)" required>
                        <label class="form-label">Amount</label>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Date</span>
                        <input type="date" class="form-control" name="date" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-floating my-3">
                        <textarea class="form-control" name="description" style="resize: none; height:125px" placeholder="Description" maxlength="200" required></textarea>
                        <label class="form-label">Description</label>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="make-expense-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form novalidate action="actions/make_expense_action.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Enter Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="make-expense-amount" placeholder="Amount" name="amount" onkeydown="return isNumber(event)" required>
                        <label class="form-label">Amount</label>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Date</span>
                        <input type="date" class="form-control" id="make-expense-date" name="date" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-floating my-3">
                        <textarea class="form-control" id="make-expense-description" name="description" style="resize: none; height:125px" placeholder="Description" maxlength="200" required></textarea>
                        <label class="form-label">Description</label>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="row g-2">
                        <?php foreach ($categories as $row): ?>
                            <?php if (strtolower($row['category_name']) === 'income') continue; ?>
                            <div class="col-4">
                                <label class="w-100">
                                    <input type="radio" name="category_id" value="<?= $row['category_id'] ?>" hidden>
                                    <div class="category-option py-3 rounded text-center"
                                        style="background-color: <?= htmlspecialchars($row['category_color']) ?>;">
                                        <p class="m-0"><?= htmlspecialchars($row['category_name']) ?></p>
                                    </div>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<a href="actions/logout_action.php">Logout</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/number-input.js"></script>
<script src="assets/js/validate-form.js"></script>

</body>
</html>