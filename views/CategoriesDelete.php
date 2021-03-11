<?php

namespace PHPMaker2021\northwindapi;

// Page object
$CategoriesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcategoriesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcategoriesdelete = currentForm = new ew.Form("fcategoriesdelete", "delete");
    loadjs.done("fcategoriesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.categories) ew.vars.tables.categories = <?= JsonEncode(GetClientVar("tables", "categories")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcategoriesdelete" id="fcategoriesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="categories">
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
<?php if ($Page->CategoryID->Visible) { // CategoryID ?>
        <th class="<?= $Page->CategoryID->headerCellClass() ?>"><span id="elh_categories_CategoryID" class="categories_CategoryID"><?= $Page->CategoryID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CategoryName->Visible) { // CategoryName ?>
        <th class="<?= $Page->CategoryName->headerCellClass() ?>"><span id="elh_categories_CategoryName" class="categories_CategoryName"><?= $Page->CategoryName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
        <th class="<?= $Page->Description->headerCellClass() ?>"><span id="elh_categories_Description" class="categories_Description"><?= $Page->Description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Picture->Visible) { // Picture ?>
        <th class="<?= $Page->Picture->headerCellClass() ?>"><span id="elh_categories_Picture" class="categories_Picture"><?= $Page->Picture->caption() ?></span></th>
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
<?php if ($Page->CategoryID->Visible) { // CategoryID ?>
        <td <?= $Page->CategoryID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_categories_CategoryID" class="categories_CategoryID">
<span<?= $Page->CategoryID->viewAttributes() ?>>
<?= $Page->CategoryID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CategoryName->Visible) { // CategoryName ?>
        <td <?= $Page->CategoryName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_categories_CategoryName" class="categories_CategoryName">
<span<?= $Page->CategoryName->viewAttributes() ?>>
<?= $Page->CategoryName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
        <td <?= $Page->Description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_categories_Description" class="categories_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Picture->Visible) { // Picture ?>
        <td <?= $Page->Picture->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_categories_Picture" class="categories_Picture">
<span<?= $Page->Picture->viewAttributes() ?>>
<?= $Page->Picture->getViewValue() ?></span>
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
