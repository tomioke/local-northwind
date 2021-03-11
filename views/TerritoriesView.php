<?php

namespace PHPMaker2021\northwindapi;

// Page object
$TerritoriesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fterritoriesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fterritoriesview = currentForm = new ew.Form("fterritoriesview", "view");
    loadjs.done("fterritoriesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.territories) ew.vars.tables.territories = <?= JsonEncode(GetClientVar("tables", "territories")) ?>;
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
<form name="fterritoriesview" id="fterritoriesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="territories">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->TerritoryID->Visible) { // TerritoryID ?>
    <tr id="r_TerritoryID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_territories_TerritoryID"><?= $Page->TerritoryID->caption() ?></span></td>
        <td data-name="TerritoryID" <?= $Page->TerritoryID->cellAttributes() ?>>
<span id="el_territories_TerritoryID">
<span<?= $Page->TerritoryID->viewAttributes() ?>>
<?= $Page->TerritoryID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TerritoryDescription->Visible) { // TerritoryDescription ?>
    <tr id="r_TerritoryDescription">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_territories_TerritoryDescription"><?= $Page->TerritoryDescription->caption() ?></span></td>
        <td data-name="TerritoryDescription" <?= $Page->TerritoryDescription->cellAttributes() ?>>
<span id="el_territories_TerritoryDescription">
<span<?= $Page->TerritoryDescription->viewAttributes() ?>>
<?= $Page->TerritoryDescription->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RegionID->Visible) { // RegionID ?>
    <tr id="r_RegionID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_territories_RegionID"><?= $Page->RegionID->caption() ?></span></td>
        <td data-name="RegionID" <?= $Page->RegionID->cellAttributes() ?>>
<span id="el_territories_RegionID">
<span<?= $Page->RegionID->viewAttributes() ?>>
<?= $Page->RegionID->getViewValue() ?></span>
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
