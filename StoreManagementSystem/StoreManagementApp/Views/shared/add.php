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
    <title>Add Element</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/add.css">
</head>
<body>

<div class="container">
    <h2>Add Element</h2>

    <?php if ($source === 'product' && $role === 'admin'): ?>
        <form method="POST" action="../product/shared/add">
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
        <form method="POST" action="../category/shared/add">
            <label for="categoryName">Name</label>
            <input type="text" name="categoryName" id="categoryName" required>
            <div class="field-desc">The name of your category</div>

            <label for="categoryTax">Category Tax</label>
            <input type="number" step="0.01" name="categoryTax" id="categoryTax" required>
            <div class="field-desc">Taxes for this category (in decimal)</div>

            <button type="submit">Add Category</button>
        </form>
    <?php elseif ($source === 'report' && $role === 'admin'): ?>
        <form method="POST" action="../report/shared/add">
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
        <form method="POST" action="../supplier/shared/add">
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
        <form method="POST" action="../user/shared/add">
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
    <?php endif; ?>
</div>

</body>
</html>
