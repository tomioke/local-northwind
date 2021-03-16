<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrderDetailsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forder_detailslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    forder_detailslist = currentForm = new ew.Form("forder_detailslist", "list");
    forder_detailslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "order_details")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.order_details)
        ew.vars.tables.order_details = currentTable;
    forder_detailslist.addFields([
        ["OrderID", [fields.OrderID.visible && fields.OrderID.required ? ew.Validators.required(fields.OrderID.caption) : null, ew.Validators.integer], fields.OrderID.isInvalid],
        ["ProductID", [fields.ProductID.visible && fields.ProductID.required ? ew.Validators.required(fields.ProductID.caption) : null], fields.ProductID.isInvalid],
        ["UnitPrice", [fields.UnitPrice.visible && fields.UnitPrice.required ? ew.Validators.required(fields.UnitPrice.caption) : null, ew.Validators.float], fields.UnitPrice.isInvalid],
        ["Quantity", [fields.Quantity.visible && fields.Quantity.required ? ew.Validators.required(fields.Quantity.caption) : null, ew.Validators.integer], fields.Quantity.isInvalid],
        ["Discount", [fields.Discount.visible && fields.Discount.required ? ew.Validators.required(fields.Discount.caption) : null, ew.Validators.float], fields.Discount.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = forder_detailslist,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    forder_detailslist.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        if (gridinsert && addcnt == 0) { // No row added
            ew.alert(ew.language.phrase("NoAddRecord"));
            return false;
        }
        return true;
    }

    // Check empty row
    forder_detailslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "OrderID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ProductID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "UnitPrice", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Quantity", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Discount", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    forder_detailslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    forder_detailslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    forder_detailslist.lists.ProductID = <?= $Page->ProductID->toClientList($Page) ?>;
    loadjs.done("forder_detailslist");
});
var forder_detailslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    forder_detailslistsrch = currentSearchForm = new ew.Form("forder_detailslistsrch");

    // Dynamic selection lists

    // Filters
    forder_detailslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("forder_detailslistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "orders") {
    if ($Page->MasterRecordExists) {
        include_once "views/OrdersMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "products") {
    if ($Page->MasterRecordExists) {
        include_once "views/ProductsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="forder_detailslistsrch" id="forder_detailslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="forder_detailslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="order_details">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> order_details">
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
<form name="forder_detailslist" id="forder_detailslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_details">
<?php if ($Page->getCurrentMasterTable() == "orders" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="orders">
<input type="hidden" name="fk_OrderID" value="<?= HtmlEncode($Page->OrderID->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "products" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="products">
<input type="hidden" name="fk_ProductID" value="<?= HtmlEncode($Page->ProductID->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_order_details" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_order_detailslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="OrderID" class="<?= $Page->OrderID->headerCellClass() ?>"><div id="elh_order_details_OrderID" class="order_details_OrderID"><?= $Page->renderSort($Page->OrderID) ?></div></th>
<?php } ?>
<?php if ($Page->ProductID->Visible) { // ProductID ?>
        <th data-name="ProductID" class="<?= $Page->ProductID->headerCellClass() ?>"><div id="elh_order_details_ProductID" class="order_details_ProductID"><?= $Page->renderSort($Page->ProductID) ?></div></th>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
        <th data-name="UnitPrice" class="<?= $Page->UnitPrice->headerCellClass() ?>"><div id="elh_order_details_UnitPrice" class="order_details_UnitPrice"><?= $Page->renderSort($Page->UnitPrice) ?></div></th>
<?php } ?>
<?php if ($Page->Quantity->Visible) { // Quantity ?>
        <th data-name="Quantity" class="<?= $Page->Quantity->headerCellClass() ?>"><div id="elh_order_details_Quantity" class="order_details_Quantity"><?= $Page->renderSort($Page->Quantity) ?></div></th>
<?php } ?>
<?php if ($Page->Discount->Visible) { // Discount ?>
        <th data-name="Discount" class="<?= $Page->Discount->headerCellClass() ?>"><div id="elh_order_details_Discount" class="order_details_Discount"><?= $Page->renderSort($Page->Discount) ?></div></th>
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

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
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
if ($Page->isGridAdd())
    $Page->RowIndex = 0;
if ($Page->isGridEdit())
    $Page->RowIndex = 0;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

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
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->isGridEdit()) { // Grid edit
            if ($Page->EventCancelled) {
                $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
            }
            if ($Page->RowAction == "insert") {
                $Page->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_order_details", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Page->RowAction != "delete" && $Page->RowAction != "insertdelete" && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->OrderID->Visible) { // OrderID ?>
        <td data-name="OrderID" <?= $Page->OrderID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->OrderID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_order_details_OrderID" class="form-group">
<span<?= $Page->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->OrderID->getDisplayValue($Page->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_OrderID" name="x<?= $Page->RowIndex ?>_OrderID" value="<?= HtmlEncode($Page->OrderID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_order_details_OrderID" class="form-group">
<input type="<?= $Page->OrderID->getInputTextType() ?>" data-table="order_details" data-field="x_OrderID" name="x<?= $Page->RowIndex ?>_OrderID" id="x<?= $Page->RowIndex ?>_OrderID" size="30" placeholder="<?= HtmlEncode($Page->OrderID->getPlaceHolder()) ?>" value="<?= $Page->OrderID->EditValue ?>"<?= $Page->OrderID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->OrderID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_OrderID" data-hidden="1" name="o<?= $Page->RowIndex ?>_OrderID" id="o<?= $Page->RowIndex ?>_OrderID" value="<?= HtmlEncode($Page->OrderID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->OrderID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_order_details_OrderID" class="form-group">
<span<?= $Page->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->OrderID->getDisplayValue($Page->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_OrderID" name="x<?= $Page->RowIndex ?>_OrderID" value="<?= HtmlEncode($Page->OrderID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_order_details_OrderID" class="form-group">
<input type="<?= $Page->OrderID->getInputTextType() ?>" data-table="order_details" data-field="x_OrderID" name="x<?= $Page->RowIndex ?>_OrderID" id="x<?= $Page->RowIndex ?>_OrderID" size="30" placeholder="<?= HtmlEncode($Page->OrderID->getPlaceHolder()) ?>" value="<?= $Page->OrderID->EditValue ?>"<?= $Page->OrderID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->OrderID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_order_details_OrderID">
<span<?= $Page->OrderID->viewAttributes() ?>>
<?= $Page->OrderID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ProductID->Visible) { // ProductID ?>
        <td data-name="ProductID" <?= $Page->ProductID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Page->ProductID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_order_details_ProductID" class="form-group">
<span<?= $Page->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ProductID->getDisplayValue($Page->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_ProductID" name="x<?= $Page->RowIndex ?>_ProductID" value="<?= HtmlEncode($Page->ProductID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_order_details_ProductID" class="form-group">
<?php $Page->ProductID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_ProductID"
        name="x<?= $Page->RowIndex ?>_ProductID"
        class="form-control ew-select<?= $Page->ProductID->isInvalidClass() ?>"
        data-select2-id="order_details_x<?= $Page->RowIndex ?>_ProductID"
        data-table="order_details"
        data-field="x_ProductID"
        data-value-separator="<?= $Page->ProductID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ProductID->getPlaceHolder()) ?>"
        <?= $Page->ProductID->editAttributes() ?>>
        <?= $Page->ProductID->selectOptionListHtml("x{$Page->RowIndex}_ProductID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->ProductID->getErrorMessage() ?></div>
<?= $Page->ProductID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_ProductID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_details_x<?= $Page->RowIndex ?>_ProductID']"),
        options = { name: "x<?= $Page->RowIndex ?>_ProductID", selectId: "order_details_x<?= $Page->RowIndex ?>_ProductID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_details.fields.ProductID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_ProductID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ProductID" id="o<?= $Page->RowIndex ?>_ProductID" value="<?= HtmlEncode($Page->ProductID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->ProductID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_order_details_ProductID" class="form-group">
<span<?= $Page->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ProductID->getDisplayValue($Page->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_ProductID" name="x<?= $Page->RowIndex ?>_ProductID" value="<?= HtmlEncode($Page->ProductID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_order_details_ProductID" class="form-group">
<?php $Page->ProductID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_ProductID"
        name="x<?= $Page->RowIndex ?>_ProductID"
        class="form-control ew-select<?= $Page->ProductID->isInvalidClass() ?>"
        data-select2-id="order_details_x<?= $Page->RowIndex ?>_ProductID"
        data-table="order_details"
        data-field="x_ProductID"
        data-value-separator="<?= $Page->ProductID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ProductID->getPlaceHolder()) ?>"
        <?= $Page->ProductID->editAttributes() ?>>
        <?= $Page->ProductID->selectOptionListHtml("x{$Page->RowIndex}_ProductID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->ProductID->getErrorMessage() ?></div>
<?= $Page->ProductID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_ProductID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_details_x<?= $Page->RowIndex ?>_ProductID']"),
        options = { name: "x<?= $Page->RowIndex ?>_ProductID", selectId: "order_details_x<?= $Page->RowIndex ?>_ProductID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_details.fields.ProductID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_order_details_ProductID">
<span<?= $Page->ProductID->viewAttributes() ?>>
<?= $Page->ProductID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
        <td data-name="UnitPrice" <?= $Page->UnitPrice->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_order_details_UnitPrice" class="form-group">
<input type="<?= $Page->UnitPrice->getInputTextType() ?>" data-table="order_details" data-field="x_UnitPrice" name="x<?= $Page->RowIndex ?>_UnitPrice" id="x<?= $Page->RowIndex ?>_UnitPrice" size="15" placeholder="<?= HtmlEncode($Page->UnitPrice->getPlaceHolder()) ?>" value="<?= $Page->UnitPrice->EditValue ?>"<?= $Page->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->UnitPrice->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_UnitPrice" data-hidden="1" name="o<?= $Page->RowIndex ?>_UnitPrice" id="o<?= $Page->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Page->UnitPrice->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_order_details_UnitPrice" class="form-group">
<input type="<?= $Page->UnitPrice->getInputTextType() ?>" data-table="order_details" data-field="x_UnitPrice" name="x<?= $Page->RowIndex ?>_UnitPrice" id="x<?= $Page->RowIndex ?>_UnitPrice" size="15" placeholder="<?= HtmlEncode($Page->UnitPrice->getPlaceHolder()) ?>" value="<?= $Page->UnitPrice->EditValue ?>"<?= $Page->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->UnitPrice->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_order_details_UnitPrice">
<span<?= $Page->UnitPrice->viewAttributes() ?>>
<?= $Page->UnitPrice->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Quantity->Visible) { // Quantity ?>
        <td data-name="Quantity" <?= $Page->Quantity->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_order_details_Quantity" class="form-group">
<input type="<?= $Page->Quantity->getInputTextType() ?>" data-table="order_details" data-field="x_Quantity" name="x<?= $Page->RowIndex ?>_Quantity" id="x<?= $Page->RowIndex ?>_Quantity" size="15" placeholder="<?= HtmlEncode($Page->Quantity->getPlaceHolder()) ?>" value="<?= $Page->Quantity->EditValue ?>"<?= $Page->Quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Quantity->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_Quantity" data-hidden="1" name="o<?= $Page->RowIndex ?>_Quantity" id="o<?= $Page->RowIndex ?>_Quantity" value="<?= HtmlEncode($Page->Quantity->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_order_details_Quantity" class="form-group">
<input type="<?= $Page->Quantity->getInputTextType() ?>" data-table="order_details" data-field="x_Quantity" name="x<?= $Page->RowIndex ?>_Quantity" id="x<?= $Page->RowIndex ?>_Quantity" size="15" placeholder="<?= HtmlEncode($Page->Quantity->getPlaceHolder()) ?>" value="<?= $Page->Quantity->EditValue ?>"<?= $Page->Quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Quantity->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_order_details_Quantity">
<span<?= $Page->Quantity->viewAttributes() ?>>
<?= $Page->Quantity->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Discount->Visible) { // Discount ?>
        <td data-name="Discount" <?= $Page->Discount->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_order_details_Discount" class="form-group">
<input type="<?= $Page->Discount->getInputTextType() ?>" data-table="order_details" data-field="x_Discount" name="x<?= $Page->RowIndex ?>_Discount" id="x<?= $Page->RowIndex ?>_Discount" size="15" placeholder="<?= HtmlEncode($Page->Discount->getPlaceHolder()) ?>" value="<?= $Page->Discount->EditValue ?>"<?= $Page->Discount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Discount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_Discount" data-hidden="1" name="o<?= $Page->RowIndex ?>_Discount" id="o<?= $Page->RowIndex ?>_Discount" value="<?= HtmlEncode($Page->Discount->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_order_details_Discount" class="form-group">
<input type="<?= $Page->Discount->getInputTextType() ?>" data-table="order_details" data-field="x_Discount" name="x<?= $Page->RowIndex ?>_Discount" id="x<?= $Page->RowIndex ?>_Discount" size="15" placeholder="<?= HtmlEncode($Page->Discount->getPlaceHolder()) ?>" value="<?= $Page->Discount->EditValue ?>"<?= $Page->Discount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Discount->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_order_details_Discount">
<span<?= $Page->Discount->viewAttributes() ?>>
<?= $Page->Discount->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["forder_detailslist","load"], function () {
    forder_detailslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
    if ($Page->isGridAdd() || $Page->isGridEdit()) {
        $Page->RowIndex = '$rowindex$';
        $Page->loadRowValues();

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_order_details", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowAttrs->appendClass("ew-template");
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->OrderID->Visible) { // OrderID ?>
        <td data-name="OrderID">
<?php if ($Page->OrderID->getSessionValue() != "") { ?>
<span id="el$rowindex$_order_details_OrderID" class="form-group order_details_OrderID">
<span<?= $Page->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->OrderID->getDisplayValue($Page->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_OrderID" name="x<?= $Page->RowIndex ?>_OrderID" value="<?= HtmlEncode($Page->OrderID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_order_details_OrderID" class="form-group order_details_OrderID">
<input type="<?= $Page->OrderID->getInputTextType() ?>" data-table="order_details" data-field="x_OrderID" name="x<?= $Page->RowIndex ?>_OrderID" id="x<?= $Page->RowIndex ?>_OrderID" size="30" placeholder="<?= HtmlEncode($Page->OrderID->getPlaceHolder()) ?>" value="<?= $Page->OrderID->EditValue ?>"<?= $Page->OrderID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->OrderID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_OrderID" data-hidden="1" name="o<?= $Page->RowIndex ?>_OrderID" id="o<?= $Page->RowIndex ?>_OrderID" value="<?= HtmlEncode($Page->OrderID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ProductID->Visible) { // ProductID ?>
        <td data-name="ProductID">
<?php if ($Page->ProductID->getSessionValue() != "") { ?>
<span id="el$rowindex$_order_details_ProductID" class="form-group order_details_ProductID">
<span<?= $Page->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ProductID->getDisplayValue($Page->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_ProductID" name="x<?= $Page->RowIndex ?>_ProductID" value="<?= HtmlEncode($Page->ProductID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_order_details_ProductID" class="form-group order_details_ProductID">
<?php $Page->ProductID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_ProductID"
        name="x<?= $Page->RowIndex ?>_ProductID"
        class="form-control ew-select<?= $Page->ProductID->isInvalidClass() ?>"
        data-select2-id="order_details_x<?= $Page->RowIndex ?>_ProductID"
        data-table="order_details"
        data-field="x_ProductID"
        data-value-separator="<?= $Page->ProductID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ProductID->getPlaceHolder()) ?>"
        <?= $Page->ProductID->editAttributes() ?>>
        <?= $Page->ProductID->selectOptionListHtml("x{$Page->RowIndex}_ProductID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->ProductID->getErrorMessage() ?></div>
<?= $Page->ProductID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_ProductID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_details_x<?= $Page->RowIndex ?>_ProductID']"),
        options = { name: "x<?= $Page->RowIndex ?>_ProductID", selectId: "order_details_x<?= $Page->RowIndex ?>_ProductID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_details.fields.ProductID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_ProductID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ProductID" id="o<?= $Page->RowIndex ?>_ProductID" value="<?= HtmlEncode($Page->ProductID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
        <td data-name="UnitPrice">
<span id="el$rowindex$_order_details_UnitPrice" class="form-group order_details_UnitPrice">
<input type="<?= $Page->UnitPrice->getInputTextType() ?>" data-table="order_details" data-field="x_UnitPrice" name="x<?= $Page->RowIndex ?>_UnitPrice" id="x<?= $Page->RowIndex ?>_UnitPrice" size="15" placeholder="<?= HtmlEncode($Page->UnitPrice->getPlaceHolder()) ?>" value="<?= $Page->UnitPrice->EditValue ?>"<?= $Page->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->UnitPrice->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_UnitPrice" data-hidden="1" name="o<?= $Page->RowIndex ?>_UnitPrice" id="o<?= $Page->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Page->UnitPrice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Quantity->Visible) { // Quantity ?>
        <td data-name="Quantity">
<span id="el$rowindex$_order_details_Quantity" class="form-group order_details_Quantity">
<input type="<?= $Page->Quantity->getInputTextType() ?>" data-table="order_details" data-field="x_Quantity" name="x<?= $Page->RowIndex ?>_Quantity" id="x<?= $Page->RowIndex ?>_Quantity" size="15" placeholder="<?= HtmlEncode($Page->Quantity->getPlaceHolder()) ?>" value="<?= $Page->Quantity->EditValue ?>"<?= $Page->Quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Quantity->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_Quantity" data-hidden="1" name="o<?= $Page->RowIndex ?>_Quantity" id="o<?= $Page->RowIndex ?>_Quantity" value="<?= HtmlEncode($Page->Quantity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Discount->Visible) { // Discount ?>
        <td data-name="Discount">
<span id="el$rowindex$_order_details_Discount" class="form-group order_details_Discount">
<input type="<?= $Page->Discount->getInputTextType() ?>" data-table="order_details" data-field="x_Discount" name="x<?= $Page->RowIndex ?>_Discount" id="x<?= $Page->RowIndex ?>_Discount" size="15" placeholder="<?= HtmlEncode($Page->Discount->getPlaceHolder()) ?>" value="<?= $Page->Discount->EditValue ?>"<?= $Page->Discount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Discount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_Discount" data-hidden="1" name="o<?= $Page->RowIndex ?>_Discount" id="o<?= $Page->RowIndex ?>_Discount" value="<?= HtmlEncode($Page->Discount->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["forder_detailslist","load"], function() {
    forder_detailslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
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
    ew.addEventHandlers("order_details");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
