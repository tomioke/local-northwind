<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class OrdersDelete extends Orders
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'orders';

    // Page object name
    public $PageObjName = "OrdersDelete";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (orders)
        if (!isset($GLOBALS["orders"]) || get_class($GLOBALS["orders"]) == PROJECT_NAMESPACE . "orders") {
            $GLOBALS["orders"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'orders');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("orders"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['OrderID'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->OrderID->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
        $this->OrderID->setVisibility();
        $this->CustomerID->setVisibility();
        $this->EmployeeID->setVisibility();
        $this->OrderDate->setVisibility();
        $this->RequiredDate->setVisibility();
        $this->ShippedDate->setVisibility();
        $this->ShipperID->setVisibility();
        $this->Freight->setVisibility();
        $this->ShipName->setVisibility();
        $this->ShipAddress->setVisibility();
        $this->ShipCity->setVisibility();
        $this->ShipRegion->setVisibility();
        $this->ShipPostalCode->setVisibility();
        $this->ShipCountry->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->CustomerID);
        $this->setupLookupOptions($this->EmployeeID);
        $this->setupLookupOptions($this->ShipperID);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("OrdersList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("OrdersList"); // Return to list
                return;
            }
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Rendering event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->OrderID->setDbValue($row['OrderID']);
        $this->CustomerID->setDbValue($row['CustomerID']);
        $this->EmployeeID->setDbValue($row['EmployeeID']);
        $this->OrderDate->setDbValue($row['OrderDate']);
        $this->RequiredDate->setDbValue($row['RequiredDate']);
        $this->ShippedDate->setDbValue($row['ShippedDate']);
        $this->ShipperID->setDbValue($row['ShipperID']);
        $this->Freight->setDbValue($row['Freight']);
        $this->ShipName->setDbValue($row['ShipName']);
        $this->ShipAddress->setDbValue($row['ShipAddress']);
        $this->ShipCity->setDbValue($row['ShipCity']);
        $this->ShipRegion->setDbValue($row['ShipRegion']);
        $this->ShipPostalCode->setDbValue($row['ShipPostalCode']);
        $this->ShipCountry->setDbValue($row['ShipCountry']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['OrderID'] = null;
        $row['CustomerID'] = null;
        $row['EmployeeID'] = null;
        $row['OrderDate'] = null;
        $row['RequiredDate'] = null;
        $row['ShippedDate'] = null;
        $row['ShipperID'] = null;
        $row['Freight'] = null;
        $row['ShipName'] = null;
        $row['ShipAddress'] = null;
        $row['ShipCity'] = null;
        $row['ShipRegion'] = null;
        $row['ShipPostalCode'] = null;
        $row['ShipCountry'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // OrderID

        // CustomerID

        // EmployeeID

        // OrderDate

        // RequiredDate

        // ShippedDate

        // ShipperID

        // Freight

        // ShipName

        // ShipAddress

        // ShipCity

        // ShipRegion

        // ShipPostalCode

        // ShipCountry
        if ($this->RowType == ROWTYPE_VIEW) {
            // OrderID
            $this->OrderID->ViewValue = $this->OrderID->CurrentValue;
            $this->OrderID->ViewValue = FormatNumber($this->OrderID->ViewValue, 0, -2, -2, -2);
            $this->OrderID->ViewCustomAttributes = "";

            // CustomerID
            $curVal = strval($this->CustomerID->CurrentValue);
            if ($curVal != "") {
                $this->CustomerID->ViewValue = $this->CustomerID->lookupCacheOption($curVal);
                if ($this->CustomerID->ViewValue === null) { // Lookup from database
                    $filterWrk = "`CustomerID`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CustomerID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CustomerID->Lookup->renderViewRow($rswrk[0]);
                        $this->CustomerID->ViewValue = $this->CustomerID->displayValue($arwrk);
                    } else {
                        $this->CustomerID->ViewValue = $this->CustomerID->CurrentValue;
                    }
                }
            } else {
                $this->CustomerID->ViewValue = null;
            }
            $this->CustomerID->ViewCustomAttributes = "";

            // EmployeeID
            $curVal = strval($this->EmployeeID->CurrentValue);
            if ($curVal != "") {
                $this->EmployeeID->ViewValue = $this->EmployeeID->lookupCacheOption($curVal);
                if ($this->EmployeeID->ViewValue === null) { // Lookup from database
                    $filterWrk = "`EmployeeID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->EmployeeID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->EmployeeID->Lookup->renderViewRow($rswrk[0]);
                        $this->EmployeeID->ViewValue = $this->EmployeeID->displayValue($arwrk);
                    } else {
                        $this->EmployeeID->ViewValue = $this->EmployeeID->CurrentValue;
                    }
                }
            } else {
                $this->EmployeeID->ViewValue = null;
            }
            $this->EmployeeID->ViewCustomAttributes = "";

            // OrderDate
            $this->OrderDate->ViewValue = $this->OrderDate->CurrentValue;
            $this->OrderDate->ViewValue = FormatDateTime($this->OrderDate->ViewValue, 0);
            $this->OrderDate->ViewCustomAttributes = "";

            // RequiredDate
            $this->RequiredDate->ViewValue = $this->RequiredDate->CurrentValue;
            $this->RequiredDate->ViewValue = FormatDateTime($this->RequiredDate->ViewValue, 7);
            $this->RequiredDate->ViewCustomAttributes = "";

            // ShippedDate
            $this->ShippedDate->ViewValue = $this->ShippedDate->CurrentValue;
            $this->ShippedDate->ViewValue = FormatDateTime($this->ShippedDate->ViewValue, 0);
            $this->ShippedDate->ViewCustomAttributes = "";

            // ShipperID
            $curVal = strval($this->ShipperID->CurrentValue);
            if ($curVal != "") {
                $this->ShipperID->ViewValue = $this->ShipperID->lookupCacheOption($curVal);
                if ($this->ShipperID->ViewValue === null) { // Lookup from database
                    $filterWrk = "`ShipperID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ShipperID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ShipperID->Lookup->renderViewRow($rswrk[0]);
                        $this->ShipperID->ViewValue = $this->ShipperID->displayValue($arwrk);
                    } else {
                        $this->ShipperID->ViewValue = $this->ShipperID->CurrentValue;
                    }
                }
            } else {
                $this->ShipperID->ViewValue = null;
            }
            $this->ShipperID->ViewCustomAttributes = "";

            // Freight
            $this->Freight->ViewValue = $this->Freight->CurrentValue;
            $this->Freight->ViewCustomAttributes = "";

            // ShipName
            $this->ShipName->ViewValue = $this->ShipName->CurrentValue;
            $this->ShipName->ViewCustomAttributes = "";

            // ShipAddress
            $this->ShipAddress->ViewValue = $this->ShipAddress->CurrentValue;
            $this->ShipAddress->ViewCustomAttributes = "";

            // ShipCity
            $this->ShipCity->ViewValue = $this->ShipCity->CurrentValue;
            $this->ShipCity->ViewCustomAttributes = "";

            // ShipRegion
            $this->ShipRegion->ViewValue = $this->ShipRegion->CurrentValue;
            $this->ShipRegion->ViewCustomAttributes = "";

            // ShipPostalCode
            $this->ShipPostalCode->ViewValue = $this->ShipPostalCode->CurrentValue;
            $this->ShipPostalCode->ViewCustomAttributes = "";

            // ShipCountry
            $this->ShipCountry->ViewValue = $this->ShipCountry->CurrentValue;
            $this->ShipCountry->ViewCustomAttributes = "";

            // OrderID
            $this->OrderID->LinkCustomAttributes = "";
            $this->OrderID->HrefValue = "";
            $this->OrderID->TooltipValue = "";

            // CustomerID
            $this->CustomerID->LinkCustomAttributes = "";
            $this->CustomerID->HrefValue = "";
            $this->CustomerID->TooltipValue = "";

            // EmployeeID
            $this->EmployeeID->LinkCustomAttributes = "";
            $this->EmployeeID->HrefValue = "";
            $this->EmployeeID->TooltipValue = "";

            // OrderDate
            $this->OrderDate->LinkCustomAttributes = "";
            $this->OrderDate->HrefValue = "";
            $this->OrderDate->TooltipValue = "";

            // RequiredDate
            $this->RequiredDate->LinkCustomAttributes = "";
            $this->RequiredDate->HrefValue = "";
            $this->RequiredDate->TooltipValue = "";

            // ShippedDate
            $this->ShippedDate->LinkCustomAttributes = "";
            $this->ShippedDate->HrefValue = "";
            $this->ShippedDate->TooltipValue = "";

            // ShipperID
            $this->ShipperID->LinkCustomAttributes = "";
            $this->ShipperID->HrefValue = "";
            $this->ShipperID->TooltipValue = "";

            // Freight
            $this->Freight->LinkCustomAttributes = "";
            $this->Freight->HrefValue = "";
            $this->Freight->TooltipValue = "";

            // ShipName
            $this->ShipName->LinkCustomAttributes = "";
            $this->ShipName->HrefValue = "";
            $this->ShipName->TooltipValue = "";

            // ShipAddress
            $this->ShipAddress->LinkCustomAttributes = "";
            $this->ShipAddress->HrefValue = "";
            $this->ShipAddress->TooltipValue = "";

            // ShipCity
            $this->ShipCity->LinkCustomAttributes = "";
            $this->ShipCity->HrefValue = "";
            $this->ShipCity->TooltipValue = "";

            // ShipRegion
            $this->ShipRegion->LinkCustomAttributes = "";
            $this->ShipRegion->HrefValue = "";
            $this->ShipRegion->TooltipValue = "";

            // ShipPostalCode
            $this->ShipPostalCode->LinkCustomAttributes = "";
            $this->ShipPostalCode->HrefValue = "";
            $this->ShipPostalCode->TooltipValue = "";

            // ShipCountry
            $this->ShipCountry->LinkCustomAttributes = "";
            $this->ShipCountry->HrefValue = "";
            $this->ShipCountry->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        $conn->beginTransaction();

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['OrderID'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("OrdersList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_CustomerID":
                    break;
                case "x_EmployeeID":
                    break;
                case "x_ShipperID":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }
}
