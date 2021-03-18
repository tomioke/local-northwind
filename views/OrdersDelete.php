<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrdersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fordersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fordersdelete = currentForm = new ew.Form("fordersdelete", "delete");
    loadjs.done("fordersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.orders) ew.vars.tables.orders = <?= JsonEncode(GetClientVar("tables", "orders")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fordersdelete" id="fordersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
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
        <th class="<?= $Page->OrderID->headerCellClass() ?>"><span id="elh_orders_OrderID" class="orders_OrderID"><?= $Page->OrderID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
        <th class="<?= $Page->CustomerID->headerCellClass() ?>"><span id="elh_orders_CustomerID" class="orders_CustomerID"><?= $Page->CustomerID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <th class="<?= $Page->EmployeeID->headerCellClass() ?>"><span id="elh_orders_EmployeeID" class="orders_EmployeeID"><?= $Page->EmployeeID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->OrderDate->Visible) { // OrderDate ?>
        <th class="<?= $Page->OrderDate->headerCellClass() ?>"><span id="elh_orders_OrderDate" class="orders_OrderDate"><?= $Page->OrderDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RequiredDate->Visible) { // RequiredDate ?>
        <th class="<?= $Page->RequiredDate->headerCellClass() ?>"><span id="elh_orders_RequiredDate" class="orders_RequiredDate"><?= $Page->RequiredDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShippedDate->Visible) { // ShippedDate ?>
        <th class="<?= $Page->ShippedDate->headerCellClass() ?>"><span id="elh_orders_ShippedDate" class="orders_ShippedDate"><?= $Page->ShippedDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
        <th class="<?= $Page->ShipperID->headerCellClass() ?>"><span id="elh_orders_ShipperID" class="orders_ShipperID"><?= $Page->ShipperID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Freight->Visible) { // Freight ?>
        <th class="<?= $Page->Freight->headerCellClass() ?>"><span id="elh_orders_Freight" class="orders_Freight"><?= $Page->Freight->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShipName->Visible) { // ShipName ?>
        <th class="<?= $Page->ShipName->headerCellClass() ?>"><span id="elh_orders_ShipName" class="orders_ShipName"><?= $Page->ShipName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShipAddress->Visible) { // ShipAddress ?>
        <th class="<?= $Page->ShipAddress->headerCellClass() ?>"><span id="elh_orders_ShipAddress" class="orders_ShipAddress"><?= $Page->ShipAddress->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShipCity->Visible) { // ShipCity ?>
        <th class="<?= $Page->ShipCity->headerCellClass() ?>"><span id="elh_orders_ShipCity" class="orders_ShipCity"><?= $Page->ShipCity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShipRegion->Visible) { // ShipRegion ?>
        <th class="<?= $Page->ShipRegion->headerCellClass() ?>"><span id="elh_orders_ShipRegion" class="orders_ShipRegion"><?= $Page->ShipRegion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShipPostalCode->Visible) { // ShipPostalCode ?>
        <th class="<?= $Page->ShipPostalCode->headerCellClass() ?>"><span id="elh_orders_ShipPostalCode" class="orders_ShipPostalCode"><?= $Page->ShipPostalCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ShipCountry->Visible) { // ShipCountry ?>
        <th class="<?= $Page->ShipCountry->headerCellClass() ?>"><span id="elh_orders_ShipCountry" class="orders_ShipCountry"><?= $Page->ShipCountry->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_orders_OrderID" class="orders_OrderID">
<span<?= $Page->OrderID->viewAttributes() ?>><a class="btn btn-primary" target="_blank" href="../open_tbs/print_order.php?param1=<?php echo urlencode(CurrentPage()->OrderID->CurrentValue) ?>">CETAK</a>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
        <td <?= $Page->CustomerID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_CustomerID" class="orders_CustomerID">
<span<?= $Page->CustomerID->viewAttributes() ?>>
<?= $Page->CustomerID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <td <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_EmployeeID" class="orders_EmployeeID">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<?= $Page->EmployeeID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->OrderDate->Visible) { // OrderDate ?>
        <td <?= $Page->OrderDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_OrderDate" class="orders_OrderDate">
<span<?= $Page->OrderDate->viewAttributes() ?>>
<?= $Page->OrderDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RequiredDate->Visible) { // RequiredDate ?>
        <td <?= $Page->RequiredDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_RequiredDate" class="orders_RequiredDate">
<span<?= $Page->RequiredDate->viewAttributes() ?>>
<?= $Page->RequiredDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShippedDate->Visible) { // ShippedDate ?>
        <td <?= $Page->ShippedDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShippedDate" class="orders_ShippedDate">
<span<?= $Page->ShippedDate->viewAttributes() ?>>
<?= $Page->ShippedDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
        <td <?= $Page->ShipperID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipperID" class="orders_ShipperID">
<span<?= $Page->ShipperID->viewAttributes() ?>>
<?= $Page->ShipperID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Freight->Visible) { // Freight ?>
        <td <?= $Page->Freight->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_Freight" class="orders_Freight">
<span<?= $Page->Freight->viewAttributes() ?>>
<?= $Page->Freight->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShipName->Visible) { // ShipName ?>
        <td <?= $Page->ShipName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipName" class="orders_ShipName">
<span<?= $Page->ShipName->viewAttributes() ?>>
<?= $Page->ShipName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShipAddress->Visible) { // ShipAddress ?>
        <td <?= $Page->ShipAddress->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipAddress" class="orders_ShipAddress">
<span<?= $Page->ShipAddress->viewAttributes() ?>>
<?= $Page->ShipAddress->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShipCity->Visible) { // ShipCity ?>
        <td <?= $Page->ShipCity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipCity" class="orders_ShipCity">
<span<?= $Page->ShipCity->viewAttributes() ?>>
<?= $Page->ShipCity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShipRegion->Visible) { // ShipRegion ?>
        <td <?= $Page->ShipRegion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipRegion" class="orders_ShipRegion">
<span<?= $Page->ShipRegion->viewAttributes() ?>>
<?= $Page->ShipRegion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShipPostalCode->Visible) { // ShipPostalCode ?>
        <td <?= $Page->ShipPostalCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipPostalCode" class="orders_ShipPostalCode">
<span<?= $Page->ShipPostalCode->viewAttributes() ?>>
<?= $Page->ShipPostalCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ShipCountry->Visible) { // ShipCountry ?>
        <td <?= $Page->ShipCountry->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipCountry" class="orders_ShipCountry">
<span<?= $Page->ShipCountry->viewAttributes() ?>>
<?= $Page->ShipCountry->getViewValue() ?></span>
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
