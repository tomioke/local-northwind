<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ProductsEdit extends Products
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'products';

    // Page object name
    public $PageObjName = "ProductsEdit";

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

        // Table object (products)
        if (!isset($GLOBALS["products"]) || get_class($GLOBALS["products"]) == PROJECT_NAMESPACE . "products") {
            $GLOBALS["products"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'products');
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
                $doc = new $class(Container("products"));
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
                    if ($pageName == "ProductsView") {
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
            $key .= @$ar['ProductID'];
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->ProductID->setVisibility();
        $this->ProductName->setVisibility();
        $this->SupplierID->setVisibility();
        $this->CategoryID->setVisibility();
        $this->QuantityPerUnit->setVisibility();
        $this->UnitPrice->setVisibility();
        $this->UnitsInStock->setVisibility();
        $this->UnitsOnOrder->setVisibility();
        $this->ReorderLevel->setVisibility();
        $this->Discontinued->setVisibility();
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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ProductID") ?? Key(0) ?? Route(2)) !== null) {
                $this->ProductID->setQueryStringValue($keyValue);
                $this->ProductID->setOldValue($this->ProductID->QueryStringValue);
            } elseif (Post("ProductID") !== null) {
                $this->ProductID->setFormValue(Post("ProductID"));
                $this->ProductID->setOldValue($this->ProductID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("ProductID") ?? Route("ProductID")) !== null) {
                    $this->ProductID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ProductID->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("ProductsList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ProductsList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'ProductID' first before field var 'x_ProductID'
        $val = $CurrentForm->hasValue("ProductID") ? $CurrentForm->getValue("ProductID") : $CurrentForm->getValue("x_ProductID");
        if (!$this->ProductID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ProductID->Visible = false; // Disable update for API request
            } else {
                $this->ProductID->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ProductID")) {
            $this->ProductID->setOldValue($CurrentForm->getValue("o_ProductID"));
        }

        // Check field name 'ProductName' first before field var 'x_ProductName'
        $val = $CurrentForm->hasValue("ProductName") ? $CurrentForm->getValue("ProductName") : $CurrentForm->getValue("x_ProductName");
        if (!$this->ProductName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ProductName->Visible = false; // Disable update for API request
            } else {
                $this->ProductName->setFormValue($val);
            }
        }

        // Check field name 'SupplierID' first before field var 'x_SupplierID'
        $val = $CurrentForm->hasValue("SupplierID") ? $CurrentForm->getValue("SupplierID") : $CurrentForm->getValue("x_SupplierID");
        if (!$this->SupplierID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SupplierID->Visible = false; // Disable update for API request
            } else {
                $this->SupplierID->setFormValue($val);
            }
        }

        // Check field name 'CategoryID' first before field var 'x_CategoryID'
        $val = $CurrentForm->hasValue("CategoryID") ? $CurrentForm->getValue("CategoryID") : $CurrentForm->getValue("x_CategoryID");
        if (!$this->CategoryID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CategoryID->Visible = false; // Disable update for API request
            } else {
                $this->CategoryID->setFormValue($val);
            }
        }

        // Check field name 'QuantityPerUnit' first before field var 'x_QuantityPerUnit'
        $val = $CurrentForm->hasValue("QuantityPerUnit") ? $CurrentForm->getValue("QuantityPerUnit") : $CurrentForm->getValue("x_QuantityPerUnit");
        if (!$this->QuantityPerUnit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QuantityPerUnit->Visible = false; // Disable update for API request
            } else {
                $this->QuantityPerUnit->setFormValue($val);
            }
        }

        // Check field name 'UnitPrice' first before field var 'x_UnitPrice'
        $val = $CurrentForm->hasValue("UnitPrice") ? $CurrentForm->getValue("UnitPrice") : $CurrentForm->getValue("x_UnitPrice");
        if (!$this->UnitPrice->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->UnitPrice->Visible = false; // Disable update for API request
            } else {
                $this->UnitPrice->setFormValue($val);
            }
        }

        // Check field name 'UnitsInStock' first before field var 'x_UnitsInStock'
        $val = $CurrentForm->hasValue("UnitsInStock") ? $CurrentForm->getValue("UnitsInStock") : $CurrentForm->getValue("x_UnitsInStock");
        if (!$this->UnitsInStock->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->UnitsInStock->Visible = false; // Disable update for API request
            } else {
                $this->UnitsInStock->setFormValue($val);
            }
        }

        // Check field name 'UnitsOnOrder' first before field var 'x_UnitsOnOrder'
        $val = $CurrentForm->hasValue("UnitsOnOrder") ? $CurrentForm->getValue("UnitsOnOrder") : $CurrentForm->getValue("x_UnitsOnOrder");
        if (!$this->UnitsOnOrder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->UnitsOnOrder->Visible = false; // Disable update for API request
            } else {
                $this->UnitsOnOrder->setFormValue($val);
            }
        }

        // Check field name 'ReorderLevel' first before field var 'x_ReorderLevel'
        $val = $CurrentForm->hasValue("ReorderLevel") ? $CurrentForm->getValue("ReorderLevel") : $CurrentForm->getValue("x_ReorderLevel");
        if (!$this->ReorderLevel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ReorderLevel->Visible = false; // Disable update for API request
            } else {
                $this->ReorderLevel->setFormValue($val);
            }
        }

        // Check field name 'Discontinued' first before field var 'x_Discontinued'
        $val = $CurrentForm->hasValue("Discontinued") ? $CurrentForm->getValue("Discontinued") : $CurrentForm->getValue("x_Discontinued");
        if (!$this->Discontinued->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Discontinued->Visible = false; // Disable update for API request
            } else {
                $this->Discontinued->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ProductID->CurrentValue = $this->ProductID->FormValue;
        $this->ProductName->CurrentValue = $this->ProductName->FormValue;
        $this->SupplierID->CurrentValue = $this->SupplierID->FormValue;
        $this->CategoryID->CurrentValue = $this->CategoryID->FormValue;
        $this->QuantityPerUnit->CurrentValue = $this->QuantityPerUnit->FormValue;
        $this->UnitPrice->CurrentValue = $this->UnitPrice->FormValue;
        $this->UnitsInStock->CurrentValue = $this->UnitsInStock->FormValue;
        $this->UnitsOnOrder->CurrentValue = $this->UnitsOnOrder->FormValue;
        $this->ReorderLevel->CurrentValue = $this->ReorderLevel->FormValue;
        $this->Discontinued->CurrentValue = $this->Discontinued->FormValue;
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
        $this->ProductID->setDbValue($row['ProductID']);
        $this->ProductName->setDbValue($row['ProductName']);
        $this->SupplierID->setDbValue($row['SupplierID']);
        $this->CategoryID->setDbValue($row['CategoryID']);
        $this->QuantityPerUnit->setDbValue($row['QuantityPerUnit']);
        $this->UnitPrice->setDbValue($row['UnitPrice']);
        $this->UnitsInStock->setDbValue($row['UnitsInStock']);
        $this->UnitsOnOrder->setDbValue($row['UnitsOnOrder']);
        $this->ReorderLevel->setDbValue($row['ReorderLevel']);
        $this->Discontinued->setDbValue($row['Discontinued']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ProductID'] = null;
        $row['ProductName'] = null;
        $row['SupplierID'] = null;
        $row['CategoryID'] = null;
        $row['QuantityPerUnit'] = null;
        $row['UnitPrice'] = null;
        $row['UnitsInStock'] = null;
        $row['UnitsOnOrder'] = null;
        $row['ReorderLevel'] = null;
        $row['Discontinued'] = null;
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

        // ProductID

        // ProductName

        // SupplierID

        // CategoryID

        // QuantityPerUnit

        // UnitPrice

        // UnitsInStock

        // UnitsOnOrder

        // ReorderLevel

        // Discontinued
        if ($this->RowType == ROWTYPE_VIEW) {
            // ProductID
            $this->ProductID->ViewValue = $this->ProductID->CurrentValue;
            $this->ProductID->ViewValue = FormatNumber($this->ProductID->ViewValue, 0, -2, -2, -2);
            $this->ProductID->ViewCustomAttributes = "";

            // ProductName
            $this->ProductName->ViewValue = $this->ProductName->CurrentValue;
            $this->ProductName->ViewCustomAttributes = "";

            // SupplierID
            $this->SupplierID->ViewValue = $this->SupplierID->CurrentValue;
            $this->SupplierID->ViewCustomAttributes = "";

            // CategoryID
            $this->CategoryID->ViewValue = $this->CategoryID->CurrentValue;
            $this->CategoryID->ViewCustomAttributes = "";

            // QuantityPerUnit
            $this->QuantityPerUnit->ViewValue = $this->QuantityPerUnit->CurrentValue;
            $this->QuantityPerUnit->ViewCustomAttributes = "";

            // UnitPrice
            $this->UnitPrice->ViewValue = $this->UnitPrice->CurrentValue;
            $this->UnitPrice->ViewCustomAttributes = "";

            // UnitsInStock
            $this->UnitsInStock->ViewValue = $this->UnitsInStock->CurrentValue;
            $this->UnitsInStock->ViewCustomAttributes = "";

            // UnitsOnOrder
            $this->UnitsOnOrder->ViewValue = $this->UnitsOnOrder->CurrentValue;
            $this->UnitsOnOrder->ViewCustomAttributes = "";

            // ReorderLevel
            $this->ReorderLevel->ViewValue = $this->ReorderLevel->CurrentValue;
            $this->ReorderLevel->ViewCustomAttributes = "";

            // Discontinued
            $this->Discontinued->ViewValue = $this->Discontinued->CurrentValue;
            $this->Discontinued->ViewCustomAttributes = "";

            // ProductID
            $this->ProductID->LinkCustomAttributes = "";
            $this->ProductID->HrefValue = "";
            $this->ProductID->TooltipValue = "";

            // ProductName
            $this->ProductName->LinkCustomAttributes = "";
            $this->ProductName->HrefValue = "";
            $this->ProductName->TooltipValue = "";

            // SupplierID
            $this->SupplierID->LinkCustomAttributes = "";
            $this->SupplierID->HrefValue = "";
            $this->SupplierID->TooltipValue = "";

            // CategoryID
            $this->CategoryID->LinkCustomAttributes = "";
            $this->CategoryID->HrefValue = "";
            $this->CategoryID->TooltipValue = "";

            // QuantityPerUnit
            $this->QuantityPerUnit->LinkCustomAttributes = "";
            $this->QuantityPerUnit->HrefValue = "";
            $this->QuantityPerUnit->TooltipValue = "";

            // UnitPrice
            $this->UnitPrice->LinkCustomAttributes = "";
            $this->UnitPrice->HrefValue = "";
            $this->UnitPrice->TooltipValue = "";

            // UnitsInStock
            $this->UnitsInStock->LinkCustomAttributes = "";
            $this->UnitsInStock->HrefValue = "";
            $this->UnitsInStock->TooltipValue = "";

            // UnitsOnOrder
            $this->UnitsOnOrder->LinkCustomAttributes = "";
            $this->UnitsOnOrder->HrefValue = "";
            $this->UnitsOnOrder->TooltipValue = "";

            // ReorderLevel
            $this->ReorderLevel->LinkCustomAttributes = "";
            $this->ReorderLevel->HrefValue = "";
            $this->ReorderLevel->TooltipValue = "";

            // Discontinued
            $this->Discontinued->LinkCustomAttributes = "";
            $this->Discontinued->HrefValue = "";
            $this->Discontinued->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ProductID
            $this->ProductID->EditAttrs["class"] = "form-control";
            $this->ProductID->EditCustomAttributes = "";
            $this->ProductID->EditValue = HtmlEncode($this->ProductID->CurrentValue);
            $this->ProductID->PlaceHolder = RemoveHtml($this->ProductID->caption());

            // ProductName
            $this->ProductName->EditAttrs["class"] = "form-control";
            $this->ProductName->EditCustomAttributes = "";
            if (!$this->ProductName->Raw) {
                $this->ProductName->CurrentValue = HtmlDecode($this->ProductName->CurrentValue);
            }
            $this->ProductName->EditValue = HtmlEncode($this->ProductName->CurrentValue);
            $this->ProductName->PlaceHolder = RemoveHtml($this->ProductName->caption());

            // SupplierID
            $this->SupplierID->EditAttrs["class"] = "form-control";
            $this->SupplierID->EditCustomAttributes = "";
            if (!$this->SupplierID->Raw) {
                $this->SupplierID->CurrentValue = HtmlDecode($this->SupplierID->CurrentValue);
            }
            $this->SupplierID->EditValue = HtmlEncode($this->SupplierID->CurrentValue);
            $this->SupplierID->PlaceHolder = RemoveHtml($this->SupplierID->caption());

            // CategoryID
            $this->CategoryID->EditAttrs["class"] = "form-control";
            $this->CategoryID->EditCustomAttributes = "";
            if (!$this->CategoryID->Raw) {
                $this->CategoryID->CurrentValue = HtmlDecode($this->CategoryID->CurrentValue);
            }
            $this->CategoryID->EditValue = HtmlEncode($this->CategoryID->CurrentValue);
            $this->CategoryID->PlaceHolder = RemoveHtml($this->CategoryID->caption());

            // QuantityPerUnit
            $this->QuantityPerUnit->EditAttrs["class"] = "form-control";
            $this->QuantityPerUnit->EditCustomAttributes = "";
            if (!$this->QuantityPerUnit->Raw) {
                $this->QuantityPerUnit->CurrentValue = HtmlDecode($this->QuantityPerUnit->CurrentValue);
            }
            $this->QuantityPerUnit->EditValue = HtmlEncode($this->QuantityPerUnit->CurrentValue);
            $this->QuantityPerUnit->PlaceHolder = RemoveHtml($this->QuantityPerUnit->caption());

            // UnitPrice
            $this->UnitPrice->EditAttrs["class"] = "form-control";
            $this->UnitPrice->EditCustomAttributes = "";
            if (!$this->UnitPrice->Raw) {
                $this->UnitPrice->CurrentValue = HtmlDecode($this->UnitPrice->CurrentValue);
            }
            $this->UnitPrice->EditValue = HtmlEncode($this->UnitPrice->CurrentValue);
            $this->UnitPrice->PlaceHolder = RemoveHtml($this->UnitPrice->caption());

            // UnitsInStock
            $this->UnitsInStock->EditAttrs["class"] = "form-control";
            $this->UnitsInStock->EditCustomAttributes = "";
            if (!$this->UnitsInStock->Raw) {
                $this->UnitsInStock->CurrentValue = HtmlDecode($this->UnitsInStock->CurrentValue);
            }
            $this->UnitsInStock->EditValue = HtmlEncode($this->UnitsInStock->CurrentValue);
            $this->UnitsInStock->PlaceHolder = RemoveHtml($this->UnitsInStock->caption());

            // UnitsOnOrder
            $this->UnitsOnOrder->EditAttrs["class"] = "form-control";
            $this->UnitsOnOrder->EditCustomAttributes = "";
            if (!$this->UnitsOnOrder->Raw) {
                $this->UnitsOnOrder->CurrentValue = HtmlDecode($this->UnitsOnOrder->CurrentValue);
            }
            $this->UnitsOnOrder->EditValue = HtmlEncode($this->UnitsOnOrder->CurrentValue);
            $this->UnitsOnOrder->PlaceHolder = RemoveHtml($this->UnitsOnOrder->caption());

            // ReorderLevel
            $this->ReorderLevel->EditAttrs["class"] = "form-control";
            $this->ReorderLevel->EditCustomAttributes = "";
            if (!$this->ReorderLevel->Raw) {
                $this->ReorderLevel->CurrentValue = HtmlDecode($this->ReorderLevel->CurrentValue);
            }
            $this->ReorderLevel->EditValue = HtmlEncode($this->ReorderLevel->CurrentValue);
            $this->ReorderLevel->PlaceHolder = RemoveHtml($this->ReorderLevel->caption());

            // Discontinued
            $this->Discontinued->EditAttrs["class"] = "form-control";
            $this->Discontinued->EditCustomAttributes = "";
            if (!$this->Discontinued->Raw) {
                $this->Discontinued->CurrentValue = HtmlDecode($this->Discontinued->CurrentValue);
            }
            $this->Discontinued->EditValue = HtmlEncode($this->Discontinued->CurrentValue);
            $this->Discontinued->PlaceHolder = RemoveHtml($this->Discontinued->caption());

            // Edit refer script

            // ProductID
            $this->ProductID->LinkCustomAttributes = "";
            $this->ProductID->HrefValue = "";

            // ProductName
            $this->ProductName->LinkCustomAttributes = "";
            $this->ProductName->HrefValue = "";

            // SupplierID
            $this->SupplierID->LinkCustomAttributes = "";
            $this->SupplierID->HrefValue = "";

            // CategoryID
            $this->CategoryID->LinkCustomAttributes = "";
            $this->CategoryID->HrefValue = "";

            // QuantityPerUnit
            $this->QuantityPerUnit->LinkCustomAttributes = "";
            $this->QuantityPerUnit->HrefValue = "";

            // UnitPrice
            $this->UnitPrice->LinkCustomAttributes = "";
            $this->UnitPrice->HrefValue = "";

            // UnitsInStock
            $this->UnitsInStock->LinkCustomAttributes = "";
            $this->UnitsInStock->HrefValue = "";

            // UnitsOnOrder
            $this->UnitsOnOrder->LinkCustomAttributes = "";
            $this->UnitsOnOrder->HrefValue = "";

            // ReorderLevel
            $this->ReorderLevel->LinkCustomAttributes = "";
            $this->ReorderLevel->HrefValue = "";

            // Discontinued
            $this->Discontinued->LinkCustomAttributes = "";
            $this->Discontinued->HrefValue = "";
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
        if ($this->ProductID->Required) {
            if (!$this->ProductID->IsDetailKey && EmptyValue($this->ProductID->FormValue)) {
                $this->ProductID->addErrorMessage(str_replace("%s", $this->ProductID->caption(), $this->ProductID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ProductID->FormValue)) {
            $this->ProductID->addErrorMessage($this->ProductID->getErrorMessage(false));
        }
        if ($this->ProductName->Required) {
            if (!$this->ProductName->IsDetailKey && EmptyValue($this->ProductName->FormValue)) {
                $this->ProductName->addErrorMessage(str_replace("%s", $this->ProductName->caption(), $this->ProductName->RequiredErrorMessage));
            }
        }
        if ($this->SupplierID->Required) {
            if (!$this->SupplierID->IsDetailKey && EmptyValue($this->SupplierID->FormValue)) {
                $this->SupplierID->addErrorMessage(str_replace("%s", $this->SupplierID->caption(), $this->SupplierID->RequiredErrorMessage));
            }
        }
        if ($this->CategoryID->Required) {
            if (!$this->CategoryID->IsDetailKey && EmptyValue($this->CategoryID->FormValue)) {
                $this->CategoryID->addErrorMessage(str_replace("%s", $this->CategoryID->caption(), $this->CategoryID->RequiredErrorMessage));
            }
        }
        if ($this->QuantityPerUnit->Required) {
            if (!$this->QuantityPerUnit->IsDetailKey && EmptyValue($this->QuantityPerUnit->FormValue)) {
                $this->QuantityPerUnit->addErrorMessage(str_replace("%s", $this->QuantityPerUnit->caption(), $this->QuantityPerUnit->RequiredErrorMessage));
            }
        }
        if ($this->UnitPrice->Required) {
            if (!$this->UnitPrice->IsDetailKey && EmptyValue($this->UnitPrice->FormValue)) {
                $this->UnitPrice->addErrorMessage(str_replace("%s", $this->UnitPrice->caption(), $this->UnitPrice->RequiredErrorMessage));
            }
        }
        if ($this->UnitsInStock->Required) {
            if (!$this->UnitsInStock->IsDetailKey && EmptyValue($this->UnitsInStock->FormValue)) {
                $this->UnitsInStock->addErrorMessage(str_replace("%s", $this->UnitsInStock->caption(), $this->UnitsInStock->RequiredErrorMessage));
            }
        }
        if ($this->UnitsOnOrder->Required) {
            if (!$this->UnitsOnOrder->IsDetailKey && EmptyValue($this->UnitsOnOrder->FormValue)) {
                $this->UnitsOnOrder->addErrorMessage(str_replace("%s", $this->UnitsOnOrder->caption(), $this->UnitsOnOrder->RequiredErrorMessage));
            }
        }
        if ($this->ReorderLevel->Required) {
            if (!$this->ReorderLevel->IsDetailKey && EmptyValue($this->ReorderLevel->FormValue)) {
                $this->ReorderLevel->addErrorMessage(str_replace("%s", $this->ReorderLevel->caption(), $this->ReorderLevel->RequiredErrorMessage));
            }
        }
        if ($this->Discontinued->Required) {
            if (!$this->Discontinued->IsDetailKey && EmptyValue($this->Discontinued->FormValue)) {
                $this->Discontinued->addErrorMessage(str_replace("%s", $this->Discontinued->caption(), $this->Discontinued->RequiredErrorMessage));
            }
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // ProductID
            $this->ProductID->setDbValueDef($rsnew, $this->ProductID->CurrentValue, 0, $this->ProductID->ReadOnly);

            // ProductName
            $this->ProductName->setDbValueDef($rsnew, $this->ProductName->CurrentValue, null, $this->ProductName->ReadOnly);

            // SupplierID
            $this->SupplierID->setDbValueDef($rsnew, $this->SupplierID->CurrentValue, null, $this->SupplierID->ReadOnly);

            // CategoryID
            $this->CategoryID->setDbValueDef($rsnew, $this->CategoryID->CurrentValue, null, $this->CategoryID->ReadOnly);

            // QuantityPerUnit
            $this->QuantityPerUnit->setDbValueDef($rsnew, $this->QuantityPerUnit->CurrentValue, null, $this->QuantityPerUnit->ReadOnly);

            // UnitPrice
            $this->UnitPrice->setDbValueDef($rsnew, $this->UnitPrice->CurrentValue, null, $this->UnitPrice->ReadOnly);

            // UnitsInStock
            $this->UnitsInStock->setDbValueDef($rsnew, $this->UnitsInStock->CurrentValue, null, $this->UnitsInStock->ReadOnly);

            // UnitsOnOrder
            $this->UnitsOnOrder->setDbValueDef($rsnew, $this->UnitsOnOrder->CurrentValue, null, $this->UnitsOnOrder->ReadOnly);

            // ReorderLevel
            $this->ReorderLevel->setDbValueDef($rsnew, $this->ReorderLevel->CurrentValue, null, $this->ReorderLevel->ReadOnly);

            // Discontinued
            $this->Discontinued->setDbValueDef($rsnew, $this->Discontinued->CurrentValue, null, $this->Discontinued->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);

            // Check for duplicate key when key changed
            if ($updateRow) {
                $newKeyFilter = $this->getRecordFilter($rsnew);
                if ($newKeyFilter != $oldKeyFilter) {
                    $rsChk = $this->loadRs($newKeyFilter)->fetch();
                    if ($rsChk !== false) {
                        $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                        $this->setFailureMessage($keyErrMsg);
                        $updateRow = false;
                    }
                }
            }
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ProductsList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
