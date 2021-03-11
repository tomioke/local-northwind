<?php

namespace PHPMaker2021\northwindapi;

// Page object
$CustomersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcustomersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcustomersview = currentForm = new ew.Form("fcustomersview", "view");
    loadjs.done("fcustomersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.customers) ew.vars.tables.customers = <?= JsonEncode(GetClientVar("tables", "customers")) ?>;
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
<form name="fcustomersview" id="fcustomersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="customers">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CustomerID->Visible) { // CustomerID ?>
    <tr id="r_CustomerID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_CustomerID"><?= $Page->CustomerID->caption() ?></span></td>
        <td data-name="CustomerID" <?= $Page->CustomerID->cellAttributes() ?>>
<span id="el_customers_CustomerID">
<span<?= $Page->CustomerID->viewAttributes() ?>>
<?= $Page->CustomerID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CompanyName->Visible) { // CompanyName ?>
    <tr id="r_CompanyName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_CompanyName"><?= $Page->CompanyName->caption() ?></span></td>
        <td data-name="CompanyName" <?= $Page->CompanyName->cellAttributes() ?>>
<span id="el_customers_CompanyName">
<span<?= $Page->CompanyName->viewAttributes() ?>>
<?= $Page->CompanyName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ContactName->Visible) { // ContactName ?>
    <tr id="r_ContactName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_ContactName"><?= $Page->ContactName->caption() ?></span></td>
        <td data-name="ContactName" <?= $Page->ContactName->cellAttributes() ?>>
<span id="el_customers_ContactName">
<span<?= $Page->ContactName->viewAttributes() ?>>
<?= $Page->ContactName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ContactTitle->Visible) { // ContactTitle ?>
    <tr id="r_ContactTitle">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_ContactTitle"><?= $Page->ContactTitle->caption() ?></span></td>
        <td data-name="ContactTitle" <?= $Page->ContactTitle->cellAttributes() ?>>
<span id="el_customers_ContactTitle">
<span<?= $Page->ContactTitle->viewAttributes() ?>>
<?= $Page->ContactTitle->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
    <tr id="r_Address">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_Address"><?= $Page->Address->caption() ?></span></td>
        <td data-name="Address" <?= $Page->Address->cellAttributes() ?>>
<span id="el_customers_Address">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
    <tr id="r_City">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_City"><?= $Page->City->caption() ?></span></td>
        <td data-name="City" <?= $Page->City->cellAttributes() ?>>
<span id="el_customers_City">
<span<?= $Page->City->viewAttributes() ?>>
<?= $Page->City->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
    <tr id="r_Region">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_Region"><?= $Page->Region->caption() ?></span></td>
        <td data-name="Region" <?= $Page->Region->cellAttributes() ?>>
<span id="el_customers_Region">
<span<?= $Page->Region->viewAttributes() ?>>
<?= $Page->Region->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
    <tr id="r_PostalCode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_PostalCode"><?= $Page->PostalCode->caption() ?></span></td>
        <td data-name="PostalCode" <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el_customers_PostalCode">
<span<?= $Page->PostalCode->viewAttributes() ?>>
<?= $Page->PostalCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
    <tr id="r_Country">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_Country"><?= $Page->Country->caption() ?></span></td>
        <td data-name="Country" <?= $Page->Country->cellAttributes() ?>>
<span id="el_customers_Country">
<span<?= $Page->Country->viewAttributes() ?>>
<?= $Page->Country->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Phone->Visible) { // Phone ?>
    <tr id="r_Phone">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_Phone"><?= $Page->Phone->caption() ?></span></td>
        <td data-name="Phone" <?= $Page->Phone->cellAttributes() ?>>
<span id="el_customers_Phone">
<span<?= $Page->Phone->viewAttributes() ?>>
<?= $Page->Phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Fax->Visible) { // Fax ?>
    <tr id="r_Fax">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customers_Fax"><?= $Page->Fax->caption() ?></span></td>
        <td data-name="Fax" <?= $Page->Fax->cellAttributes() ?>>
<span id="el_customers_Fax">
<span<?= $Page->Fax->viewAttributes() ?>>
<?= $Page->Fax->getViewValue() ?></span>
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
