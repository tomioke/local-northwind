<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrderDetailsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var forder_detailsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    forder_detailsadd = currentForm = new ew.Form("forder_detailsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "order_details")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.order_details)
        ew.vars.tables.order_details = currentTable;
    forder_detailsadd.addFields([
        ["OrderID", [fields.OrderID.visible && fields.OrderID.required ? ew.Validators.required(fields.OrderID.caption) : null, ew.Validators.integer], fields.OrderID.isInvalid],
        ["ProductID", [fields.ProductID.visible && fields.ProductID.required ? ew.Validators.required(fields.ProductID.caption) : null], fields.ProductID.isInvalid],
        ["UnitPrice", [fields.UnitPrice.visible && fields.UnitPrice.required ? ew.Validators.required(fields.UnitPrice.caption) : null, ew.Validators.float], fields.UnitPrice.isInvalid],
        ["Quantity", [fields.Quantity.visible && fields.Quantity.required ? ew.Validators.required(fields.Quantity.caption) : null, ew.Validators.integer], fields.Quantity.isInvalid],
        ["Discount", [fields.Discount.visible && fields.Discount.required ? ew.Validators.required(fields.Discount.caption) : null, ew.Validators.float], fields.Discount.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = forder_detailsadd,
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
    forder_detailsadd.validate = function () {
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
    forder_detailsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    forder_detailsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    forder_detailsadd.lists.ProductID = <?= $Page->ProductID->toClientList($Page) ?>;
    loadjs.done("forder_detailsadd");
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
<form name="forder_detailsadd" id="forder_detailsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_details">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "orders") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="orders">
<input type="hidden" name="fk_OrderID" value="<?= HtmlEncode($Page->OrderID->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->OrderID->Visible) { // OrderID ?>
    <div id="r_OrderID" class="form-group row">
        <label id="elh_order_details_OrderID" for="x_OrderID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->OrderID->caption() ?><?= $Page->OrderID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->OrderID->cellAttributes() ?>>
<?php if ($Page->OrderID->getSessionValue() != "") { ?>
<span id="el_order_details_OrderID">
<span<?= $Page->OrderID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->OrderID->getDisplayValue($Page->OrderID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_OrderID" name="x_OrderID" value="<?= HtmlEncode($Page->OrderID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_order_details_OrderID">
<input type="<?= $Page->OrderID->getInputTextType() ?>" data-table="order_details" data-field="x_OrderID" name="x_OrderID" id="x_OrderID" size="30" placeholder="<?= HtmlEncode($Page->OrderID->getPlaceHolder()) ?>" value="<?= $Page->OrderID->EditValue ?>"<?= $Page->OrderID->editAttributes() ?> aria-describedby="x_OrderID_help">
<?= $Page->OrderID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->OrderID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ProductID->Visible) { // ProductID ?>
    <div id="r_ProductID" class="form-group row">
        <label id="elh_order_details_ProductID" for="x_ProductID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ProductID->caption() ?><?= $Page->ProductID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ProductID->cellAttributes() ?>>
<span id="el_order_details_ProductID">
<?php $Page->ProductID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_ProductID"
        name="x_ProductID"
        class="form-control ew-select<?= $Page->ProductID->isInvalidClass() ?>"
        data-select2-id="order_details_x_ProductID"
        data-table="order_details"
        data-field="x_ProductID"
        data-value-separator="<?= $Page->ProductID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ProductID->getPlaceHolder()) ?>"
        <?= $Page->ProductID->editAttributes() ?>>
        <?= $Page->ProductID->selectOptionListHtml("x_ProductID") ?>
    </select>
    <?= $Page->ProductID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ProductID->getErrorMessage() ?></div>
<?= $Page->ProductID->Lookup->getParamTag($Page, "p_x_ProductID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_details_x_ProductID']"),
        options = { name: "x_ProductID", selectId: "order_details_x_ProductID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_details.fields.ProductID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UnitPrice->Visible) { // UnitPrice ?>
    <div id="r_UnitPrice" class="form-group row">
        <label id="elh_order_details_UnitPrice" for="x_UnitPrice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UnitPrice->caption() ?><?= $Page->UnitPrice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UnitPrice->cellAttributes() ?>>
<span id="el_order_details_UnitPrice">
<input type="<?= $Page->UnitPrice->getInputTextType() ?>" data-table="order_details" data-field="x_UnitPrice" name="x_UnitPrice" id="x_UnitPrice" size="15" placeholder="<?= HtmlEncode($Page->UnitPrice->getPlaceHolder()) ?>" value="<?= $Page->UnitPrice->EditValue ?>"<?= $Page->UnitPrice->editAttributes() ?> aria-describedby="x_UnitPrice_help">
<?= $Page->UnitPrice->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UnitPrice->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Quantity->Visible) { // Quantity ?>
    <div id="r_Quantity" class="form-group row">
        <label id="elh_order_details_Quantity" for="x_Quantity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Quantity->caption() ?><?= $Page->Quantity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Quantity->cellAttributes() ?>>
<span id="el_order_details_Quantity">
<input type="<?= $Page->Quantity->getInputTextType() ?>" data-table="order_details" data-field="x_Quantity" name="x_Quantity" id="x_Quantity" size="15" placeholder="<?= HtmlEncode($Page->Quantity->getPlaceHolder()) ?>" value="<?= $Page->Quantity->EditValue ?>"<?= $Page->Quantity->editAttributes() ?> aria-describedby="x_Quantity_help">
<?= $Page->Quantity->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Quantity->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Discount->Visible) { // Discount ?>
    <div id="r_Discount" class="form-group row">
        <label id="elh_order_details_Discount" for="x_Discount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Discount->caption() ?><?= $Page->Discount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Discount->cellAttributes() ?>>
<span id="el_order_details_Discount">
<input type="<?= $Page->Discount->getInputTextType() ?>" data-table="order_details" data-field="x_Discount" name="x_Discount" id="x_Discount" size="15" placeholder="<?= HtmlEncode($Page->Discount->getPlaceHolder()) ?>" value="<?= $Page->Discount->EditValue ?>"<?= $Page->Discount->editAttributes() ?> aria-describedby="x_Discount_help">
<?= $Page->Discount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Discount->getErrorMessage() ?></div>
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
    ew.addEventHandlers("order_details");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
