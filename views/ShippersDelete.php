<?php

namespace PHPMaker2021\northwindapi;

// Page object
$ShippersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fshippersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fshippersdelete = currentForm = new ew.Form("fshippersdelete", "delete");
    loadjs.done("fshippersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.shippers) ew.vars.tables.shippers = <?= JsonEncode(GetClientVar("tables", "shippers")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fshippersdelete" id="fshippersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="shippers">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
        <th class="<?= $Page->ShipperID->headerCellClass() ?>"><span id="elh_shippers_ShipperID" class="shippers_ShipperID"><?= $Page->ShipperID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
        <th class="<?= $Page->CompanyName->headerCellClass() ?>"><span id="elh_shippers_CompanyName" class="shippers_CompanyName"><?= $Page->CompanyName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
        <th class="<?= $Page->Phone->headerCellClass() ?>"><span id="elh_shippers_Phone" class="shippers_Phone"><?= $Page->Phone->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->ShipperID->Visible) { // ShipperID ?>
        <td <?= $Page->ShipperID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_shippers_ShipperID" class="shippers_ShipperID">
<span<?= $Page->ShipperID->viewAttributes() ?>>
<?= $Page->ShipperID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
        <td <?= $Page->CompanyName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_shippers_CompanyName" class="shippers_CompanyName">
<span<?= $Page->CompanyName->viewAttributes() ?>>
<?= $Page->CompanyName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
        <td <?= $Page->Phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_shippers_Phone" class="shippers_Phone">
<span<?= $Page->Phone->viewAttributes() ?>>
<?= $Page->Phone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
