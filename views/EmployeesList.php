<?php

namespace PHPMaker2021\northwindapi;

// Page object
$EmployeesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var femployeeslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    femployeeslist = currentForm = new ew.Form("femployeeslist", "list");
    femployeeslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("femployeeslist");
});
var femployeeslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    femployeeslistsrch = currentSearchForm = new ew.Form("femployeeslistsrch");

    // Dynamic selection lists

    // Filters
    femployeeslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("femployeeslistsrch");
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
<form name="femployeeslistsrch" id="femployeeslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="femployeeslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="employees">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> employees">
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
<form name="femployeeslist" id="femployeeslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employees">
<div id="gmp_employees" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_employeeslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <th data-name="EmployeeID" class="<?= $Page->EmployeeID->headerCellClass() ?>"><div id="elh_employees_EmployeeID" class="employees_EmployeeID"><?= $Page->renderSort($Page->EmployeeID) ?></div></th>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
        <th data-name="LastName" class="<?= $Page->LastName->headerCellClass() ?>"><div id="elh_employees_LastName" class="employees_LastName"><?= $Page->renderSort($Page->LastName) ?></div></th>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
        <th data-name="FirstName" class="<?= $Page->FirstName->headerCellClass() ?>"><div id="elh_employees_FirstName" class="employees_FirstName"><?= $Page->renderSort($Page->FirstName) ?></div></th>
<?php } ?>
<?php if ($Page->Title->Visible) { // Title ?>
        <th data-name="Title" class="<?= $Page->Title->headerCellClass() ?>"><div id="elh_employees_Title" class="employees_Title"><?= $Page->renderSort($Page->Title) ?></div></th>
<?php } ?>
<?php if ($Page->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
        <th data-name="TitleOfCourtesy" class="<?= $Page->TitleOfCourtesy->headerCellClass() ?>"><div id="elh_employees_TitleOfCourtesy" class="employees_TitleOfCourtesy"><?= $Page->renderSort($Page->TitleOfCourtesy) ?></div></th>
<?php } ?>
<?php if ($Page->BirthDate->Visible) { // BirthDate ?>
        <th data-name="BirthDate" class="<?= $Page->BirthDate->headerCellClass() ?>"><div id="elh_employees_BirthDate" class="employees_BirthDate"><?= $Page->renderSort($Page->BirthDate) ?></div></th>
<?php } ?>
<?php if ($Page->HireDate->Visible) { // HireDate ?>
        <th data-name="HireDate" class="<?= $Page->HireDate->headerCellClass() ?>"><div id="elh_employees_HireDate" class="employees_HireDate"><?= $Page->renderSort($Page->HireDate) ?></div></th>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <th data-name="Address" class="<?= $Page->Address->headerCellClass() ?>"><div id="elh_employees_Address" class="employees_Address"><?= $Page->renderSort($Page->Address) ?></div></th>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
        <th data-name="City" class="<?= $Page->City->headerCellClass() ?>"><div id="elh_employees_City" class="employees_City"><?= $Page->renderSort($Page->City) ?></div></th>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
        <th data-name="Region" class="<?= $Page->Region->headerCellClass() ?>"><div id="elh_employees_Region" class="employees_Region"><?= $Page->renderSort($Page->Region) ?></div></th>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <th data-name="PostalCode" class="<?= $Page->PostalCode->headerCellClass() ?>"><div id="elh_employees_PostalCode" class="employees_PostalCode"><?= $Page->renderSort($Page->PostalCode) ?></div></th>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
        <th data-name="Country" class="<?= $Page->Country->headerCellClass() ?>"><div id="elh_employees_Country" class="employees_Country"><?= $Page->renderSort($Page->Country) ?></div></th>
<?php } ?>
<?php if ($Page->HomePhone->Visible) { // HomePhone ?>
        <th data-name="HomePhone" class="<?= $Page->HomePhone->headerCellClass() ?>"><div id="elh_employees_HomePhone" class="employees_HomePhone"><?= $Page->renderSort($Page->HomePhone) ?></div></th>
<?php } ?>
<?php if ($Page->Extension->Visible) { // Extension ?>
        <th data-name="Extension" class="<?= $Page->Extension->headerCellClass() ?>"><div id="elh_employees_Extension" class="employees_Extension"><?= $Page->renderSort($Page->Extension) ?></div></th>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
        <th data-name="Photo" class="<?= $Page->Photo->headerCellClass() ?>"><div id="elh_employees_Photo" class="employees_Photo"><?= $Page->renderSort($Page->Photo) ?></div></th>
<?php } ?>
<?php if ($Page->Notes->Visible) { // Notes ?>
        <th data-name="Notes" class="<?= $Page->Notes->headerCellClass() ?>"><div id="elh_employees_Notes" class="employees_Notes"><?= $Page->renderSort($Page->Notes) ?></div></th>
<?php } ?>
<?php if ($Page->ReportsTo->Visible) { // ReportsTo ?>
        <th data-name="ReportsTo" class="<?= $Page->ReportsTo->headerCellClass() ?>"><div id="elh_employees_ReportsTo" class="employees_ReportsTo"><?= $Page->renderSort($Page->ReportsTo) ?></div></th>
<?php } ?>
<?php if ($Page->PhotoPath->Visible) { // PhotoPath ?>
        <th data-name="PhotoPath" class="<?= $Page->PhotoPath->headerCellClass() ?>"><div id="elh_employees_PhotoPath" class="employees_PhotoPath"><?= $Page->renderSort($Page->PhotoPath) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_employees", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <td data-name="EmployeeID" <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_EmployeeID">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<?= $Page->EmployeeID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LastName->Visible) { // LastName ?>
        <td data-name="LastName" <?= $Page->LastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_LastName">
<span<?= $Page->LastName->viewAttributes() ?>>
<?= $Page->LastName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FirstName->Visible) { // FirstName ?>
        <td data-name="FirstName" <?= $Page->FirstName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_FirstName">
<span<?= $Page->FirstName->viewAttributes() ?>>
<?= $Page->FirstName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Title->Visible) { // Title ?>
        <td data-name="Title" <?= $Page->Title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Title">
<span<?= $Page->Title->viewAttributes() ?>>
<?= $Page->Title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
        <td data-name="TitleOfCourtesy" <?= $Page->TitleOfCourtesy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_TitleOfCourtesy">
<span<?= $Page->TitleOfCourtesy->viewAttributes() ?>>
<?= $Page->TitleOfCourtesy->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BirthDate->Visible) { // BirthDate ?>
        <td data-name="BirthDate" <?= $Page->BirthDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_BirthDate">
<span<?= $Page->BirthDate->viewAttributes() ?>>
<?= $Page->BirthDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->HireDate->Visible) { // HireDate ?>
        <td data-name="HireDate" <?= $Page->HireDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_HireDate">
<span<?= $Page->HireDate->viewAttributes() ?>>
<?= $Page->HireDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Address->Visible) { // Address ?>
        <td data-name="Address" <?= $Page->Address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Address">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->City->Visible) { // City ?>
        <td data-name="City" <?= $Page->City->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_City">
<span<?= $Page->City->viewAttributes() ?>>
<?= $Page->City->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Region->Visible) { // Region ?>
        <td data-name="Region" <?= $Page->Region->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Region">
<span<?= $Page->Region->viewAttributes() ?>>
<?= $Page->Region->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <td data-name="PostalCode" <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_PostalCode">
<span<?= $Page->PostalCode->viewAttributes() ?>>
<?= $Page->PostalCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Country->Visible) { // Country ?>
        <td data-name="Country" <?= $Page->Country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Country">
<span<?= $Page->Country->viewAttributes() ?>>
<?= $Page->Country->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->HomePhone->Visible) { // HomePhone ?>
        <td data-name="HomePhone" <?= $Page->HomePhone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_HomePhone">
<span<?= $Page->HomePhone->viewAttributes() ?>>
<?= $Page->HomePhone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Extension->Visible) { // Extension ?>
        <td data-name="Extension" <?= $Page->Extension->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Extension">
<span<?= $Page->Extension->viewAttributes() ?>>
<?= $Page->Extension->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Photo->Visible) { // Photo ?>
        <td data-name="Photo" <?= $Page->Photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Photo">
<span<?= $Page->Photo->viewAttributes() ?>>
<?= $Page->Photo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Notes->Visible) { // Notes ?>
        <td data-name="Notes" <?= $Page->Notes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Notes">
<span<?= $Page->Notes->viewAttributes() ?>>
<?= $Page->Notes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ReportsTo->Visible) { // ReportsTo ?>
        <td data-name="ReportsTo" <?= $Page->ReportsTo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_ReportsTo">
<span<?= $Page->ReportsTo->viewAttributes() ?>>
<?= $Page->ReportsTo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PhotoPath->Visible) { // PhotoPath ?>
        <td data-name="PhotoPath" <?= $Page->PhotoPath->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_PhotoPath">
<span<?= $Page->PhotoPath->viewAttributes() ?>>
<?= $Page->PhotoPath->getViewValue() ?></span>
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
    ew.addEventHandlers("employees");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
