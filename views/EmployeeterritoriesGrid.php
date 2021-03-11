<?php

namespace PHPMaker2021\northwindapi;

// Set up and run Grid object
$Grid = Container("EmployeeterritoriesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var femployeeterritoriesgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    femployeeterritoriesgrid = new ew.Form("femployeeterritoriesgrid", "grid");
    femployeeterritoriesgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "employeeterritories")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.employeeterritories)
        ew.vars.tables.employeeterritories = currentTable;
    femployeeterritoriesgrid.addFields([
        ["EmployeeID", [fields.EmployeeID.visible && fields.EmployeeID.required ? ew.Validators.required(fields.EmployeeID.caption) : null, ew.Validators.integer], fields.EmployeeID.isInvalid],
        ["TerritoryID", [fields.TerritoryID.visible && fields.TerritoryID.required ? ew.Validators.required(fields.TerritoryID.caption) : null], fields.TerritoryID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = femployeeterritoriesgrid,
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
    femployeeterritoriesgrid.validate = function () {
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
    femployeeterritoriesgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "EmployeeID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TerritoryID", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    femployeeterritoriesgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femployeeterritoriesgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("femployeeterritoriesgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> employeeterritories">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="femployeeterritoriesgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_employeeterritories" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_employeeterritoriesgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->EmployeeID->Visible) { // EmployeeID ?>
        <th data-name="EmployeeID" class="<?= $Grid->EmployeeID->headerCellClass() ?>"><div id="elh_employeeterritories_EmployeeID" class="employeeterritories_EmployeeID"><?= $Grid->renderSort($Grid->EmployeeID) ?></div></th>
<?php } ?>
<?php if ($Grid->TerritoryID->Visible) { // TerritoryID ?>
        <th data-name="TerritoryID" class="<?= $Grid->TerritoryID->headerCellClass() ?>"><div id="elh_employeeterritories_TerritoryID" class="employeeterritories_TerritoryID"><?= $Grid->renderSort($Grid->TerritoryID) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_employeeterritories", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->EmployeeID->Visible) { // EmployeeID ?>
        <td data-name="EmployeeID" <?= $Grid->EmployeeID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->EmployeeID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_employeeterritories_EmployeeID" class="form-group">
<span<?= $Grid->EmployeeID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EmployeeID->getDisplayValue($Grid->EmployeeID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_EmployeeID" name="x<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_employeeterritories_EmployeeID" class="form-group">
<input type="<?= $Grid->EmployeeID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_EmployeeID" name="x<?= $Grid->RowIndex ?>_EmployeeID" id="x<?= $Grid->RowIndex ?>_EmployeeID" size="30" placeholder="<?= HtmlEncode($Grid->EmployeeID->getPlaceHolder()) ?>" value="<?= $Grid->EmployeeID->EditValue ?>"<?= $Grid->EmployeeID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EmployeeID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EmployeeID" id="o<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->EmployeeID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_employeeterritories_EmployeeID" class="form-group">
<span<?= $Grid->EmployeeID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EmployeeID->getDisplayValue($Grid->EmployeeID->EditValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_EmployeeID" name="x<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Grid->EmployeeID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_EmployeeID" name="x<?= $Grid->RowIndex ?>_EmployeeID" id="x<?= $Grid->RowIndex ?>_EmployeeID" size="30" placeholder="<?= HtmlEncode($Grid->EmployeeID->getPlaceHolder()) ?>" value="<?= $Grid->EmployeeID->EditValue ?>"<?= $Grid->EmployeeID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EmployeeID->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EmployeeID" id="o<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->OldValue ?? $Grid->EmployeeID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_employeeterritories_EmployeeID">
<span<?= $Grid->EmployeeID->viewAttributes() ?>>
<?= $Grid->EmployeeID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="femployeeterritoriesgrid$x<?= $Grid->RowIndex ?>_EmployeeID" id="femployeeterritoriesgrid$x<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->FormValue) ?>">
<input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="femployeeterritoriesgrid$o<?= $Grid->RowIndex ?>_EmployeeID" id="femployeeterritoriesgrid$o<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EmployeeID" id="x<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->TerritoryID->Visible) { // TerritoryID ?>
        <td data-name="TerritoryID" <?= $Grid->TerritoryID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_employeeterritories_TerritoryID" class="form-group">
<input type="<?= $Grid->TerritoryID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_TerritoryID" name="x<?= $Grid->RowIndex ?>_TerritoryID" id="x<?= $Grid->RowIndex ?>_TerritoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->TerritoryID->getPlaceHolder()) ?>" value="<?= $Grid->TerritoryID->EditValue ?>"<?= $Grid->TerritoryID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TerritoryID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TerritoryID" id="o<?= $Grid->RowIndex ?>_TerritoryID" value="<?= HtmlEncode($Grid->TerritoryID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->TerritoryID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_TerritoryID" name="x<?= $Grid->RowIndex ?>_TerritoryID" id="x<?= $Grid->RowIndex ?>_TerritoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->TerritoryID->getPlaceHolder()) ?>" value="<?= $Grid->TerritoryID->EditValue ?>"<?= $Grid->TerritoryID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TerritoryID->getErrorMessage() ?></div>
<input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TerritoryID" id="o<?= $Grid->RowIndex ?>_TerritoryID" value="<?= HtmlEncode($Grid->TerritoryID->OldValue ?? $Grid->TerritoryID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_employeeterritories_TerritoryID">
<span<?= $Grid->TerritoryID->viewAttributes() ?>>
<?= $Grid->TerritoryID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="femployeeterritoriesgrid$x<?= $Grid->RowIndex ?>_TerritoryID" id="femployeeterritoriesgrid$x<?= $Grid->RowIndex ?>_TerritoryID" value="<?= HtmlEncode($Grid->TerritoryID->FormValue) ?>">
<input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="femployeeterritoriesgrid$o<?= $Grid->RowIndex ?>_TerritoryID" id="femployeeterritoriesgrid$o<?= $Grid->RowIndex ?>_TerritoryID" value="<?= HtmlEncode($Grid->TerritoryID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TerritoryID" id="x<?= $Grid->RowIndex ?>_TerritoryID" value="<?= HtmlEncode($Grid->TerritoryID->CurrentValue) ?>">
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["femployeeterritoriesgrid","load"], function () {
    femployeeterritoriesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_employeeterritories", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->EmployeeID->Visible) { // EmployeeID ?>
        <td data-name="EmployeeID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->EmployeeID->getSessionValue() != "") { ?>
<span id="el$rowindex$_employeeterritories_EmployeeID" class="form-group employeeterritories_EmployeeID">
<span<?= $Grid->EmployeeID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EmployeeID->getDisplayValue($Grid->EmployeeID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_EmployeeID" name="x<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_employeeterritories_EmployeeID" class="form-group employeeterritories_EmployeeID">
<input type="<?= $Grid->EmployeeID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_EmployeeID" name="x<?= $Grid->RowIndex ?>_EmployeeID" id="x<?= $Grid->RowIndex ?>_EmployeeID" size="30" placeholder="<?= HtmlEncode($Grid->EmployeeID->getPlaceHolder()) ?>" value="<?= $Grid->EmployeeID->EditValue ?>"<?= $Grid->EmployeeID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EmployeeID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_employeeterritories_EmployeeID" class="form-group employeeterritories_EmployeeID">
<span<?= $Grid->EmployeeID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EmployeeID->getDisplayValue($Grid->EmployeeID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EmployeeID" id="x<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EmployeeID" id="o<?= $Grid->RowIndex ?>_EmployeeID" value="<?= HtmlEncode($Grid->EmployeeID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TerritoryID->Visible) { // TerritoryID ?>
        <td data-name="TerritoryID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_employeeterritories_TerritoryID" class="form-group employeeterritories_TerritoryID">
<input type="<?= $Grid->TerritoryID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_TerritoryID" name="x<?= $Grid->RowIndex ?>_TerritoryID" id="x<?= $Grid->RowIndex ?>_TerritoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->TerritoryID->getPlaceHolder()) ?>" value="<?= $Grid->TerritoryID->EditValue ?>"<?= $Grid->TerritoryID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TerritoryID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_employeeterritories_TerritoryID" class="form-group employeeterritories_TerritoryID">
<span<?= $Grid->TerritoryID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TerritoryID->getDisplayValue($Grid->TerritoryID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TerritoryID" id="x<?= $Grid->RowIndex ?>_TerritoryID" value="<?= HtmlEncode($Grid->TerritoryID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TerritoryID" id="o<?= $Grid->RowIndex ?>_TerritoryID" value="<?= HtmlEncode($Grid->TerritoryID->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["femployeeterritoriesgrid","load"], function() {
    femployeeterritoriesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="femployeeterritoriesgrid">
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
    ew.addEventHandlers("employeeterritories");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
