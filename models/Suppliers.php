<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for suppliers
 */
class Suppliers extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $SupplierID;
    public $CompanyName;
    public $ContactName;
    public $ContactTitle;
    public $Address;
    public $City;
    public $Region;
    public $PostalCode;
    public $Country;
    public $Phone;
    public $Fax;
    public $HomePage;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'suppliers';
        $this->TableName = 'suppliers';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`suppliers`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // SupplierID
        $this->SupplierID = new DbField('suppliers', 'suppliers', 'x_SupplierID', 'SupplierID', '`SupplierID`', '`SupplierID`', 3, 11, -1, false, '`SupplierID`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SupplierID->IsPrimaryKey = true; // Primary key field
        $this->SupplierID->Nullable = false; // NOT NULL field
        $this->SupplierID->Required = true; // Required field
        $this->SupplierID->Sortable = true; // Allow sort
        $this->SupplierID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->SupplierID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SupplierID->Param, "CustomMsg");
        $this->Fields['SupplierID'] = &$this->SupplierID;

        // CompanyName
        $this->CompanyName = new DbField('suppliers', 'suppliers', 'x_CompanyName', 'CompanyName', '`CompanyName`', '`CompanyName`', 200, 255, -1, false, '`CompanyName`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CompanyName->Sortable = true; // Allow sort
        $this->CompanyName->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CompanyName->Param, "CustomMsg");
        $this->Fields['CompanyName'] = &$this->CompanyName;

        // ContactName
        $this->ContactName = new DbField('suppliers', 'suppliers', 'x_ContactName', 'ContactName', '`ContactName`', '`ContactName`', 200, 255, -1, false, '`ContactName`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ContactName->Sortable = true; // Allow sort
        $this->ContactName->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ContactName->Param, "CustomMsg");
        $this->Fields['ContactName'] = &$this->ContactName;

        // ContactTitle
        $this->ContactTitle = new DbField('suppliers', 'suppliers', 'x_ContactTitle', 'ContactTitle', '`ContactTitle`', '`ContactTitle`', 200, 255, -1, false, '`ContactTitle`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ContactTitle->Sortable = true; // Allow sort
        $this->ContactTitle->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ContactTitle->Param, "CustomMsg");
        $this->Fields['ContactTitle'] = &$this->ContactTitle;

        // Address
        $this->Address = new DbField('suppliers', 'suppliers', 'x_Address', 'Address', '`Address`', '`Address`', 200, 255, -1, false, '`Address`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Address->Sortable = true; // Allow sort
        $this->Address->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Address->Param, "CustomMsg");
        $this->Fields['Address'] = &$this->Address;

        // City
        $this->City = new DbField('suppliers', 'suppliers', 'x_City', 'City', '`City`', '`City`', 200, 255, -1, false, '`City`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->City->Sortable = true; // Allow sort
        $this->City->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->City->Param, "CustomMsg");
        $this->Fields['City'] = &$this->City;

        // Region
        $this->Region = new DbField('suppliers', 'suppliers', 'x_Region', 'Region', '`Region`', '`Region`', 200, 255, -1, false, '`Region`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Region->Sortable = true; // Allow sort
        $this->Region->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Region->Param, "CustomMsg");
        $this->Fields['Region'] = &$this->Region;

        // PostalCode
        $this->PostalCode = new DbField('suppliers', 'suppliers', 'x_PostalCode', 'PostalCode', '`PostalCode`', '`PostalCode`', 200, 255, -1, false, '`PostalCode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PostalCode->Sortable = true; // Allow sort
        $this->PostalCode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PostalCode->Param, "CustomMsg");
        $this->Fields['PostalCode'] = &$this->PostalCode;

        // Country
        $this->Country = new DbField('suppliers', 'suppliers', 'x_Country', 'Country', '`Country`', '`Country`', 200, 255, -1, false, '`Country`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Country->Sortable = true; // Allow sort
        $this->Country->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Country->Param, "CustomMsg");
        $this->Fields['Country'] = &$this->Country;

        // Phone
        $this->Phone = new DbField('suppliers', 'suppliers', 'x_Phone', 'Phone', '`Phone`', '`Phone`', 200, 255, -1, false, '`Phone`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Phone->Sortable = true; // Allow sort
        $this->Phone->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Phone->Param, "CustomMsg");
        $this->Fields['Phone'] = &$this->Phone;

        // Fax
        $this->Fax = new DbField('suppliers', 'suppliers', 'x_Fax', 'Fax', '`Fax`', '`Fax`', 200, 255, -1, false, '`Fax`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Fax->Sortable = true; // Allow sort
        $this->Fax->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Fax->Param, "CustomMsg");
        $this->Fields['Fax'] = &$this->Fax;

        // HomePage
        $this->HomePage = new DbField('suppliers', 'suppliers', 'x_HomePage', 'HomePage', '`HomePage`', '`HomePage`', 200, 255, -1, false, '`HomePage`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->HomePage->Sortable = true; // Allow sort
        $this->HomePage->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->HomePage->Param, "CustomMsg");
        $this->Fields['HomePage'] = &$this->HomePage;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`suppliers`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('SupplierID', $rs)) {
                AddFilter($where, QuotedName('SupplierID', $this->Dbid) . '=' . QuotedValue($rs['SupplierID'], $this->SupplierID->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->SupplierID->DbValue = $row['SupplierID'];
        $this->CompanyName->DbValue = $row['CompanyName'];
        $this->ContactName->DbValue = $row['ContactName'];
        $this->ContactTitle->DbValue = $row['ContactTitle'];
        $this->Address->DbValue = $row['Address'];
        $this->City->DbValue = $row['City'];
        $this->Region->DbValue = $row['Region'];
        $this->PostalCode->DbValue = $row['PostalCode'];
        $this->Country->DbValue = $row['Country'];
        $this->Phone->DbValue = $row['Phone'];
        $this->Fax->DbValue = $row['Fax'];
        $this->HomePage->DbValue = $row['HomePage'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`SupplierID` = @SupplierID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->SupplierID->CurrentValue : $this->SupplierID->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->SupplierID->CurrentValue = $keys[0];
            } else {
                $this->SupplierID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('SupplierID', $row) ? $row['SupplierID'] : null;
        } else {
            $val = $this->SupplierID->OldValue !== null ? $this->SupplierID->OldValue : $this->SupplierID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@SupplierID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("SuppliersList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "SuppliersView") {
            return $Language->phrase("View");
        } elseif ($pageName == "SuppliersEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "SuppliersAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "SuppliersView";
            case Config("API_ADD_ACTION"):
                return "SuppliersAdd";
            case Config("API_EDIT_ACTION"):
                return "SuppliersEdit";
            case Config("API_DELETE_ACTION"):
                return "SuppliersDelete";
            case Config("API_LIST_ACTION"):
                return "SuppliersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "SuppliersList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SuppliersView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SuppliersView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "SuppliersAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "SuppliersAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("SuppliersEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("SuppliersAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("SuppliersDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "SupplierID:" . JsonEncode($this->SupplierID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->SupplierID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->SupplierID->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("SupplierID") ?? Route("SupplierID")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->SupplierID->CurrentValue = $key;
            } else {
                $this->SupplierID->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->SupplierID->setDbValue($row['SupplierID']);
        $this->CompanyName->setDbValue($row['CompanyName']);
        $this->ContactName->setDbValue($row['ContactName']);
        $this->ContactTitle->setDbValue($row['ContactTitle']);
        $this->Address->setDbValue($row['Address']);
        $this->City->setDbValue($row['City']);
        $this->Region->setDbValue($row['Region']);
        $this->PostalCode->setDbValue($row['PostalCode']);
        $this->Country->setDbValue($row['Country']);
        $this->Phone->setDbValue($row['Phone']);
        $this->Fax->setDbValue($row['Fax']);
        $this->HomePage->setDbValue($row['HomePage']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // SupplierID

        // CompanyName

        // ContactName

        // ContactTitle

        // Address

        // City

        // Region

        // PostalCode

        // Country

        // Phone

        // Fax

        // HomePage

        // SupplierID
        $this->SupplierID->ViewValue = $this->SupplierID->CurrentValue;
        $this->SupplierID->ViewValue = FormatNumber($this->SupplierID->ViewValue, 0, -2, -2, -2);
        $this->SupplierID->ViewCustomAttributes = "";

        // CompanyName
        $this->CompanyName->ViewValue = $this->CompanyName->CurrentValue;
        $this->CompanyName->ViewCustomAttributes = "";

        // ContactName
        $this->ContactName->ViewValue = $this->ContactName->CurrentValue;
        $this->ContactName->ViewCustomAttributes = "";

        // ContactTitle
        $this->ContactTitle->ViewValue = $this->ContactTitle->CurrentValue;
        $this->ContactTitle->ViewCustomAttributes = "";

        // Address
        $this->Address->ViewValue = $this->Address->CurrentValue;
        $this->Address->ViewCustomAttributes = "";

        // City
        $this->City->ViewValue = $this->City->CurrentValue;
        $this->City->ViewCustomAttributes = "";

        // Region
        $this->Region->ViewValue = $this->Region->CurrentValue;
        $this->Region->ViewCustomAttributes = "";

        // PostalCode
        $this->PostalCode->ViewValue = $this->PostalCode->CurrentValue;
        $this->PostalCode->ViewCustomAttributes = "";

        // Country
        $this->Country->ViewValue = $this->Country->CurrentValue;
        $this->Country->ViewCustomAttributes = "";

        // Phone
        $this->Phone->ViewValue = $this->Phone->CurrentValue;
        $this->Phone->ViewCustomAttributes = "";

        // Fax
        $this->Fax->ViewValue = $this->Fax->CurrentValue;
        $this->Fax->ViewCustomAttributes = "";

        // HomePage
        $this->HomePage->ViewValue = $this->HomePage->CurrentValue;
        $this->HomePage->ViewCustomAttributes = "";

        // SupplierID
        $this->SupplierID->LinkCustomAttributes = "";
        $this->SupplierID->HrefValue = "";
        $this->SupplierID->TooltipValue = "";

        // CompanyName
        $this->CompanyName->LinkCustomAttributes = "";
        $this->CompanyName->HrefValue = "";
        $this->CompanyName->TooltipValue = "";

        // ContactName
        $this->ContactName->LinkCustomAttributes = "";
        $this->ContactName->HrefValue = "";
        $this->ContactName->TooltipValue = "";

        // ContactTitle
        $this->ContactTitle->LinkCustomAttributes = "";
        $this->ContactTitle->HrefValue = "";
        $this->ContactTitle->TooltipValue = "";

        // Address
        $this->Address->LinkCustomAttributes = "";
        $this->Address->HrefValue = "";
        $this->Address->TooltipValue = "";

        // City
        $this->City->LinkCustomAttributes = "";
        $this->City->HrefValue = "";
        $this->City->TooltipValue = "";

        // Region
        $this->Region->LinkCustomAttributes = "";
        $this->Region->HrefValue = "";
        $this->Region->TooltipValue = "";

        // PostalCode
        $this->PostalCode->LinkCustomAttributes = "";
        $this->PostalCode->HrefValue = "";
        $this->PostalCode->TooltipValue = "";

        // Country
        $this->Country->LinkCustomAttributes = "";
        $this->Country->HrefValue = "";
        $this->Country->TooltipValue = "";

        // Phone
        $this->Phone->LinkCustomAttributes = "";
        $this->Phone->HrefValue = "";
        $this->Phone->TooltipValue = "";

        // Fax
        $this->Fax->LinkCustomAttributes = "";
        $this->Fax->HrefValue = "";
        $this->Fax->TooltipValue = "";

        // HomePage
        $this->HomePage->LinkCustomAttributes = "";
        $this->HomePage->HrefValue = "";
        $this->HomePage->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // SupplierID
        $this->SupplierID->EditAttrs["class"] = "form-control";
        $this->SupplierID->EditCustomAttributes = "";
        $this->SupplierID->EditValue = $this->SupplierID->CurrentValue;
        $this->SupplierID->PlaceHolder = RemoveHtml($this->SupplierID->caption());

        // CompanyName
        $this->CompanyName->EditAttrs["class"] = "form-control";
        $this->CompanyName->EditCustomAttributes = "";
        if (!$this->CompanyName->Raw) {
            $this->CompanyName->CurrentValue = HtmlDecode($this->CompanyName->CurrentValue);
        }
        $this->CompanyName->EditValue = $this->CompanyName->CurrentValue;
        $this->CompanyName->PlaceHolder = RemoveHtml($this->CompanyName->caption());

        // ContactName
        $this->ContactName->EditAttrs["class"] = "form-control";
        $this->ContactName->EditCustomAttributes = "";
        if (!$this->ContactName->Raw) {
            $this->ContactName->CurrentValue = HtmlDecode($this->ContactName->CurrentValue);
        }
        $this->ContactName->EditValue = $this->ContactName->CurrentValue;
        $this->ContactName->PlaceHolder = RemoveHtml($this->ContactName->caption());

        // ContactTitle
        $this->ContactTitle->EditAttrs["class"] = "form-control";
        $this->ContactTitle->EditCustomAttributes = "";
        if (!$this->ContactTitle->Raw) {
            $this->ContactTitle->CurrentValue = HtmlDecode($this->ContactTitle->CurrentValue);
        }
        $this->ContactTitle->EditValue = $this->ContactTitle->CurrentValue;
        $this->ContactTitle->PlaceHolder = RemoveHtml($this->ContactTitle->caption());

        // Address
        $this->Address->EditAttrs["class"] = "form-control";
        $this->Address->EditCustomAttributes = "";
        if (!$this->Address->Raw) {
            $this->Address->CurrentValue = HtmlDecode($this->Address->CurrentValue);
        }
        $this->Address->EditValue = $this->Address->CurrentValue;
        $this->Address->PlaceHolder = RemoveHtml($this->Address->caption());

        // City
        $this->City->EditAttrs["class"] = "form-control";
        $this->City->EditCustomAttributes = "";
        if (!$this->City->Raw) {
            $this->City->CurrentValue = HtmlDecode($this->City->CurrentValue);
        }
        $this->City->EditValue = $this->City->CurrentValue;
        $this->City->PlaceHolder = RemoveHtml($this->City->caption());

        // Region
        $this->Region->EditAttrs["class"] = "form-control";
        $this->Region->EditCustomAttributes = "";
        if (!$this->Region->Raw) {
            $this->Region->CurrentValue = HtmlDecode($this->Region->CurrentValue);
        }
        $this->Region->EditValue = $this->Region->CurrentValue;
        $this->Region->PlaceHolder = RemoveHtml($this->Region->caption());

        // PostalCode
        $this->PostalCode->EditAttrs["class"] = "form-control";
        $this->PostalCode->EditCustomAttributes = "";
        if (!$this->PostalCode->Raw) {
            $this->PostalCode->CurrentValue = HtmlDecode($this->PostalCode->CurrentValue);
        }
        $this->PostalCode->EditValue = $this->PostalCode->CurrentValue;
        $this->PostalCode->PlaceHolder = RemoveHtml($this->PostalCode->caption());

        // Country
        $this->Country->EditAttrs["class"] = "form-control";
        $this->Country->EditCustomAttributes = "";
        if (!$this->Country->Raw) {
            $this->Country->CurrentValue = HtmlDecode($this->Country->CurrentValue);
        }
        $this->Country->EditValue = $this->Country->CurrentValue;
        $this->Country->PlaceHolder = RemoveHtml($this->Country->caption());

        // Phone
        $this->Phone->EditAttrs["class"] = "form-control";
        $this->Phone->EditCustomAttributes = "";
        if (!$this->Phone->Raw) {
            $this->Phone->CurrentValue = HtmlDecode($this->Phone->CurrentValue);
        }
        $this->Phone->EditValue = $this->Phone->CurrentValue;
        $this->Phone->PlaceHolder = RemoveHtml($this->Phone->caption());

        // Fax
        $this->Fax->EditAttrs["class"] = "form-control";
        $this->Fax->EditCustomAttributes = "";
        if (!$this->Fax->Raw) {
            $this->Fax->CurrentValue = HtmlDecode($this->Fax->CurrentValue);
        }
        $this->Fax->EditValue = $this->Fax->CurrentValue;
        $this->Fax->PlaceHolder = RemoveHtml($this->Fax->caption());

        // HomePage
        $this->HomePage->EditAttrs["class"] = "form-control";
        $this->HomePage->EditCustomAttributes = "";
        if (!$this->HomePage->Raw) {
            $this->HomePage->CurrentValue = HtmlDecode($this->HomePage->CurrentValue);
        }
        $this->HomePage->EditValue = $this->HomePage->CurrentValue;
        $this->HomePage->PlaceHolder = RemoveHtml($this->HomePage->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->SupplierID);
                    $doc->exportCaption($this->CompanyName);
                    $doc->exportCaption($this->ContactName);
                    $doc->exportCaption($this->ContactTitle);
                    $doc->exportCaption($this->Address);
                    $doc->exportCaption($this->City);
                    $doc->exportCaption($this->Region);
                    $doc->exportCaption($this->PostalCode);
                    $doc->exportCaption($this->Country);
                    $doc->exportCaption($this->Phone);
                    $doc->exportCaption($this->Fax);
                    $doc->exportCaption($this->HomePage);
                } else {
                    $doc->exportCaption($this->SupplierID);
                    $doc->exportCaption($this->CompanyName);
                    $doc->exportCaption($this->ContactName);
                    $doc->exportCaption($this->ContactTitle);
                    $doc->exportCaption($this->Address);
                    $doc->exportCaption($this->City);
                    $doc->exportCaption($this->Region);
                    $doc->exportCaption($this->PostalCode);
                    $doc->exportCaption($this->Country);
                    $doc->exportCaption($this->Phone);
                    $doc->exportCaption($this->Fax);
                    $doc->exportCaption($this->HomePage);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->SupplierID);
                        $doc->exportField($this->CompanyName);
                        $doc->exportField($this->ContactName);
                        $doc->exportField($this->ContactTitle);
                        $doc->exportField($this->Address);
                        $doc->exportField($this->City);
                        $doc->exportField($this->Region);
                        $doc->exportField($this->PostalCode);
                        $doc->exportField($this->Country);
                        $doc->exportField($this->Phone);
                        $doc->exportField($this->Fax);
                        $doc->exportField($this->HomePage);
                    } else {
                        $doc->exportField($this->SupplierID);
                        $doc->exportField($this->CompanyName);
                        $doc->exportField($this->ContactName);
                        $doc->exportField($this->ContactTitle);
                        $doc->exportField($this->Address);
                        $doc->exportField($this->City);
                        $doc->exportField($this->Region);
                        $doc->exportField($this->PostalCode);
                        $doc->exportField($this->Country);
                        $doc->exportField($this->Phone);
                        $doc->exportField($this->Fax);
                        $doc->exportField($this->HomePage);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
