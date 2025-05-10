<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$role = $_SESSION['role'];
$source = strtolower($_GET['controller'] ?? 'unknown');
?>

<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Element</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/shared.css">
</head>
<body>

<div class="container">
    <h2>Update Element</h2>

    <?php if ($source === 'product'): ?>
        <form method="POST" action="../shared/update/<?= $product->productId ?>">
            <label for="productName">Name</label>
            <input type="text" name="productName" id="productName" value="<?= htmlspecialchars($product->productName) ?>" required>
            <div class="field-desc">The display name of your item</div>

            <label for="cost">Cost</label>
            <input type="number" step="0.01" name="cost" id="cost" value="<?= $product->cost ?>" required>
            <div class="field-desc">How much then item costs.</div>

            <label for="priceToSell">Sell Price</label>
            <input type="number" step="0.01" name="priceToSell" id="priceToSell" value="<?= $product->priceToSell ?>" required>
            <div class="field-desc">How much the item will sell for</div>

            <label for="categoryId">Category ID</label>
            <input type="number" name="categoryId" id="categoryId" value="<?= $product->categoryId ?>" required oninput="updateCategoryName()">
            <div class="field-desc">
                Category name: <span id="categoryNameDisplay" style="font-weight: bold;">Unknown category</span>
            </div>


            <label for="threshold">Threshold</label>
            <input type="number" name="threshold" id="threshold" value="<?= $product->threshold ?>" required>
            <div class="field-desc">Amount needed to be considered in stock.</div>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="<?= $product->quantity ?>" required>
            <div class="field-desc">How much product is currently available.</div>

            <button type="submit">Update Product</button>

            <script>
                const categoryMap = {
                    <?php foreach ($categories as $category): ?>
                    <?= $category->categoryId ?>: "<?= htmlspecialchars($category->categoryName) ?>",
                    <?php endforeach; ?>
                };

                function updateCategoryName() {
                    const input = document.getElementById('categoryId');
                    const nameDisplay = document.getElementById('categoryNameDisplay');
                    const id = input.value.trim();

                    if (categoryMap.hasOwnProperty(id)) {
                        nameDisplay.textContent = categoryMap[id];
                    } else if (id === '') {
                        nameDisplay.textContent = "Unknown category";
                    } else {
                        nameDisplay.textContent = "Invalid category";
                    }
                }
            </script>
        </form>
    <?php elseif ($_SESSION['role'] === 'admin'): ?>
        <?php if ($source === 'category'): ?>
            <form method="POST" action="../shared/update/<?= $category->categoryId ?>">
                <label for="categoryName">Name</label>
                <input type="text" id="categoryName" name="categoryName" value="<?= htmlspecialchars($category->categoryName) ?>" required>
                <div class="field-desc">The name of your category</div>

                <label for="categoryTax">Category Tax</label>
                <input type="number" step="0.01" name="categoryTax" id="categoryTax" value="<?= $category->categoryTax ?>" required>
                <div class="field-desc">Taxes for this category (in decimal).</div>

                <button type="submit">Update Category</button>
            </form>
        <?php elseif ($source === 'report'): ?>
            <form method="POST" action="../shared/update/<?= $report->reportId ?>">
                <label for="earnings">Earnings</label>
                <input type="number" step="0.01" name="earnings" id="earnings" value="<?= $report->earnings ?>" required>
                <div class="field-desc">How much you've earned</div>

                <label for="profits">Profits</label>
                <input type="number" step="0.01" name="profits" id="profits" value="<?= $report->profits ?>" required>
                <div class="field-desc">How much you've made</div>

                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="<?= $report->description ?>" required>
                <div class="field-desc">A little summary of the day</div>

                <button type="submit">Update Report</button>
            </form>
        <?php elseif ($source === 'supplier'): ?>
            <form method="POST" action="../shared/update/<?= $supplier->supplierId ?>">
                <label for="supplierName">Supplier Name</label>
                <input type="text" name="supplierName" id="supplierName" value="<?= $supplier->supplierName ?>" required>
                <div class="field-desc">Name of the supplier</div>

                <label for="email">E-mail</label>
                <input type="text" name="email" id="email" value="<?= $supplier->email ?>" required>
                <div class="field-desc">E-mail of the supplier</div>

                <label for="phoneNum">Phone Number</label>
                <input type="text" name="phoneNum" id="phoneNum" value="<?= $supplier->phoneNum ?>" required>
                <div class="field-desc">Phone Number of the supplier</div>

                <button type="submit">Update Supplier</button>
            </form>
        <?php elseif ($source === 'user'): ?>
            <form method="POST" action="../shared/update/<?= $user->id ?>">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= $user->username ?>" required>
                <div class="field-desc">Username of the user</div>

                <label for="password">Password</label>
                <input type="text" name="password" id="password" value="<?= $user->password ?>"  disabled>
                <div class="field-desc">Password given to the user (can only be changed by said user)</div>

                <label>Role</label>
                <?php if ($canChangeRole): ?>
                    <select name="role">
                        <option value="admin" <?= ($user->role == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="employee" <?= ($user->role == 'employee') ? 'selected' : '' ?>>Employee</option>
                    </select>
                <?php else: ?>
                    <input type="text" value="<?= htmlspecialchars($user->role) ?>" readonly>
                    <input type="hidden" name="role" value="<?= htmlspecialchars($user->role) ?>">
                <?php endif; ?>
                <div class="field-desc">Select the role of the user. (Depending on the role, they will have access to more or less features)</div>

                <button type="submit">Update User</button>
            </form>
        <?php elseif ($source === 'shift'): ?>
            <form method="POST" action="../shared/update/<?= $shift->shiftId ?>">
                <label for="userId">Select User:</label>
                <select name="userId" id="userId" required>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user->id ?>" <?= $user->id == $shift->userId ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user->username) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="field-desc">Username of the user</div>

                <label for="day">Select Day:</label>
                <select name="day" id="day" required>
                    <?php
                    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    foreach ($daysOfWeek as $day): ?>
                        <option value="<?= $day ?>" <?= $day === $shift->day ? 'selected' : '' ?>><?= $day ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="field-desc">Day of the week</div>

                <label for="startTime">Start Time:</label>
                <select name="startTime" id="startTime" required>
                    <?php for ($hour = 9; $hour <= 22; $hour++): ?>
                        <?php $value = sprintf('%02d:00:00', $hour); ?>
                        <option value="<?= $value ?>" <?= $value === $shift->startTime ? 'selected' : '' ?>>
                            <?= sprintf('%02d:00', $hour) ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <div class="field-desc">Start time of the shift</div>

                <label for="endTime">End Time:</label>
                <select name="endTime" id="endTime" required>
                    <?php for ($hour = 10; $hour <= 23; $hour++): ?>
                        <?php $value = sprintf('%02d:00:00', $hour); ?>
                        <option value="<?= $value ?>" <?= $value === $shift->endTime ? 'selected' : '' ?>>
                            <?= sprintf('%02d:00', $hour) ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <div class="field-desc">End time of the shift</div>
                <div id="timeError" style="color: red; font-size: 12px; display: none;">End time must be after start time!</div>

                <button type="submit">Update Shift</button>

                <script>
                    const form = document.querySelector('form');
                    const startSelect = document.getElementById('startTime');
                    const endSelect = document.getElementById('endTime');
                    const timeError = document.getElementById('timeError');

                    function validateTime() {
                        if (startSelect.value >= endSelect.value) {
                            endSelect.style.border = '2px solid red';
                            timeError.style.display = 'block';
                            return false;
                        } else {
                            endSelect.style.border = '';
                            timeError.style.display = 'none';
                            return true;
                        }
                    }

                    startSelect.addEventListener('change', validateTime);
                    endSelect.addEventListener('change', validateTime);

                    form.addEventListener('submit', function(e) {
                        if (!validateTime()) {
                            e.preventDefault();
                        }
                    });
                </script>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
