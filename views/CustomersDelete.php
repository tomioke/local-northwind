<?php

namespace PHPMaker2021\northwindapi;

// Page object
$CustomersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcustomersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcustomersdelete = currentForm = new ew.Form("fcustomersdelete", "delete");
    loadjs.done("fcustomersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.customers) ew.vars.tables.customers = <?= JsonEncode(GetClientVar("tables", "customers")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcustomersdelete" id="fcustomersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="customers">
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
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
        <th class="<?= $Page->CustomerID->headerCellClass() ?>"><span id="elh_customers_CustomerID" class="customers_CustomerID"><?= $Page->CustomerID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
        <th class="<?= $Page->CompanyName->headerCellClass() ?>"><span id="elh_customers_CompanyName" class="customers_CompanyName"><?= $Page->CompanyName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ContactName->Visible) { // ContactName ?>
        <th class="<?= $Page->ContactName->headerCellClass() ?>"><span id="elh_customers_ContactName" class="customers_ContactName"><?= $Page->ContactName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ContactTitle->Visible) { // ContactTitle ?>
        <th class="<?= $Page->ContactTitle->headerCellClass() ?>"><span id="elh_customers_ContactTitle" class="customers_ContactTitle"><?= $Page->ContactTitle->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <th class="<?= $Page->Address->headerCellClass() ?>"><span id="elh_customers_Address" class="customers_Address"><?= $Page->Address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
        <th class="<?= $Page->City->headerCellClass() ?>"><span id="elh_customers_City" class="customers_City"><?= $Page->City->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
        <th class="<?= $Page->Region->headerCellClass() ?>"><span id="elh_customers_Region" class="customers_Region"><?= $Page->Region->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <th class="<?= $Page->PostalCode->headerCellClass() ?>"><span id="elh_customers_PostalCode" class="customers_PostalCode"><?= $Page->PostalCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
        <th class="<?= $Page->Country->headerCellClass() ?>"><span id="elh_customers_Country" class="customers_Country"><?= $Page->Country->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
        <th class="<?= $Page->Phone->headerCellClass() ?>"><span id="elh_customers_Phone" class="customers_Phone"><?= $Page->Phone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Fax->Visible) { // Fax ?>
        <th class="<?= $Page->Fax->headerCellClass() ?>"><span id="elh_customers_Fax" class="customers_Fax"><?= $Page->Fax->caption() ?></span></th>
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
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
        <td <?= $Page->CustomerID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_CustomerID" class="customers_CustomerID">
<span<?= $Page->CustomerID->viewAttributes() ?>>
<?= $Page->CustomerID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
        <td <?= $Page->CompanyName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_CompanyName" class="customers_CompanyName">
<span<?= $Page->CompanyName->viewAttributes() ?>>
<?= $Page->CompanyName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ContactName->Visible) { // ContactName ?>
        <td <?= $Page->ContactName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_ContactName" class="customers_ContactName">
<span<?= $Page->ContactName->viewAttributes() ?>>
<?= $Page->ContactName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ContactTitle->Visible) { // ContactTitle ?>
        <td <?= $Page->ContactTitle->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_ContactTitle" class="customers_ContactTitle">
<span<?= $Page->ContactTitle->viewAttributes() ?>>
<?= $Page->ContactTitle->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <td <?= $Page->Address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_Address" class="customers_Address">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
        <td <?= $Page->City->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_City" class="customers_City">
<span<?= $Page->City->viewAttributes() ?>>
<?= $Page->City->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
        <td <?= $Page->Region->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_Region" class="customers_Region">
<span<?= $Page->Region->viewAttributes() ?>>
<?= $Page->Region->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <td <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_PostalCode" class="customers_PostalCode">
<span<?= $Page->PostalCode->viewAttributes() ?>>
<?= $Page->PostalCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
        <td <?= $Page->Country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_Country" class="customers_Country">
<span<?= $Page->Country->viewAttributes() ?>>
<?= $Page->Country->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
        <td <?= $Page->Phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_Phone" class="customers_Phone">
<span<?= $Page->Phone->viewAttributes() ?>>
<?= $Page->Phone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Fax->Visible) { // Fax ?>
        <td <?= $Page->Fax->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customers_Fax" class="customers_Fax">
<span<?= $Page->Fax->viewAttributes() ?>>
<?= $Page->Fax->getViewValue() ?></span>
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
