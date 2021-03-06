<?php

namespace PHPMaker2021\northwindapi;

// Page object
$ProductsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fproductslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fproductslist = currentForm = new ew.Form("fproductslist", "list");
    fproductslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fproductslist");
});
var fproductslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fproductslistsrch = currentSearchForm = new ew.Form("fproductslistsrch");

    // Dynamic selection lists

    // Filters
    fproductslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fproductslistsrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "categories") {
    if ($Page->MasterRecordExists) {
        include_once "views/CategoriesMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fproductslistsrch" id="fproductslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fproductslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="products">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> products">
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
<form name="fproductslist" id="fproductslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="products">
<?php if ($Page->getCurrentMasterTable() == "categories" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="categories">
<input type="hidden" name="fk_CategoryID" value="<?= HtmlEncode($Page->CategoryID->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_products" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_productslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->CategoryID->Visible) { // CategoryID ?>
        <th data-name="CategoryID" class="<?= $Page->CategoryID->headerCellClass() ?>"><div id="elh_products_CategoryID" class="products_CategoryID"><?= $Page->renderSort($Page->CategoryID) ?></div></th>
<?php } ?>
<?php if ($Page->ProductID->Visible) { // ProductID ?>
        <th data-name="ProductID" class="<?= $Page->ProductID->headerCellClass() ?>"><div id="elh_products_ProductID" class="products_ProductID"><?= $Page->renderSort($Page->ProductID) ?></div></th>
<?php } ?>
<?php if ($Page->ProductName->Visible) { // ProductName ?>
        <th data-name="ProductName" class="<?= $Page->ProductName->headerCellClass() ?>"><div id="elh_products_ProductName" class="products_ProductName"><?= $Page->renderSort($Page->ProductName) ?></div></th>
<?php } ?>
<?php if ($Page->SupplierID->Visible) { // SupplierID ?>
        <th data-name="SupplierID" class="<?= $Page->SupplierID->headerCellClass() ?>"><div id="elh_products_SupplierID" class="products_SupplierID"><?= $Page->renderSort($Page->SupplierID) ?></div></th>
<?php } ?>
<?php if ($Page->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
        <th data-name="QuantityPerUnit" class="<?= $Page->QuantityPerUnit->headerCellClass() ?>"><div id="elh_products_QuantityPerUnit" class="products_QuantityPerUnit"><?= $Page->renderSort($Page->QuantityPerUnit) ?></div></th>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
        <th data-name="UnitPrice" class="<?= $Page->UnitPrice->headerCellClass() ?>"><div id="elh_products_UnitPrice" class="products_UnitPrice"><?= $Page->renderSort($Page->UnitPrice) ?></div></th>
<?php } ?>
<?php if ($Page->UnitsInStock->Visible) { // UnitsInStock ?>
        <th data-name="UnitsInStock" class="<?= $Page->UnitsInStock->headerCellClass() ?>"><div id="elh_products_UnitsInStock" class="products_UnitsInStock"><?= $Page->renderSort($Page->UnitsInStock) ?></div></th>
<?php } ?>
<?php if ($Page->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
        <th data-name="UnitsOnOrder" class="<?= $Page->UnitsOnOrder->headerCellClass() ?>"><div id="elh_products_UnitsOnOrder" class="products_UnitsOnOrder"><?= $Page->renderSort($Page->UnitsOnOrder) ?></div></th>
<?php } ?>
<?php if ($Page->ReorderLevel->Visible) { // ReorderLevel ?>
        <th data-name="ReorderLevel" class="<?= $Page->ReorderLevel->headerCellClass() ?>"><div id="elh_products_ReorderLevel" class="products_ReorderLevel"><?= $Page->renderSort($Page->ReorderLevel) ?></div></th>
<?php } ?>
<?php if ($Page->Discontinued->Visible) { // Discontinued ?>
        <th data-name="Discontinued" class="<?= $Page->Discontinued->headerCellClass() ?>"><div id="elh_products_Discontinued" class="products_Discontinued"><?= $Page->renderSort($Page->Discontinued) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_products", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->CategoryID->Visible) { // CategoryID ?>
        <td data-name="CategoryID" <?= $Page->CategoryID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_CategoryID">
<span<?= $Page->CategoryID->viewAttributes() ?>>
<?= $Page->CategoryID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ProductID->Visible) { // ProductID ?>
        <td data-name="ProductID" <?= $Page->ProductID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_ProductID">
<span<?= $Page->ProductID->viewAttributes() ?>>
<?= $Page->ProductID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ProductName->Visible) { // ProductName ?>
        <td data-name="ProductName" <?= $Page->ProductName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_ProductName">
<span<?= $Page->ProductName->viewAttributes() ?>>
<?= $Page->ProductName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SupplierID->Visible) { // SupplierID ?>
        <td data-name="SupplierID" <?= $Page->SupplierID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_SupplierID">
<span<?= $Page->SupplierID->viewAttributes() ?>>
<?= $Page->SupplierID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
        <td data-name="QuantityPerUnit" <?= $Page->QuantityPerUnit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_QuantityPerUnit">
<span<?= $Page->QuantityPerUnit->viewAttributes() ?>>
<?= $Page->QuantityPerUnit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
        <td data-name="UnitPrice" <?= $Page->UnitPrice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_UnitPrice">
<span<?= $Page->UnitPrice->viewAttributes() ?>>
<?= $Page->UnitPrice->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->UnitsInStock->Visible) { // UnitsInStock ?>
        <td data-name="UnitsInStock" <?= $Page->UnitsInStock->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_UnitsInStock">
<span<?= $Page->UnitsInStock->viewAttributes() ?>>
<?= $Page->UnitsInStock->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
        <td data-name="UnitsOnOrder" <?= $Page->UnitsOnOrder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_UnitsOnOrder">
<span<?= $Page->UnitsOnOrder->viewAttributes() ?>>
<?= $Page->UnitsOnOrder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ReorderLevel->Visible) { // ReorderLevel ?>
        <td data-name="ReorderLevel" <?= $Page->ReorderLevel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_ReorderLevel">
<span<?= $Page->ReorderLevel->viewAttributes() ?>>
<?= $Page->ReorderLevel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Discontinued->Visible) { // Discontinued ?>
        <td data-name="Discontinued" <?= $Page->Discontinued->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_products_Discontinued">
<span<?= $Page->Discontinued->viewAttributes() ?>>
<?= $Page->Discontinued->getViewValue() ?></span>
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
    ew.addEventHandlers("products");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
