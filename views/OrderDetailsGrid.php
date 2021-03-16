<?php

namespace PHPMaker2021\northwindapi;

// Set up and run Grid object
$Grid = Container("OrderDetailsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forder_detailsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    forder_detailsgrid = new ew.Form("forder_detailsgrid", "grid");
    forder_detailsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "order_details")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.order_details)
        ew.vars.tables.order_details = currentTable;
    forder_detailsgrid.addFields([
        ["OrderID", [fields.OrderID.visible && fields.OrderID.required ? ew.Validators.required(fields.OrderID.caption) : null, ew.Validators.integer], fields.OrderID.isInvalid],
        ["ProductID", [fields.ProductID.visible && fields.ProductID.required ? ew.Validators.required(fields.ProductID.caption) : null], fields.ProductID.isInvalid],
        ["UnitPrice", [fields.UnitPrice.visible && fields.UnitPrice.required ? ew.Validators.required(fields.UnitPrice.caption) : null, ew.Validators.float], fields.UnitPrice.isInvalid],
        ["Quantity", [fields.Quantity.visible && fields.Quantity.required ? ew.Validators.required(fields.Quantity.caption) : null, ew.Validators.integer], fields.Quantity.isInvalid],
        ["Discount", [fields.Discount.visible && fields.Discount.required ? ew.Validators.required(fields.Discount.caption) : null, ew.Validators.float], fields.Discount.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = forder_detailsgrid,
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
    forder_detailsgrid.validate = function () {
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
        return true;
    }

    // Check empty row
    forder_detailsgrid.emptyRow = function (rowIndex) {
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
    forder_detailsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    forder_detailsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    forder_detailsgrid.lists.ProductID = <?= $Grid->ProductID->toClientList($Grid) ?>;
    loadjs.done("forder_detailsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> order_details">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="forder_detailsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_order_details" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_order_detailsgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->OrderID->Visible) { // OrderID ?>
        <th data-name="OrderID" class="<?= $Grid->OrderID->headerCellClass() ?>"><div id="elh_order_details_OrderID" class="order_details_OrderID"><?= $Grid->renderSort($Grid->OrderID) ?></div></th>
<?php } ?>
<?php if ($Grid->ProductID->Visible) { // ProductID ?>
        <th data-name="ProductID" class="<?= $Grid->ProductID->headerCellClass() ?>"><div id="elh_order_details_ProductID" class="order_details_ProductID"><?= $Grid->renderSort($Grid->ProductID) ?></div></th>
<?php } ?>
<?php if ($Grid->UnitPrice->Visible) { // UnitPrice ?>
        <th data-name="UnitPrice" class="<?= $Grid->UnitPrice->headerCellClass() ?>"><div id="elh_order_details_UnitPrice" class="order_details_UnitPrice"><?= $Grid->renderSort($Grid->UnitPrice) ?></div></th>
<?php } ?>
<?php if ($Grid->Quantity->Visible) { // Quantity ?>
        <th data-name="Quantity" class="<?= $Grid->Quantity->headerCellClass() ?>"><div id="elh_order_details_Quantity" class="order_details_Quantity"><?= $Grid->renderSort($Grid->Quantity) ?></div></th>
<?php } ?>
<?php if ($Grid->Discount->Visible) { // Discount ?>
        <th data-name="Discount" class="<?= $Grid->Discount->headerCellClass() ?>"><div id="elh_order_details_Discount" class="order_details_Discount"><?= $Grid->renderSort($Grid->Discount) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_order_details", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->OrderID->Visible) { // OrderID ?>
        <td data-name="OrderID" <?= $Grid->OrderID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->OrderID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_OrderID" class="form-group">
<span<?= $Grid->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->OrderID->getDisplayValue($Grid->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_OrderID" name="x<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_OrderID" class="form-group">
<input type="<?= $Grid->OrderID->getInputTextType() ?>" data-table="order_details" data-field="x_OrderID" name="x<?= $Grid->RowIndex ?>_OrderID" id="x<?= $Grid->RowIndex ?>_OrderID" size="30" placeholder="<?= HtmlEncode($Grid->OrderID->getPlaceHolder()) ?>" value="<?= $Grid->OrderID->EditValue ?>"<?= $Grid->OrderID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OrderID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_OrderID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_OrderID" id="o<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->OrderID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_OrderID" class="form-group">
<span<?= $Grid->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->OrderID->getDisplayValue($Grid->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_OrderID" name="x<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_OrderID" class="form-group">
<input type="<?= $Grid->OrderID->getInputTextType() ?>" data-table="order_details" data-field="x_OrderID" name="x<?= $Grid->RowIndex ?>_OrderID" id="x<?= $Grid->RowIndex ?>_OrderID" size="30" placeholder="<?= HtmlEncode($Grid->OrderID->getPlaceHolder()) ?>" value="<?= $Grid->OrderID->EditValue ?>"<?= $Grid->OrderID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OrderID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_OrderID">
<span<?= $Grid->OrderID->viewAttributes() ?>>
<?= $Grid->OrderID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_details" data-field="x_OrderID" data-hidden="1" name="forder_detailsgrid$x<?= $Grid->RowIndex ?>_OrderID" id="forder_detailsgrid$x<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_OrderID" data-hidden="1" name="forder_detailsgrid$o<?= $Grid->RowIndex ?>_OrderID" id="forder_detailsgrid$o<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ProductID->Visible) { // ProductID ?>
        <td data-name="ProductID" <?= $Grid->ProductID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->ProductID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_ProductID" class="form-group">
<span<?= $Grid->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ProductID->getDisplayValue($Grid->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ProductID" name="x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_ProductID" class="form-group">
<?php $Grid->ProductID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_ProductID"
        name="x<?= $Grid->RowIndex ?>_ProductID"
        class="form-control ew-select<?= $Grid->ProductID->isInvalidClass() ?>"
        data-select2-id="order_details_x<?= $Grid->RowIndex ?>_ProductID"
        data-table="order_details"
        data-field="x_ProductID"
        data-value-separator="<?= $Grid->ProductID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->ProductID->getPlaceHolder()) ?>"
        <?= $Grid->ProductID->editAttributes() ?>>
        <?= $Grid->ProductID->selectOptionListHtml("x{$Grid->RowIndex}_ProductID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->ProductID->getErrorMessage() ?></div>
<?= $Grid->ProductID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_ProductID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_details_x<?= $Grid->RowIndex ?>_ProductID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_ProductID", selectId: "order_details_x<?= $Grid->RowIndex ?>_ProductID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_details.fields.ProductID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_ProductID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ProductID" id="o<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->ProductID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_ProductID" class="form-group">
<span<?= $Grid->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ProductID->getDisplayValue($Grid->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ProductID" name="x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_details_ProductID" class="form-group">
<?php $Grid->ProductID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_ProductID"
        name="x<?= $Grid->RowIndex ?>_ProductID"
        class="form-control ew-select<?= $Grid->ProductID->isInvalidClass() ?>"
        data-select2-id="order_details_x<?= $Grid->RowIndex ?>_ProductID"
        data-table="order_details"
        data-field="x_ProductID"
        data-value-separator="<?= $Grid->ProductID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->ProductID->getPlaceHolder()) ?>"
        <?= $Grid->ProductID->editAttributes() ?>>
        <?= $Grid->ProductID->selectOptionListHtml("x{$Grid->RowIndex}_ProductID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->ProductID->getErrorMessage() ?></div>
<?= $Grid->ProductID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_ProductID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_details_x<?= $Grid->RowIndex ?>_ProductID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_ProductID", selectId: "order_details_x<?= $Grid->RowIndex ?>_ProductID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_details.fields.ProductID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_ProductID">
<span<?= $Grid->ProductID->viewAttributes() ?>>
<?= $Grid->ProductID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_details" data-field="x_ProductID" data-hidden="1" name="forder_detailsgrid$x<?= $Grid->RowIndex ?>_ProductID" id="forder_detailsgrid$x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_ProductID" data-hidden="1" name="forder_detailsgrid$o<?= $Grid->RowIndex ?>_ProductID" id="forder_detailsgrid$o<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->UnitPrice->Visible) { // UnitPrice ?>
        <td data-name="UnitPrice" <?= $Grid->UnitPrice->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_UnitPrice" class="form-group">
<input type="<?= $Grid->UnitPrice->getInputTextType() ?>" data-table="order_details" data-field="x_UnitPrice" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" size="15" placeholder="<?= HtmlEncode($Grid->UnitPrice->getPlaceHolder()) ?>" value="<?= $Grid->UnitPrice->EditValue ?>"<?= $Grid->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitPrice->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_UnitPrice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitPrice" id="o<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_UnitPrice" class="form-group">
<input type="<?= $Grid->UnitPrice->getInputTextType() ?>" data-table="order_details" data-field="x_UnitPrice" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" size="15" placeholder="<?= HtmlEncode($Grid->UnitPrice->getPlaceHolder()) ?>" value="<?= $Grid->UnitPrice->EditValue ?>"<?= $Grid->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitPrice->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_UnitPrice">
<span<?= $Grid->UnitPrice->viewAttributes() ?>>
<?= $Grid->UnitPrice->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_details" data-field="x_UnitPrice" data-hidden="1" name="forder_detailsgrid$x<?= $Grid->RowIndex ?>_UnitPrice" id="forder_detailsgrid$x<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_UnitPrice" data-hidden="1" name="forder_detailsgrid$o<?= $Grid->RowIndex ?>_UnitPrice" id="forder_detailsgrid$o<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Quantity->Visible) { // Quantity ?>
        <td data-name="Quantity" <?= $Grid->Quantity->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_Quantity" class="form-group">
<input type="<?= $Grid->Quantity->getInputTextType() ?>" data-table="order_details" data-field="x_Quantity" name="x<?= $Grid->RowIndex ?>_Quantity" id="x<?= $Grid->RowIndex ?>_Quantity" size="15" placeholder="<?= HtmlEncode($Grid->Quantity->getPlaceHolder()) ?>" value="<?= $Grid->Quantity->EditValue ?>"<?= $Grid->Quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Quantity->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_Quantity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Quantity" id="o<?= $Grid->RowIndex ?>_Quantity" value="<?= HtmlEncode($Grid->Quantity->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_Quantity" class="form-group">
<input type="<?= $Grid->Quantity->getInputTextType() ?>" data-table="order_details" data-field="x_Quantity" name="x<?= $Grid->RowIndex ?>_Quantity" id="x<?= $Grid->RowIndex ?>_Quantity" size="15" placeholder="<?= HtmlEncode($Grid->Quantity->getPlaceHolder()) ?>" value="<?= $Grid->Quantity->EditValue ?>"<?= $Grid->Quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Quantity->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_Quantity">
<span<?= $Grid->Quantity->viewAttributes() ?>>
<?= $Grid->Quantity->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_details" data-field="x_Quantity" data-hidden="1" name="forder_detailsgrid$x<?= $Grid->RowIndex ?>_Quantity" id="forder_detailsgrid$x<?= $Grid->RowIndex ?>_Quantity" value="<?= HtmlEncode($Grid->Quantity->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_Quantity" data-hidden="1" name="forder_detailsgrid$o<?= $Grid->RowIndex ?>_Quantity" id="forder_detailsgrid$o<?= $Grid->RowIndex ?>_Quantity" value="<?= HtmlEncode($Grid->Quantity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Discount->Visible) { // Discount ?>
        <td data-name="Discount" <?= $Grid->Discount->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_Discount" class="form-group">
<input type="<?= $Grid->Discount->getInputTextType() ?>" data-table="order_details" data-field="x_Discount" name="x<?= $Grid->RowIndex ?>_Discount" id="x<?= $Grid->RowIndex ?>_Discount" size="15" placeholder="<?= HtmlEncode($Grid->Discount->getPlaceHolder()) ?>" value="<?= $Grid->Discount->EditValue ?>"<?= $Grid->Discount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Discount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_details" data-field="x_Discount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Discount" id="o<?= $Grid->RowIndex ?>_Discount" value="<?= HtmlEncode($Grid->Discount->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_Discount" class="form-group">
<input type="<?= $Grid->Discount->getInputTextType() ?>" data-table="order_details" data-field="x_Discount" name="x<?= $Grid->RowIndex ?>_Discount" id="x<?= $Grid->RowIndex ?>_Discount" size="15" placeholder="<?= HtmlEncode($Grid->Discount->getPlaceHolder()) ?>" value="<?= $Grid->Discount->EditValue ?>"<?= $Grid->Discount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Discount->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_details_Discount">
<span<?= $Grid->Discount->viewAttributes() ?>>
<?= $Grid->Discount->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_details" data-field="x_Discount" data-hidden="1" name="forder_detailsgrid$x<?= $Grid->RowIndex ?>_Discount" id="forder_detailsgrid$x<?= $Grid->RowIndex ?>_Discount" value="<?= HtmlEncode($Grid->Discount->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_Discount" data-hidden="1" name="forder_detailsgrid$o<?= $Grid->RowIndex ?>_Discount" id="forder_detailsgrid$o<?= $Grid->RowIndex ?>_Discount" value="<?= HtmlEncode($Grid->Discount->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["forder_detailsgrid","load"], function () {
    forder_detailsgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_order_details", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->OrderID->Visible) { // OrderID ?>
        <td data-name="OrderID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->OrderID->getSessionValue() != "") { ?>
<span id="el$rowindex$_order_details_OrderID" class="form-group order_details_OrderID">
<span<?= $Grid->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->OrderID->getDisplayValue($Grid->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_OrderID" name="x<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_order_details_OrderID" class="form-group order_details_OrderID">
<input type="<?= $Grid->OrderID->getInputTextType() ?>" data-table="order_details" data-field="x_OrderID" name="x<?= $Grid->RowIndex ?>_OrderID" id="x<?= $Grid->RowIndex ?>_OrderID" size="30" placeholder="<?= HtmlEncode($Grid->OrderID->getPlaceHolder()) ?>" value="<?= $Grid->OrderID->EditValue ?>"<?= $Grid->OrderID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OrderID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_order_details_OrderID" class="form-group order_details_OrderID">
<span<?= $Grid->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->OrderID->getDisplayValue($Grid->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_OrderID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_OrderID" id="x<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_OrderID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_OrderID" id="o<?= $Grid->RowIndex ?>_OrderID" value="<?= HtmlEncode($Grid->OrderID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ProductID->Visible) { // ProductID ?>
        <td data-name="ProductID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->ProductID->getSessionValue() != "") { ?>
<span id="el$rowindex$_order_details_ProductID" class="form-group order_details_ProductID">
<span<?= $Grid->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ProductID->getDisplayValue($Grid->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ProductID" name="x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_order_details_ProductID" class="form-group order_details_ProductID">
<?php $Grid->ProductID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_ProductID"
        name="x<?= $Grid->RowIndex ?>_ProductID"
        class="form-control ew-select<?= $Grid->ProductID->isInvalidClass() ?>"
        data-select2-id="order_details_x<?= $Grid->RowIndex ?>_ProductID"
        data-table="order_details"
        data-field="x_ProductID"
        data-value-separator="<?= $Grid->ProductID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->ProductID->getPlaceHolder()) ?>"
        <?= $Grid->ProductID->editAttributes() ?>>
        <?= $Grid->ProductID->selectOptionListHtml("x{$Grid->RowIndex}_ProductID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->ProductID->getErrorMessage() ?></div>
<?= $Grid->ProductID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_ProductID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_details_x<?= $Grid->RowIndex ?>_ProductID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_ProductID", selectId: "order_details_x<?= $Grid->RowIndex ?>_ProductID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_details.fields.ProductID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_order_details_ProductID" class="form-group order_details_ProductID">
<span<?= $Grid->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ProductID->getDisplayValue($Grid->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_ProductID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ProductID" id="x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_ProductID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ProductID" id="o<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->UnitPrice->Visible) { // UnitPrice ?>
        <td data-name="UnitPrice">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_details_UnitPrice" class="form-group order_details_UnitPrice">
<input type="<?= $Grid->UnitPrice->getInputTextType() ?>" data-table="order_details" data-field="x_UnitPrice" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" size="15" placeholder="<?= HtmlEncode($Grid->UnitPrice->getPlaceHolder()) ?>" value="<?= $Grid->UnitPrice->EditValue ?>"<?= $Grid->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitPrice->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_details_UnitPrice" class="form-group order_details_UnitPrice">
<span<?= $Grid->UnitPrice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->UnitPrice->getDisplayValue($Grid->UnitPrice->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_UnitPrice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_UnitPrice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitPrice" id="o<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Quantity->Visible) { // Quantity ?>
        <td data-name="Quantity">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_details_Quantity" class="form-group order_details_Quantity">
<input type="<?= $Grid->Quantity->getInputTextType() ?>" data-table="order_details" data-field="x_Quantity" name="x<?= $Grid->RowIndex ?>_Quantity" id="x<?= $Grid->RowIndex ?>_Quantity" size="15" placeholder="<?= HtmlEncode($Grid->Quantity->getPlaceHolder()) ?>" value="<?= $Grid->Quantity->EditValue ?>"<?= $Grid->Quantity->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Quantity->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_details_Quantity" class="form-group order_details_Quantity">
<span<?= $Grid->Quantity->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Quantity->getDisplayValue($Grid->Quantity->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_Quantity" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Quantity" id="x<?= $Grid->RowIndex ?>_Quantity" value="<?= HtmlEncode($Grid->Quantity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_Quantity" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Quantity" id="o<?= $Grid->RowIndex ?>_Quantity" value="<?= HtmlEncode($Grid->Quantity->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Discount->Visible) { // Discount ?>
        <td data-name="Discount">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_details_Discount" class="form-group order_details_Discount">
<input type="<?= $Grid->Discount->getInputTextType() ?>" data-table="order_details" data-field="x_Discount" name="x<?= $Grid->RowIndex ?>_Discount" id="x<?= $Grid->RowIndex ?>_Discount" size="15" placeholder="<?= HtmlEncode($Grid->Discount->getPlaceHolder()) ?>" value="<?= $Grid->Discount->EditValue ?>"<?= $Grid->Discount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Discount->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_details_Discount" class="form-group order_details_Discount">
<span<?= $Grid->Discount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Discount->getDisplayValue($Grid->Discount->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_Discount" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Discount" id="x<?= $Grid->RowIndex ?>_Discount" value="<?= HtmlEncode($Grid->Discount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_Discount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Discount" id="o<?= $Grid->RowIndex ?>_Discount" value="<?= HtmlEncode($Grid->Discount->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["forder_detailsgrid","load"], function() {
    forder_detailsgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="forder_detailsgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
