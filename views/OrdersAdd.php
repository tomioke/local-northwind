<?php

namespace PHPMaker2021\northwindapi;

// Page object
$OrdersAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fordersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fordersadd = currentForm = new ew.Form("fordersadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "orders")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.orders)
        ew.vars.tables.orders = currentTable;
    fordersadd.addFields([
        ["CustomerID", [fields.CustomerID.visible && fields.CustomerID.required ? ew.Validators.required(fields.CustomerID.caption) : null], fields.CustomerID.isInvalid],
        ["EmployeeID", [fields.EmployeeID.visible && fields.EmployeeID.required ? ew.Validators.required(fields.EmployeeID.caption) : null], fields.EmployeeID.isInvalid],
        ["OrderDate", [fields.OrderDate.visible && fields.OrderDate.required ? ew.Validators.required(fields.OrderDate.caption) : null, ew.Validators.datetime(0)], fields.OrderDate.isInvalid],
        ["RequiredDate", [fields.RequiredDate.visible && fields.RequiredDate.required ? ew.Validators.required(fields.RequiredDate.caption) : null, ew.Validators.datetime(7)], fields.RequiredDate.isInvalid],
        ["ShippedDate", [fields.ShippedDate.visible && fields.ShippedDate.required ? ew.Validators.required(fields.ShippedDate.caption) : null, ew.Validators.datetime(0)], fields.ShippedDate.isInvalid],
        ["ShipperID", [fields.ShipperID.visible && fields.ShipperID.required ? ew.Validators.required(fields.ShipperID.caption) : null], fields.ShipperID.isInvalid],
        ["Freight", [fields.Freight.visible && fields.Freight.required ? ew.Validators.required(fields.Freight.caption) : null], fields.Freight.isInvalid],
        ["ShipName", [fields.ShipName.visible && fields.ShipName.required ? ew.Validators.required(fields.ShipName.caption) : null], fields.ShipName.isInvalid],
        ["ShipAddress", [fields.ShipAddress.visible && fields.ShipAddress.required ? ew.Validators.required(fields.ShipAddress.caption) : null], fields.ShipAddress.isInvalid],
        ["ShipCity", [fields.ShipCity.visible && fields.ShipCity.required ? ew.Validators.required(fields.ShipCity.caption) : null], fields.ShipCity.isInvalid],
        ["ShipRegion", [fields.ShipRegion.visible && fields.ShipRegion.required ? ew.Validators.required(fields.ShipRegion.caption) : null], fields.ShipRegion.isInvalid],
        ["ShipPostalCode", [fields.ShipPostalCode.visible && fields.ShipPostalCode.required ? ew.Validators.required(fields.ShipPostalCode.caption) : null], fields.ShipPostalCode.isInvalid],
        ["ShipCountry", [fields.ShipCountry.visible && fields.ShipCountry.required ? ew.Validators.required(fields.ShipCountry.caption) : null], fields.ShipCountry.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fordersadd,
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
    fordersadd.validate = function () {
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
    fordersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fordersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Multi-Page
    fordersadd.multiPage = new ew.MultiPage("fordersadd");

    // Dynamic selection lists
    fordersadd.lists.CustomerID = <?= $Page->CustomerID->toClientList($Page) ?>;
    fordersadd.lists.EmployeeID = <?= $Page->EmployeeID->toClientList($Page) ?>;
    fordersadd.lists.ShipperID = <?= $Page->ShipperID->toClientList($Page) ?>;
    loadjs.done("fordersadd");
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
<form name="fordersadd" id="fordersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav-tabs" id="Page"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navStyle() ?>">
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(1) ?>" href="#tab_orders1" data-toggle="tab"><?= $Page->pageCaption(1) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(2) ?>" href="#tab_orders2" data-toggle="tab"><?= $Page->pageCaption(2) ?></a></li>
        <li class="nav-item"><a class="nav-link<?= $Page->MultiPages->pageStyle(3) ?>" href="#tab_orders3" data-toggle="tab"><?= $Page->pageCaption(3) ?></a></li>
    </ul>
    <div class="tab-content"><!-- multi-page tabs .tab-content -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(1) ?>" id="tab_orders1"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
    <div id="r_CustomerID" class="form-group row">
        <label id="elh_orders_CustomerID" for="x_CustomerID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CustomerID->caption() ?><?= $Page->CustomerID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CustomerID->cellAttributes() ?>>
<span id="el_orders_CustomerID">
    <select
        id="x_CustomerID"
        name="x_CustomerID"
        class="form-control ew-select<?= $Page->CustomerID->isInvalidClass() ?>"
        data-select2-id="orders_x_CustomerID"
        data-table="orders"
        data-field="x_CustomerID"
        data-page="1"
        data-value-separator="<?= $Page->CustomerID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CustomerID->getPlaceHolder()) ?>"
        <?= $Page->CustomerID->editAttributes() ?>>
        <?= $Page->CustomerID->selectOptionListHtml("x_CustomerID") ?>
    </select>
    <?= $Page->CustomerID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->CustomerID->getErrorMessage() ?></div>
<?= $Page->CustomerID->Lookup->getParamTag($Page, "p_x_CustomerID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='orders_x_CustomerID']"),
        options = { name: "x_CustomerID", selectId: "orders_x_CustomerID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.orders.fields.CustomerID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
    <div id="r_EmployeeID" class="form-group row">
        <label id="elh_orders_EmployeeID" for="x_EmployeeID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EmployeeID->caption() ?><?= $Page->EmployeeID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el_orders_EmployeeID">
    <select
        id="x_EmployeeID"
        name="x_EmployeeID"
        class="form-control ew-select<?= $Page->EmployeeID->isInvalidClass() ?>"
        data-select2-id="orders_x_EmployeeID"
        data-table="orders"
        data-field="x_EmployeeID"
        data-page="1"
        data-value-separator="<?= $Page->EmployeeID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->EmployeeID->getPlaceHolder()) ?>"
        <?= $Page->EmployeeID->editAttributes() ?>>
        <?= $Page->EmployeeID->selectOptionListHtml("x_EmployeeID") ?>
    </select>
    <?= $Page->EmployeeID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->EmployeeID->getErrorMessage() ?></div>
<?= $Page->EmployeeID->Lookup->getParamTag($Page, "p_x_EmployeeID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='orders_x_EmployeeID']"),
        options = { name: "x_EmployeeID", selectId: "orders_x_EmployeeID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.orders.fields.EmployeeID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(2) ?>" id="tab_orders2"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->OrderDate->Visible) { // OrderDate ?>
    <div id="r_OrderDate" class="form-group row">
        <label id="elh_orders_OrderDate" for="x_OrderDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->OrderDate->caption() ?><?= $Page->OrderDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->OrderDate->cellAttributes() ?>>
<span id="el_orders_OrderDate">
<input type="<?= $Page->OrderDate->getInputTextType() ?>" data-table="orders" data-field="x_OrderDate" data-page="2" name="x_OrderDate" id="x_OrderDate" maxlength="255" placeholder="<?= HtmlEncode($Page->OrderDate->getPlaceHolder()) ?>" value="<?= $Page->OrderDate->EditValue ?>"<?= $Page->OrderDate->editAttributes() ?> aria-describedby="x_OrderDate_help">
<?= $Page->OrderDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->OrderDate->getErrorMessage() ?></div>
<?php if (!$Page->OrderDate->ReadOnly && !$Page->OrderDate->Disabled && !isset($Page->OrderDate->EditAttrs["readonly"]) && !isset($Page->OrderDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fordersadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fordersadd", "x_OrderDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RequiredDate->Visible) { // RequiredDate ?>
    <div id="r_RequiredDate" class="form-group row">
        <label id="elh_orders_RequiredDate" for="x_RequiredDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RequiredDate->caption() ?><?= $Page->RequiredDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RequiredDate->cellAttributes() ?>>
<span id="el_orders_RequiredDate">
<input type="<?= $Page->RequiredDate->getInputTextType() ?>" data-table="orders" data-field="x_RequiredDate" data-page="2" data-format="7" name="x_RequiredDate" id="x_RequiredDate" maxlength="255" placeholder="<?= HtmlEncode($Page->RequiredDate->getPlaceHolder()) ?>" value="<?= $Page->RequiredDate->EditValue ?>"<?= $Page->RequiredDate->editAttributes() ?> aria-describedby="x_RequiredDate_help">
<?= $Page->RequiredDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RequiredDate->getErrorMessage() ?></div>
<?php if (!$Page->RequiredDate->ReadOnly && !$Page->RequiredDate->Disabled && !isset($Page->RequiredDate->EditAttrs["readonly"]) && !isset($Page->RequiredDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fordersadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fordersadd", "x_RequiredDate", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ShippedDate->Visible) { // ShippedDate ?>
    <div id="r_ShippedDate" class="form-group row">
        <label id="elh_orders_ShippedDate" for="x_ShippedDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShippedDate->caption() ?><?= $Page->ShippedDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShippedDate->cellAttributes() ?>>
<span id="el_orders_ShippedDate">
<input type="<?= $Page->ShippedDate->getInputTextType() ?>" data-table="orders" data-field="x_ShippedDate" data-page="2" name="x_ShippedDate" id="x_ShippedDate" maxlength="255" placeholder="<?= HtmlEncode($Page->ShippedDate->getPlaceHolder()) ?>" value="<?= $Page->ShippedDate->EditValue ?>"<?= $Page->ShippedDate->editAttributes() ?> aria-describedby="x_ShippedDate_help">
<?= $Page->ShippedDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShippedDate->getErrorMessage() ?></div>
<?php if (!$Page->ShippedDate->ReadOnly && !$Page->ShippedDate->Disabled && !isset($Page->ShippedDate->EditAttrs["readonly"]) && !isset($Page->ShippedDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fordersadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fordersadd", "x_ShippedDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="tab-pane<?= $Page->MultiPages->pageStyle(3) ?>" id="tab_orders3"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
    <div id="r_ShipperID" class="form-group row">
        <label id="elh_orders_ShipperID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipperID->caption() ?><?= $Page->ShipperID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipperID->cellAttributes() ?>>
<span id="el_orders_ShipperID">
<template id="tp_x_ShipperID">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="orders" data-field="x_ShipperID" name="x_ShipperID" id="x_ShipperID"<?= $Page->ShipperID->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_ShipperID" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_ShipperID"
    name="x_ShipperID"
    value="<?= HtmlEncode($Page->ShipperID->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ShipperID"
    data-target="dsl_x_ShipperID"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ShipperID->isInvalidClass() ?>"
    data-table="orders"
    data-field="x_ShipperID"
    data-page="3"
    data-value-separator="<?= $Page->ShipperID->displayValueSeparatorAttribute() ?>"
    <?= $Page->ShipperID->editAttributes() ?>>
<?= $Page->ShipperID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShipperID->getErrorMessage() ?></div>
<?= $Page->ShipperID->Lookup->getParamTag($Page, "p_x_ShipperID") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Freight->Visible) { // Freight ?>
    <div id="r_Freight" class="form-group row">
        <label id="elh_orders_Freight" for="x_Freight" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Freight->caption() ?><?= $Page->Freight->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Freight->cellAttributes() ?>>
<span id="el_orders_Freight">
<input type="<?= $Page->Freight->getInputTextType() ?>" data-table="orders" data-field="x_Freight" data-page="3" name="x_Freight" id="x_Freight" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Freight->getPlaceHolder()) ?>" value="<?= $Page->Freight->EditValue ?>"<?= $Page->Freight->editAttributes() ?> aria-describedby="x_Freight_help">
<?= $Page->Freight->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Freight->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ShipName->Visible) { // ShipName ?>
    <div id="r_ShipName" class="form-group row">
        <label id="elh_orders_ShipName" for="x_ShipName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipName->caption() ?><?= $Page->ShipName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipName->cellAttributes() ?>>
<span id="el_orders_ShipName">
<input type="<?= $Page->ShipName->getInputTextType() ?>" data-table="orders" data-field="x_ShipName" data-page="3" name="x_ShipName" id="x_ShipName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ShipName->getPlaceHolder()) ?>" value="<?= $Page->ShipName->EditValue ?>"<?= $Page->ShipName->editAttributes() ?> aria-describedby="x_ShipName_help">
<?= $Page->ShipName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShipName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ShipAddress->Visible) { // ShipAddress ?>
    <div id="r_ShipAddress" class="form-group row">
        <label id="elh_orders_ShipAddress" for="x_ShipAddress" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipAddress->caption() ?><?= $Page->ShipAddress->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipAddress->cellAttributes() ?>>
<span id="el_orders_ShipAddress">
<input type="<?= $Page->ShipAddress->getInputTextType() ?>" data-table="orders" data-field="x_ShipAddress" data-page="3" name="x_ShipAddress" id="x_ShipAddress" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ShipAddress->getPlaceHolder()) ?>" value="<?= $Page->ShipAddress->EditValue ?>"<?= $Page->ShipAddress->editAttributes() ?> aria-describedby="x_ShipAddress_help">
<?= $Page->ShipAddress->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShipAddress->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ShipCity->Visible) { // ShipCity ?>
    <div id="r_ShipCity" class="form-group row">
        <label id="elh_orders_ShipCity" for="x_ShipCity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipCity->caption() ?><?= $Page->ShipCity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipCity->cellAttributes() ?>>
<span id="el_orders_ShipCity">
<input type="<?= $Page->ShipCity->getInputTextType() ?>" data-table="orders" data-field="x_ShipCity" data-page="3" name="x_ShipCity" id="x_ShipCity" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ShipCity->getPlaceHolder()) ?>" value="<?= $Page->ShipCity->EditValue ?>"<?= $Page->ShipCity->editAttributes() ?> aria-describedby="x_ShipCity_help">
<?= $Page->ShipCity->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShipCity->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ShipRegion->Visible) { // ShipRegion ?>
    <div id="r_ShipRegion" class="form-group row">
        <label id="elh_orders_ShipRegion" for="x_ShipRegion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipRegion->caption() ?><?= $Page->ShipRegion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipRegion->cellAttributes() ?>>
<span id="el_orders_ShipRegion">
<input type="<?= $Page->ShipRegion->getInputTextType() ?>" data-table="orders" data-field="x_ShipRegion" data-page="3" name="x_ShipRegion" id="x_ShipRegion" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ShipRegion->getPlaceHolder()) ?>" value="<?= $Page->ShipRegion->EditValue ?>"<?= $Page->ShipRegion->editAttributes() ?> aria-describedby="x_ShipRegion_help">
<?= $Page->ShipRegion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShipRegion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ShipPostalCode->Visible) { // ShipPostalCode ?>
    <div id="r_ShipPostalCode" class="form-group row">
        <label id="elh_orders_ShipPostalCode" for="x_ShipPostalCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipPostalCode->caption() ?><?= $Page->ShipPostalCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipPostalCode->cellAttributes() ?>>
<span id="el_orders_ShipPostalCode">
<input type="<?= $Page->ShipPostalCode->getInputTextType() ?>" data-table="orders" data-field="x_ShipPostalCode" data-page="3" name="x_ShipPostalCode" id="x_ShipPostalCode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ShipPostalCode->getPlaceHolder()) ?>" value="<?= $Page->ShipPostalCode->EditValue ?>"<?= $Page->ShipPostalCode->editAttributes() ?> aria-describedby="x_ShipPostalCode_help">
<?= $Page->ShipPostalCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShipPostalCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ShipCountry->Visible) { // ShipCountry ?>
    <div id="r_ShipCountry" class="form-group row">
        <label id="elh_orders_ShipCountry" for="x_ShipCountry" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ShipCountry->caption() ?><?= $Page->ShipCountry->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ShipCountry->cellAttributes() ?>>
<span id="el_orders_ShipCountry">
<input type="<?= $Page->ShipCountry->getInputTextType() ?>" data-table="orders" data-field="x_ShipCountry" data-page="3" name="x_ShipCountry" id="x_ShipCountry" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ShipCountry->getPlaceHolder()) ?>" value="<?= $Page->ShipCountry->EditValue ?>"<?= $Page->ShipCountry->editAttributes() ?> aria-describedby="x_ShipCountry_help">
<?= $Page->ShipCountry->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ShipCountry->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?php
    if (in_array("order_details", explode(",", $Page->getCurrentDetailTable())) && $order_details->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("order_details", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "OrderDetailsGrid.php" ?>
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
    ew.addEventHandlers("orders");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
