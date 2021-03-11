<?php

namespace PHPMaker2021\northwindapi;

// Table
$products = Container("products");
?>
<?php if ($products->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_productsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($products->ProductID->Visible) { // ProductID ?>
        <tr id="r_ProductID">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->ProductID->caption() ?></td>
            <td <?= $products->ProductID->cellAttributes() ?>>
<span id="el_products_ProductID">
<span<?= $products->ProductID->viewAttributes() ?>>
<?= $products->ProductID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->ProductName->Visible) { // ProductName ?>
        <tr id="r_ProductName">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->ProductName->caption() ?></td>
            <td <?= $products->ProductName->cellAttributes() ?>>
<span id="el_products_ProductName">
<span<?= $products->ProductName->viewAttributes() ?>>
<?= $products->ProductName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->SupplierID->Visible) { // SupplierID ?>
        <tr id="r_SupplierID">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->SupplierID->caption() ?></td>
            <td <?= $products->SupplierID->cellAttributes() ?>>
<span id="el_products_SupplierID">
<span<?= $products->SupplierID->viewAttributes() ?>>
<?= $products->SupplierID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->CategoryID->Visible) { // CategoryID ?>
        <tr id="r_CategoryID">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->CategoryID->caption() ?></td>
            <td <?= $products->CategoryID->cellAttributes() ?>>
<span id="el_products_CategoryID">
<span<?= $products->CategoryID->viewAttributes() ?>>
<?= $products->CategoryID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
        <tr id="r_QuantityPerUnit">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->QuantityPerUnit->caption() ?></td>
            <td <?= $products->QuantityPerUnit->cellAttributes() ?>>
<span id="el_products_QuantityPerUnit">
<span<?= $products->QuantityPerUnit->viewAttributes() ?>>
<?= $products->QuantityPerUnit->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->UnitPrice->Visible) { // UnitPrice ?>
        <tr id="r_UnitPrice">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->UnitPrice->caption() ?></td>
            <td <?= $products->UnitPrice->cellAttributes() ?>>
<span id="el_products_UnitPrice">
<span<?= $products->UnitPrice->viewAttributes() ?>>
<?= $products->UnitPrice->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->UnitsInStock->Visible) { // UnitsInStock ?>
        <tr id="r_UnitsInStock">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->UnitsInStock->caption() ?></td>
            <td <?= $products->UnitsInStock->cellAttributes() ?>>
<span id="el_products_UnitsInStock">
<span<?= $products->UnitsInStock->viewAttributes() ?>>
<?= $products->UnitsInStock->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
        <tr id="r_UnitsOnOrder">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->UnitsOnOrder->caption() ?></td>
            <td <?= $products->UnitsOnOrder->cellAttributes() ?>>
<span id="el_products_UnitsOnOrder">
<span<?= $products->UnitsOnOrder->viewAttributes() ?>>
<?= $products->UnitsOnOrder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->ReorderLevel->Visible) { // ReorderLevel ?>
        <tr id="r_ReorderLevel">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->ReorderLevel->caption() ?></td>
            <td <?= $products->ReorderLevel->cellAttributes() ?>>
<span id="el_products_ReorderLevel">
<span<?= $products->ReorderLevel->viewAttributes() ?>>
<?= $products->ReorderLevel->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($products->Discontinued->Visible) { // Discontinued ?>
        <tr id="r_Discontinued">
            <td class="<?= $products->TableLeftColumnClass ?>"><?= $products->Discontinued->caption() ?></td>
            <td <?= $products->Discontinued->cellAttributes() ?>>
<span id="el_products_Discontinued">
<span<?= $products->Discontinued->viewAttributes() ?>>
<?= $products->Discontinued->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
