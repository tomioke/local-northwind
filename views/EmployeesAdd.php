<?php

namespace PHPMaker2021\northwindapi;

// Page object
$EmployeesAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var femployeesadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    femployeesadd = currentForm = new ew.Form("femployeesadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "employees")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.employees)
        ew.vars.tables.employees = currentTable;
    femployeesadd.addFields([
        ["LastName", [fields.LastName.visible && fields.LastName.required ? ew.Validators.required(fields.LastName.caption) : null], fields.LastName.isInvalid],
        ["FirstName", [fields.FirstName.visible && fields.FirstName.required ? ew.Validators.required(fields.FirstName.caption) : null], fields.FirstName.isInvalid],
        ["Title", [fields.Title.visible && fields.Title.required ? ew.Validators.required(fields.Title.caption) : null], fields.Title.isInvalid],
        ["TitleOfCourtesy", [fields.TitleOfCourtesy.visible && fields.TitleOfCourtesy.required ? ew.Validators.required(fields.TitleOfCourtesy.caption) : null], fields.TitleOfCourtesy.isInvalid],
        ["BirthDate", [fields.BirthDate.visible && fields.BirthDate.required ? ew.Validators.required(fields.BirthDate.caption) : null], fields.BirthDate.isInvalid],
        ["HireDate", [fields.HireDate.visible && fields.HireDate.required ? ew.Validators.required(fields.HireDate.caption) : null], fields.HireDate.isInvalid],
        ["Address", [fields.Address.visible && fields.Address.required ? ew.Validators.required(fields.Address.caption) : null], fields.Address.isInvalid],
        ["City", [fields.City.visible && fields.City.required ? ew.Validators.required(fields.City.caption) : null], fields.City.isInvalid],
        ["Region", [fields.Region.visible && fields.Region.required ? ew.Validators.required(fields.Region.caption) : null], fields.Region.isInvalid],
        ["PostalCode", [fields.PostalCode.visible && fields.PostalCode.required ? ew.Validators.required(fields.PostalCode.caption) : null], fields.PostalCode.isInvalid],
        ["Country", [fields.Country.visible && fields.Country.required ? ew.Validators.required(fields.Country.caption) : null], fields.Country.isInvalid],
        ["HomePhone", [fields.HomePhone.visible && fields.HomePhone.required ? ew.Validators.required(fields.HomePhone.caption) : null], fields.HomePhone.isInvalid],
        ["Extension", [fields.Extension.visible && fields.Extension.required ? ew.Validators.required(fields.Extension.caption) : null], fields.Extension.isInvalid],
        ["Photo", [fields.Photo.visible && fields.Photo.required ? ew.Validators.required(fields.Photo.caption) : null], fields.Photo.isInvalid],
        ["Notes", [fields.Notes.visible && fields.Notes.required ? ew.Validators.required(fields.Notes.caption) : null], fields.Notes.isInvalid],
        ["ReportsTo", [fields.ReportsTo.visible && fields.ReportsTo.required ? ew.Validators.required(fields.ReportsTo.caption) : null], fields.ReportsTo.isInvalid],
        ["PhotoPath", [fields.PhotoPath.visible && fields.PhotoPath.required ? ew.Validators.required(fields.PhotoPath.caption) : null], fields.PhotoPath.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = femployeesadd,
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
    femployeesadd.validate = function () {
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
    femployeesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femployeesadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("femployeesadd");
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
<form name="femployeesadd" id="femployeesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->LastName->Visible) { // LastName ?>
    <div id="r_LastName" class="form-group row">
        <label id="elh_employees_LastName" for="x_LastName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LastName->caption() ?><?= $Page->LastName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LastName->cellAttributes() ?>>
<span id="el_employees_LastName">
<input type="<?= $Page->LastName->getInputTextType() ?>" data-table="employees" data-field="x_LastName" name="x_LastName" id="x_LastName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->LastName->getPlaceHolder()) ?>" value="<?= $Page->LastName->EditValue ?>"<?= $Page->LastName->editAttributes() ?> aria-describedby="x_LastName_help">
<?= $Page->LastName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LastName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
    <div id="r_FirstName" class="form-group row">
        <label id="elh_employees_FirstName" for="x_FirstName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FirstName->caption() ?><?= $Page->FirstName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FirstName->cellAttributes() ?>>
<span id="el_employees_FirstName">
<input type="<?= $Page->FirstName->getInputTextType() ?>" data-table="employees" data-field="x_FirstName" name="x_FirstName" id="x_FirstName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->FirstName->getPlaceHolder()) ?>" value="<?= $Page->FirstName->EditValue ?>"<?= $Page->FirstName->editAttributes() ?> aria-describedby="x_FirstName_help">
<?= $Page->FirstName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FirstName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Title->Visible) { // Title ?>
    <div id="r_Title" class="form-group row">
        <label id="elh_employees_Title" for="x_Title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Title->caption() ?><?= $Page->Title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Title->cellAttributes() ?>>
<span id="el_employees_Title">
<input type="<?= $Page->Title->getInputTextType() ?>" data-table="employees" data-field="x_Title" name="x_Title" id="x_Title" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Title->getPlaceHolder()) ?>" value="<?= $Page->Title->EditValue ?>"<?= $Page->Title->editAttributes() ?> aria-describedby="x_Title_help">
<?= $Page->Title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
    <div id="r_TitleOfCourtesy" class="form-group row">
        <label id="elh_employees_TitleOfCourtesy" for="x_TitleOfCourtesy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TitleOfCourtesy->caption() ?><?= $Page->TitleOfCourtesy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TitleOfCourtesy->cellAttributes() ?>>
<span id="el_employees_TitleOfCourtesy">
<input type="<?= $Page->TitleOfCourtesy->getInputTextType() ?>" data-table="employees" data-field="x_TitleOfCourtesy" name="x_TitleOfCourtesy" id="x_TitleOfCourtesy" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->TitleOfCourtesy->getPlaceHolder()) ?>" value="<?= $Page->TitleOfCourtesy->EditValue ?>"<?= $Page->TitleOfCourtesy->editAttributes() ?> aria-describedby="x_TitleOfCourtesy_help">
<?= $Page->TitleOfCourtesy->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TitleOfCourtesy->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BirthDate->Visible) { // BirthDate ?>
    <div id="r_BirthDate" class="form-group row">
        <label id="elh_employees_BirthDate" for="x_BirthDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BirthDate->caption() ?><?= $Page->BirthDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BirthDate->cellAttributes() ?>>
<span id="el_employees_BirthDate">
<input type="<?= $Page->BirthDate->getInputTextType() ?>" data-table="employees" data-field="x_BirthDate" name="x_BirthDate" id="x_BirthDate" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->BirthDate->getPlaceHolder()) ?>" value="<?= $Page->BirthDate->EditValue ?>"<?= $Page->BirthDate->editAttributes() ?> aria-describedby="x_BirthDate_help">
<?= $Page->BirthDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BirthDate->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->HireDate->Visible) { // HireDate ?>
    <div id="r_HireDate" class="form-group row">
        <label id="elh_employees_HireDate" for="x_HireDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->HireDate->caption() ?><?= $Page->HireDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->HireDate->cellAttributes() ?>>
<span id="el_employees_HireDate">
<input type="<?= $Page->HireDate->getInputTextType() ?>" data-table="employees" data-field="x_HireDate" name="x_HireDate" id="x_HireDate" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->HireDate->getPlaceHolder()) ?>" value="<?= $Page->HireDate->EditValue ?>"<?= $Page->HireDate->editAttributes() ?> aria-describedby="x_HireDate_help">
<?= $Page->HireDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->HireDate->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
    <div id="r_Address" class="form-group row">
        <label id="elh_employees_Address" for="x_Address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Address->caption() ?><?= $Page->Address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Address->cellAttributes() ?>>
<span id="el_employees_Address">
<input type="<?= $Page->Address->getInputTextType() ?>" data-table="employees" data-field="x_Address" name="x_Address" id="x_Address" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Address->getPlaceHolder()) ?>" value="<?= $Page->Address->EditValue ?>"<?= $Page->Address->editAttributes() ?> aria-describedby="x_Address_help">
<?= $Page->Address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
    <div id="r_City" class="form-group row">
        <label id="elh_employees_City" for="x_City" class="<?= $Page->LeftColumnClass ?>"><?= $Page->City->caption() ?><?= $Page->City->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->City->cellAttributes() ?>>
<span id="el_employees_City">
<input type="<?= $Page->City->getInputTextType() ?>" data-table="employees" data-field="x_City" name="x_City" id="x_City" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->City->getPlaceHolder()) ?>" value="<?= $Page->City->EditValue ?>"<?= $Page->City->editAttributes() ?> aria-describedby="x_City_help">
<?= $Page->City->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->City->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
    <div id="r_Region" class="form-group row">
        <label id="elh_employees_Region" for="x_Region" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Region->caption() ?><?= $Page->Region->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Region->cellAttributes() ?>>
<span id="el_employees_Region">
<input type="<?= $Page->Region->getInputTextType() ?>" data-table="employees" data-field="x_Region" name="x_Region" id="x_Region" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Region->getPlaceHolder()) ?>" value="<?= $Page->Region->EditValue ?>"<?= $Page->Region->editAttributes() ?> aria-describedby="x_Region_help">
<?= $Page->Region->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Region->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
    <div id="r_PostalCode" class="form-group row">
        <label id="elh_employees_PostalCode" for="x_PostalCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PostalCode->caption() ?><?= $Page->PostalCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el_employees_PostalCode">
<input type="<?= $Page->PostalCode->getInputTextType() ?>" data-table="employees" data-field="x_PostalCode" name="x_PostalCode" id="x_PostalCode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->PostalCode->getPlaceHolder()) ?>" value="<?= $Page->PostalCode->EditValue ?>"<?= $Page->PostalCode->editAttributes() ?> aria-describedby="x_PostalCode_help">
<?= $Page->PostalCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PostalCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
    <div id="r_Country" class="form-group row">
        <label id="elh_employees_Country" for="x_Country" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Country->caption() ?><?= $Page->Country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Country->cellAttributes() ?>>
<span id="el_employees_Country">
<input type="<?= $Page->Country->getInputTextType() ?>" data-table="employees" data-field="x_Country" name="x_Country" id="x_Country" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Country->getPlaceHolder()) ?>" value="<?= $Page->Country->EditValue ?>"<?= $Page->Country->editAttributes() ?> aria-describedby="x_Country_help">
<?= $Page->Country->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Country->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->HomePhone->Visible) { // HomePhone ?>
    <div id="r_HomePhone" class="form-group row">
        <label id="elh_employees_HomePhone" for="x_HomePhone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->HomePhone->caption() ?><?= $Page->HomePhone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->HomePhone->cellAttributes() ?>>
<span id="el_employees_HomePhone">
<input type="<?= $Page->HomePhone->getInputTextType() ?>" data-table="employees" data-field="x_HomePhone" name="x_HomePhone" id="x_HomePhone" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->HomePhone->getPlaceHolder()) ?>" value="<?= $Page->HomePhone->EditValue ?>"<?= $Page->HomePhone->editAttributes() ?> aria-describedby="x_HomePhone_help">
<?= $Page->HomePhone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->HomePhone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Extension->Visible) { // Extension ?>
    <div id="r_Extension" class="form-group row">
        <label id="elh_employees_Extension" for="x_Extension" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Extension->caption() ?><?= $Page->Extension->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Extension->cellAttributes() ?>>
<span id="el_employees_Extension">
<input type="<?= $Page->Extension->getInputTextType() ?>" data-table="employees" data-field="x_Extension" name="x_Extension" id="x_Extension" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Extension->getPlaceHolder()) ?>" value="<?= $Page->Extension->EditValue ?>"<?= $Page->Extension->editAttributes() ?> aria-describedby="x_Extension_help">
<?= $Page->Extension->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Extension->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
    <div id="r_Photo" class="form-group row">
        <label id="elh_employees_Photo" for="x_Photo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Photo->caption() ?><?= $Page->Photo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Photo->cellAttributes() ?>>
<span id="el_employees_Photo">
<input type="<?= $Page->Photo->getInputTextType() ?>" data-table="employees" data-field="x_Photo" name="x_Photo" id="x_Photo" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Photo->getPlaceHolder()) ?>" value="<?= $Page->Photo->EditValue ?>"<?= $Page->Photo->editAttributes() ?> aria-describedby="x_Photo_help">
<?= $Page->Photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Photo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Notes->Visible) { // Notes ?>
    <div id="r_Notes" class="form-group row">
        <label id="elh_employees_Notes" for="x_Notes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Notes->caption() ?><?= $Page->Notes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Notes->cellAttributes() ?>>
<span id="el_employees_Notes">
<input type="<?= $Page->Notes->getInputTextType() ?>" data-table="employees" data-field="x_Notes" name="x_Notes" id="x_Notes" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Notes->getPlaceHolder()) ?>" value="<?= $Page->Notes->EditValue ?>"<?= $Page->Notes->editAttributes() ?> aria-describedby="x_Notes_help">
<?= $Page->Notes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Notes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ReportsTo->Visible) { // ReportsTo ?>
    <div id="r_ReportsTo" class="form-group row">
        <label id="elh_employees_ReportsTo" for="x_ReportsTo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ReportsTo->caption() ?><?= $Page->ReportsTo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ReportsTo->cellAttributes() ?>>
<span id="el_employees_ReportsTo">
<input type="<?= $Page->ReportsTo->getInputTextType() ?>" data-table="employees" data-field="x_ReportsTo" name="x_ReportsTo" id="x_ReportsTo" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ReportsTo->getPlaceHolder()) ?>" value="<?= $Page->ReportsTo->EditValue ?>"<?= $Page->ReportsTo->editAttributes() ?> aria-describedby="x_ReportsTo_help">
<?= $Page->ReportsTo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ReportsTo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PhotoPath->Visible) { // PhotoPath ?>
    <div id="r_PhotoPath" class="form-group row">
        <label id="elh_employees_PhotoPath" for="x_PhotoPath" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PhotoPath->caption() ?><?= $Page->PhotoPath->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PhotoPath->cellAttributes() ?>>
<span id="el_employees_PhotoPath">
<input type="<?= $Page->PhotoPath->getInputTextType() ?>" data-table="employees" data-field="x_PhotoPath" name="x_PhotoPath" id="x_PhotoPath" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->PhotoPath->getPlaceHolder()) ?>" value="<?= $Page->PhotoPath->EditValue ?>"<?= $Page->PhotoPath->editAttributes() ?> aria-describedby="x_PhotoPath_help">
<?= $Page->PhotoPath->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PhotoPath->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("employeeterritories", explode(",", $Page->getCurrentDetailTable())) && $employeeterritories->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("employeeterritories", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "EmployeeterritoriesGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("employees");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
