<?php

namespace PHPMaker2021\northwindapi;

// Page object
$EmployeeterritoriesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var femployeeterritoriesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    femployeeterritoriesedit = currentForm = new ew.Form("femployeeterritoriesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "employeeterritories")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.employeeterritories)
        ew.vars.tables.employeeterritories = currentTable;
    femployeeterritoriesedit.addFields([
        ["EmployeeID", [fields.EmployeeID.visible && fields.EmployeeID.required ? ew.Validators.required(fields.EmployeeID.caption) : null, ew.Validators.integer], fields.EmployeeID.isInvalid],
        ["TerritoryID", [fields.TerritoryID.visible && fields.TerritoryID.required ? ew.Validators.required(fields.TerritoryID.caption) : null], fields.TerritoryID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = femployeeterritoriesedit,
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
    femployeeterritoriesedit.validate = function () {
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

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    femployeeterritoriesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femployeeterritoriesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("femployeeterritoriesedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="femployeeterritoriesedit" id="femployeeterritoriesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employeeterritories">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "employees") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="employees">
<input type="hidden" name="fk_EmployeeID" value="<?= HtmlEncode($Page->EmployeeID->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
    <div id="r_EmployeeID" class="form-group row">
        <label id="elh_employeeterritories_EmployeeID" for="x_EmployeeID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EmployeeID->caption() ?><?= $Page->EmployeeID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EmployeeID->cellAttributes() ?>>
<?php if ($Page->EmployeeID->getSessionValue() != "") { ?>
<span id="el_employeeterritories_EmployeeID">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->EmployeeID->getDisplayValue($Page->EmployeeID->EditValue))) ?>"></span>
</span>
<input type="hidden" id="x_EmployeeID" name="x_EmployeeID" value="<?= HtmlEncode($Page->EmployeeID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->EmployeeID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_EmployeeID" name="x_EmployeeID" id="x_EmployeeID" size="30" placeholder="<?= HtmlEncode($Page->EmployeeID->getPlaceHolder()) ?>" value="<?= $Page->EmployeeID->EditValue ?>"<?= $Page->EmployeeID->editAttributes() ?> aria-describedby="x_EmployeeID_help">
<?= $Page->EmployeeID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EmployeeID->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="employeeterritories" data-field="x_EmployeeID" data-hidden="1" name="o_EmployeeID" id="o_EmployeeID" value="<?= HtmlEncode($Page->EmployeeID->OldValue ?? $Page->EmployeeID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TerritoryID->Visible) { // TerritoryID ?>
    <div id="r_TerritoryID" class="form-group row">
        <label id="elh_employeeterritories_TerritoryID" for="x_TerritoryID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TerritoryID->caption() ?><?= $Page->TerritoryID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TerritoryID->cellAttributes() ?>>
<input type="<?= $Page->TerritoryID->getInputTextType() ?>" data-table="employeeterritories" data-field="x_TerritoryID" name="x_TerritoryID" id="x_TerritoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->TerritoryID->getPlaceHolder()) ?>" value="<?= $Page->TerritoryID->EditValue ?>"<?= $Page->TerritoryID->editAttributes() ?> aria-describedby="x_TerritoryID_help">
<?= $Page->TerritoryID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TerritoryID->getErrorMessage() ?></div>
<input type="hidden" data-table="employeeterritories" data-field="x_TerritoryID" data-hidden="1" name="o_TerritoryID" id="o_TerritoryID" value="<?= HtmlEncode($Page->TerritoryID->OldValue ?? $Page->TerritoryID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
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
