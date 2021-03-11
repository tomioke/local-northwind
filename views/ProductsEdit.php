<?php

namespace PHPMaker2021\northwindapi;

// Page object
$ProductsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fproductsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fproductsedit = currentForm = new ew.Form("fproductsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "products")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.products)
        ew.vars.tables.products = currentTable;
    fproductsedit.addFields([
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
        var f = fproductsedit,
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
    fproductsedit.validate = function () {
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
    fproductsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fproductsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fproductsedit");
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
<form name="fproductsedit" id="fproductsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="products">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ProductID->Visible) { // ProductID ?>
    <div id="r_ProductID" class="form-group row">
        <label id="elh_products_ProductID" for="x_ProductID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ProductID->caption() ?><?= $Page->ProductID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ProductID->cellAttributes() ?>>
<input type="<?= $Page->ProductID->getInputTextType() ?>" data-table="products" data-field="x_ProductID" name="x_ProductID" id="x_ProductID" size="30" placeholder="<?= HtmlEncode($Page->ProductID->getPlaceHolder()) ?>" value="<?= $Page->ProductID->EditValue ?>"<?= $Page->ProductID->editAttributes() ?> aria-describedby="x_ProductID_help">
<?= $Page->ProductID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ProductID->getErrorMessage() ?></div>
<input type="hidden" data-table="products" data-field="x_ProductID" data-hidden="1" name="o_ProductID" id="o_ProductID" value="<?= HtmlEncode($Page->ProductID->OldValue ?? $Page->ProductID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ProductName->Visible) { // ProductName ?>
    <div id="r_ProductName" class="form-group row">
        <label id="elh_products_ProductName" for="x_ProductName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ProductName->caption() ?><?= $Page->ProductName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ProductName->cellAttributes() ?>>
<span id="el_products_ProductName">
<input type="<?= $Page->ProductName->getInputTextType() ?>" data-table="products" data-field="x_ProductName" name="x_ProductName" id="x_ProductName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ProductName->getPlaceHolder()) ?>" value="<?= $Page->ProductName->EditValue ?>"<?= $Page->ProductName->editAttributes() ?> aria-describedby="x_ProductName_help">
<?= $Page->ProductName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ProductName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SupplierID->Visible) { // SupplierID ?>
    <div id="r_SupplierID" class="form-group row">
        <label id="elh_products_SupplierID" for="x_SupplierID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SupplierID->caption() ?><?= $Page->SupplierID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SupplierID->cellAttributes() ?>>
<span id="el_products_SupplierID">
<input type="<?= $Page->SupplierID->getInputTextType() ?>" data-table="products" data-field="x_SupplierID" name="x_SupplierID" id="x_SupplierID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->SupplierID->getPlaceHolder()) ?>" value="<?= $Page->SupplierID->EditValue ?>"<?= $Page->SupplierID->editAttributes() ?> aria-describedby="x_SupplierID_help">
<?= $Page->SupplierID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SupplierID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CategoryID->Visible) { // CategoryID ?>
    <div id="r_CategoryID" class="form-group row">
        <label id="elh_products_CategoryID" for="x_CategoryID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CategoryID->caption() ?><?= $Page->CategoryID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CategoryID->cellAttributes() ?>>
<span id="el_products_CategoryID">
<input type="<?= $Page->CategoryID->getInputTextType() ?>" data-table="products" data-field="x_CategoryID" name="x_CategoryID" id="x_CategoryID" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->CategoryID->getPlaceHolder()) ?>" value="<?= $Page->CategoryID->EditValue ?>"<?= $Page->CategoryID->editAttributes() ?> aria-describedby="x_CategoryID_help">
<?= $Page->CategoryID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CategoryID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->QuantityPerUnit->Visible) { // QuantityPerUnit ?>
    <div id="r_QuantityPerUnit" class="form-group row">
        <label id="elh_products_QuantityPerUnit" for="x_QuantityPerUnit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->QuantityPerUnit->caption() ?><?= $Page->QuantityPerUnit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->QuantityPerUnit->cellAttributes() ?>>
<span id="el_products_QuantityPerUnit">
<input type="<?= $Page->QuantityPerUnit->getInputTextType() ?>" data-table="products" data-field="x_QuantityPerUnit" name="x_QuantityPerUnit" id="x_QuantityPerUnit" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->QuantityPerUnit->getPlaceHolder()) ?>" value="<?= $Page->QuantityPerUnit->EditValue ?>"<?= $Page->QuantityPerUnit->editAttributes() ?> aria-describedby="x_QuantityPerUnit_help">
<?= $Page->QuantityPerUnit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->QuantityPerUnit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
    <div id="r_UnitPrice" class="form-group row">
        <label id="elh_products_UnitPrice" for="x_UnitPrice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UnitPrice->caption() ?><?= $Page->UnitPrice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UnitPrice->cellAttributes() ?>>
<span id="el_products_UnitPrice">
<input type="<?= $Page->UnitPrice->getInputTextType() ?>" data-table="products" data-field="x_UnitPrice" name="x_UnitPrice" id="x_UnitPrice" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->UnitPrice->getPlaceHolder()) ?>" value="<?= $Page->UnitPrice->EditValue ?>"<?= $Page->UnitPrice->editAttributes() ?> aria-describedby="x_UnitPrice_help">
<?= $Page->UnitPrice->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UnitPrice->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UnitsInStock->Visible) { // UnitsInStock ?>
    <div id="r_UnitsInStock" class="form-group row">
        <label id="elh_products_UnitsInStock" for="x_UnitsInStock" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UnitsInStock->caption() ?><?= $Page->UnitsInStock->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UnitsInStock->cellAttributes() ?>>
<span id="el_products_UnitsInStock">
<input type="<?= $Page->UnitsInStock->getInputTextType() ?>" data-table="products" data-field="x_UnitsInStock" name="x_UnitsInStock" id="x_UnitsInStock" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->UnitsInStock->getPlaceHolder()) ?>" value="<?= $Page->UnitsInStock->EditValue ?>"<?= $Page->UnitsInStock->editAttributes() ?> aria-describedby="x_UnitsInStock_help">
<?= $Page->UnitsInStock->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UnitsInStock->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UnitsOnOrder->Visible) { // UnitsOnOrder ?>
    <div id="r_UnitsOnOrder" class="form-group row">
        <label id="elh_products_UnitsOnOrder" for="x_UnitsOnOrder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UnitsOnOrder->caption() ?><?= $Page->UnitsOnOrder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UnitsOnOrder->cellAttributes() ?>>
<span id="el_products_UnitsOnOrder">
<input type="<?= $Page->UnitsOnOrder->getInputTextType() ?>" data-table="products" data-field="x_UnitsOnOrder" name="x_UnitsOnOrder" id="x_UnitsOnOrder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->UnitsOnOrder->getPlaceHolder()) ?>" value="<?= $Page->UnitsOnOrder->EditValue ?>"<?= $Page->UnitsOnOrder->editAttributes() ?> aria-describedby="x_UnitsOnOrder_help">
<?= $Page->UnitsOnOrder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UnitsOnOrder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ReorderLevel->Visible) { // ReorderLevel ?>
    <div id="r_ReorderLevel" class="form-group row">
        <label id="elh_products_ReorderLevel" for="x_ReorderLevel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ReorderLevel->caption() ?><?= $Page->ReorderLevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ReorderLevel->cellAttributes() ?>>
<span id="el_products_ReorderLevel">
<input type="<?= $Page->ReorderLevel->getInputTextType() ?>" data-table="products" data-field="x_ReorderLevel" name="x_ReorderLevel" id="x_ReorderLevel" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ReorderLevel->getPlaceHolder()) ?>" value="<?= $Page->ReorderLevel->EditValue ?>"<?= $Page->ReorderLevel->editAttributes() ?> aria-describedby="x_ReorderLevel_help">
<?= $Page->ReorderLevel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ReorderLevel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Discontinued->Visible) { // Discontinued ?>
    <div id="r_Discontinued" class="form-group row">
        <label id="elh_products_Discontinued" for="x_Discontinued" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Discontinued->caption() ?><?= $Page->Discontinued->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Discontinued->cellAttributes() ?>>
<span id="el_products_Discontinued">
<input type="<?= $Page->Discontinued->getInputTextType() ?>" data-table="products" data-field="x_Discontinued" name="x_Discontinued" id="x_Discontinued" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Discontinued->getPlaceHolder()) ?>" value="<?= $Page->Discontinued->EditValue ?>"<?= $Page->Discontinued->editAttributes() ?> aria-describedby="x_Discontinued_help">
<?= $Page->Discontinued->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Discontinued->getErrorMessage() ?></div>
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
    ew.addEventHandlers("products");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
