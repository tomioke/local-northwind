<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrderDetailsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var forder_detailsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    forder_detailsdelete = currentForm = new ew.Form("forder_detailsdelete", "delete");
    loadjs.done("forder_detailsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.order_details) ew.vars.tables.order_details = <?= JsonEncode(GetClientVar("tables", "order_details")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="forder_detailsdelete" id="forder_detailsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_details">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->OrderID->Visible) { // OrderID ?>
        <th class="<?= $Page->OrderID->headerCellClass() ?>"><span id="elh_order_details_OrderID" class="order_details_OrderID"><?= $Page->OrderID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ProductID->Visible) { // ProductID ?>
        <th class="<?= $Page->ProductID->headerCellClass() ?>"><span id="elh_order_details_ProductID" class="order_details_ProductID"><?= $Page->ProductID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
        <th class="<?= $Page->UnitPrice->headerCellClass() ?>"><span id="elh_order_details_UnitPrice" class="order_details_UnitPrice"><?= $Page->UnitPrice->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Quantity->Visible) { // Quantity ?>
        <th class="<?= $Page->Quantity->headerCellClass() ?>"><span id="elh_order_details_Quantity" class="order_details_Quantity"><?= $Page->Quantity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Discount->Visible) { // Discount ?>
        <th class="<?= $Page->Discount->headerCellClass() ?>"><span id="elh_order_details_Discount" class="order_details_Discount"><?= $Page->Discount->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->OrderID->Visible) { // OrderID ?>
        <td <?= $Page->OrderID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_details_OrderID" class="order_details_OrderID">
<span<?= $Page->OrderID->viewAttributes() ?>>
<?= $Page->OrderID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ProductID->Visible) { // ProductID ?>
        <td <?= $Page->ProductID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_details_ProductID" class="order_details_ProductID">
<span<?= $Page->ProductID->viewAttributes() ?>>
<?= $Page->ProductID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
        <td <?= $Page->UnitPrice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_details_UnitPrice" class="order_details_UnitPrice">
<span<?= $Page->UnitPrice->viewAttributes() ?>>
<?= $Page->UnitPrice->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Quantity->Visible) { // Quantity ?>
        <td <?= $Page->Quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_details_Quantity" class="order_details_Quantity">
<span<?= $Page->Quantity->viewAttributes() ?>>
<?= $Page->Quantity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Discount->Visible) { // Discount ?>
        <td <?= $Page->Discount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_details_Discount" class="order_details_Discount">
<span<?= $Page->Discount->viewAttributes() ?>>
<?= $Page->Discount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
