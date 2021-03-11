<?php

namespace PHPMaker2021\northwindapi;

// Page object
$TerritoriesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fterritoriesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fterritoriesdelete = currentForm = new ew.Form("fterritoriesdelete", "delete");
    loadjs.done("fterritoriesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.territories) ew.vars.tables.territories = <?= JsonEncode(GetClientVar("tables", "territories")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fterritoriesdelete" id="fterritoriesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="territories">
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
<?php if ($Page->TerritoryID->Visible) { // TerritoryID ?>
        <th class="<?= $Page->TerritoryID->headerCellClass() ?>"><span id="elh_territories_TerritoryID" class="territories_TerritoryID"><?= $Page->TerritoryID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TerritoryDescription->Visible) { // TerritoryDescription ?>
        <th class="<?= $Page->TerritoryDescription->headerCellClass() ?>"><span id="elh_territories_TerritoryDescription" class="territories_TerritoryDescription"><?= $Page->TerritoryDescription->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RegionID->Visible) { // RegionID ?>
        <th class="<?= $Page->RegionID->headerCellClass() ?>"><span id="elh_territories_RegionID" class="territories_RegionID"><?= $Page->RegionID->caption() ?></span></th>
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
<?php if ($Page->TerritoryID->Visible) { // TerritoryID ?>
        <td <?= $Page->TerritoryID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_territories_TerritoryID" class="territories_TerritoryID">
<span<?= $Page->TerritoryID->viewAttributes() ?>>
<?= $Page->TerritoryID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TerritoryDescription->Visible) { // TerritoryDescription ?>
        <td <?= $Page->TerritoryDescription->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_territories_TerritoryDescription" class="territories_TerritoryDescription">
<span<?= $Page->TerritoryDescription->viewAttributes() ?>>
<?= $Page->TerritoryDescription->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RegionID->Visible) { // RegionID ?>
        <td <?= $Page->RegionID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_territories_RegionID" class="territories_RegionID">
<span<?= $Page->RegionID->viewAttributes() ?>>
<?= $Page->RegionID->getViewValue() ?></span>
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
