<?php

namespace PHPMaker2021\northwindapi;

// Page object
$CategoriesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcategoriesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fcategoriesedit = currentForm = new ew.Form("fcategoriesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "categories")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.categories)
        ew.vars.tables.categories = currentTable;
    fcategoriesedit.addFields([
        ["CategoryID", [fields.CategoryID.visible && fields.CategoryID.required ? ew.Validators.required(fields.CategoryID.caption) : null], fields.CategoryID.isInvalid],
        ["CategoryName", [fields.CategoryName.visible && fields.CategoryName.required ? ew.Validators.required(fields.CategoryName.caption) : null], fields.CategoryName.isInvalid],
        ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
        ["Picture", [fields.Picture.visible && fields.Picture.required ? ew.Validators.fileRequired(fields.Picture.caption) : null], fields.Picture.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcategoriesedit,
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
    fcategoriesedit.validate = function () {
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
    fcategoriesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcategoriesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcategoriesedit");
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
<form name="fcategoriesedit" id="fcategoriesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="categories">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->CategoryID->Visible) { // CategoryID ?>
    <div id="r_CategoryID" class="form-group row">
        <label id="elh_categories_CategoryID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CategoryID->caption() ?><?= $Page->CategoryID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CategoryID->cellAttributes() ?>>
<span id="el_categories_CategoryID">
<span<?= $Page->CategoryID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CategoryID->getDisplayValue($Page->CategoryID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="categories" data-field="x_CategoryID" data-hidden="1" name="x_CategoryID" id="x_CategoryID" value="<?= HtmlEncode($Page->CategoryID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CategoryName->Visible) { // CategoryName ?>
    <div id="r_CategoryName" class="form-group row">
        <label id="elh_categories_CategoryName" for="x_CategoryName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CategoryName->caption() ?><?= $Page->CategoryName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CategoryName->cellAttributes() ?>>
<span id="el_categories_CategoryName">
<input type="<?= $Page->CategoryName->getInputTextType() ?>" data-table="categories" data-field="x_CategoryName" name="x_CategoryName" id="x_CategoryName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->CategoryName->getPlaceHolder()) ?>" value="<?= $Page->CategoryName->EditValue ?>"<?= $Page->CategoryName->editAttributes() ?> aria-describedby="x_CategoryName_help">
<?= $Page->CategoryName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CategoryName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description" class="form-group row">
        <label id="elh_categories_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Description->cellAttributes() ?>>
<span id="el_categories_Description">
<textarea data-table="categories" data-field="x_Description" name="x_Description" id="x_Description" cols="150" rows="8" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Picture->Visible) { // Picture ?>
    <div id="r_Picture" class="form-group row">
        <label id="elh_categories_Picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Picture->caption() ?><?= $Page->Picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Picture->cellAttributes() ?>>
<span id="el_categories_Picture">
<div id="fd_x_Picture">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->Picture->title() ?>" data-table="categories" data-field="x_Picture" name="x_Picture" id="x_Picture" lang="<?= CurrentLanguageID() ?>"<?= $Page->Picture->editAttributes() ?><?= ($Page->Picture->ReadOnly || $Page->Picture->Disabled) ? " disabled" : "" ?> aria-describedby="x_Picture_help">
        <label class="custom-file-label ew-file-label" for="x_Picture"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->Picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Picture->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Picture" id= "fn_x_Picture" value="<?= $Page->Picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_Picture" id= "fa_x_Picture" value="<?= (Post("fa_x_Picture") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_Picture" id= "fs_x_Picture" value="50">
<input type="hidden" name="fx_x_Picture" id= "fx_x_Picture" value="<?= $Page->Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Picture" id= "fm_x_Picture" value="<?= $Page->Picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Picture" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("products", explode(",", $Page->getCurrentDetailTable())) && $products->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("products", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ProductsGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("categories");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
