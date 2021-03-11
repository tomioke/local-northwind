<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrderDetailsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forder_detailsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    forder_detailsview = currentForm = new ew.Form("forder_detailsview", "view");
    loadjs.done("forder_detailsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.order_details) ew.vars.tables.order_details = <?= JsonEncode(GetClientVar("tables", "order_details")) ?>;
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
<form name="forder_detailsview" id="forder_detailsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_details">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->order_detail_id->Visible) { // order_detail_id ?>
    <tr id="r_order_detail_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_details_order_detail_id"><?= $Page->order_detail_id->caption() ?></span></td>
        <td data-name="order_detail_id" <?= $Page->order_detail_id->cellAttributes() ?>>
<span id="el_order_details_order_detail_id">
<span<?= $Page->order_detail_id->viewAttributes() ?>>
<?= $Page->order_detail_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->OrderID->Visible) { // OrderID ?>
    <tr id="r_OrderID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_details_OrderID"><?= $Page->OrderID->caption() ?></span></td>
        <td data-name="OrderID" <?= $Page->OrderID->cellAttributes() ?>>
<span id="el_order_details_OrderID">
<span<?= $Page->OrderID->viewAttributes() ?>>
<?= $Page->OrderID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ProductID->Visible) { // ProductID ?>
    <tr id="r_ProductID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_details_ProductID"><?= $Page->ProductID->caption() ?></span></td>
        <td data-name="ProductID" <?= $Page->ProductID->cellAttributes() ?>>
<span id="el_order_details_ProductID">
<span<?= $Page->ProductID->viewAttributes() ?>>
<?= $Page->ProductID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
    <tr id="r_UnitPrice">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_details_UnitPrice"><?= $Page->UnitPrice->caption() ?></span></td>
        <td data-name="UnitPrice" <?= $Page->UnitPrice->cellAttributes() ?>>
<span id="el_order_details_UnitPrice">
<span<?= $Page->UnitPrice->viewAttributes() ?>>
<?= $Page->UnitPrice->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Quantity->Visible) { // Quantity ?>
    <tr id="r_Quantity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_details_Quantity"><?= $Page->Quantity->caption() ?></span></td>
        <td data-name="Quantity" <?= $Page->Quantity->cellAttributes() ?>>
<span id="el_order_details_Quantity">
<span<?= $Page->Quantity->viewAttributes() ?>>
<?= $Page->Quantity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Discount->Visible) { // Discount ?>
    <tr id="r_Discount">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_details_Discount"><?= $Page->Discount->caption() ?></span></td>
        <td data-name="Discount" <?= $Page->Discount->cellAttributes() ?>>
<span id="el_order_details_Discount">
<span<?= $Page->Discount->viewAttributes() ?>>
<?= $Page->Discount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
