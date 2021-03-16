<?php

namespace PHPMaker2021\northwindapi;

// Page object
$CategoriesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcategoriesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcategoriesview = currentForm = new ew.Form("fcategoriesview", "view");
    loadjs.done("fcategoriesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.categories) ew.vars.tables.categories = <?= JsonEncode(GetClientVar("tables", "categories")) ?>;
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
<form name="fcategoriesview" id="fcategoriesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="categories">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CategoryID->Visible) { // CategoryID ?>
    <tr id="r_CategoryID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_categories_CategoryID"><?= $Page->CategoryID->caption() ?></span></td>
        <td data-name="CategoryID" <?= $Page->CategoryID->cellAttributes() ?>>
<span id="el_categories_CategoryID">
<span<?= $Page->CategoryID->viewAttributes() ?>>
<?= $Page->CategoryID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CategoryName->Visible) { // CategoryName ?>
    <tr id="r_CategoryName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_categories_CategoryName"><?= $Page->CategoryName->caption() ?></span></td>
        <td data-name="CategoryName" <?= $Page->CategoryName->cellAttributes() ?>>
<span id="el_categories_CategoryName">
<span<?= $Page->CategoryName->viewAttributes() ?>>
<?= $Page->CategoryName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <tr id="r_Description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_categories_Description"><?= $Page->Description->caption() ?></span></td>
        <td data-name="Description" <?= $Page->Description->cellAttributes() ?>>
<span id="el_categories_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Picture->Visible) { // Picture ?>
    <tr id="r_Picture">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_categories_Picture"><?= $Page->Picture->caption() ?></span></td>
        <td data-name="Picture" <?= $Page->Picture->cellAttributes() ?>>
<span id="el_categories_Picture">
<span>
<?= GetFileViewTag($Page->Picture, $Page->Picture->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("products", explode(",", $Page->getCurrentDetailTable())) && $products->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("products", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ProductsGrid.php" ?>
<?php } ?>
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
