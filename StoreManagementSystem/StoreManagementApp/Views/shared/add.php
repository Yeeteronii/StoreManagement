<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$role = $_SESSION['role'];
$dirname = $_SESSION['dirname'];
$source = strtolower($_GET['controller'] ?? 'unknown');
?>

<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Element</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/shared.css">
</head>
<body>

<div class="container">
    <h2>Add Element</h2>

    <?php if ($source === 'product' && $role === 'admin'): ?>
        <form method="POST" action="<?= $dirname ?>/product/add">
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <label for="productName">Name</label>
            <input type="text" name="productName" id="productName" required>
            <div class="field-desc">The display name of your item</div>

            <label for="cost">Cost</label>
            <input type="number" step="0.01" name="cost" id="cost" required>
            <div class="field-desc">How much then item costs.</div>

            <label for="priceToSell">Sell Price</label>
            <input type="number" step="0.01" name="priceToSell" id="priceToSell" required>
            <div class="field-desc">How much the item will sell for</div>


            <label for="categoryId">Category ID</label>
            <input type="number" name="categoryId" id="categoryId" required oninput="updateCategoryName()">
            <div class="field-desc">
                Category name: <span id="categoryNameDisplay" style="font-weight: bold;">Unknown category</span>
            </div>

            <label for="threshold">Threshold</label>
            <input type="number" name="threshold" id="threshold" required>
            <div class="field-desc">Amount needed to be considered in stock.</div>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" required>
            <div class="field-desc">How much product is currently available.</div>

            <button type="submit">Add Product</button>

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

    <?php elseif ($source === 'category' && $role === 'admin'): ?>
        <form method="POST" action="<?= $dirname ?>/category/add">
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <label for="categoryName">Name</label>
            <input type="text" name="categoryName" id="categoryName" required>
            <div class="field-desc">The name of your category</div>

            <label for="categoryTax">Category Tax</label>
            <input type="number" step="0.01" name="categoryTax" id="categoryTax" required>
            <div class="field-desc">Taxes for this category (in decimal)</div>

            <button type="submit">Add Category</button>
        </form>
    <?php elseif ($source === 'report' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/report/add">
            <label for="earnings">Earnings</label>
            <input type="number" step="0.01" name="earnings" id="earnings" required>
            <div class="field-desc">How much you've earned</div>

            <label for="profits">Profits</label>
            <input type="number" step="0.01" name="profits" id="profits" required>
            <div class="field-desc">How much you've made</div>

            <label for="description">Description</label>
            <input type="text" name="description" id="description" required>
            <div class="field-desc">A little summary of the day</div>

            <button type="submit">Add Report</button>
        </form>
    <?php elseif ($source === 'supplier' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/supplier/add">
            <label for="supplierName">Supplier Name</label>
            <input type="text" name="supplierName" id="supplierName" required>
            <div class="field-desc">Name of the supplier</div>

            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" required>
            <div class="field-desc">E-mail of the supplier</div>

            <label for="phoneNum">Phone Number</label>
            <input type="text" name="phoneNum" id="phoneNum" required>
            <div class="field-desc">Phone Number of the supplier</div>

            <button type="submit">Add Supplier</button>
        </form>
    <?php elseif ($source === 'user' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/user/add">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <div class="field-desc">Username of the user</div>

            <label for="password">Password</label>
            <input type="text" name="password" id="password" required>
            <div class="field-desc">Password given to the user (can only be changed by said user)</div>

            <label>Role:</label>
            <select name="group_id" required>
                <?php foreach ($groups as $group): ?>
                    <option value="<?= $group->id ?>"><?= htmlspecialchars($group->name) ?></option>
                <?php endforeach; ?>
            </select><br>
            <div class="field-desc">Select the role of the user. (Depending on the role, they will have access to more or less features)</div>

            <button type="submit">Add User</button>
        </form>
    <?php elseif ($source === 'shift' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/shift/add">
            <label for="userId">Select User:</label>
            <select name="userId" id="userId" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->id ?>"><?= htmlspecialchars($user->username) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="field-desc">Username of the user</div>

            <label for="day">Select Day:</label>
            <select name="day" id="day" required>
                <?php
                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                foreach ($daysOfWeek as $day): ?>
                    <option value="<?= $day ?>"><?= $day ?></option>
                <?php endforeach; ?>
            </select>
            <div class="field-desc">Day of the week</div>

            <label for="startTime">Start Time:</label>
            <select name="startTime" id="startTime" required>
                <?php for ($hour = 9; $hour <= 22; $hour++): ?>
                    <option value="<?= sprintf('%02d:00:00', $hour) ?>"><?= sprintf('%02d:00', $hour) ?></option>
                <?php endfor; ?>
            </select>
            <div class="field-desc">Start time of the shift</div>

            <label for="endTime">End Time:</label>
            <select name="endTime" id="endTime" required>
                <?php for ($hour = 10; $hour <= 23; $hour++): ?>
                    <option value="<?= sprintf('%02d:00:00', $hour) ?>"><?= sprintf('%02d:00', $hour) ?></option>
                <?php endfor; ?>
            </select>
            <div class="field-desc">End time of the shift</div>
            <div id="timeError" style="color: red; font-size: 12px; display: none;">End time must be after start time!</div>
            <button type="submit">Add Shift</button>


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
</div>

</body>
</html>
