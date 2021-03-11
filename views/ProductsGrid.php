<?php

namespace PHPMaker2021\northwindapi;

// Set up and run Grid object
$Grid = Container("ProductsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fproductsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fproductsgrid = new ew.Form("fproductsgrid", "grid");
    fproductsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "products")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.products)
        ew.vars.tables.products = currentTable;
    fproductsgrid.addFields([
        ["ProductID", [fields.ProductID.visible && fields.ProductID.required ? ew.Validators.required(fields.ProductID.caption) : null, ew.Validators.integer], fields.ProductID.isInvalid],
        ["ProductName", [fields.ProductName.visible && fields.ProductName.required ? ew.Validators.required(fields.ProductName.caption) : null], fields.ProductName.isInvalid],
        ["SupplierID", [fields.SupplierID.visible && fields.SupplierID.required ? ew.Validators.required(fields.SupplierID.caption) : null], fields.SupplierID.isInvalid],
        ["CategoryID", [fields.CategoryID.visible && fields.CategoryID.required ? ew.Validators.required(fields.CategoryID.caption) : null], fields.CategoryID.isInvalid],
        ["QuantityPerUnit", [fields.QuantityPerUnit.visible && fields.QuantityPerUnit.required ? ew.Validators.required(fields.QuantityPerUnit.caption) : null], fields.QuantityPerUnit.isInvalid],
        ["UnitPrice", [fields.UnitPrice.visible && fields.UnitPrice.required ? ew.Validators.required(fields.UnitPrice.caption) : null], fields.UnitPrice.isInvalid],
        ["UnitsInStock", [fields.UnitsInStock.visible && fields.UnitsInStock.required ? ew.Validators.required(fields.UnitsInStock.caption) : null], fields.UnitsInStock.isInvalid],
        ["UnitsOnOrder", [fields.UnitsOnOrder.visible && fields.UnitsOnOrder.required ? ew.Validators.required(fields.UnitsOnOrder.caption) : null], fields.UnitsOnOrder.isInvalid],
        ["ReorderLevel", [fields.ReorderLevel.visible && fields.ReorderLevel.required ? ew.Validators.required(fields.ReorderLevel.caption) : null], fields.ReorderLevel.isInvalid],
        ["Discontinued", [fields.Discontinued.visible && fields.Discontinued.required ? ew.Validators.required(fields.Discontinued.caption) : null], fields.Discontinued.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fproductsgrid,
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
    fproductsgrid.validate = function () {
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
    fproductsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "ProductID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ProductName", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "SupplierID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CategoryID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QuantityPerUnit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "UnitPrice", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "UnitsInStock", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "UnitsOnOrder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ReorderLevel", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "Discontinued", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fproductsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fproductsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fproductsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> products">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fproductsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_products" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_productsgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->ProductID->Visible) { // ProductID ?>
        <th data-name="ProductID" class="<?= $Grid->ProductID->headerCellClass() ?>"><div id="elh_products_ProductID" class="products_ProductID"><?= $Grid->renderSort($Grid->ProductID) ?></div></th>
<?php } ?>
<?php if ($Grid->ProductName->Visible) { // ProductName ?>
        <th data-name="ProductName" class="<?= $Grid->ProductName->headerCellClass() ?>"><div id="elh_products_ProductName" class="products_ProductName"><?= $Grid->renderSort($Grid->ProductName) ?></div></th>
<?php } ?>
<?php if ($Grid->SupplierID->Visible) { // SupplierID ?>
        <th data-name="SupplierID" class="<?= $Grid->SupplierID->headerCellClass() ?>"><div id="elh_products_SupplierID" class="products_SupplierID"><?= $Grid->renderSort($Grid->SupplierID) ?></div></th>
<?php } ?>
<?php if ($Grid->CategoryID->Visible) { // CategoryID ?>
        <th data-name="CategoryID" class="<?= $Grid->CategoryID->headerCellClass() ?>"><div id="elh_products_CategoryID" class="products_CategoryID"><?= $Grid->renderSort($Grid->CategoryID) ?></div></th>
<?php } ?>
<?php if ($Grid->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
        <th data-name="QuantityPerUnit" class="<?= $Grid->QuantityPerUnit->headerCellClass() ?>"><div id="elh_products_QuantityPerUnit" class="products_QuantityPerUnit"><?= $Grid->renderSort($Grid->QuantityPerUnit) ?></div></th>
<?php } ?>
<?php if ($Grid->UnitPrice->Visible) { // UnitPrice ?>
        <th data-name="UnitPrice" class="<?= $Grid->UnitPrice->headerCellClass() ?>"><div id="elh_products_UnitPrice" class="products_UnitPrice"><?= $Grid->renderSort($Grid->UnitPrice) ?></div></th>
<?php } ?>
<?php if ($Grid->UnitsInStock->Visible) { // UnitsInStock ?>
        <th data-name="UnitsInStock" class="<?= $Grid->UnitsInStock->headerCellClass() ?>"><div id="elh_products_UnitsInStock" class="products_UnitsInStock"><?= $Grid->renderSort($Grid->UnitsInStock) ?></div></th>
<?php } ?>
<?php if ($Grid->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
        <th data-name="UnitsOnOrder" class="<?= $Grid->UnitsOnOrder->headerCellClass() ?>"><div id="elh_products_UnitsOnOrder" class="products_UnitsOnOrder"><?= $Grid->renderSort($Grid->UnitsOnOrder) ?></div></th>
<?php } ?>
<?php if ($Grid->ReorderLevel->Visible) { // ReorderLevel ?>
        <th data-name="ReorderLevel" class="<?= $Grid->ReorderLevel->headerCellClass() ?>"><div id="elh_products_ReorderLevel" class="products_ReorderLevel"><?= $Grid->renderSort($Grid->ReorderLevel) ?></div></th>
<?php } ?>
<?php if ($Grid->Discontinued->Visible) { // Discontinued ?>
        <th data-name="Discontinued" class="<?= $Grid->Discontinued->headerCellClass() ?>"><div id="elh_products_Discontinued" class="products_Discontinued"><?= $Grid->renderSort($Grid->Discontinued) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_products", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->ProductID->Visible) { // ProductID ?>
        <td data-name="ProductID" <?= $Grid->ProductID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_ProductID" class="form-group">
<input type="<?= $Grid->ProductID->getInputTextType() ?>" data-table="products" data-field="x_ProductID" name="x<?= $Grid->RowIndex ?>_ProductID" id="x<?= $Grid->RowIndex ?>_ProductID" size="30" placeholder="<?= HtmlEncode($Grid->ProductID->getPlaceHolder()) ?>" value="<?= $Grid->ProductID->EditValue ?>"<?= $Grid->ProductID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ProductID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ProductID" id="o<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->ProductID->getInputTextType() ?>" data-table="products" data-field="x_ProductID" name="x<?= $Grid->RowIndex ?>_ProductID" id="x<?= $Grid->RowIndex ?>_ProductID" size="30" placeholder="<?= HtmlEncode($Grid->ProductID->getPlaceHolder()) ?>" value="<?= $Grid->ProductID->EditValue ?>"<?= $Grid->ProductID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ProductID->getErrorMessage() ?></div>
<input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ProductID" id="o<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->OldValue ?? $Grid->ProductID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_ProductID">
<span<?= $Grid->ProductID->viewAttributes() ?>>
<?= $Grid->ProductID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_ProductID" id="fproductsgrid$x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_ProductID" id="fproductsgrid$o<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ProductID" id="x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->ProductName->Visible) { // ProductName ?>
        <td data-name="ProductName" <?= $Grid->ProductName->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_ProductName" class="form-group">
<input type="<?= $Grid->ProductName->getInputTextType() ?>" data-table="products" data-field="x_ProductName" name="x<?= $Grid->RowIndex ?>_ProductName" id="x<?= $Grid->RowIndex ?>_ProductName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ProductName->getPlaceHolder()) ?>" value="<?= $Grid->ProductName->EditValue ?>"<?= $Grid->ProductName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ProductName->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_ProductName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ProductName" id="o<?= $Grid->RowIndex ?>_ProductName" value="<?= HtmlEncode($Grid->ProductName->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_ProductName" class="form-group">
<input type="<?= $Grid->ProductName->getInputTextType() ?>" data-table="products" data-field="x_ProductName" name="x<?= $Grid->RowIndex ?>_ProductName" id="x<?= $Grid->RowIndex ?>_ProductName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ProductName->getPlaceHolder()) ?>" value="<?= $Grid->ProductName->EditValue ?>"<?= $Grid->ProductName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ProductName->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_ProductName">
<span<?= $Grid->ProductName->viewAttributes() ?>>
<?= $Grid->ProductName->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_ProductName" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_ProductName" id="fproductsgrid$x<?= $Grid->RowIndex ?>_ProductName" value="<?= HtmlEncode($Grid->ProductName->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_ProductName" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_ProductName" id="fproductsgrid$o<?= $Grid->RowIndex ?>_ProductName" value="<?= HtmlEncode($Grid->ProductName->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->SupplierID->Visible) { // SupplierID ?>
        <td data-name="SupplierID" <?= $Grid->SupplierID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->SupplierID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_products_SupplierID" class="form-group">
<span<?= $Grid->SupplierID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SupplierID->getDisplayValue($Grid->SupplierID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_SupplierID" name="x<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_products_SupplierID" class="form-group">
<input type="<?= $Grid->SupplierID->getInputTextType() ?>" data-table="products" data-field="x_SupplierID" name="x<?= $Grid->RowIndex ?>_SupplierID" id="x<?= $Grid->RowIndex ?>_SupplierID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->SupplierID->getPlaceHolder()) ?>" value="<?= $Grid->SupplierID->EditValue ?>"<?= $Grid->SupplierID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SupplierID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="products" data-field="x_SupplierID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SupplierID" id="o<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->SupplierID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_products_SupplierID" class="form-group">
<span<?= $Grid->SupplierID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SupplierID->getDisplayValue($Grid->SupplierID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_SupplierID" name="x<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_products_SupplierID" class="form-group">
<input type="<?= $Grid->SupplierID->getInputTextType() ?>" data-table="products" data-field="x_SupplierID" name="x<?= $Grid->RowIndex ?>_SupplierID" id="x<?= $Grid->RowIndex ?>_SupplierID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->SupplierID->getPlaceHolder()) ?>" value="<?= $Grid->SupplierID->EditValue ?>"<?= $Grid->SupplierID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SupplierID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_SupplierID">
<span<?= $Grid->SupplierID->viewAttributes() ?>>
<?= $Grid->SupplierID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_SupplierID" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_SupplierID" id="fproductsgrid$x<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_SupplierID" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_SupplierID" id="fproductsgrid$o<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CategoryID->Visible) { // CategoryID ?>
        <td data-name="CategoryID" <?= $Grid->CategoryID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_CategoryID" class="form-group">
<input type="<?= $Grid->CategoryID->getInputTextType() ?>" data-table="products" data-field="x_CategoryID" name="x<?= $Grid->RowIndex ?>_CategoryID" id="x<?= $Grid->RowIndex ?>_CategoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->CategoryID->getPlaceHolder()) ?>" value="<?= $Grid->CategoryID->EditValue ?>"<?= $Grid->CategoryID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CategoryID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_CategoryID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CategoryID" id="o<?= $Grid->RowIndex ?>_CategoryID" value="<?= HtmlEncode($Grid->CategoryID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_CategoryID" class="form-group">
<input type="<?= $Grid->CategoryID->getInputTextType() ?>" data-table="products" data-field="x_CategoryID" name="x<?= $Grid->RowIndex ?>_CategoryID" id="x<?= $Grid->RowIndex ?>_CategoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->CategoryID->getPlaceHolder()) ?>" value="<?= $Grid->CategoryID->EditValue ?>"<?= $Grid->CategoryID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CategoryID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_CategoryID">
<span<?= $Grid->CategoryID->viewAttributes() ?>>
<?= $Grid->CategoryID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_CategoryID" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_CategoryID" id="fproductsgrid$x<?= $Grid->RowIndex ?>_CategoryID" value="<?= HtmlEncode($Grid->CategoryID->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_CategoryID" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_CategoryID" id="fproductsgrid$o<?= $Grid->RowIndex ?>_CategoryID" value="<?= HtmlEncode($Grid->CategoryID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
        <td data-name="QuantityPerUnit" <?= $Grid->QuantityPerUnit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_QuantityPerUnit" class="form-group">
<input type="<?= $Grid->QuantityPerUnit->getInputTextType() ?>" data-table="products" data-field="x_QuantityPerUnit" name="x<?= $Grid->RowIndex ?>_QuantityPerUnit" id="x<?= $Grid->RowIndex ?>_QuantityPerUnit" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->QuantityPerUnit->getPlaceHolder()) ?>" value="<?= $Grid->QuantityPerUnit->EditValue ?>"<?= $Grid->QuantityPerUnit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QuantityPerUnit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_QuantityPerUnit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QuantityPerUnit" id="o<?= $Grid->RowIndex ?>_QuantityPerUnit" value="<?= HtmlEncode($Grid->QuantityPerUnit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_QuantityPerUnit" class="form-group">
<input type="<?= $Grid->QuantityPerUnit->getInputTextType() ?>" data-table="products" data-field="x_QuantityPerUnit" name="x<?= $Grid->RowIndex ?>_QuantityPerUnit" id="x<?= $Grid->RowIndex ?>_QuantityPerUnit" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->QuantityPerUnit->getPlaceHolder()) ?>" value="<?= $Grid->QuantityPerUnit->EditValue ?>"<?= $Grid->QuantityPerUnit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QuantityPerUnit->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_QuantityPerUnit">
<span<?= $Grid->QuantityPerUnit->viewAttributes() ?>>
<?= $Grid->QuantityPerUnit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_QuantityPerUnit" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_QuantityPerUnit" id="fproductsgrid$x<?= $Grid->RowIndex ?>_QuantityPerUnit" value="<?= HtmlEncode($Grid->QuantityPerUnit->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_QuantityPerUnit" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_QuantityPerUnit" id="fproductsgrid$o<?= $Grid->RowIndex ?>_QuantityPerUnit" value="<?= HtmlEncode($Grid->QuantityPerUnit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->UnitPrice->Visible) { // UnitPrice ?>
        <td data-name="UnitPrice" <?= $Grid->UnitPrice->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitPrice" class="form-group">
<input type="<?= $Grid->UnitPrice->getInputTextType() ?>" data-table="products" data-field="x_UnitPrice" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitPrice->getPlaceHolder()) ?>" value="<?= $Grid->UnitPrice->EditValue ?>"<?= $Grid->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitPrice->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_UnitPrice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitPrice" id="o<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitPrice" class="form-group">
<input type="<?= $Grid->UnitPrice->getInputTextType() ?>" data-table="products" data-field="x_UnitPrice" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitPrice->getPlaceHolder()) ?>" value="<?= $Grid->UnitPrice->EditValue ?>"<?= $Grid->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitPrice->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitPrice">
<span<?= $Grid->UnitPrice->viewAttributes() ?>>
<?= $Grid->UnitPrice->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_UnitPrice" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_UnitPrice" id="fproductsgrid$x<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_UnitPrice" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_UnitPrice" id="fproductsgrid$o<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->UnitsInStock->Visible) { // UnitsInStock ?>
        <td data-name="UnitsInStock" <?= $Grid->UnitsInStock->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitsInStock" class="form-group">
<input type="<?= $Grid->UnitsInStock->getInputTextType() ?>" data-table="products" data-field="x_UnitsInStock" name="x<?= $Grid->RowIndex ?>_UnitsInStock" id="x<?= $Grid->RowIndex ?>_UnitsInStock" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitsInStock->getPlaceHolder()) ?>" value="<?= $Grid->UnitsInStock->EditValue ?>"<?= $Grid->UnitsInStock->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitsInStock->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_UnitsInStock" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitsInStock" id="o<?= $Grid->RowIndex ?>_UnitsInStock" value="<?= HtmlEncode($Grid->UnitsInStock->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitsInStock" class="form-group">
<input type="<?= $Grid->UnitsInStock->getInputTextType() ?>" data-table="products" data-field="x_UnitsInStock" name="x<?= $Grid->RowIndex ?>_UnitsInStock" id="x<?= $Grid->RowIndex ?>_UnitsInStock" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitsInStock->getPlaceHolder()) ?>" value="<?= $Grid->UnitsInStock->EditValue ?>"<?= $Grid->UnitsInStock->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitsInStock->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitsInStock">
<span<?= $Grid->UnitsInStock->viewAttributes() ?>>
<?= $Grid->UnitsInStock->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_UnitsInStock" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_UnitsInStock" id="fproductsgrid$x<?= $Grid->RowIndex ?>_UnitsInStock" value="<?= HtmlEncode($Grid->UnitsInStock->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_UnitsInStock" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_UnitsInStock" id="fproductsgrid$o<?= $Grid->RowIndex ?>_UnitsInStock" value="<?= HtmlEncode($Grid->UnitsInStock->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
        <td data-name="UnitsOnOrder" <?= $Grid->UnitsOnOrder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitsOnOrder" class="form-group">
<input type="<?= $Grid->UnitsOnOrder->getInputTextType() ?>" data-table="products" data-field="x_UnitsOnOrder" name="x<?= $Grid->RowIndex ?>_UnitsOnOrder" id="x<?= $Grid->RowIndex ?>_UnitsOnOrder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitsOnOrder->getPlaceHolder()) ?>" value="<?= $Grid->UnitsOnOrder->EditValue ?>"<?= $Grid->UnitsOnOrder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitsOnOrder->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_UnitsOnOrder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitsOnOrder" id="o<?= $Grid->RowIndex ?>_UnitsOnOrder" value="<?= HtmlEncode($Grid->UnitsOnOrder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitsOnOrder" class="form-group">
<input type="<?= $Grid->UnitsOnOrder->getInputTextType() ?>" data-table="products" data-field="x_UnitsOnOrder" name="x<?= $Grid->RowIndex ?>_UnitsOnOrder" id="x<?= $Grid->RowIndex ?>_UnitsOnOrder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitsOnOrder->getPlaceHolder()) ?>" value="<?= $Grid->UnitsOnOrder->EditValue ?>"<?= $Grid->UnitsOnOrder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitsOnOrder->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_UnitsOnOrder">
<span<?= $Grid->UnitsOnOrder->viewAttributes() ?>>
<?= $Grid->UnitsOnOrder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_UnitsOnOrder" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_UnitsOnOrder" id="fproductsgrid$x<?= $Grid->RowIndex ?>_UnitsOnOrder" value="<?= HtmlEncode($Grid->UnitsOnOrder->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_UnitsOnOrder" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_UnitsOnOrder" id="fproductsgrid$o<?= $Grid->RowIndex ?>_UnitsOnOrder" value="<?= HtmlEncode($Grid->UnitsOnOrder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ReorderLevel->Visible) { // ReorderLevel ?>
        <td data-name="ReorderLevel" <?= $Grid->ReorderLevel->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_ReorderLevel" class="form-group">
<input type="<?= $Grid->ReorderLevel->getInputTextType() ?>" data-table="products" data-field="x_ReorderLevel" name="x<?= $Grid->RowIndex ?>_ReorderLevel" id="x<?= $Grid->RowIndex ?>_ReorderLevel" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ReorderLevel->getPlaceHolder()) ?>" value="<?= $Grid->ReorderLevel->EditValue ?>"<?= $Grid->ReorderLevel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ReorderLevel->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_ReorderLevel" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ReorderLevel" id="o<?= $Grid->RowIndex ?>_ReorderLevel" value="<?= HtmlEncode($Grid->ReorderLevel->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_ReorderLevel" class="form-group">
<input type="<?= $Grid->ReorderLevel->getInputTextType() ?>" data-table="products" data-field="x_ReorderLevel" name="x<?= $Grid->RowIndex ?>_ReorderLevel" id="x<?= $Grid->RowIndex ?>_ReorderLevel" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ReorderLevel->getPlaceHolder()) ?>" value="<?= $Grid->ReorderLevel->EditValue ?>"<?= $Grid->ReorderLevel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ReorderLevel->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_ReorderLevel">
<span<?= $Grid->ReorderLevel->viewAttributes() ?>>
<?= $Grid->ReorderLevel->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_ReorderLevel" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_ReorderLevel" id="fproductsgrid$x<?= $Grid->RowIndex ?>_ReorderLevel" value="<?= HtmlEncode($Grid->ReorderLevel->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_ReorderLevel" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_ReorderLevel" id="fproductsgrid$o<?= $Grid->RowIndex ?>_ReorderLevel" value="<?= HtmlEncode($Grid->ReorderLevel->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Discontinued->Visible) { // Discontinued ?>
        <td data-name="Discontinued" <?= $Grid->Discontinued->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_products_Discontinued" class="form-group">
<input type="<?= $Grid->Discontinued->getInputTextType() ?>" data-table="products" data-field="x_Discontinued" name="x<?= $Grid->RowIndex ?>_Discontinued" id="x<?= $Grid->RowIndex ?>_Discontinued" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Discontinued->getPlaceHolder()) ?>" value="<?= $Grid->Discontinued->EditValue ?>"<?= $Grid->Discontinued->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Discontinued->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="products" data-field="x_Discontinued" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Discontinued" id="o<?= $Grid->RowIndex ?>_Discontinued" value="<?= HtmlEncode($Grid->Discontinued->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_products_Discontinued" class="form-group">
<input type="<?= $Grid->Discontinued->getInputTextType() ?>" data-table="products" data-field="x_Discontinued" name="x<?= $Grid->RowIndex ?>_Discontinued" id="x<?= $Grid->RowIndex ?>_Discontinued" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Discontinued->getPlaceHolder()) ?>" value="<?= $Grid->Discontinued->EditValue ?>"<?= $Grid->Discontinued->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Discontinued->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_products_Discontinued">
<span<?= $Grid->Discontinued->viewAttributes() ?>>
<?= $Grid->Discontinued->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="products" data-field="x_Discontinued" data-hidden="1" name="fproductsgrid$x<?= $Grid->RowIndex ?>_Discontinued" id="fproductsgrid$x<?= $Grid->RowIndex ?>_Discontinued" value="<?= HtmlEncode($Grid->Discontinued->FormValue) ?>">
<input type="hidden" data-table="products" data-field="x_Discontinued" data-hidden="1" name="fproductsgrid$o<?= $Grid->RowIndex ?>_Discontinued" id="fproductsgrid$o<?= $Grid->RowIndex ?>_Discontinued" value="<?= HtmlEncode($Grid->Discontinued->OldValue) ?>">
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
loadjs.ready(["fproductsgrid","load"], function () {
    fproductsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_products", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->ProductID->Visible) { // ProductID ?>
        <td data-name="ProductID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_ProductID" class="form-group products_ProductID">
<input type="<?= $Grid->ProductID->getInputTextType() ?>" data-table="products" data-field="x_ProductID" name="x<?= $Grid->RowIndex ?>_ProductID" id="x<?= $Grid->RowIndex ?>_ProductID" size="30" placeholder="<?= HtmlEncode($Grid->ProductID->getPlaceHolder()) ?>" value="<?= $Grid->ProductID->EditValue ?>"<?= $Grid->ProductID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ProductID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_ProductID" class="form-group products_ProductID">
<span<?= $Grid->ProductID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ProductID->getDisplayValue($Grid->ProductID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ProductID" id="x<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ProductID" id="o<?= $Grid->RowIndex ?>_ProductID" value="<?= HtmlEncode($Grid->ProductID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ProductName->Visible) { // ProductName ?>
        <td data-name="ProductName">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_ProductName" class="form-group products_ProductName">
<input type="<?= $Grid->ProductName->getInputTextType() ?>" data-table="products" data-field="x_ProductName" name="x<?= $Grid->RowIndex ?>_ProductName" id="x<?= $Grid->RowIndex ?>_ProductName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ProductName->getPlaceHolder()) ?>" value="<?= $Grid->ProductName->EditValue ?>"<?= $Grid->ProductName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ProductName->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_ProductName" class="form-group products_ProductName">
<span<?= $Grid->ProductName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ProductName->getDisplayValue($Grid->ProductName->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_ProductName" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ProductName" id="x<?= $Grid->RowIndex ?>_ProductName" value="<?= HtmlEncode($Grid->ProductName->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_ProductName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ProductName" id="o<?= $Grid->RowIndex ?>_ProductName" value="<?= HtmlEncode($Grid->ProductName->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->SupplierID->Visible) { // SupplierID ?>
        <td data-name="SupplierID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->SupplierID->getSessionValue() != "") { ?>
<span id="el$rowindex$_products_SupplierID" class="form-group products_SupplierID">
<span<?= $Grid->SupplierID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SupplierID->getDisplayValue($Grid->SupplierID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_SupplierID" name="x<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_products_SupplierID" class="form-group products_SupplierID">
<input type="<?= $Grid->SupplierID->getInputTextType() ?>" data-table="products" data-field="x_SupplierID" name="x<?= $Grid->RowIndex ?>_SupplierID" id="x<?= $Grid->RowIndex ?>_SupplierID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->SupplierID->getPlaceHolder()) ?>" value="<?= $Grid->SupplierID->EditValue ?>"<?= $Grid->SupplierID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->SupplierID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_products_SupplierID" class="form-group products_SupplierID">
<span<?= $Grid->SupplierID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->SupplierID->getDisplayValue($Grid->SupplierID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_SupplierID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_SupplierID" id="x<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_SupplierID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_SupplierID" id="o<?= $Grid->RowIndex ?>_SupplierID" value="<?= HtmlEncode($Grid->SupplierID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CategoryID->Visible) { // CategoryID ?>
        <td data-name="CategoryID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_CategoryID" class="form-group products_CategoryID">
<input type="<?= $Grid->CategoryID->getInputTextType() ?>" data-table="products" data-field="x_CategoryID" name="x<?= $Grid->RowIndex ?>_CategoryID" id="x<?= $Grid->RowIndex ?>_CategoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->CategoryID->getPlaceHolder()) ?>" value="<?= $Grid->CategoryID->EditValue ?>"<?= $Grid->CategoryID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CategoryID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_CategoryID" class="form-group products_CategoryID">
<span<?= $Grid->CategoryID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CategoryID->getDisplayValue($Grid->CategoryID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_CategoryID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CategoryID" id="x<?= $Grid->RowIndex ?>_CategoryID" value="<?= HtmlEncode($Grid->CategoryID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_CategoryID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CategoryID" id="o<?= $Grid->RowIndex ?>_CategoryID" value="<?= HtmlEncode($Grid->CategoryID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
        <td data-name="QuantityPerUnit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_QuantityPerUnit" class="form-group products_QuantityPerUnit">
<input type="<?= $Grid->QuantityPerUnit->getInputTextType() ?>" data-table="products" data-field="x_QuantityPerUnit" name="x<?= $Grid->RowIndex ?>_QuantityPerUnit" id="x<?= $Grid->RowIndex ?>_QuantityPerUnit" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->QuantityPerUnit->getPlaceHolder()) ?>" value="<?= $Grid->QuantityPerUnit->EditValue ?>"<?= $Grid->QuantityPerUnit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QuantityPerUnit->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_QuantityPerUnit" class="form-group products_QuantityPerUnit">
<span<?= $Grid->QuantityPerUnit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QuantityPerUnit->getDisplayValue($Grid->QuantityPerUnit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_QuantityPerUnit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QuantityPerUnit" id="x<?= $Grid->RowIndex ?>_QuantityPerUnit" value="<?= HtmlEncode($Grid->QuantityPerUnit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_QuantityPerUnit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QuantityPerUnit" id="o<?= $Grid->RowIndex ?>_QuantityPerUnit" value="<?= HtmlEncode($Grid->QuantityPerUnit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->UnitPrice->Visible) { // UnitPrice ?>
        <td data-name="UnitPrice">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_UnitPrice" class="form-group products_UnitPrice">
<input type="<?= $Grid->UnitPrice->getInputTextType() ?>" data-table="products" data-field="x_UnitPrice" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitPrice->getPlaceHolder()) ?>" value="<?= $Grid->UnitPrice->EditValue ?>"<?= $Grid->UnitPrice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitPrice->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_UnitPrice" class="form-group products_UnitPrice">
<span<?= $Grid->UnitPrice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->UnitPrice->getDisplayValue($Grid->UnitPrice->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_UnitPrice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_UnitPrice" id="x<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_UnitPrice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitPrice" id="o<?= $Grid->RowIndex ?>_UnitPrice" value="<?= HtmlEncode($Grid->UnitPrice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->UnitsInStock->Visible) { // UnitsInStock ?>
        <td data-name="UnitsInStock">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_UnitsInStock" class="form-group products_UnitsInStock">
<input type="<?= $Grid->UnitsInStock->getInputTextType() ?>" data-table="products" data-field="x_UnitsInStock" name="x<?= $Grid->RowIndex ?>_UnitsInStock" id="x<?= $Grid->RowIndex ?>_UnitsInStock" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitsInStock->getPlaceHolder()) ?>" value="<?= $Grid->UnitsInStock->EditValue ?>"<?= $Grid->UnitsInStock->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitsInStock->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_UnitsInStock" class="form-group products_UnitsInStock">
<span<?= $Grid->UnitsInStock->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->UnitsInStock->getDisplayValue($Grid->UnitsInStock->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_UnitsInStock" data-hidden="1" name="x<?= $Grid->RowIndex ?>_UnitsInStock" id="x<?= $Grid->RowIndex ?>_UnitsInStock" value="<?= HtmlEncode($Grid->UnitsInStock->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_UnitsInStock" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitsInStock" id="o<?= $Grid->RowIndex ?>_UnitsInStock" value="<?= HtmlEncode($Grid->UnitsInStock->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
        <td data-name="UnitsOnOrder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_UnitsOnOrder" class="form-group products_UnitsOnOrder">
<input type="<?= $Grid->UnitsOnOrder->getInputTextType() ?>" data-table="products" data-field="x_UnitsOnOrder" name="x<?= $Grid->RowIndex ?>_UnitsOnOrder" id="x<?= $Grid->RowIndex ?>_UnitsOnOrder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->UnitsOnOrder->getPlaceHolder()) ?>" value="<?= $Grid->UnitsOnOrder->EditValue ?>"<?= $Grid->UnitsOnOrder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->UnitsOnOrder->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_UnitsOnOrder" class="form-group products_UnitsOnOrder">
<span<?= $Grid->UnitsOnOrder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->UnitsOnOrder->getDisplayValue($Grid->UnitsOnOrder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_UnitsOnOrder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_UnitsOnOrder" id="x<?= $Grid->RowIndex ?>_UnitsOnOrder" value="<?= HtmlEncode($Grid->UnitsOnOrder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_UnitsOnOrder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_UnitsOnOrder" id="o<?= $Grid->RowIndex ?>_UnitsOnOrder" value="<?= HtmlEncode($Grid->UnitsOnOrder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ReorderLevel->Visible) { // ReorderLevel ?>
        <td data-name="ReorderLevel">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_ReorderLevel" class="form-group products_ReorderLevel">
<input type="<?= $Grid->ReorderLevel->getInputTextType() ?>" data-table="products" data-field="x_ReorderLevel" name="x<?= $Grid->RowIndex ?>_ReorderLevel" id="x<?= $Grid->RowIndex ?>_ReorderLevel" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->ReorderLevel->getPlaceHolder()) ?>" value="<?= $Grid->ReorderLevel->EditValue ?>"<?= $Grid->ReorderLevel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ReorderLevel->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_ReorderLevel" class="form-group products_ReorderLevel">
<span<?= $Grid->ReorderLevel->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ReorderLevel->getDisplayValue($Grid->ReorderLevel->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_ReorderLevel" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ReorderLevel" id="x<?= $Grid->RowIndex ?>_ReorderLevel" value="<?= HtmlEncode($Grid->ReorderLevel->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_ReorderLevel" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ReorderLevel" id="o<?= $Grid->RowIndex ?>_ReorderLevel" value="<?= HtmlEncode($Grid->ReorderLevel->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->Discontinued->Visible) { // Discontinued ?>
        <td data-name="Discontinued">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_products_Discontinued" class="form-group products_Discontinued">
<input type="<?= $Grid->Discontinued->getInputTextType() ?>" data-table="products" data-field="x_Discontinued" name="x<?= $Grid->RowIndex ?>_Discontinued" id="x<?= $Grid->RowIndex ?>_Discontinued" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Discontinued->getPlaceHolder()) ?>" value="<?= $Grid->Discontinued->EditValue ?>"<?= $Grid->Discontinued->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Discontinued->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_products_Discontinued" class="form-group products_Discontinued">
<span<?= $Grid->Discontinued->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Discontinued->getDisplayValue($Grid->Discontinued->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="products" data-field="x_Discontinued" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Discontinued" id="x<?= $Grid->RowIndex ?>_Discontinued" value="<?= HtmlEncode($Grid->Discontinued->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="products" data-field="x_Discontinued" data-hidden="1" name="o<?= $Grid->RowIndex ?>_Discontinued" id="o<?= $Grid->RowIndex ?>_Discontinued" value="<?= HtmlEncode($Grid->Discontinued->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fproductsgrid","load"], function() {
    fproductsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fproductsgrid">
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
    ew.addEventHandlers("products");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
