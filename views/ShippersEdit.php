<?php

namespace PHPMaker2021\northwindapi;

// Page object
$ShippersEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fshippersedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fshippersedit = currentForm = new ew.Form("fshippersedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "shippers")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.shippers)
        ew.vars.tables.shippers = currentTable;
    fshippersedit.addFields([
        ["ShipperID", [fields.ShipperID.visible && fields.ShipperID.required ? ew.Validators.required(fields.ShipperID.caption) : null], fields.ShipperID.isInvalid],
        ["CompanyName", [fields.CompanyName.visible && fields.CompanyName.required ? ew.Validators.required(fields.CompanyName.caption) : null], fields.CompanyName.isInvalid],
        ["Phone", [fields.Phone.visible && fields.Phone.required ? ew.Validators.required(fields.Phone.caption) : null], fields.Phone.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fshippersedit,
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
    fshippersedit.validate = function () {
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
    fshippersedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fshippersedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fshippersedit");
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
<form name="fshippersedit" id="fshippersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="shippers">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
    <div id="r_ShipperID" class="form-group row">
        <label id="elh_shippers_ShipperID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipperID->caption() ?><?= $Page->ShipperID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipperID->cellAttributes() ?>>
<span id="el_shippers_ShipperID">
<span<?= $Page->ShipperID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ShipperID->getDisplayValue($Page->ShipperID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="shippers" data-field="x_ShipperID" data-hidden="1" name="x_ShipperID" id="x_ShipperID" value="<?= HtmlEncode($Page->ShipperID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
    <div id="r_CompanyName" class="form-group row">
        <label id="elh_shippers_CompanyName" for="x_CompanyName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CompanyName->caption() ?><?= $Page->CompanyName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CompanyName->cellAttributes() ?>>
<span id="el_shippers_CompanyName">
<input type="<?= $Page->CompanyName->getInputTextType() ?>" data-table="shippers" data-field="x_CompanyName" name="x_CompanyName" id="x_CompanyName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->CompanyName->getPlaceHolder()) ?>" value="<?= $Page->CompanyName->EditValue ?>"<?= $Page->CompanyName->editAttributes() ?> aria-describedby="x_CompanyName_help">
<?= $Page->CompanyName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CompanyName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
    <div id="r_Phone" class="form-group row">
        <label id="elh_shippers_Phone" for="x_Phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Phone->caption() ?><?= $Page->Phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Phone->cellAttributes() ?>>
<span id="el_shippers_Phone">
<input type="<?= $Page->Phone->getInputTextType() ?>" data-table="shippers" data-field="x_Phone" name="x_Phone" id="x_Phone" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Phone->getPlaceHolder()) ?>" value="<?= $Page->Phone->EditValue ?>"<?= $Page->Phone->editAttributes() ?> aria-describedby="x_Phone_help">
<?= $Page->Phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Phone->getErrorMessage() ?></div>
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
    ew.addEventHandlers("shippers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
