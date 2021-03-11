<?php

namespace PHPMaker2021\northwindapi;

// Page object
$TerritoriesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fterritoriesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fterritoriesedit = currentForm = new ew.Form("fterritoriesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "territories")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.territories)
        ew.vars.tables.territories = currentTable;
    fterritoriesedit.addFields([
        ["TerritoryID", [fields.TerritoryID.visible && fields.TerritoryID.required ? ew.Validators.required(fields.TerritoryID.caption) : null], fields.TerritoryID.isInvalid],
        ["TerritoryDescription", [fields.TerritoryDescription.visible && fields.TerritoryDescription.required ? ew.Validators.required(fields.TerritoryDescription.caption) : null], fields.TerritoryDescription.isInvalid],
        ["RegionID", [fields.RegionID.visible && fields.RegionID.required ? ew.Validators.required(fields.RegionID.caption) : null], fields.RegionID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fterritoriesedit,
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
    fterritoriesedit.validate = function () {
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
    fterritoriesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fterritoriesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fterritoriesedit");
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
<form name="fterritoriesedit" id="fterritoriesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="territories">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->TerritoryID->Visible) { // TerritoryID ?>
    <div id="r_TerritoryID" class="form-group row">
        <label id="elh_territories_TerritoryID" for="x_TerritoryID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TerritoryID->caption() ?><?= $Page->TerritoryID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TerritoryID->cellAttributes() ?>>
<input type="<?= $Page->TerritoryID->getInputTextType() ?>" data-table="territories" data-field="x_TerritoryID" name="x_TerritoryID" id="x_TerritoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->TerritoryID->getPlaceHolder()) ?>" value="<?= $Page->TerritoryID->EditValue ?>"<?= $Page->TerritoryID->editAttributes() ?> aria-describedby="x_TerritoryID_help">
<?= $Page->TerritoryID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TerritoryID->getErrorMessage() ?></div>
<input type="hidden" data-table="territories" data-field="x_TerritoryID" data-hidden="1" name="o_TerritoryID" id="o_TerritoryID" value="<?= HtmlEncode($Page->TerritoryID->OldValue ?? $Page->TerritoryID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TerritoryDescription->Visible) { // TerritoryDescription ?>
    <div id="r_TerritoryDescription" class="form-group row">
        <label id="elh_territories_TerritoryDescription" for="x_TerritoryDescription" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TerritoryDescription->caption() ?><?= $Page->TerritoryDescription->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TerritoryDescription->cellAttributes() ?>>
<span id="el_territories_TerritoryDescription">
<input type="<?= $Page->TerritoryDescription->getInputTextType() ?>" data-table="territories" data-field="x_TerritoryDescription" name="x_TerritoryDescription" id="x_TerritoryDescription" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->TerritoryDescription->getPlaceHolder()) ?>" value="<?= $Page->TerritoryDescription->EditValue ?>"<?= $Page->TerritoryDescription->editAttributes() ?> aria-describedby="x_TerritoryDescription_help">
<?= $Page->TerritoryDescription->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TerritoryDescription->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RegionID->Visible) { // RegionID ?>
    <div id="r_RegionID" class="form-group row">
        <label id="elh_territories_RegionID" for="x_RegionID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RegionID->caption() ?><?= $Page->RegionID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RegionID->cellAttributes() ?>>
<span id="el_territories_RegionID">
<input type="<?= $Page->RegionID->getInputTextType() ?>" data-table="territories" data-field="x_RegionID" name="x_RegionID" id="x_RegionID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->RegionID->getPlaceHolder()) ?>" value="<?= $Page->RegionID->EditValue ?>"<?= $Page->RegionID->editAttributes() ?> aria-describedby="x_RegionID_help">
<?= $Page->RegionID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RegionID->getErrorMessage() ?></div>
</span>
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
    ew.addEventHandlers("territories");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
