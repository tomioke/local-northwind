<?php

namespace PHPMaker2021\northwindapi;

// Table
$employees = Container("employees");
?>
<?php if ($employees->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_employeesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($employees->EmployeeID->Visible) { // EmployeeID ?>
        <tr id="r_EmployeeID">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->EmployeeID->caption() ?></td>
            <td <?= $employees->EmployeeID->cellAttributes() ?>>
<span id="el_employees_EmployeeID">
<span<?= $employees->EmployeeID->viewAttributes() ?>>
<?= $employees->EmployeeID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->LastName->Visible) { // LastName ?>
        <tr id="r_LastName">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->LastName->caption() ?></td>
            <td <?= $employees->LastName->cellAttributes() ?>>
<span id="el_employees_LastName">
<span<?= $employees->LastName->viewAttributes() ?>>
<?= $employees->LastName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->FirstName->Visible) { // FirstName ?>
        <tr id="r_FirstName">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->FirstName->caption() ?></td>
            <td <?= $employees->FirstName->cellAttributes() ?>>
<span id="el_employees_FirstName">
<span<?= $employees->FirstName->viewAttributes() ?>>
<?= $employees->FirstName->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->Title->Visible) { // Title ?>
        <tr id="r_Title">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->Title->caption() ?></td>
            <td <?= $employees->Title->cellAttributes() ?>>
<span id="el_employees_Title">
<span<?= $employees->Title->viewAttributes() ?>>
<?= $employees->Title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
        <tr id="r_TitleOfCourtesy">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->TitleOfCourtesy->caption() ?></td>
            <td <?= $employees->TitleOfCourtesy->cellAttributes() ?>>
<span id="el_employees_TitleOfCourtesy">
<span<?= $employees->TitleOfCourtesy->viewAttributes() ?>>
<?= $employees->TitleOfCourtesy->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->BirthDate->Visible) { // BirthDate ?>
        <tr id="r_BirthDate">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->BirthDate->caption() ?></td>
            <td <?= $employees->BirthDate->cellAttributes() ?>>
<span id="el_employees_BirthDate">
<span<?= $employees->BirthDate->viewAttributes() ?>>
<?= $employees->BirthDate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->HireDate->Visible) { // HireDate ?>
        <tr id="r_HireDate">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->HireDate->caption() ?></td>
            <td <?= $employees->HireDate->cellAttributes() ?>>
<span id="el_employees_HireDate">
<span<?= $employees->HireDate->viewAttributes() ?>>
<?= $employees->HireDate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->Address->Visible) { // Address ?>
        <tr id="r_Address">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->Address->caption() ?></td>
            <td <?= $employees->Address->cellAttributes() ?>>
<span id="el_employees_Address">
<span<?= $employees->Address->viewAttributes() ?>>
<?= $employees->Address->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->City->Visible) { // City ?>
        <tr id="r_City">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->City->caption() ?></td>
            <td <?= $employees->City->cellAttributes() ?>>
<span id="el_employees_City">
<span<?= $employees->City->viewAttributes() ?>>
<?= $employees->City->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->Region->Visible) { // Region ?>
        <tr id="r_Region">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->Region->caption() ?></td>
            <td <?= $employees->Region->cellAttributes() ?>>
<span id="el_employees_Region">
<span<?= $employees->Region->viewAttributes() ?>>
<?= $employees->Region->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->PostalCode->Visible) { // PostalCode ?>
        <tr id="r_PostalCode">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->PostalCode->caption() ?></td>
            <td <?= $employees->PostalCode->cellAttributes() ?>>
<span id="el_employees_PostalCode">
<span<?= $employees->PostalCode->viewAttributes() ?>>
<?= $employees->PostalCode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->Country->Visible) { // Country ?>
        <tr id="r_Country">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->Country->caption() ?></td>
            <td <?= $employees->Country->cellAttributes() ?>>
<span id="el_employees_Country">
<span<?= $employees->Country->viewAttributes() ?>>
<?= $employees->Country->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->HomePhone->Visible) { // HomePhone ?>
        <tr id="r_HomePhone">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->HomePhone->caption() ?></td>
            <td <?= $employees->HomePhone->cellAttributes() ?>>
<span id="el_employees_HomePhone">
<span<?= $employees->HomePhone->viewAttributes() ?>>
<?= $employees->HomePhone->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->Extension->Visible) { // Extension ?>
        <tr id="r_Extension">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->Extension->caption() ?></td>
            <td <?= $employees->Extension->cellAttributes() ?>>
<span id="el_employees_Extension">
<span<?= $employees->Extension->viewAttributes() ?>>
<?= $employees->Extension->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->Photo->Visible) { // Photo ?>
        <tr id="r_Photo">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->Photo->caption() ?></td>
            <td <?= $employees->Photo->cellAttributes() ?>>
<span id="el_employees_Photo">
<span<?= $employees->Photo->viewAttributes() ?>>
<?= $employees->Photo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->Notes->Visible) { // Notes ?>
        <tr id="r_Notes">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->Notes->caption() ?></td>
            <td <?= $employees->Notes->cellAttributes() ?>>
<span id="el_employees_Notes">
<span<?= $employees->Notes->viewAttributes() ?>>
<?= $employees->Notes->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->ReportsTo->Visible) { // ReportsTo ?>
        <tr id="r_ReportsTo">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->ReportsTo->caption() ?></td>
            <td <?= $employees->ReportsTo->cellAttributes() ?>>
<span id="el_employees_ReportsTo">
<span<?= $employees->ReportsTo->viewAttributes() ?>>
<?= $employees->ReportsTo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($employees->PhotoPath->Visible) { // PhotoPath ?>
        <tr id="r_PhotoPath">
            <td class="<?= $employees->TableLeftColumnClass ?>"><?= $employees->PhotoPath->caption() ?></td>
            <td <?= $employees->PhotoPath->cellAttributes() ?>>
<span id="el_employees_PhotoPath">
<span<?= $employees->PhotoPath->viewAttributes() ?>>
<?= $employees->PhotoPath->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
