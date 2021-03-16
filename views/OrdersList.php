<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrdersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forderslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    forderslist = currentForm = new ew.Form("forderslist", "list");
    forderslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("forderslist");
});
var forderslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    forderslistsrch = currentSearchForm = new ew.Form("forderslistsrch");

    // Dynamic selection lists

    // Filters
    forderslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("forderslistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="forderslistsrch" id="forderslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="forderslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="orders">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> orders">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="forderslist" id="forderslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
<div id="gmp_orders" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_orderslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->OrderID->Visible) { // OrderID ?>
        <th data-name="OrderID" class="<?= $Page->OrderID->headerCellClass() ?>"><div id="elh_orders_OrderID" class="orders_OrderID"><?= $Page->renderSort($Page->OrderID) ?></div></th>
<?php } ?>
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
        <th data-name="CustomerID" class="<?= $Page->CustomerID->headerCellClass() ?>"><div id="elh_orders_CustomerID" class="orders_CustomerID"><?= $Page->renderSort($Page->CustomerID) ?></div></th>
<?php } ?>
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <th data-name="EmployeeID" class="<?= $Page->EmployeeID->headerCellClass() ?>"><div id="elh_orders_EmployeeID" class="orders_EmployeeID"><?= $Page->renderSort($Page->EmployeeID) ?></div></th>
<?php } ?>
<?php if ($Page->OrderDate->Visible) { // OrderDate ?>
        <th data-name="OrderDate" class="<?= $Page->OrderDate->headerCellClass() ?>"><div id="elh_orders_OrderDate" class="orders_OrderDate"><?= $Page->renderSort($Page->OrderDate) ?></div></th>
<?php } ?>
<?php if ($Page->RequiredDate->Visible) { // RequiredDate ?>
        <th data-name="RequiredDate" class="<?= $Page->RequiredDate->headerCellClass() ?>"><div id="elh_orders_RequiredDate" class="orders_RequiredDate"><?= $Page->renderSort($Page->RequiredDate) ?></div></th>
<?php } ?>
<?php if ($Page->ShippedDate->Visible) { // ShippedDate ?>
        <th data-name="ShippedDate" class="<?= $Page->ShippedDate->headerCellClass() ?>"><div id="elh_orders_ShippedDate" class="orders_ShippedDate"><?= $Page->renderSort($Page->ShippedDate) ?></div></th>
<?php } ?>
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
        <th data-name="ShipperID" class="<?= $Page->ShipperID->headerCellClass() ?>"><div id="elh_orders_ShipperID" class="orders_ShipperID"><?= $Page->renderSort($Page->ShipperID) ?></div></th>
<?php } ?>
<?php if ($Page->Freight->Visible) { // Freight ?>
        <th data-name="Freight" class="<?= $Page->Freight->headerCellClass() ?>"><div id="elh_orders_Freight" class="orders_Freight"><?= $Page->renderSort($Page->Freight) ?></div></th>
<?php } ?>
<?php if ($Page->ShipName->Visible) { // ShipName ?>
        <th data-name="ShipName" class="<?= $Page->ShipName->headerCellClass() ?>"><div id="elh_orders_ShipName" class="orders_ShipName"><?= $Page->renderSort($Page->ShipName) ?></div></th>
<?php } ?>
<?php if ($Page->ShipAddress->Visible) { // ShipAddress ?>
        <th data-name="ShipAddress" class="<?= $Page->ShipAddress->headerCellClass() ?>"><div id="elh_orders_ShipAddress" class="orders_ShipAddress"><?= $Page->renderSort($Page->ShipAddress) ?></div></th>
<?php } ?>
<?php if ($Page->ShipCity->Visible) { // ShipCity ?>
        <th data-name="ShipCity" class="<?= $Page->ShipCity->headerCellClass() ?>"><div id="elh_orders_ShipCity" class="orders_ShipCity"><?= $Page->renderSort($Page->ShipCity) ?></div></th>
<?php } ?>
<?php if ($Page->ShipRegion->Visible) { // ShipRegion ?>
        <th data-name="ShipRegion" class="<?= $Page->ShipRegion->headerCellClass() ?>"><div id="elh_orders_ShipRegion" class="orders_ShipRegion"><?= $Page->renderSort($Page->ShipRegion) ?></div></th>
<?php } ?>
<?php if ($Page->ShipPostalCode->Visible) { // ShipPostalCode ?>
        <th data-name="ShipPostalCode" class="<?= $Page->ShipPostalCode->headerCellClass() ?>"><div id="elh_orders_ShipPostalCode" class="orders_ShipPostalCode"><?= $Page->renderSort($Page->ShipPostalCode) ?></div></th>
<?php } ?>
<?php if ($Page->ShipCountry->Visible) { // ShipCountry ?>
        <th data-name="ShipCountry" class="<?= $Page->ShipCountry->headerCellClass() ?>"><div id="elh_orders_ShipCountry" class="orders_ShipCountry"><?= $Page->renderSort($Page->ShipCountry) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_orders", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->OrderID->Visible) { // OrderID ?>
        <td data-name="OrderID" <?= $Page->OrderID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_OrderID">
<span<?= $Page->OrderID->viewAttributes() ?>>
<?= $Page->OrderID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CustomerID->Visible) { // CustomerID ?>
        <td data-name="CustomerID" <?= $Page->CustomerID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_CustomerID">
<span<?= $Page->CustomerID->viewAttributes() ?>>
<?= $Page->CustomerID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <td data-name="EmployeeID" <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_EmployeeID">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<?= $Page->EmployeeID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->OrderDate->Visible) { // OrderDate ?>
        <td data-name="OrderDate" <?= $Page->OrderDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_OrderDate">
<span<?= $Page->OrderDate->viewAttributes() ?>>
<?= $Page->OrderDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RequiredDate->Visible) { // RequiredDate ?>
        <td data-name="RequiredDate" <?= $Page->RequiredDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_RequiredDate">
<span<?= $Page->RequiredDate->viewAttributes() ?>>
<?= $Page->RequiredDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShippedDate->Visible) { // ShippedDate ?>
        <td data-name="ShippedDate" <?= $Page->ShippedDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShippedDate">
<span<?= $Page->ShippedDate->viewAttributes() ?>>
<?= $Page->ShippedDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShipperID->Visible) { // ShipperID ?>
        <td data-name="ShipperID" <?= $Page->ShipperID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipperID">
<span<?= $Page->ShipperID->viewAttributes() ?>>
<?= $Page->ShipperID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Freight->Visible) { // Freight ?>
        <td data-name="Freight" <?= $Page->Freight->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_Freight">
<span<?= $Page->Freight->viewAttributes() ?>>
<?= $Page->Freight->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShipName->Visible) { // ShipName ?>
        <td data-name="ShipName" <?= $Page->ShipName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipName">
<span<?= $Page->ShipName->viewAttributes() ?>>
<?= $Page->ShipName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShipAddress->Visible) { // ShipAddress ?>
        <td data-name="ShipAddress" <?= $Page->ShipAddress->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipAddress">
<span<?= $Page->ShipAddress->viewAttributes() ?>>
<?= $Page->ShipAddress->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShipCity->Visible) { // ShipCity ?>
        <td data-name="ShipCity" <?= $Page->ShipCity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipCity">
<span<?= $Page->ShipCity->viewAttributes() ?>>
<?= $Page->ShipCity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShipRegion->Visible) { // ShipRegion ?>
        <td data-name="ShipRegion" <?= $Page->ShipRegion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipRegion">
<span<?= $Page->ShipRegion->viewAttributes() ?>>
<?= $Page->ShipRegion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShipPostalCode->Visible) { // ShipPostalCode ?>
        <td data-name="ShipPostalCode" <?= $Page->ShipPostalCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipPostalCode">
<span<?= $Page->ShipPostalCode->viewAttributes() ?>>
<?= $Page->ShipPostalCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ShipCountry->Visible) { // ShipCountry ?>
        <td data-name="ShipCountry" <?= $Page->ShipCountry->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_orders_ShipCountry">
<span<?= $Page->ShipCountry->viewAttributes() ?>>
<?= $Page->ShipCountry->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
