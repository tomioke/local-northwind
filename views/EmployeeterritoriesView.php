<?php

namespace PHPMaker2021\northwindapi;

// Page object
$EmployeeterritoriesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var femployeeterritoriesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    femployeeterritoriesview = currentForm = new ew.Form("femployeeterritoriesview", "view");
    loadjs.done("femployeeterritoriesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.employeeterritories) ew.vars.tables.employeeterritories = <?= JsonEncode(GetClientVar("tables", "employeeterritories")) ?>;
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
<form name="femployeeterritoriesview" id="femployeeterritoriesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employeeterritories">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
    <tr id="r_EmployeeID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employeeterritories_EmployeeID"><?= $Page->EmployeeID->caption() ?></span></td>
        <td data-name="EmployeeID" <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el_employeeterritories_EmployeeID">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<?= $Page->EmployeeID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TerritoryID->Visible) { // TerritoryID ?>
    <tr id="r_TerritoryID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employeeterritories_TerritoryID"><?= $Page->TerritoryID->caption() ?></span></td>
        <td data-name="TerritoryID" <?= $Page->TerritoryID->cellAttributes() ?>>
<span id="el_employeeterritories_TerritoryID">
<span<?= $Page->TerritoryID->viewAttributes() ?>>
<?= $Page->TerritoryID->getViewValue() ?></span>
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
