<?php
    session_start();
    include "includes/connect_db.php";
    include "actions/dashboard/get_data_action.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Hello, <?php echo $_SESSION['username'];?></h1>
<a href="profile.php">Profile</a>
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
                    <td>₱<?= number_format($row['transaction_amount'], 2) ?></td>
                    <td><?= htmlspecialchars(date("F d, Y", strtotime($row['transaction_date']))) ?></td>
                    <td class="text-wrap" style="max-width: 300px; white-space: normal;">
                        <?= htmlspecialchars($row['transaction_description']) ?>
                    </td>
                    <td>
                        <form action="actions/dashboard/delete_transaction_action.php" method="post">
                            <input type="hidden" name="transaction_id" value="<?= $row['transaction_id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>

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
                        <p class="m-0"><?= htmlspecialchars($row['category_name']) ?></p>
                        <p class="m-0">₱<?= htmlspecialchars(number_format($row['category_amount'], 2)) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#make-expense-modal">+</button>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div style="position: relative; height: 250px;">
                    <canvas id="barGraph"></canvas>
                </div>
            </div>
            <div class="col-md-5">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    
</div>

<script>
    const barCtx = document.getElementById('barGraph').getContext('2d');

    const barGraph = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Expenses',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: <?php echo json_encode($colors); ?>,
                borderRadius: 5,
                maxBarThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `₱${context.raw.toLocaleString()}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                },
                y: {
                    ticks: {
                        precision: 0,
                        stepSize: 200,
                        callback: function(value) {
                            return `₱${value.toLocaleString()}`;
                        }
                    }
                }
            }
        }
    });
</script>

<script>
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    const pieChart = new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Expenses','Income'],
            datasets: [{
                data: [<?php echo json_encode($expense_total); ?>, <?php echo json_encode($income_total); ?>],
                backgroundColor: ['#F1BA88', '#A6D6D6'],
                borderWidth: 7,
                borderColor: '#ffffff',
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        color: '#444',
                        font: {
                            size: 14,
                            family: 'sans-serif'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ₱${value.toLocaleString()}`;
                        }
                    }
                }
            }
        }
    });
</script>

<div class="modal fade" id="add-balance-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form novalidate action="actions/dashboard/add_balance_action.php" method="post">
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
                        <textarea class="form-control" name="description" style="resize: none; height:120px " placeholder="Description" maxlength="200" required></textarea>
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
            <form novalidate action="actions/dashboard/make_expense_action.php" method="post">
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
                        <textarea class="form-control" id="make-expense-description" name="description" style="resize: none; height:120px" placeholder="Description" maxlength="200" required></textarea>
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
                                        <p><?= htmlspecialchars($row['category_name']) ?></p>
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

<script src="assets/js/number-input.js"></script>
<script>
    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
        form.addEventListener("submit", function (e) {
        if (!form.checkValidity()) {
            e.preventDefault();
        }
        form.classList.add("was-validated"); 
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>