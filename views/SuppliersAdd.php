<?php

namespace PHPMaker2021\northwindapi;

// Page object
$SuppliersAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsuppliersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsuppliersadd = currentForm = new ew.Form("fsuppliersadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "suppliers")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.suppliers)
        ew.vars.tables.suppliers = currentTable;
    fsuppliersadd.addFields([
        ["SupplierID", [fields.SupplierID.visible && fields.SupplierID.required ? ew.Validators.required(fields.SupplierID.caption) : null, ew.Validators.integer], fields.SupplierID.isInvalid],
        ["CompanyName", [fields.CompanyName.visible && fields.CompanyName.required ? ew.Validators.required(fields.CompanyName.caption) : null], fields.CompanyName.isInvalid],
        ["ContactName", [fields.ContactName.visible && fields.ContactName.required ? ew.Validators.required(fields.ContactName.caption) : null], fields.ContactName.isInvalid],
        ["ContactTitle", [fields.ContactTitle.visible && fields.ContactTitle.required ? ew.Validators.required(fields.ContactTitle.caption) : null], fields.ContactTitle.isInvalid],
        ["Address", [fields.Address.visible && fields.Address.required ? ew.Validators.required(fields.Address.caption) : null], fields.Address.isInvalid],
        ["City", [fields.City.visible && fields.City.required ? ew.Validators.required(fields.City.caption) : null], fields.City.isInvalid],
        ["Region", [fields.Region.visible && fields.Region.required ? ew.Validators.required(fields.Region.caption) : null], fields.Region.isInvalid],
        ["PostalCode", [fields.PostalCode.visible && fields.PostalCode.required ? ew.Validators.required(fields.PostalCode.caption) : null], fields.PostalCode.isInvalid],
        ["Country", [fields.Country.visible && fields.Country.required ? ew.Validators.required(fields.Country.caption) : null], fields.Country.isInvalid],
        ["Phone", [fields.Phone.visible && fields.Phone.required ? ew.Validators.required(fields.Phone.caption) : null], fields.Phone.isInvalid],
        ["Fax", [fields.Fax.visible && fields.Fax.required ? ew.Validators.required(fields.Fax.caption) : null], fields.Fax.isInvalid],
        ["HomePage", [fields.HomePage.visible && fields.HomePage.required ? ew.Validators.required(fields.HomePage.caption) : null], fields.HomePage.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsuppliersadd,
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
    fsuppliersadd.validate = function () {
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
    fsuppliersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsuppliersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsuppliersadd");
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
<form name="fsuppliersadd" id="fsuppliersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="suppliers">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->SupplierID->Visible) { // SupplierID ?>
    <div id="r_SupplierID" class="form-group row">
        <label id="elh_suppliers_SupplierID" for="x_SupplierID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SupplierID->caption() ?><?= $Page->SupplierID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SupplierID->cellAttributes() ?>>
<span id="el_suppliers_SupplierID">
<input type="<?= $Page->SupplierID->getInputTextType() ?>" data-table="suppliers" data-field="x_SupplierID" name="x_SupplierID" id="x_SupplierID" size="30" placeholder="<?= HtmlEncode($Page->SupplierID->getPlaceHolder()) ?>" value="<?= $Page->SupplierID->EditValue ?>"<?= $Page->SupplierID->editAttributes() ?> aria-describedby="x_SupplierID_help">
<?= $Page->SupplierID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SupplierID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
    <div id="r_CompanyName" class="form-group row">
        <label id="elh_suppliers_CompanyName" for="x_CompanyName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CompanyName->caption() ?><?= $Page->CompanyName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CompanyName->cellAttributes() ?>>
<span id="el_suppliers_CompanyName">
<input type="<?= $Page->CompanyName->getInputTextType() ?>" data-table="suppliers" data-field="x_CompanyName" name="x_CompanyName" id="x_CompanyName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->CompanyName->getPlaceHolder()) ?>" value="<?= $Page->CompanyName->EditValue ?>"<?= $Page->CompanyName->editAttributes() ?> aria-describedby="x_CompanyName_help">
<?= $Page->CompanyName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CompanyName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ContactName->Visible) { // ContactName ?>
    <div id="r_ContactName" class="form-group row">
        <label id="elh_suppliers_ContactName" for="x_ContactName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ContactName->caption() ?><?= $Page->ContactName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ContactName->cellAttributes() ?>>
<span id="el_suppliers_ContactName">
<input type="<?= $Page->ContactName->getInputTextType() ?>" data-table="suppliers" data-field="x_ContactName" name="x_ContactName" id="x_ContactName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ContactName->getPlaceHolder()) ?>" value="<?= $Page->ContactName->EditValue ?>"<?= $Page->ContactName->editAttributes() ?> aria-describedby="x_ContactName_help">
<?= $Page->ContactName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ContactName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ContactTitle->Visible) { // ContactTitle ?>
    <div id="r_ContactTitle" class="form-group row">
        <label id="elh_suppliers_ContactTitle" for="x_ContactTitle" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ContactTitle->caption() ?><?= $Page->ContactTitle->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ContactTitle->cellAttributes() ?>>
<span id="el_suppliers_ContactTitle">
<input type="<?= $Page->ContactTitle->getInputTextType() ?>" data-table="suppliers" data-field="x_ContactTitle" name="x_ContactTitle" id="x_ContactTitle" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ContactTitle->getPlaceHolder()) ?>" value="<?= $Page->ContactTitle->EditValue ?>"<?= $Page->ContactTitle->editAttributes() ?> aria-describedby="x_ContactTitle_help">
<?= $Page->ContactTitle->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ContactTitle->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
    <div id="r_Address" class="form-group row">
        <label id="elh_suppliers_Address" for="x_Address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Address->caption() ?><?= $Page->Address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Address->cellAttributes() ?>>
<span id="el_suppliers_Address">
<input type="<?= $Page->Address->getInputTextType() ?>" data-table="suppliers" data-field="x_Address" name="x_Address" id="x_Address" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Address->getPlaceHolder()) ?>" value="<?= $Page->Address->EditValue ?>"<?= $Page->Address->editAttributes() ?> aria-describedby="x_Address_help">
<?= $Page->Address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
    <div id="r_City" class="form-group row">
        <label id="elh_suppliers_City" for="x_City" class="<?= $Page->LeftColumnClass ?>"><?= $Page->City->caption() ?><?= $Page->City->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->City->cellAttributes() ?>>
<span id="el_suppliers_City">
<input type="<?= $Page->City->getInputTextType() ?>" data-table="suppliers" data-field="x_City" name="x_City" id="x_City" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->City->getPlaceHolder()) ?>" value="<?= $Page->City->EditValue ?>"<?= $Page->City->editAttributes() ?> aria-describedby="x_City_help">
<?= $Page->City->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->City->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
    <div id="r_Region" class="form-group row">
        <label id="elh_suppliers_Region" for="x_Region" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Region->caption() ?><?= $Page->Region->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Region->cellAttributes() ?>>
<span id="el_suppliers_Region">
<input type="<?= $Page->Region->getInputTextType() ?>" data-table="suppliers" data-field="x_Region" name="x_Region" id="x_Region" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Region->getPlaceHolder()) ?>" value="<?= $Page->Region->EditValue ?>"<?= $Page->Region->editAttributes() ?> aria-describedby="x_Region_help">
<?= $Page->Region->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Region->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
    <div id="r_PostalCode" class="form-group row">
        <label id="elh_suppliers_PostalCode" for="x_PostalCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PostalCode->caption() ?><?= $Page->PostalCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el_suppliers_PostalCode">
<input type="<?= $Page->PostalCode->getInputTextType() ?>" data-table="suppliers" data-field="x_PostalCode" name="x_PostalCode" id="x_PostalCode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->PostalCode->getPlaceHolder()) ?>" value="<?= $Page->PostalCode->EditValue ?>"<?= $Page->PostalCode->editAttributes() ?> aria-describedby="x_PostalCode_help">
<?= $Page->PostalCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PostalCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
    <div id="r_Country" class="form-group row">
        <label id="elh_suppliers_Country" for="x_Country" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Country->caption() ?><?= $Page->Country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Country->cellAttributes() ?>>
<span id="el_suppliers_Country">
<input type="<?= $Page->Country->getInputTextType() ?>" data-table="suppliers" data-field="x_Country" name="x_Country" id="x_Country" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Country->getPlaceHolder()) ?>" value="<?= $Page->Country->EditValue ?>"<?= $Page->Country->editAttributes() ?> aria-describedby="x_Country_help">
<?= $Page->Country->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Country->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
    <div id="r_Phone" class="form-group row">
        <label id="elh_suppliers_Phone" for="x_Phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Phone->caption() ?><?= $Page->Phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Phone->cellAttributes() ?>>
<span id="el_suppliers_Phone">
<input type="<?= $Page->Phone->getInputTextType() ?>" data-table="suppliers" data-field="x_Phone" name="x_Phone" id="x_Phone" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Phone->getPlaceHolder()) ?>" value="<?= $Page->Phone->EditValue ?>"<?= $Page->Phone->editAttributes() ?> aria-describedby="x_Phone_help">
<?= $Page->Phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Fax->Visible) { // Fax ?>
    <div id="r_Fax" class="form-group row">
        <label id="elh_suppliers_Fax" for="x_Fax" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Fax->caption() ?><?= $Page->Fax->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Fax->cellAttributes() ?>>
<span id="el_suppliers_Fax">
<input type="<?= $Page->Fax->getInputTextType() ?>" data-table="suppliers" data-field="x_Fax" name="x_Fax" id="x_Fax" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Fax->getPlaceHolder()) ?>" value="<?= $Page->Fax->EditValue ?>"<?= $Page->Fax->editAttributes() ?> aria-describedby="x_Fax_help">
<?= $Page->Fax->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Fax->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->HomePage->Visible) { // HomePage ?>
    <div id="r_HomePage" class="form-group row">
        <label id="elh_suppliers_HomePage" for="x_HomePage" class="<?= $Page->LeftColumnClass ?>"><?= $Page->HomePage->caption() ?><?= $Page->HomePage->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->HomePage->cellAttributes() ?>>
<span id="el_suppliers_HomePage">
<input type="<?= $Page->HomePage->getInputTextType() ?>" data-table="suppliers" data-field="x_HomePage" name="x_HomePage" id="x_HomePage" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->HomePage->getPlaceHolder()) ?>" value="<?= $Page->HomePage->EditValue ?>"<?= $Page->HomePage->editAttributes() ?> aria-describedby="x_HomePage_help">
<?= $Page->HomePage->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->HomePage->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("suppliers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
