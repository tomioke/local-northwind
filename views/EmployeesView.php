<?php

namespace PHPMaker2021\northwindapi;

// Page object
$EmployeesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var femployeesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    femployeesview = currentForm = new ew.Form("femployeesview", "view");
    loadjs.done("femployeesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.employees) ew.vars.tables.employees = <?= JsonEncode(GetClientVar("tables", "employees")) ?>;
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
<form name="femployeesview" id="femployeesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
    <tr id="r_EmployeeID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_EmployeeID"><?= $Page->EmployeeID->caption() ?></span></td>
        <td data-name="EmployeeID" <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el_employees_EmployeeID">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<?= $Page->EmployeeID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
    <tr id="r_LastName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_LastName"><?= $Page->LastName->caption() ?></span></td>
        <td data-name="LastName" <?= $Page->LastName->cellAttributes() ?>>
<span id="el_employees_LastName">
<span<?= $Page->LastName->viewAttributes() ?>>
<?= $Page->LastName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
    <tr id="r_FirstName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_FirstName"><?= $Page->FirstName->caption() ?></span></td>
        <td data-name="FirstName" <?= $Page->FirstName->cellAttributes() ?>>
<span id="el_employees_FirstName">
<span<?= $Page->FirstName->viewAttributes() ?>>
<?= $Page->FirstName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Title->Visible) { // Title ?>
    <tr id="r_Title">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_Title"><?= $Page->Title->caption() ?></span></td>
        <td data-name="Title" <?= $Page->Title->cellAttributes() ?>>
<span id="el_employees_Title">
<span<?= $Page->Title->viewAttributes() ?>>
<?= $Page->Title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
    <tr id="r_TitleOfCourtesy">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_TitleOfCourtesy"><?= $Page->TitleOfCourtesy->caption() ?></span></td>
        <td data-name="TitleOfCourtesy" <?= $Page->TitleOfCourtesy->cellAttributes() ?>>
<span id="el_employees_TitleOfCourtesy">
<span<?= $Page->TitleOfCourtesy->viewAttributes() ?>>
<?= $Page->TitleOfCourtesy->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BirthDate->Visible) { // BirthDate ?>
    <tr id="r_BirthDate">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_BirthDate"><?= $Page->BirthDate->caption() ?></span></td>
        <td data-name="BirthDate" <?= $Page->BirthDate->cellAttributes() ?>>
<span id="el_employees_BirthDate">
<span<?= $Page->BirthDate->viewAttributes() ?>>
<?= $Page->BirthDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->HireDate->Visible) { // HireDate ?>
    <tr id="r_HireDate">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_HireDate"><?= $Page->HireDate->caption() ?></span></td>
        <td data-name="HireDate" <?= $Page->HireDate->cellAttributes() ?>>
<span id="el_employees_HireDate">
<span<?= $Page->HireDate->viewAttributes() ?>>
<?= $Page->HireDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
    <tr id="r_Address">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_Address"><?= $Page->Address->caption() ?></span></td>
        <td data-name="Address" <?= $Page->Address->cellAttributes() ?>>
<span id="el_employees_Address">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
    <tr id="r_City">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_City"><?= $Page->City->caption() ?></span></td>
        <td data-name="City" <?= $Page->City->cellAttributes() ?>>
<span id="el_employees_City">
<span<?= $Page->City->viewAttributes() ?>>
<?= $Page->City->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
    <tr id="r_Region">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_Region"><?= $Page->Region->caption() ?></span></td>
        <td data-name="Region" <?= $Page->Region->cellAttributes() ?>>
<span id="el_employees_Region">
<span<?= $Page->Region->viewAttributes() ?>>
<?= $Page->Region->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
    <tr id="r_PostalCode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_PostalCode"><?= $Page->PostalCode->caption() ?></span></td>
        <td data-name="PostalCode" <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el_employees_PostalCode">
<span<?= $Page->PostalCode->viewAttributes() ?>>
<?= $Page->PostalCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
    <tr id="r_Country">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_Country"><?= $Page->Country->caption() ?></span></td>
        <td data-name="Country" <?= $Page->Country->cellAttributes() ?>>
<span id="el_employees_Country">
<span<?= $Page->Country->viewAttributes() ?>>
<?= $Page->Country->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->HomePhone->Visible) { // HomePhone ?>
    <tr id="r_HomePhone">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_HomePhone"><?= $Page->HomePhone->caption() ?></span></td>
        <td data-name="HomePhone" <?= $Page->HomePhone->cellAttributes() ?>>
<span id="el_employees_HomePhone">
<span<?= $Page->HomePhone->viewAttributes() ?>>
<?= $Page->HomePhone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Extension->Visible) { // Extension ?>
    <tr id="r_Extension">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_Extension"><?= $Page->Extension->caption() ?></span></td>
        <td data-name="Extension" <?= $Page->Extension->cellAttributes() ?>>
<span id="el_employees_Extension">
<span<?= $Page->Extension->viewAttributes() ?>>
<?= $Page->Extension->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
    <tr id="r_Photo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_Photo"><?= $Page->Photo->caption() ?></span></td>
        <td data-name="Photo" <?= $Page->Photo->cellAttributes() ?>>
<span id="el_employees_Photo">
<span<?= $Page->Photo->viewAttributes() ?>>
<?= $Page->Photo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Notes->Visible) { // Notes ?>
    <tr id="r_Notes">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_Notes"><?= $Page->Notes->caption() ?></span></td>
        <td data-name="Notes" <?= $Page->Notes->cellAttributes() ?>>
<span id="el_employees_Notes">
<span<?= $Page->Notes->viewAttributes() ?>>
<?= $Page->Notes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ReportsTo->Visible) { // ReportsTo ?>
    <tr id="r_ReportsTo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_ReportsTo"><?= $Page->ReportsTo->caption() ?></span></td>
        <td data-name="ReportsTo" <?= $Page->ReportsTo->cellAttributes() ?>>
<span id="el_employees_ReportsTo">
<span<?= $Page->ReportsTo->viewAttributes() ?>>
<?= $Page->ReportsTo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PhotoPath->Visible) { // PhotoPath ?>
    <tr id="r_PhotoPath">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_employees_PhotoPath"><?= $Page->PhotoPath->caption() ?></span></td>
        <td data-name="PhotoPath" <?= $Page->PhotoPath->cellAttributes() ?>>
<span id="el_employees_PhotoPath">
<span<?= $Page->PhotoPath->viewAttributes() ?>>
<?= $Page->PhotoPath->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("employeeterritories", explode(",", $Page->getCurrentDetailTable())) && $employeeterritories->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("employeeterritories", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "EmployeeterritoriesGrid.php" ?>
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
