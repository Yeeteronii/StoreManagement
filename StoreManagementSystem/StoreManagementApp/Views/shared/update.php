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
    <title><?=UPDATEELEMENT?></title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/shared.css">
</head>
<body>

<div class="container">
    <h2><?=UPDATEELEMENT?></h2>

    <?php if ($source === 'product'): ?>
        <form method="POST" action="<?= $dirname ?>/product/update/<?= $product->productId ?>">
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <label for="productName"><?=NAME?></label>
            <input type="text" name="productName" id="productName" value="<?= htmlspecialchars($product->productName) ?>" required>
            <div class="field-desc"><?=THEDISPLAYNAMEOFYOURITEM?></div>

            <label for="cost"><?=COST?></label>
            <input type="number" step="0.01" name="cost" id="cost" value="<?= $product->cost ?>" required>
            <div class="field-desc"><?=HOWMUCHTHEITEMCOSTS?></div>

            <label for="priceToSell"><?=SELLPRICE?></label>
            <input type="number" step="0.01" name="priceToSell" id="priceToSell" value="<?= $product->priceToSell ?>" required>
            <div class="field-desc"><?=HOWMUCHITEMSELLFOR?></div>

            <label for="categoryId"><?=CATEGORYID?></label>
            <input type="number" name="categoryId" id="categoryId" value="<?= $product->categoryId ?>" required oninput="updateCategoryName()">
            <div class="field-desc">
                <?=CATEGORYNAME?> <span id="categoryNameDisplay" style="font-weight: bold;"><?=UNKNOWNCATEGORY?></span>
            </div>


            <label for="threshold"><?=THRESHOLD?></label>
            <input type="number" name="threshold" id="threshold" value="<?= $product->threshold ?>" required>
            <div class="field-desc"><?=AMOUNTNEEDEDFORSTOCK?></div>

            <label for="quantity"><?=QUANTITY?></label>
            <input type="number" name="quantity" id="quantity" value="<?= $product->quantity ?>" required>
            <div class="field-desc"><?=QUANTITYTOOLTIP?></div>

            <button type="submit"><?=UPDATEPRODUCT?></button>

            <script>
                const categoryMap = {
                    <?php foreach ($categories as $category): ?>
                    <?= $category->categoryId ?>: "<?= htmlspecialchars($category->categoryName) ?>"
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
            <form method="POST" action="<?= $dirname ?>/category/update/<?= $category->categoryId ?>">
                <?php if (!empty($error)): ?>
                    <div class="add-error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <label for="categoryName"><?=NAME?></label>
                <input type="text" id="categoryName" name="categoryName" value="<?= htmlspecialchars($category->categoryName) ?>" required>
                <div class="field-desc"><?=NAMETOOLTIP?></div>

                <label for="categoryTax"><?=CATEGORYTAX?></label>
                <input type="number" step="0.01" name="categoryTax" id="categoryTax" value="<?= $category->categoryTax ?>" required>
                <div class="field-desc"><?=CATEGORYTAXTOOLTIP?></div>

                <button type="submit"><?=UPDATECATEGORY?></button>
            </form>
        <?php elseif ($source === 'report'): ?>
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?= $dirname ?>/report/update/<?= $report->reportId ?>">
                <label for="earnings"><?=EARNINGS?></label>
                <input type="number" step="0.01" name="earnings" id="earnings" value="<?= $report->earnings ?>" required>
                <div class="field-desc"><?=EARNINGTOOLTIP?></div>

                <label for="profits"><?=PROFITS?></label>
                <input type="number" step="0.01" name="profits" id="profits" value="<?= $report->profits ?>" required>
                <div class="field-desc"><?=PROFITTOOLTIP?></div>

                <label for="description"><?=DESCRIPTION?></label>
                <input type="text" name="description" id="description" value="<?= $report->description ?>" required>
                <div class="field-desc"><?=DESCRIPTIONTOOLTIP?></div>

                <button type="submit"><?=UPDATEREPORT?></button>
            </form>
        <?php elseif ($source === 'supplier'): ?>
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?= $dirname ?>/supplier/update/<?= $supplier->supplierId ?>">
                <label for="supplierName"><?=SUPPLIERNAME?></label>
                <input type="text" name="supplierName" id="supplierName" value="<?= $supplier->supplierName ?>" required>
                <div class="field-desc"><?=SUPPLIERNAMETOOLTIP?></div>

                <label for="email"><?=EMAIL?></label>
                <input type="text" name="email" id="email" value="<?= $supplier->email ?>" required>
                <div class="field-desc"><?=EMAILTOOLTIP?></div>

                <label for="phoneNum"><?=PHONENUMBER?></label>
                <input type="text" name="phoneNum" id="phoneNum" value="<?= $supplier->phoneNum ?>" required>
                <div class="field-desc"><?=PHONENUMBERTOOLTIP?></div>

                <button type="submit"><?=UPDATESUPPLIER?></button>
            </form>
        <?php elseif ($source === 'user'): ?>
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?= $dirname ?>/user/update/<?= $user->id ?>">
                <label for="username"><?=USERNAME?></label>
                <input type="text" name="username" id="username" value="<?= $user->username ?>" required>
                <div class="field-desc"><?=USERNAMETOOLTIP?></div>

                <label for="password"><?=PASSWORD?></label>
                <input type="text" name="password" id="password" value="<?= $user->password ?>"  disabled>
                <div class="field-desc"><?=PASSWORDTOOLTIP?></div>

                <label><?=ROLE?></label>
                <?php if ($canChangeRole): ?>
                    <select name="role">
                        <option value="admin" <?= ($user->role == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="employee" <?= ($user->role == 'employee') ? 'selected' : '' ?>>Employee</option>
                    </select>
                <?php else: ?>
                    <input type="text" value="<?= htmlspecialchars($user->role) ?>" readonly>
                    <input type="hidden" name="role" value="<?= htmlspecialchars($user->role) ?>">
                <?php endif; ?>
                <div class="field-desc"><?=ROLETOOLTIP?></div>

                <button type="submit"><?=UPDATEUSER?></button>
            </form>
        <?php elseif ($source === 'shift'): ?>
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?= $dirname ?>/shift/update/<?= $shift->shiftId ?>">
                <label for="userId"><?=SELECTUSER?></label>
                <select name="userId" id="userId" required>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user->id ?>" <?= $user->id == $shift->userId ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user->username) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="field-desc"><?=USERNAMETOOLTIP?></div>

                <label for="day"><?=SELECTDAY?></label>
                <select name="day" id="day" required>
                    <?php
                    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    foreach ($daysOfWeek as $day): ?>
                        <option value="<?= $day ?>" <?= $day === $shift->day ? 'selected' : '' ?>><?= $day ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="field-desc"><?=DAYOFTHEWEEK?></div>

                <label for="startTime"><?=STARTTIME?></label>
                <select name="startTime" id="startTime" required>
                    <?php for ($hour = 9; $hour <= 22; $hour++): ?>
                        <?php $value = sprintf('%02d:00:00', $hour); ?>
                        <option value="<?= $value ?>" <?= $value === $shift->startTime ? 'selected' : '' ?>>
                            <?= sprintf('%02d:00', $hour) ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <div class="field-desc"><?=STARTTIMETOOLTIP?></div>

                <label for="endTime"><?=ENDTIME?></label>
                <select name="endTime" id="endTime" required>
                    <?php for ($hour = 10; $hour <= 23; $hour++): ?>
                        <?php $value = sprintf('%02d:00:00', $hour); ?>
                        <option value="<?= $value ?>" <?= $value === $shift->endTime ? 'selected' : '' ?>>
                            <?= sprintf('%02d:00', $hour) ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <div class="field-desc"><?=ENDTIMETOOLTIP?></div>
                <div id="timeError" style="color: red; font-size: 12px; display: none;"><?=ENDTIMEERROR?></div>

                <button type="submit"><?=UPDATESHIFT?></button>

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
