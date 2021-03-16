<?php

namespace PHPMaker2021\northwindapi;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for order_details
 */
class OrderDetails extends DbTable
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
    public $order_detail_id;
    public $OrderID;
    public $ProductID;
    public $UnitPrice;
    public $Quantity;
    public $Discount;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'order_details';
        $this->TableName = 'order_details';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`order_details`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // order_detail_id
        $this->order_detail_id = new DbField('order_details', 'order_details', 'x_order_detail_id', 'order_detail_id', '`order_detail_id`', '`order_detail_id`', 3, 11, -1, false, '`order_detail_id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->order_detail_id->IsAutoIncrement = true; // Autoincrement field
        $this->order_detail_id->IsPrimaryKey = true; // Primary key field
        $this->order_detail_id->Sortable = true; // Allow sort
        $this->order_detail_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->order_detail_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->order_detail_id->Param, "CustomMsg");
        $this->Fields['order_detail_id'] = &$this->order_detail_id;

        // OrderID
        $this->OrderID = new DbField('order_details', 'order_details', 'x_OrderID', 'OrderID', '`OrderID`', '`OrderID`', 20, 20, -1, false, '`OrderID`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->OrderID->IsForeignKey = true; // Foreign key field
        $this->OrderID->Nullable = false; // NOT NULL field
        $this->OrderID->Required = true; // Required field
        $this->OrderID->Sortable = true; // Allow sort
        $this->OrderID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->OrderID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->OrderID->Param, "CustomMsg");
        $this->Fields['OrderID'] = &$this->OrderID;

        // ProductID
        $this->ProductID = new DbField('order_details', 'order_details', 'x_ProductID', 'ProductID', '`ProductID`', '`ProductID`', 3, 11, -1, false, '`ProductID`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->ProductID->IsForeignKey = true; // Foreign key field
        $this->ProductID->Nullable = false; // NOT NULL field
        $this->ProductID->Required = true; // Required field
        $this->ProductID->Sortable = true; // Allow sort
        $this->ProductID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ProductID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->ProductID->Lookup = new Lookup('ProductID', 'products', false, 'ProductID', ["ProductName","UnitPrice","",""], [], [], [], [], ["UnitPrice"], ["x_UnitPrice"], '', '');
        $this->ProductID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ProductID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ProductID->Param, "CustomMsg");
        $this->Fields['ProductID'] = &$this->ProductID;

        // UnitPrice
        $this->UnitPrice = new DbField('order_details', 'order_details', 'x_UnitPrice', 'UnitPrice', '`UnitPrice`', '`UnitPrice`', 131, 10, -1, false, '`UnitPrice`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->UnitPrice->Nullable = false; // NOT NULL field
        $this->UnitPrice->Required = true; // Required field
        $this->UnitPrice->Sortable = true; // Allow sort
        $this->UnitPrice->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->UnitPrice->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->UnitPrice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->UnitPrice->Param, "CustomMsg");
        $this->Fields['UnitPrice'] = &$this->UnitPrice;

        // Quantity
        $this->Quantity = new DbField('order_details', 'order_details', 'x_Quantity', 'Quantity', '`Quantity`', '`Quantity`', 3, 11, -1, false, '`Quantity`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Quantity->Nullable = false; // NOT NULL field
        $this->Quantity->Required = true; // Required field
        $this->Quantity->Sortable = true; // Allow sort
        $this->Quantity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Quantity->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Quantity->Param, "CustomMsg");
        $this->Fields['Quantity'] = &$this->Quantity;

        // Discount
        $this->Discount = new DbField('order_details', 'order_details', 'x_Discount', 'Discount', '`Discount`', '`Discount`', 131, 20, -1, false, '`Discount`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Discount->Sortable = true; // Allow sort
        $this->Discount->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->Discount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Discount->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Discount->Param, "CustomMsg");
        $this->Fields['Discount'] = &$this->Discount;
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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "orders") {
            if ($this->OrderID->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`OrderID`", $this->OrderID->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "products") {
            if ($this->ProductID->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`ProductID`", $this->ProductID->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "orders") {
            if ($this->OrderID->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`OrderID`", $this->OrderID->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "products") {
            if ($this->ProductID->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`ProductID`", $this->ProductID->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_orders()
    {
        return "`OrderID`=@OrderID@";
    }
    // Detail filter
    public function sqlDetailFilter_orders()
    {
        return "`OrderID`=@OrderID@";
    }

    // Master filter
    public function sqlMasterFilter_products()
    {
        return "`ProductID`=@ProductID@";
    }
    // Detail filter
    public function sqlDetailFilter_products()
    {
        return "`ProductID`=@ProductID@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`order_details`";
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
            // Get insert id if necessary
            $this->order_detail_id->setDbValue($conn->lastInsertId());
            $rs['order_detail_id'] = $this->order_detail_id->DbValue;
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
            if (array_key_exists('order_detail_id', $rs)) {
                AddFilter($where, QuotedName('order_detail_id', $this->Dbid) . '=' . QuotedValue($rs['order_detail_id'], $this->order_detail_id->DataType, $this->Dbid));
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
        $this->order_detail_id->DbValue = $row['order_detail_id'];
        $this->OrderID->DbValue = $row['OrderID'];
        $this->ProductID->DbValue = $row['ProductID'];
        $this->UnitPrice->DbValue = $row['UnitPrice'];
        $this->Quantity->DbValue = $row['Quantity'];
        $this->Discount->DbValue = $row['Discount'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`order_detail_id` = @order_detail_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->order_detail_id->CurrentValue : $this->order_detail_id->OldValue;
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
                $this->order_detail_id->CurrentValue = $keys[0];
            } else {
                $this->order_detail_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('order_detail_id', $row) ? $row['order_detail_id'] : null;
        } else {
            $val = $this->order_detail_id->OldValue !== null ? $this->order_detail_id->OldValue : $this->order_detail_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@order_detail_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("OrderDetailsList");
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
        if ($pageName == "OrderDetailsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "OrderDetailsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "OrderDetailsAdd") {
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
                return "OrderDetailsView";
            case Config("API_ADD_ACTION"):
                return "OrderDetailsAdd";
            case Config("API_EDIT_ACTION"):
                return "OrderDetailsEdit";
            case Config("API_DELETE_ACTION"):
                return "OrderDetailsDelete";
            case Config("API_LIST_ACTION"):
                return "OrderDetailsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "OrderDetailsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("OrderDetailsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("OrderDetailsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "OrderDetailsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "OrderDetailsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("OrderDetailsEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("OrderDetailsAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("OrderDetailsDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "orders" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_OrderID", $this->OrderID->CurrentValue ?? $this->OrderID->getSessionValue());
        }
        if ($this->getCurrentMasterTable() == "products" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_ProductID", $this->ProductID->CurrentValue ?? $this->ProductID->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "order_detail_id:" . JsonEncode($this->order_detail_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->order_detail_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->order_detail_id->CurrentValue);
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
            if (($keyValue = Param("order_detail_id") ?? Route("order_detail_id")) !== null) {
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
                $this->order_detail_id->CurrentValue = $key;
            } else {
                $this->order_detail_id->OldValue = $key;
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
        $this->order_detail_id->setDbValue($row['order_detail_id']);
        $this->OrderID->setDbValue($row['OrderID']);
        $this->ProductID->setDbValue($row['ProductID']);
        $this->UnitPrice->setDbValue($row['UnitPrice']);
        $this->Quantity->setDbValue($row['Quantity']);
        $this->Discount->setDbValue($row['Discount']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // order_detail_id

        // OrderID

        // ProductID

        // UnitPrice

        // Quantity

        // Discount

        // order_detail_id
        $this->order_detail_id->ViewValue = $this->order_detail_id->CurrentValue;
        $this->order_detail_id->ViewCustomAttributes = "";

        // OrderID
        $this->OrderID->ViewValue = $this->OrderID->CurrentValue;
        $this->OrderID->ViewValue = FormatNumber($this->OrderID->ViewValue, 0, -2, -2, -2);
        $this->OrderID->ViewCustomAttributes = "";

        // ProductID
        $curVal = strval($this->ProductID->CurrentValue);
        if ($curVal != "") {
            $this->ProductID->ViewValue = $this->ProductID->lookupCacheOption($curVal);
            if ($this->ProductID->ViewValue === null) { // Lookup from database
                $filterWrk = "`ProductID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->ProductID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->ProductID->Lookup->renderViewRow($rswrk[0]);
                    $this->ProductID->ViewValue = $this->ProductID->displayValue($arwrk);
                } else {
                    $this->ProductID->ViewValue = $this->ProductID->CurrentValue;
                }
            }
        } else {
            $this->ProductID->ViewValue = null;
        }
        $this->ProductID->ViewCustomAttributes = "";

        // UnitPrice
        $this->UnitPrice->ViewValue = $this->UnitPrice->CurrentValue;
        $this->UnitPrice->ViewValue = FormatNumber($this->UnitPrice->ViewValue, 2, -2, -2, -2);
        $this->UnitPrice->ViewCustomAttributes = "";

        // Quantity
        $this->Quantity->ViewValue = $this->Quantity->CurrentValue;
        $this->Quantity->ViewValue = FormatNumber($this->Quantity->ViewValue, 0, -2, -2, -2);
        $this->Quantity->ViewCustomAttributes = "";

        // Discount
        $this->Discount->ViewValue = $this->Discount->CurrentValue;
        $this->Discount->ViewValue = FormatNumber($this->Discount->ViewValue, 2, -2, -2, -2);
        $this->Discount->ViewCustomAttributes = "";

        // order_detail_id
        $this->order_detail_id->LinkCustomAttributes = "";
        $this->order_detail_id->HrefValue = "";
        $this->order_detail_id->TooltipValue = "";

        // OrderID
        $this->OrderID->LinkCustomAttributes = "";
        $this->OrderID->HrefValue = "";
        $this->OrderID->TooltipValue = "";

        // ProductID
        $this->ProductID->LinkCustomAttributes = "";
        $this->ProductID->HrefValue = "";
        $this->ProductID->TooltipValue = "";

        // UnitPrice
        $this->UnitPrice->LinkCustomAttributes = "";
        $this->UnitPrice->HrefValue = "";
        $this->UnitPrice->TooltipValue = "";

        // Quantity
        $this->Quantity->LinkCustomAttributes = "";
        $this->Quantity->HrefValue = "";
        $this->Quantity->TooltipValue = "";

        // Discount
        $this->Discount->LinkCustomAttributes = "";
        $this->Discount->HrefValue = "";
        $this->Discount->TooltipValue = "";

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

        // order_detail_id
        $this->order_detail_id->EditAttrs["class"] = "form-control";
        $this->order_detail_id->EditCustomAttributes = "";
        $this->order_detail_id->EditValue = $this->order_detail_id->CurrentValue;
        $this->order_detail_id->ViewCustomAttributes = "";

        // OrderID
        $this->OrderID->EditAttrs["class"] = "form-control";
        $this->OrderID->EditCustomAttributes = "";
        if ($this->OrderID->getSessionValue() != "") {
            $this->OrderID->CurrentValue = GetForeignKeyValue($this->OrderID->getSessionValue());
            $this->OrderID->ViewValue = $this->OrderID->CurrentValue;
            $this->OrderID->ViewValue = FormatNumber($this->OrderID->ViewValue, 0, -2, -2, -2);
            $this->OrderID->ViewCustomAttributes = "";
        } else {
            $this->OrderID->EditValue = $this->OrderID->CurrentValue;
            $this->OrderID->PlaceHolder = RemoveHtml($this->OrderID->caption());
        }

        // ProductID
        $this->ProductID->EditAttrs["class"] = "form-control";
        $this->ProductID->EditCustomAttributes = "";
        if ($this->ProductID->getSessionValue() != "") {
            $this->ProductID->CurrentValue = GetForeignKeyValue($this->ProductID->getSessionValue());
            $curVal = strval($this->ProductID->CurrentValue);
            if ($curVal != "") {
                $this->ProductID->ViewValue = $this->ProductID->lookupCacheOption($curVal);
                if ($this->ProductID->ViewValue === null) { // Lookup from database
                    $filterWrk = "`ProductID`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ProductID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ProductID->Lookup->renderViewRow($rswrk[0]);
                        $this->ProductID->ViewValue = $this->ProductID->displayValue($arwrk);
                    } else {
                        $this->ProductID->ViewValue = $this->ProductID->CurrentValue;
                    }
                }
            } else {
                $this->ProductID->ViewValue = null;
            }
            $this->ProductID->ViewCustomAttributes = "";
        } else {
            $this->ProductID->PlaceHolder = RemoveHtml($this->ProductID->caption());
        }

        // UnitPrice
        $this->UnitPrice->EditAttrs["class"] = "form-control";
        $this->UnitPrice->EditCustomAttributes = "";
        $this->UnitPrice->EditValue = $this->UnitPrice->CurrentValue;
        $this->UnitPrice->PlaceHolder = RemoveHtml($this->UnitPrice->caption());
        if (strval($this->UnitPrice->EditValue) != "" && is_numeric($this->UnitPrice->EditValue)) {
            $this->UnitPrice->EditValue = FormatNumber($this->UnitPrice->EditValue, -2, -2, -2, -2);
        }

        // Quantity
        $this->Quantity->EditAttrs["class"] = "form-control";
        $this->Quantity->EditCustomAttributes = "";
        $this->Quantity->EditValue = $this->Quantity->CurrentValue;
        $this->Quantity->PlaceHolder = RemoveHtml($this->Quantity->caption());

        // Discount
        $this->Discount->EditAttrs["class"] = "form-control";
        $this->Discount->EditCustomAttributes = "";
        $this->Discount->EditValue = $this->Discount->CurrentValue;
        $this->Discount->PlaceHolder = RemoveHtml($this->Discount->caption());
        if (strval($this->Discount->EditValue) != "" && is_numeric($this->Discount->EditValue)) {
            $this->Discount->EditValue = FormatNumber($this->Discount->EditValue, -2, -2, -2, -2);
        }

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
                    $doc->exportCaption($this->order_detail_id);
                    $doc->exportCaption($this->OrderID);
                    $doc->exportCaption($this->ProductID);
                    $doc->exportCaption($this->UnitPrice);
                    $doc->exportCaption($this->Quantity);
                    $doc->exportCaption($this->Discount);
                } else {
                    $doc->exportCaption($this->order_detail_id);
                    $doc->exportCaption($this->OrderID);
                    $doc->exportCaption($this->ProductID);
                    $doc->exportCaption($this->UnitPrice);
                    $doc->exportCaption($this->Quantity);
                    $doc->exportCaption($this->Discount);
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
                        $doc->exportField($this->order_detail_id);
                        $doc->exportField($this->OrderID);
                        $doc->exportField($this->ProductID);
                        $doc->exportField($this->UnitPrice);
                        $doc->exportField($this->Quantity);
                        $doc->exportField($this->Discount);
                    } else {
                        $doc->exportField($this->order_detail_id);
                        $doc->exportField($this->OrderID);
                        $doc->exportField($this->ProductID);
                        $doc->exportField($this->UnitPrice);
                        $doc->exportField($this->Quantity);
                        $doc->exportField($this->Discount);
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
