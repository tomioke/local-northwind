<?php

namespace PHPMaker2021\northwindapi;

// Page object
$ShippersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fshippersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fshippersview = currentForm = new ew.Form("fshippersview", "view");
    loadjs.done("fshippersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.shippers) ew.vars.tables.shippers = <?= JsonEncode(GetClientVar("tables", "shippers")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fshippersview" id="fshippersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="shippers">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
    <tr id="r_ShipperID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_shippers_ShipperID"><?= $Page->ShipperID->caption() ?></span></td>
        <td data-name="ShipperID" <?= $Page->ShipperID->cellAttributes() ?>>
<span id="el_shippers_ShipperID">
<span<?= $Page->ShipperID->viewAttributes() ?>>
<?= $Page->ShipperID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
    <tr id="r_CompanyName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_shippers_CompanyName"><?= $Page->CompanyName->caption() ?></span></td>
        <td data-name="CompanyName" <?= $Page->CompanyName->cellAttributes() ?>>
<span id="el_shippers_CompanyName">
<span<?= $Page->CompanyName->viewAttributes() ?>>
<?= $Page->CompanyName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
    <tr id="r_Phone">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_shippers_Phone"><?= $Page->Phone->caption() ?></span></td>
        <td data-name="Phone" <?= $Page->Phone->cellAttributes() ?>>
<span id="el_shippers_Phone">
<span<?= $Page->Phone->viewAttributes() ?>>
<?= $Page->Phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
