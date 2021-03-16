<?php

namespace PHPMaker2021\northwindapi;

// Page object
$ProductsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fproductsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fproductsview = currentForm = new ew.Form("fproductsview", "view");
    loadjs.done("fproductsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.products) ew.vars.tables.products = <?= JsonEncode(GetClientVar("tables", "products")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fproductsview" id="fproductsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="products">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CategoryID->Visible) { // CategoryID ?>
    <tr id="r_CategoryID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_CategoryID"><?= $Page->CategoryID->caption() ?></span></td>
        <td data-name="CategoryID" <?= $Page->CategoryID->cellAttributes() ?>>
<span id="el_products_CategoryID">
<span<?= $Page->CategoryID->viewAttributes() ?>>
<?= $Page->CategoryID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ProductID->Visible) { // ProductID ?>
    <tr id="r_ProductID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_ProductID"><?= $Page->ProductID->caption() ?></span></td>
        <td data-name="ProductID" <?= $Page->ProductID->cellAttributes() ?>>
<span id="el_products_ProductID">
<span<?= $Page->ProductID->viewAttributes() ?>>
<?= $Page->ProductID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ProductName->Visible) { // ProductName ?>
    <tr id="r_ProductName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_ProductName"><?= $Page->ProductName->caption() ?></span></td>
        <td data-name="ProductName" <?= $Page->ProductName->cellAttributes() ?>>
<span id="el_products_ProductName">
<span<?= $Page->ProductName->viewAttributes() ?>>
<?= $Page->ProductName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SupplierID->Visible) { // SupplierID ?>
    <tr id="r_SupplierID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_SupplierID"><?= $Page->SupplierID->caption() ?></span></td>
        <td data-name="SupplierID" <?= $Page->SupplierID->cellAttributes() ?>>
<span id="el_products_SupplierID">
<span<?= $Page->SupplierID->viewAttributes() ?>>
<?= $Page->SupplierID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
    <tr id="r_QuantityPerUnit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_QuantityPerUnit"><?= $Page->QuantityPerUnit->caption() ?></span></td>
        <td data-name="QuantityPerUnit" <?= $Page->QuantityPerUnit->cellAttributes() ?>>
<span id="el_products_QuantityPerUnit">
<span<?= $Page->QuantityPerUnit->viewAttributes() ?>>
<?= $Page->QuantityPerUnit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
    <tr id="r_UnitPrice">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_UnitPrice"><?= $Page->UnitPrice->caption() ?></span></td>
        <td data-name="UnitPrice" <?= $Page->UnitPrice->cellAttributes() ?>>
<span id="el_products_UnitPrice">
<span<?= $Page->UnitPrice->viewAttributes() ?>>
<?= $Page->UnitPrice->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UnitsInStock->Visible) { // UnitsInStock ?>
    <tr id="r_UnitsInStock">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_UnitsInStock"><?= $Page->UnitsInStock->caption() ?></span></td>
        <td data-name="UnitsInStock" <?= $Page->UnitsInStock->cellAttributes() ?>>
<span id="el_products_UnitsInStock">
<span<?= $Page->UnitsInStock->viewAttributes() ?>>
<?= $Page->UnitsInStock->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
    <tr id="r_UnitsOnOrder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_UnitsOnOrder"><?= $Page->UnitsOnOrder->caption() ?></span></td>
        <td data-name="UnitsOnOrder" <?= $Page->UnitsOnOrder->cellAttributes() ?>>
<span id="el_products_UnitsOnOrder">
<span<?= $Page->UnitsOnOrder->viewAttributes() ?>>
<?= $Page->UnitsOnOrder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ReorderLevel->Visible) { // ReorderLevel ?>
    <tr id="r_ReorderLevel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_ReorderLevel"><?= $Page->ReorderLevel->caption() ?></span></td>
        <td data-name="ReorderLevel" <?= $Page->ReorderLevel->cellAttributes() ?>>
<span id="el_products_ReorderLevel">
<span<?= $Page->ReorderLevel->viewAttributes() ?>>
<?= $Page->ReorderLevel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Discontinued->Visible) { // Discontinued ?>
    <tr id="r_Discontinued">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_products_Discontinued"><?= $Page->Discontinued->caption() ?></span></td>
        <td data-name="Discontinued" <?= $Page->Discontinued->cellAttributes() ?>>
<span id="el_products_Discontinued">
<span<?= $Page->Discontinued->viewAttributes() ?>>
<?= $Page->Discontinued->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("order_details", explode(",", $Page->getCurrentDetailTable())) && $order_details->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("order_details", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "OrderDetailsGrid.php" ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
