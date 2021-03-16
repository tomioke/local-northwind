<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class OrdersAdd extends Orders
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'orders';

    // Page object name
    public $PageObjName = "OrdersAdd";

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "OrdersView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;
    public $MultiPages; // Multi pages object

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->OrderID->Visible = false;
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

        // Set up multi page object
        $this->setupMultiPages();

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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("OrderID") ?? Route("OrderID")) !== null) {
                $this->OrderID->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("OrdersList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "OrdersList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "OrdersView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->OrderID->CurrentValue = null;
        $this->OrderID->OldValue = $this->OrderID->CurrentValue;
        $this->CustomerID->CurrentValue = null;
        $this->CustomerID->OldValue = $this->CustomerID->CurrentValue;
        $this->EmployeeID->CurrentValue = null;
        $this->EmployeeID->OldValue = $this->EmployeeID->CurrentValue;
        $this->OrderDate->CurrentValue = null;
        $this->OrderDate->OldValue = $this->OrderDate->CurrentValue;
        $this->RequiredDate->CurrentValue = null;
        $this->RequiredDate->OldValue = $this->RequiredDate->CurrentValue;
        $this->ShippedDate->CurrentValue = null;
        $this->ShippedDate->OldValue = $this->ShippedDate->CurrentValue;
        $this->ShipperID->CurrentValue = null;
        $this->ShipperID->OldValue = $this->ShipperID->CurrentValue;
        $this->Freight->CurrentValue = null;
        $this->Freight->OldValue = $this->Freight->CurrentValue;
        $this->ShipName->CurrentValue = null;
        $this->ShipName->OldValue = $this->ShipName->CurrentValue;
        $this->ShipAddress->CurrentValue = null;
        $this->ShipAddress->OldValue = $this->ShipAddress->CurrentValue;
        $this->ShipCity->CurrentValue = null;
        $this->ShipCity->OldValue = $this->ShipCity->CurrentValue;
        $this->ShipRegion->CurrentValue = null;
        $this->ShipRegion->OldValue = $this->ShipRegion->CurrentValue;
        $this->ShipPostalCode->CurrentValue = null;
        $this->ShipPostalCode->OldValue = $this->ShipPostalCode->CurrentValue;
        $this->ShipCountry->CurrentValue = null;
        $this->ShipCountry->OldValue = $this->ShipCountry->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'CustomerID' first before field var 'x_CustomerID'
        $val = $CurrentForm->hasValue("CustomerID") ? $CurrentForm->getValue("CustomerID") : $CurrentForm->getValue("x_CustomerID");
        if (!$this->CustomerID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CustomerID->Visible = false; // Disable update for API request
            } else {
                $this->CustomerID->setFormValue($val);
            }
        }

        // Check field name 'EmployeeID' first before field var 'x_EmployeeID'
        $val = $CurrentForm->hasValue("EmployeeID") ? $CurrentForm->getValue("EmployeeID") : $CurrentForm->getValue("x_EmployeeID");
        if (!$this->EmployeeID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EmployeeID->Visible = false; // Disable update for API request
            } else {
                $this->EmployeeID->setFormValue($val);
            }
        }

        // Check field name 'OrderDate' first before field var 'x_OrderDate'
        $val = $CurrentForm->hasValue("OrderDate") ? $CurrentForm->getValue("OrderDate") : $CurrentForm->getValue("x_OrderDate");
        if (!$this->OrderDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->OrderDate->Visible = false; // Disable update for API request
            } else {
                $this->OrderDate->setFormValue($val);
            }
            $this->OrderDate->CurrentValue = UnFormatDateTime($this->OrderDate->CurrentValue, 0);
        }

        // Check field name 'RequiredDate' first before field var 'x_RequiredDate'
        $val = $CurrentForm->hasValue("RequiredDate") ? $CurrentForm->getValue("RequiredDate") : $CurrentForm->getValue("x_RequiredDate");
        if (!$this->RequiredDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RequiredDate->Visible = false; // Disable update for API request
            } else {
                $this->RequiredDate->setFormValue($val);
            }
            $this->RequiredDate->CurrentValue = UnFormatDateTime($this->RequiredDate->CurrentValue, 0);
        }

        // Check field name 'ShippedDate' first before field var 'x_ShippedDate'
        $val = $CurrentForm->hasValue("ShippedDate") ? $CurrentForm->getValue("ShippedDate") : $CurrentForm->getValue("x_ShippedDate");
        if (!$this->ShippedDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShippedDate->Visible = false; // Disable update for API request
            } else {
                $this->ShippedDate->setFormValue($val);
            }
            $this->ShippedDate->CurrentValue = UnFormatDateTime($this->ShippedDate->CurrentValue, 0);
        }

        // Check field name 'ShipperID' first before field var 'x_ShipperID'
        $val = $CurrentForm->hasValue("ShipperID") ? $CurrentForm->getValue("ShipperID") : $CurrentForm->getValue("x_ShipperID");
        if (!$this->ShipperID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShipperID->Visible = false; // Disable update for API request
            } else {
                $this->ShipperID->setFormValue($val);
            }
        }

        // Check field name 'Freight' first before field var 'x_Freight'
        $val = $CurrentForm->hasValue("Freight") ? $CurrentForm->getValue("Freight") : $CurrentForm->getValue("x_Freight");
        if (!$this->Freight->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Freight->Visible = false; // Disable update for API request
            } else {
                $this->Freight->setFormValue($val);
            }
        }

        // Check field name 'ShipName' first before field var 'x_ShipName'
        $val = $CurrentForm->hasValue("ShipName") ? $CurrentForm->getValue("ShipName") : $CurrentForm->getValue("x_ShipName");
        if (!$this->ShipName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShipName->Visible = false; // Disable update for API request
            } else {
                $this->ShipName->setFormValue($val);
            }
        }

        // Check field name 'ShipAddress' first before field var 'x_ShipAddress'
        $val = $CurrentForm->hasValue("ShipAddress") ? $CurrentForm->getValue("ShipAddress") : $CurrentForm->getValue("x_ShipAddress");
        if (!$this->ShipAddress->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShipAddress->Visible = false; // Disable update for API request
            } else {
                $this->ShipAddress->setFormValue($val);
            }
        }

        // Check field name 'ShipCity' first before field var 'x_ShipCity'
        $val = $CurrentForm->hasValue("ShipCity") ? $CurrentForm->getValue("ShipCity") : $CurrentForm->getValue("x_ShipCity");
        if (!$this->ShipCity->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShipCity->Visible = false; // Disable update for API request
            } else {
                $this->ShipCity->setFormValue($val);
            }
        }

        // Check field name 'ShipRegion' first before field var 'x_ShipRegion'
        $val = $CurrentForm->hasValue("ShipRegion") ? $CurrentForm->getValue("ShipRegion") : $CurrentForm->getValue("x_ShipRegion");
        if (!$this->ShipRegion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShipRegion->Visible = false; // Disable update for API request
            } else {
                $this->ShipRegion->setFormValue($val);
            }
        }

        // Check field name 'ShipPostalCode' first before field var 'x_ShipPostalCode'
        $val = $CurrentForm->hasValue("ShipPostalCode") ? $CurrentForm->getValue("ShipPostalCode") : $CurrentForm->getValue("x_ShipPostalCode");
        if (!$this->ShipPostalCode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShipPostalCode->Visible = false; // Disable update for API request
            } else {
                $this->ShipPostalCode->setFormValue($val);
            }
        }

        // Check field name 'ShipCountry' first before field var 'x_ShipCountry'
        $val = $CurrentForm->hasValue("ShipCountry") ? $CurrentForm->getValue("ShipCountry") : $CurrentForm->getValue("x_ShipCountry");
        if (!$this->ShipCountry->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ShipCountry->Visible = false; // Disable update for API request
            } else {
                $this->ShipCountry->setFormValue($val);
            }
        }

        // Check field name 'OrderID' first before field var 'x_OrderID'
        $val = $CurrentForm->hasValue("OrderID") ? $CurrentForm->getValue("OrderID") : $CurrentForm->getValue("x_OrderID");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->CustomerID->CurrentValue = $this->CustomerID->FormValue;
        $this->EmployeeID->CurrentValue = $this->EmployeeID->FormValue;
        $this->OrderDate->CurrentValue = $this->OrderDate->FormValue;
        $this->OrderDate->CurrentValue = UnFormatDateTime($this->OrderDate->CurrentValue, 0);
        $this->RequiredDate->CurrentValue = $this->RequiredDate->FormValue;
        $this->RequiredDate->CurrentValue = UnFormatDateTime($this->RequiredDate->CurrentValue, 0);
        $this->ShippedDate->CurrentValue = $this->ShippedDate->FormValue;
        $this->ShippedDate->CurrentValue = UnFormatDateTime($this->ShippedDate->CurrentValue, 0);
        $this->ShipperID->CurrentValue = $this->ShipperID->FormValue;
        $this->Freight->CurrentValue = $this->Freight->FormValue;
        $this->ShipName->CurrentValue = $this->ShipName->FormValue;
        $this->ShipAddress->CurrentValue = $this->ShipAddress->FormValue;
        $this->ShipCity->CurrentValue = $this->ShipCity->FormValue;
        $this->ShipRegion->CurrentValue = $this->ShipRegion->FormValue;
        $this->ShipPostalCode->CurrentValue = $this->ShipPostalCode->FormValue;
        $this->ShipCountry->CurrentValue = $this->ShipCountry->FormValue;
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
        $this->loadDefaultValues();
        $row = [];
        $row['OrderID'] = $this->OrderID->CurrentValue;
        $row['CustomerID'] = $this->CustomerID->CurrentValue;
        $row['EmployeeID'] = $this->EmployeeID->CurrentValue;
        $row['OrderDate'] = $this->OrderDate->CurrentValue;
        $row['RequiredDate'] = $this->RequiredDate->CurrentValue;
        $row['ShippedDate'] = $this->ShippedDate->CurrentValue;
        $row['ShipperID'] = $this->ShipperID->CurrentValue;
        $row['Freight'] = $this->Freight->CurrentValue;
        $row['ShipName'] = $this->ShipName->CurrentValue;
        $row['ShipAddress'] = $this->ShipAddress->CurrentValue;
        $row['ShipCity'] = $this->ShipCity->CurrentValue;
        $row['ShipRegion'] = $this->ShipRegion->CurrentValue;
        $row['ShipPostalCode'] = $this->ShipPostalCode->CurrentValue;
        $row['ShipCountry'] = $this->ShipCountry->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
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
            $this->CustomerID->ViewValue = $this->CustomerID->CurrentValue;
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
            $this->RequiredDate->ViewValue = FormatDateTime($this->RequiredDate->ViewValue, 0);
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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // CustomerID
            $this->CustomerID->EditAttrs["class"] = "form-control";
            $this->CustomerID->EditCustomAttributes = "";
            if (!$this->CustomerID->Raw) {
                $this->CustomerID->CurrentValue = HtmlDecode($this->CustomerID->CurrentValue);
            }
            $this->CustomerID->EditValue = HtmlEncode($this->CustomerID->CurrentValue);
            $curVal = strval($this->CustomerID->CurrentValue);
            if ($curVal != "") {
                $this->CustomerID->EditValue = $this->CustomerID->lookupCacheOption($curVal);
                if ($this->CustomerID->EditValue === null) { // Lookup from database
                    $filterWrk = "`CustomerID`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CustomerID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CustomerID->Lookup->renderViewRow($rswrk[0]);
                        $this->CustomerID->EditValue = $this->CustomerID->displayValue($arwrk);
                    } else {
                        $this->CustomerID->EditValue = HtmlEncode($this->CustomerID->CurrentValue);
                    }
                }
            } else {
                $this->CustomerID->EditValue = null;
            }
            $this->CustomerID->PlaceHolder = RemoveHtml($this->CustomerID->caption());

            // EmployeeID
            $this->EmployeeID->EditAttrs["class"] = "form-control";
            $this->EmployeeID->EditCustomAttributes = "";
            $curVal = trim(strval($this->EmployeeID->CurrentValue));
            if ($curVal != "") {
                $this->EmployeeID->ViewValue = $this->EmployeeID->lookupCacheOption($curVal);
            } else {
                $this->EmployeeID->ViewValue = $this->EmployeeID->Lookup !== null && is_array($this->EmployeeID->Lookup->Options) ? $curVal : null;
            }
            if ($this->EmployeeID->ViewValue !== null) { // Load from cache
                $this->EmployeeID->EditValue = array_values($this->EmployeeID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`EmployeeID`" . SearchString("=", $this->EmployeeID->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->EmployeeID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->EmployeeID->EditValue = $arwrk;
            }
            $this->EmployeeID->PlaceHolder = RemoveHtml($this->EmployeeID->caption());

            // OrderDate
            $this->OrderDate->EditAttrs["class"] = "form-control";
            $this->OrderDate->EditCustomAttributes = "";
            $this->OrderDate->EditValue = HtmlEncode(FormatDateTime($this->OrderDate->CurrentValue, 8));
            $this->OrderDate->PlaceHolder = RemoveHtml($this->OrderDate->caption());

            // RequiredDate
            $this->RequiredDate->EditAttrs["class"] = "form-control";
            $this->RequiredDate->EditCustomAttributes = "";
            $this->RequiredDate->EditValue = HtmlEncode(FormatDateTime($this->RequiredDate->CurrentValue, 8));
            $this->RequiredDate->PlaceHolder = RemoveHtml($this->RequiredDate->caption());

            // ShippedDate
            $this->ShippedDate->EditAttrs["class"] = "form-control";
            $this->ShippedDate->EditCustomAttributes = "";
            $this->ShippedDate->EditValue = HtmlEncode(FormatDateTime($this->ShippedDate->CurrentValue, 8));
            $this->ShippedDate->PlaceHolder = RemoveHtml($this->ShippedDate->caption());

            // ShipperID
            $this->ShipperID->EditCustomAttributes = "";
            $curVal = trim(strval($this->ShipperID->CurrentValue));
            if ($curVal != "") {
                $this->ShipperID->ViewValue = $this->ShipperID->lookupCacheOption($curVal);
            } else {
                $this->ShipperID->ViewValue = $this->ShipperID->Lookup !== null && is_array($this->ShipperID->Lookup->Options) ? $curVal : null;
            }
            if ($this->ShipperID->ViewValue !== null) { // Load from cache
                $this->ShipperID->EditValue = array_values($this->ShipperID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`ShipperID`" . SearchString("=", $this->ShipperID->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->ShipperID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ShipperID->EditValue = $arwrk;
            }
            $this->ShipperID->PlaceHolder = RemoveHtml($this->ShipperID->caption());

            // Freight
            $this->Freight->EditAttrs["class"] = "form-control";
            $this->Freight->EditCustomAttributes = "";
            if (!$this->Freight->Raw) {
                $this->Freight->CurrentValue = HtmlDecode($this->Freight->CurrentValue);
            }
            $this->Freight->EditValue = HtmlEncode($this->Freight->CurrentValue);
            $this->Freight->PlaceHolder = RemoveHtml($this->Freight->caption());

            // ShipName
            $this->ShipName->EditAttrs["class"] = "form-control";
            $this->ShipName->EditCustomAttributes = "";
            if (!$this->ShipName->Raw) {
                $this->ShipName->CurrentValue = HtmlDecode($this->ShipName->CurrentValue);
            }
            $this->ShipName->EditValue = HtmlEncode($this->ShipName->CurrentValue);
            $this->ShipName->PlaceHolder = RemoveHtml($this->ShipName->caption());

            // ShipAddress
            $this->ShipAddress->EditAttrs["class"] = "form-control";
            $this->ShipAddress->EditCustomAttributes = "";
            if (!$this->ShipAddress->Raw) {
                $this->ShipAddress->CurrentValue = HtmlDecode($this->ShipAddress->CurrentValue);
            }
            $this->ShipAddress->EditValue = HtmlEncode($this->ShipAddress->CurrentValue);
            $this->ShipAddress->PlaceHolder = RemoveHtml($this->ShipAddress->caption());

            // ShipCity
            $this->ShipCity->EditAttrs["class"] = "form-control";
            $this->ShipCity->EditCustomAttributes = "";
            if (!$this->ShipCity->Raw) {
                $this->ShipCity->CurrentValue = HtmlDecode($this->ShipCity->CurrentValue);
            }
            $this->ShipCity->EditValue = HtmlEncode($this->ShipCity->CurrentValue);
            $this->ShipCity->PlaceHolder = RemoveHtml($this->ShipCity->caption());

            // ShipRegion
            $this->ShipRegion->EditAttrs["class"] = "form-control";
            $this->ShipRegion->EditCustomAttributes = "";
            if (!$this->ShipRegion->Raw) {
                $this->ShipRegion->CurrentValue = HtmlDecode($this->ShipRegion->CurrentValue);
            }
            $this->ShipRegion->EditValue = HtmlEncode($this->ShipRegion->CurrentValue);
            $this->ShipRegion->PlaceHolder = RemoveHtml($this->ShipRegion->caption());

            // ShipPostalCode
            $this->ShipPostalCode->EditAttrs["class"] = "form-control";
            $this->ShipPostalCode->EditCustomAttributes = "";
            if (!$this->ShipPostalCode->Raw) {
                $this->ShipPostalCode->CurrentValue = HtmlDecode($this->ShipPostalCode->CurrentValue);
            }
            $this->ShipPostalCode->EditValue = HtmlEncode($this->ShipPostalCode->CurrentValue);
            $this->ShipPostalCode->PlaceHolder = RemoveHtml($this->ShipPostalCode->caption());

            // ShipCountry
            $this->ShipCountry->EditAttrs["class"] = "form-control";
            $this->ShipCountry->EditCustomAttributes = "";
            if (!$this->ShipCountry->Raw) {
                $this->ShipCountry->CurrentValue = HtmlDecode($this->ShipCountry->CurrentValue);
            }
            $this->ShipCountry->EditValue = HtmlEncode($this->ShipCountry->CurrentValue);
            $this->ShipCountry->PlaceHolder = RemoveHtml($this->ShipCountry->caption());

            // Add refer script

            // CustomerID
            $this->CustomerID->LinkCustomAttributes = "";
            $this->CustomerID->HrefValue = "";

            // EmployeeID
            $this->EmployeeID->LinkCustomAttributes = "";
            $this->EmployeeID->HrefValue = "";

            // OrderDate
            $this->OrderDate->LinkCustomAttributes = "";
            $this->OrderDate->HrefValue = "";

            // RequiredDate
            $this->RequiredDate->LinkCustomAttributes = "";
            $this->RequiredDate->HrefValue = "";

            // ShippedDate
            $this->ShippedDate->LinkCustomAttributes = "";
            $this->ShippedDate->HrefValue = "";

            // ShipperID
            $this->ShipperID->LinkCustomAttributes = "";
            $this->ShipperID->HrefValue = "";

            // Freight
            $this->Freight->LinkCustomAttributes = "";
            $this->Freight->HrefValue = "";

            // ShipName
            $this->ShipName->LinkCustomAttributes = "";
            $this->ShipName->HrefValue = "";

            // ShipAddress
            $this->ShipAddress->LinkCustomAttributes = "";
            $this->ShipAddress->HrefValue = "";

            // ShipCity
            $this->ShipCity->LinkCustomAttributes = "";
            $this->ShipCity->HrefValue = "";

            // ShipRegion
            $this->ShipRegion->LinkCustomAttributes = "";
            $this->ShipRegion->HrefValue = "";

            // ShipPostalCode
            $this->ShipPostalCode->LinkCustomAttributes = "";
            $this->ShipPostalCode->HrefValue = "";

            // ShipCountry
            $this->ShipCountry->LinkCustomAttributes = "";
            $this->ShipCountry->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->CustomerID->Required) {
            if (!$this->CustomerID->IsDetailKey && EmptyValue($this->CustomerID->FormValue)) {
                $this->CustomerID->addErrorMessage(str_replace("%s", $this->CustomerID->caption(), $this->CustomerID->RequiredErrorMessage));
            }
        }
        if ($this->EmployeeID->Required) {
            if (!$this->EmployeeID->IsDetailKey && EmptyValue($this->EmployeeID->FormValue)) {
                $this->EmployeeID->addErrorMessage(str_replace("%s", $this->EmployeeID->caption(), $this->EmployeeID->RequiredErrorMessage));
            }
        }
        if ($this->OrderDate->Required) {
            if (!$this->OrderDate->IsDetailKey && EmptyValue($this->OrderDate->FormValue)) {
                $this->OrderDate->addErrorMessage(str_replace("%s", $this->OrderDate->caption(), $this->OrderDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->OrderDate->FormValue)) {
            $this->OrderDate->addErrorMessage($this->OrderDate->getErrorMessage(false));
        }
        if ($this->RequiredDate->Required) {
            if (!$this->RequiredDate->IsDetailKey && EmptyValue($this->RequiredDate->FormValue)) {
                $this->RequiredDate->addErrorMessage(str_replace("%s", $this->RequiredDate->caption(), $this->RequiredDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->RequiredDate->FormValue)) {
            $this->RequiredDate->addErrorMessage($this->RequiredDate->getErrorMessage(false));
        }
        if ($this->ShippedDate->Required) {
            if (!$this->ShippedDate->IsDetailKey && EmptyValue($this->ShippedDate->FormValue)) {
                $this->ShippedDate->addErrorMessage(str_replace("%s", $this->ShippedDate->caption(), $this->ShippedDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ShippedDate->FormValue)) {
            $this->ShippedDate->addErrorMessage($this->ShippedDate->getErrorMessage(false));
        }
        if ($this->ShipperID->Required) {
            if ($this->ShipperID->FormValue == "") {
                $this->ShipperID->addErrorMessage(str_replace("%s", $this->ShipperID->caption(), $this->ShipperID->RequiredErrorMessage));
            }
        }
        if ($this->Freight->Required) {
            if (!$this->Freight->IsDetailKey && EmptyValue($this->Freight->FormValue)) {
                $this->Freight->addErrorMessage(str_replace("%s", $this->Freight->caption(), $this->Freight->RequiredErrorMessage));
            }
        }
        if ($this->ShipName->Required) {
            if (!$this->ShipName->IsDetailKey && EmptyValue($this->ShipName->FormValue)) {
                $this->ShipName->addErrorMessage(str_replace("%s", $this->ShipName->caption(), $this->ShipName->RequiredErrorMessage));
            }
        }
        if ($this->ShipAddress->Required) {
            if (!$this->ShipAddress->IsDetailKey && EmptyValue($this->ShipAddress->FormValue)) {
                $this->ShipAddress->addErrorMessage(str_replace("%s", $this->ShipAddress->caption(), $this->ShipAddress->RequiredErrorMessage));
            }
        }
        if ($this->ShipCity->Required) {
            if (!$this->ShipCity->IsDetailKey && EmptyValue($this->ShipCity->FormValue)) {
                $this->ShipCity->addErrorMessage(str_replace("%s", $this->ShipCity->caption(), $this->ShipCity->RequiredErrorMessage));
            }
        }
        if ($this->ShipRegion->Required) {
            if (!$this->ShipRegion->IsDetailKey && EmptyValue($this->ShipRegion->FormValue)) {
                $this->ShipRegion->addErrorMessage(str_replace("%s", $this->ShipRegion->caption(), $this->ShipRegion->RequiredErrorMessage));
            }
        }
        if ($this->ShipPostalCode->Required) {
            if (!$this->ShipPostalCode->IsDetailKey && EmptyValue($this->ShipPostalCode->FormValue)) {
                $this->ShipPostalCode->addErrorMessage(str_replace("%s", $this->ShipPostalCode->caption(), $this->ShipPostalCode->RequiredErrorMessage));
            }
        }
        if ($this->ShipCountry->Required) {
            if (!$this->ShipCountry->IsDetailKey && EmptyValue($this->ShipCountry->FormValue)) {
                $this->ShipCountry->addErrorMessage(str_replace("%s", $this->ShipCountry->caption(), $this->ShipCountry->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("OrderDetailsGrid");
        if (in_array("order_details", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // CustomerID
        $this->CustomerID->setDbValueDef($rsnew, $this->CustomerID->CurrentValue, null, false);

        // EmployeeID
        $this->EmployeeID->setDbValueDef($rsnew, $this->EmployeeID->CurrentValue, null, false);

        // OrderDate
        $this->OrderDate->setDbValueDef($rsnew, UnFormatDateTime($this->OrderDate->CurrentValue, 0), null, false);

        // RequiredDate
        $this->RequiredDate->setDbValueDef($rsnew, UnFormatDateTime($this->RequiredDate->CurrentValue, 0), null, false);

        // ShippedDate
        $this->ShippedDate->setDbValueDef($rsnew, UnFormatDateTime($this->ShippedDate->CurrentValue, 0), null, false);

        // ShipperID
        $this->ShipperID->setDbValueDef($rsnew, $this->ShipperID->CurrentValue, null, false);

        // Freight
        $this->Freight->setDbValueDef($rsnew, $this->Freight->CurrentValue, null, false);

        // ShipName
        $this->ShipName->setDbValueDef($rsnew, $this->ShipName->CurrentValue, null, false);

        // ShipAddress
        $this->ShipAddress->setDbValueDef($rsnew, $this->ShipAddress->CurrentValue, null, false);

        // ShipCity
        $this->ShipCity->setDbValueDef($rsnew, $this->ShipCity->CurrentValue, null, false);

        // ShipRegion
        $this->ShipRegion->setDbValueDef($rsnew, $this->ShipRegion->CurrentValue, null, false);

        // ShipPostalCode
        $this->ShipPostalCode->setDbValueDef($rsnew, $this->ShipPostalCode->CurrentValue, null, false);

        // ShipCountry
        $this->ShipCountry->setDbValueDef($rsnew, $this->ShipCountry->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("OrderDetailsGrid");
            if (in_array("order_details", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->OrderID->setSessionValue($this->OrderID->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->OrderID->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("order_details", $detailTblVar)) {
                $detailPageObj = Container("OrderDetailsGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->OrderID->IsDetailKey = true;
                    $detailPageObj->OrderID->CurrentValue = $this->OrderID->CurrentValue;
                    $detailPageObj->OrderID->setSessionValue($detailPageObj->OrderID->CurrentValue);
                    $detailPageObj->ProductID->setSessionValue(""); // Clear session key
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("OrdersList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $pages->add(3);
        $this->MultiPages = $pages;
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
