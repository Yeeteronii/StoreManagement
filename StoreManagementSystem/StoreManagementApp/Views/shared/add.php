<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$role = $_SESSION['role'];
$dirname = dirname($_SERVER['SCRIPT_NAME']);
$source = strtolower($_GET['controller'] ?? 'unknown');
?>

<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title><?=ADDTITLE?></title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/shared.css">
</head>
<body>

<div class="container">
    <h2><?=ADDTITLE?></h2>

    <?php if ($source === 'product' && $role === 'admin'): ?>
        <form method="POST" action="<?= $dirname ?>/product/add">
            <?php if (!empty($error)): ?>
                <div class="add-error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <label for="productName"><?=NAME?></label>
            <input type="text" name="productName" id="productName" required>
            <div class="field-desc"><?=NAMEDESCRIPTION?></div>

            <label for="cost"><?=COST?></label>
            <input type="number" step="0.01" name="cost" id="cost" required>
            <div class="field-desc"><?=COSTDESCRIPTION?></div>

            <label for="priceToSell"><?=SELLPRICE?></label>
            <input type="number" step="0.01" name="priceToSell" id="priceToSell" required>
            <div class="field-desc"><?=SELLPRICEDESCRIPTION?></div>


            <label for="categoryId"><?=CATEGORYID?></label>
            <input type="number" name="categoryId" id="categoryId" required oninput="updateCategoryName()">
            <div class="field-desc">
                <?=CATEGORYNAME?> : <span id="categoryNameDisplay" style="font-weight: bold;"><?=CATEGORYDESCRIPTION?></span>
            </div>

            <label for="threshold"><?=THRESHOLD?></label>
            <input type="number" name="threshold" id="threshold" required>
            <div class="field-desc"><?=THRESHOLDDESCRIPTION?></div>

            <label for="quantity"><?=QUANTITY?></label>
            <input type="number" name="quantity" id="quantity" required>
            <div class="field-desc"><?=QUANTITYDESCRIPTION?></div>

            <button type="submit"><?=ADDPRODUCT?></button>

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
                        nameDisplay.textContent = "<?=CATEGORYDESCRIPTION?>";
                    } else {
                        nameDisplay.textContent = "<?=INVALID?>";
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
            <label for="categoryName"><?=NAME?></label>
            <input type="text" name="categoryName" id="categoryName" required>
            <div class="field-desc"><?=NAMETOOLTIP?></div>

            <label for="categoryTax"><?=CATEGORYTAX?></label>
            <input type="number" step="0.01" name="categoryTax" id="categoryTax" required>
            <div class="field-desc"><?=CATEGORYTAXTOOLTIP?></div>

            <button type="submit"><?=ADDCATEGORY?></button>
        </form>
    <?php elseif ($source === 'report' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/report/add">
            <label for="earnings"><?=EARNINGS?></label>
            <input type="number" step="0.01" name="earnings" id="earnings" required>
            <div class="field-desc"><?=EARNINGSDESCRIPTION?></div>

            <label for="profits"><?=PROFITS?></label>
            <input type="number" step="0.01" name="profits" id="profits" required>
            <div class="field-desc"><?=PROFITSDESCRIPTION?></div>

            <label for="description"><?=DESCRIPTION?></label>
            <input type="text" name="description" id="description" required>
            <div class="field-desc"><?=DESCRIPTIONDESCRIPTION?></div>

            <button type="submit"><?=ADDREPORT?></button>
        </form>
    <?php elseif ($source === 'supplier' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/supplier/add">
            <label for="supplierName"><?=SUPPLIERNAME?></label>
            <input type="text" name="supplierName" id="supplierName" required>
            <div class="field-desc"><?=SUPPLIERNAMEDESCRIPTION?></div>

            <label for="email"><?=EMAIL?></label>
            <input type="text" name="email" id="email" required>
            <div class="field-desc"><?=EMAILDESCRIPTION?></div>

            <label for="phoneNum"><?=PHONENUMBER?></label>
            <input type="text" name="phoneNum" id="phoneNum" required>
            <div class="field-desc"><?=PHONENUMBERDESCRIPTION?></div>

            <button type="submit"><?=ADDSUPPLIER?></button>
        </form>
    <?php elseif ($source === 'user' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/user/add">
            <label for="username"><?=USERNAME?></label>
            <input type="text" name="username" id="username" required>
            <div class="field-desc"><?=USERNAMEDESCRIPTION?></div>

            <label for="password"><?=PASSWORD?></label>
            <input type="text" name="password" id="password" required>
            <div class="field-desc"><?=PASSWORDDESCRIPTION?></div>

            <label><?=ROLE?></label>
            <select name="group_id" required>
                <?php foreach ($groups as $group): ?>
                    <option value="<?= $group->id ?>"><?= htmlspecialchars($group->name) ?></option>
                <?php endforeach; ?>
            </select><br>
            <div class="field-desc"><?=ROLEDESCRIPTION?></div>

            <button type="submit"><?=ADDUSER?></button>
        </form>
    <?php elseif ($source === 'shift' && $role === 'admin'): ?>
        <?php if (!empty($error)): ?>
            <div class="add-error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/shift/add">
            <label for="userId"><?=SELECTUSER?></label>
            <select name="userId" id="userId" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->id ?>"><?= htmlspecialchars($user->username) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="field-desc"><?=USERNAMETOOLTIP?></div>

            <label for="day"><?=SELECTDAY?></label>
            <select name="day" id="day" required>
                <?php
                $daysOfWeek = [
                    'Monday' => 'Lundi',
                    'Tuesday' => 'Mardi',
                    'Wednesday' => 'Mercredi',
                    'Thursday' => 'Jeudi',
                    'Friday' => 'Vendredi',
                    'Saturday' => 'Samedi',
                    'Sunday' => 'Dimanche'
                ];
                foreach ($daysOfWeek as $value => $label): ?>
                    <option value="<?= $value ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <div class="field-desc"><?=DAYOFTHEWEEK?></div>

            <label for="startTime"><?=STARTTIME?></label>
            <select name="startTime" id="startTime" required>
                <?php for ($hour = 9; $hour <= 22; $hour++): ?>
                    <option value="<?= sprintf('%02d:00:00', $hour) ?>"><?= sprintf('%02d:00', $hour) ?></option>
                <?php endfor; ?>
            </select>
            <div class="field-desc"><?=STARTTIMETOOLTIP?></div>

            <label for="endTime"><?=ENDTIME?></label>
            <select name="endTime" id="endTime" required>
                <?php for ($hour = 10; $hour <= 23; $hour++): ?>
                    <option value="<?= sprintf('%02d:00:00', $hour) ?>"><?= sprintf('%02d:00', $hour) ?></option>
                <?php endfor; ?>
            </select>
            <div class="field-desc"><?=ENDTIMETOOLTIP?></div>
            <div id="timeError" style="color: red; font-size: 12px; display: none;"><?=ENDTIMEERROR?></div>
            <button type="submit"><?=ADDSHIFT?></button>


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
