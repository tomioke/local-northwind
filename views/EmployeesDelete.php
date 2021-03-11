<?php

namespace PHPMaker2021\northwindapi;

// Page object
$EmployeesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var femployeesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    femployeesdelete = currentForm = new ew.Form("femployeesdelete", "delete");
    loadjs.done("femployeesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.employees) ew.vars.tables.employees = <?= JsonEncode(GetClientVar("tables", "employees")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="femployeesdelete" id="femployeesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employees">
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
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <th class="<?= $Page->EmployeeID->headerCellClass() ?>"><span id="elh_employees_EmployeeID" class="employees_EmployeeID"><?= $Page->EmployeeID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
        <th class="<?= $Page->LastName->headerCellClass() ?>"><span id="elh_employees_LastName" class="employees_LastName"><?= $Page->LastName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
        <th class="<?= $Page->FirstName->headerCellClass() ?>"><span id="elh_employees_FirstName" class="employees_FirstName"><?= $Page->FirstName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Title->Visible) { // Title ?>
        <th class="<?= $Page->Title->headerCellClass() ?>"><span id="elh_employees_Title" class="employees_Title"><?= $Page->Title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
        <th class="<?= $Page->TitleOfCourtesy->headerCellClass() ?>"><span id="elh_employees_TitleOfCourtesy" class="employees_TitleOfCourtesy"><?= $Page->TitleOfCourtesy->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BirthDate->Visible) { // BirthDate ?>
        <th class="<?= $Page->BirthDate->headerCellClass() ?>"><span id="elh_employees_BirthDate" class="employees_BirthDate"><?= $Page->BirthDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->HireDate->Visible) { // HireDate ?>
        <th class="<?= $Page->HireDate->headerCellClass() ?>"><span id="elh_employees_HireDate" class="employees_HireDate"><?= $Page->HireDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <th class="<?= $Page->Address->headerCellClass() ?>"><span id="elh_employees_Address" class="employees_Address"><?= $Page->Address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
        <th class="<?= $Page->City->headerCellClass() ?>"><span id="elh_employees_City" class="employees_City"><?= $Page->City->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
        <th class="<?= $Page->Region->headerCellClass() ?>"><span id="elh_employees_Region" class="employees_Region"><?= $Page->Region->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <th class="<?= $Page->PostalCode->headerCellClass() ?>"><span id="elh_employees_PostalCode" class="employees_PostalCode"><?= $Page->PostalCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
        <th class="<?= $Page->Country->headerCellClass() ?>"><span id="elh_employees_Country" class="employees_Country"><?= $Page->Country->caption() ?></span></th>
<?php } ?>
<?php if ($Page->HomePhone->Visible) { // HomePhone ?>
        <th class="<?= $Page->HomePhone->headerCellClass() ?>"><span id="elh_employees_HomePhone" class="employees_HomePhone"><?= $Page->HomePhone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Extension->Visible) { // Extension ?>
        <th class="<?= $Page->Extension->headerCellClass() ?>"><span id="elh_employees_Extension" class="employees_Extension"><?= $Page->Extension->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
        <th class="<?= $Page->Photo->headerCellClass() ?>"><span id="elh_employees_Photo" class="employees_Photo"><?= $Page->Photo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Notes->Visible) { // Notes ?>
        <th class="<?= $Page->Notes->headerCellClass() ?>"><span id="elh_employees_Notes" class="employees_Notes"><?= $Page->Notes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ReportsTo->Visible) { // ReportsTo ?>
        <th class="<?= $Page->ReportsTo->headerCellClass() ?>"><span id="elh_employees_ReportsTo" class="employees_ReportsTo"><?= $Page->ReportsTo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PhotoPath->Visible) { // PhotoPath ?>
        <th class="<?= $Page->PhotoPath->headerCellClass() ?>"><span id="elh_employees_PhotoPath" class="employees_PhotoPath"><?= $Page->PhotoPath->caption() ?></span></th>
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
<?php if ($Page->EmployeeID->Visible) { // EmployeeID ?>
        <td <?= $Page->EmployeeID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_EmployeeID" class="employees_EmployeeID">
<span<?= $Page->EmployeeID->viewAttributes() ?>>
<?= $Page->EmployeeID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
        <td <?= $Page->LastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_LastName" class="employees_LastName">
<span<?= $Page->LastName->viewAttributes() ?>>
<?= $Page->LastName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
        <td <?= $Page->FirstName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_FirstName" class="employees_FirstName">
<span<?= $Page->FirstName->viewAttributes() ?>>
<?= $Page->FirstName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Title->Visible) { // Title ?>
        <td <?= $Page->Title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Title" class="employees_Title">
<span<?= $Page->Title->viewAttributes() ?>>
<?= $Page->Title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
        <td <?= $Page->TitleOfCourtesy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_TitleOfCourtesy" class="employees_TitleOfCourtesy">
<span<?= $Page->TitleOfCourtesy->viewAttributes() ?>>
<?= $Page->TitleOfCourtesy->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BirthDate->Visible) { // BirthDate ?>
        <td <?= $Page->BirthDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_BirthDate" class="employees_BirthDate">
<span<?= $Page->BirthDate->viewAttributes() ?>>
<?= $Page->BirthDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->HireDate->Visible) { // HireDate ?>
        <td <?= $Page->HireDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_HireDate" class="employees_HireDate">
<span<?= $Page->HireDate->viewAttributes() ?>>
<?= $Page->HireDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
        <td <?= $Page->Address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Address" class="employees_Address">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->City->Visible) { // City ?>
        <td <?= $Page->City->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_City" class="employees_City">
<span<?= $Page->City->viewAttributes() ?>>
<?= $Page->City->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Region->Visible) { // Region ?>
        <td <?= $Page->Region->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Region" class="employees_Region">
<span<?= $Page->Region->viewAttributes() ?>>
<?= $Page->Region->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PostalCode->Visible) { // PostalCode ?>
        <td <?= $Page->PostalCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_PostalCode" class="employees_PostalCode">
<span<?= $Page->PostalCode->viewAttributes() ?>>
<?= $Page->PostalCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Country->Visible) { // Country ?>
        <td <?= $Page->Country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Country" class="employees_Country">
<span<?= $Page->Country->viewAttributes() ?>>
<?= $Page->Country->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->HomePhone->Visible) { // HomePhone ?>
        <td <?= $Page->HomePhone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_HomePhone" class="employees_HomePhone">
<span<?= $Page->HomePhone->viewAttributes() ?>>
<?= $Page->HomePhone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Extension->Visible) { // Extension ?>
        <td <?= $Page->Extension->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Extension" class="employees_Extension">
<span<?= $Page->Extension->viewAttributes() ?>>
<?= $Page->Extension->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
        <td <?= $Page->Photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Photo" class="employees_Photo">
<span<?= $Page->Photo->viewAttributes() ?>>
<?= $Page->Photo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Notes->Visible) { // Notes ?>
        <td <?= $Page->Notes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_Notes" class="employees_Notes">
<span<?= $Page->Notes->viewAttributes() ?>>
<?= $Page->Notes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ReportsTo->Visible) { // ReportsTo ?>
        <td <?= $Page->ReportsTo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_ReportsTo" class="employees_ReportsTo">
<span<?= $Page->ReportsTo->viewAttributes() ?>>
<?= $Page->ReportsTo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PhotoPath->Visible) { // PhotoPath ?>
        <td <?= $Page->PhotoPath->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employees_PhotoPath" class="employees_PhotoPath">
<span<?= $Page->PhotoPath->viewAttributes() ?>>
<?= $Page->PhotoPath->getViewValue() ?></span>
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
