<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrdersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fordersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fordersview = currentForm = new ew.Form("fordersview", "view");
    loadjs.done("fordersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.orders) ew.vars.tables.orders = <?= JsonEncode(GetClientVar("tables", "orders")) ?>;
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
<form name="fordersview" id="fordersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (!$Page->isExport()) { ?>
<div class="ew-multi-page">
<div class="ew-nav-tabs" id="Page"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navStyle() ?>">
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(1) ?>" href="#tab_orders1" data-toggle="tab"><?= $Page->pageCaption(1) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(2) ?>" href="#tab_orders2" data-toggle="tab"><?= $Page->pageCaption(2) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(3) ?>" href="#tab_orders3" data-toggle="tab"><?= $Page->pageCaption(3) ?></a></li>
    </ul>
    <div class="tab-content">
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(1) ?>" id="tab_orders1"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->OrderID->Visible) { // OrderID ?>
    <tr id="r_OrderID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_OrderID"><?= $Page->OrderID->caption() ?></span></td>
        <td data-name="OrderID" <?= $Page->OrderID->cellAttributes() ?>>
<span id="el_orders_OrderID" data-page="1">
<span<?= $Page->OrderID->viewAttributes() ?>>
<?= $Page->OrderID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
    <tr id="r_CustomerID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_CustomerID"><?= $Page->CustomerID->caption() ?></span></td>
        <td data-name="CustomerID" <?= $Page->CustomerID->cellAttributes() ?>>
<span id="el_orders_CustomerID" data-page="1">
<span<?= $Page->CustomerID->viewAttributes() ?>>
<?= $Page->CustomerID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
    <tr id="r_EmployeeID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_EmployeeID"><?= $Page->EmployeeID->caption() ?></span></td>
        <td data-name="EmployeeID" <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el_orders_EmployeeID" data-page="1">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<?= $Page->EmployeeID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(2) ?>" id="tab_orders2"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->OrderDate->Visible) { // OrderDate ?>
    <tr id="r_OrderDate">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_OrderDate"><?= $Page->OrderDate->caption() ?></span></td>
        <td data-name="OrderDate" <?= $Page->OrderDate->cellAttributes() ?>>
<span id="el_orders_OrderDate" data-page="2">
<span<?= $Page->OrderDate->viewAttributes() ?>>
<?= $Page->OrderDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RequiredDate->Visible) { // RequiredDate ?>
    <tr id="r_RequiredDate">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_RequiredDate"><?= $Page->RequiredDate->caption() ?></span></td>
        <td data-name="RequiredDate" <?= $Page->RequiredDate->cellAttributes() ?>>
<span id="el_orders_RequiredDate" data-page="2">
<span<?= $Page->RequiredDate->viewAttributes() ?>>
<?= $Page->RequiredDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ShippedDate->Visible) { // ShippedDate ?>
    <tr id="r_ShippedDate">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShippedDate"><?= $Page->ShippedDate->caption() ?></span></td>
        <td data-name="ShippedDate" <?= $Page->ShippedDate->cellAttributes() ?>>
<span id="el_orders_ShippedDate" data-page="2">
<span<?= $Page->ShippedDate->viewAttributes() ?>>
<?= $Page->ShippedDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(3) ?>" id="tab_orders3"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
    <tr id="r_ShipperID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShipperID"><?= $Page->ShipperID->caption() ?></span></td>
        <td data-name="ShipperID" <?= $Page->ShipperID->cellAttributes() ?>>
<span id="el_orders_ShipperID" data-page="3">
<span<?= $Page->ShipperID->viewAttributes() ?>>
<?= $Page->ShipperID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Freight->Visible) { // Freight ?>
    <tr id="r_Freight">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_Freight"><?= $Page->Freight->caption() ?></span></td>
        <td data-name="Freight" <?= $Page->Freight->cellAttributes() ?>>
<span id="el_orders_Freight" data-page="3">
<span<?= $Page->Freight->viewAttributes() ?>>
<?= $Page->Freight->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ShipName->Visible) { // ShipName ?>
    <tr id="r_ShipName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShipName"><?= $Page->ShipName->caption() ?></span></td>
        <td data-name="ShipName" <?= $Page->ShipName->cellAttributes() ?>>
<span id="el_orders_ShipName" data-page="3">
<span<?= $Page->ShipName->viewAttributes() ?>>
<?= $Page->ShipName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ShipAddress->Visible) { // ShipAddress ?>
    <tr id="r_ShipAddress">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShipAddress"><?= $Page->ShipAddress->caption() ?></span></td>
        <td data-name="ShipAddress" <?= $Page->ShipAddress->cellAttributes() ?>>
<span id="el_orders_ShipAddress" data-page="3">
<span<?= $Page->ShipAddress->viewAttributes() ?>>
<?= $Page->ShipAddress->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ShipCity->Visible) { // ShipCity ?>
    <tr id="r_ShipCity">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShipCity"><?= $Page->ShipCity->caption() ?></span></td>
        <td data-name="ShipCity" <?= $Page->ShipCity->cellAttributes() ?>>
<span id="el_orders_ShipCity" data-page="3">
<span<?= $Page->ShipCity->viewAttributes() ?>>
<?= $Page->ShipCity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ShipRegion->Visible) { // ShipRegion ?>
    <tr id="r_ShipRegion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShipRegion"><?= $Page->ShipRegion->caption() ?></span></td>
        <td data-name="ShipRegion" <?= $Page->ShipRegion->cellAttributes() ?>>
<span id="el_orders_ShipRegion" data-page="3">
<span<?= $Page->ShipRegion->viewAttributes() ?>>
<?= $Page->ShipRegion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ShipPostalCode->Visible) { // ShipPostalCode ?>
    <tr id="r_ShipPostalCode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShipPostalCode"><?= $Page->ShipPostalCode->caption() ?></span></td>
        <td data-name="ShipPostalCode" <?= $Page->ShipPostalCode->cellAttributes() ?>>
<span id="el_orders_ShipPostalCode" data-page="3">
<span<?= $Page->ShipPostalCode->viewAttributes() ?>>
<?= $Page->ShipPostalCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ShipCountry->Visible) { // ShipCountry ?>
    <tr id="r_ShipCountry">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_orders_ShipCountry"><?= $Page->ShipCountry->caption() ?></span></td>
        <td data-name="ShipCountry" <?= $Page->ShipCountry->cellAttributes() ?>>
<span id="el_orders_ShipCountry" data-page="3">
<span<?= $Page->ShipCountry->viewAttributes() ?>>
<?= $Page->ShipCountry->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
    </div>
</div>
</div>
<?php } ?>
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
