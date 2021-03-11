<?php

namespace PHPMaker2021\northwindapi;

// Page object
$SuppliersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsupplierslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsupplierslist = currentForm = new ew.Form("fsupplierslist", "list");
    fsupplierslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fsupplierslist");
});
var fsupplierslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fsupplierslistsrch = currentSearchForm = new ew.Form("fsupplierslistsrch");

    // Dynamic selection lists

    // Filters
    fsupplierslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fsupplierslistsrch");
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
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fsupplierslistsrch" id="fsupplierslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fsupplierslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="suppliers">
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> suppliers">
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
<form name="fsupplierslist" id="fsupplierslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="suppliers">
<div id="gmp_suppliers" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_supplierslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->SupplierID->Visible) { // SupplierID ?>
        <th data-name="SupplierID" class="<?= $Page->SupplierID->headerCellClass() ?>"><div id="elh_suppliers_SupplierID" class="suppliers_SupplierID"><?= $Page->renderSort($Page->SupplierID) ?></div></th>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
        <th data-name="CompanyName" class="<?= $Page->CompanyName->headerCellClass() ?>"><div id="elh_suppliers_CompanyName" class="suppliers_CompanyName"><?= $Page->renderSort($Page->CompanyName) ?></div></th>
<?php } ?>
<?php if ($Page->ContactName->Visible) { // ContactName ?>
        <th data-name="ContactName" class="<?= $Page->ContactName->headerCellClass() ?>"><div id="elh_suppliers_ContactName" class="suppliers_ContactName"><?= $Page->renderSort($Page->ContactName) ?></div></th>
<?php } ?>
<?php if ($Page->ContactTitle->Visible) { // ContactTitle ?>
        <th data-name="ContactTitle" class="<?= $Page->ContactTitle->headerCellClass() ?>"><div id="elh_suppliers_ContactTitle" class="suppliers_ContactTitle"><?= $Page->renderSort($Page->ContactTitle) ?></div></th>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <th data-name="Address" class="<?= $Page->Address->headerCellClass() ?>"><div id="elh_suppliers_Address" class="suppliers_Address"><?= $Page->renderSort($Page->Address) ?></div></th>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
        <th data-name="City" class="<?= $Page->City->headerCellClass() ?>"><div id="elh_suppliers_City" class="suppliers_City"><?= $Page->renderSort($Page->City) ?></div></th>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
        <th data-name="Region" class="<?= $Page->Region->headerCellClass() ?>"><div id="elh_suppliers_Region" class="suppliers_Region"><?= $Page->renderSort($Page->Region) ?></div></th>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <th data-name="PostalCode" class="<?= $Page->PostalCode->headerCellClass() ?>"><div id="elh_suppliers_PostalCode" class="suppliers_PostalCode"><?= $Page->renderSort($Page->PostalCode) ?></div></th>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
        <th data-name="Country" class="<?= $Page->Country->headerCellClass() ?>"><div id="elh_suppliers_Country" class="suppliers_Country"><?= $Page->renderSort($Page->Country) ?></div></th>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
        <th data-name="Phone" class="<?= $Page->Phone->headerCellClass() ?>"><div id="elh_suppliers_Phone" class="suppliers_Phone"><?= $Page->renderSort($Page->Phone) ?></div></th>
<?php } ?>
<?php if ($Page->Fax->Visible) { // Fax ?>
        <th data-name="Fax" class="<?= $Page->Fax->headerCellClass() ?>"><div id="elh_suppliers_Fax" class="suppliers_Fax"><?= $Page->renderSort($Page->Fax) ?></div></th>
<?php } ?>
<?php if ($Page->HomePage->Visible) { // HomePage ?>
        <th data-name="HomePage" class="<?= $Page->HomePage->headerCellClass() ?>"><div id="elh_suppliers_HomePage" class="suppliers_HomePage"><?= $Page->renderSort($Page->HomePage) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_suppliers", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->SupplierID->Visible) { // SupplierID ?>
        <td data-name="SupplierID" <?= $Page->SupplierID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_SupplierID">
<span<?= $Page->SupplierID->viewAttributes() ?>>
<?= $Page->SupplierID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CompanyName->Visible) { // CompanyName ?>
        <td data-name="CompanyName" <?= $Page->CompanyName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_CompanyName">
<span<?= $Page->CompanyName->viewAttributes() ?>>
<?= $Page->CompanyName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ContactName->Visible) { // ContactName ?>
        <td data-name="ContactName" <?= $Page->ContactName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_ContactName">
<span<?= $Page->ContactName->viewAttributes() ?>>
<?= $Page->ContactName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ContactTitle->Visible) { // ContactTitle ?>
        <td data-name="ContactTitle" <?= $Page->ContactTitle->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_ContactTitle">
<span<?= $Page->ContactTitle->viewAttributes() ?>>
<?= $Page->ContactTitle->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Address->Visible) { // Address ?>
        <td data-name="Address" <?= $Page->Address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_Address">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->City->Visible) { // City ?>
        <td data-name="City" <?= $Page->City->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_City">
<span<?= $Page->City->viewAttributes() ?>>
<?= $Page->City->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Region->Visible) { // Region ?>
        <td data-name="Region" <?= $Page->Region->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_Region">
<span<?= $Page->Region->viewAttributes() ?>>
<?= $Page->Region->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <td data-name="PostalCode" <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_PostalCode">
<span<?= $Page->PostalCode->viewAttributes() ?>>
<?= $Page->PostalCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Country->Visible) { // Country ?>
        <td data-name="Country" <?= $Page->Country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_Country">
<span<?= $Page->Country->viewAttributes() ?>>
<?= $Page->Country->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Phone->Visible) { // Phone ?>
        <td data-name="Phone" <?= $Page->Phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_Phone">
<span<?= $Page->Phone->viewAttributes() ?>>
<?= $Page->Phone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Fax->Visible) { // Fax ?>
        <td data-name="Fax" <?= $Page->Fax->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_Fax">
<span<?= $Page->Fax->viewAttributes() ?>>
<?= $Page->Fax->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->HomePage->Visible) { // HomePage ?>
        <td data-name="HomePage" <?= $Page->HomePage->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suppliers_HomePage">
<span<?= $Page->HomePage->viewAttributes() ?>>
<?= $Page->HomePage->getViewValue() ?></span>
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
    ew.addEventHandlers("suppliers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
