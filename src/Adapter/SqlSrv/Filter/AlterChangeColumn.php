<?php

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of AlterAddColumn
 *
 * @author David
 */
class AlterChangeColumn extends AbstractAlter {

    public function getQualifyingPattern() {
        return '/ALTER\W+TABlE\W+(\w+)[\W\w]+CHANGE/i';
    }

    public function getDataPattern() {
        return '/CHANGE\s+(\w+)\s+(\w+)\s+([\w\(\)]+)(?:\s+DEFAULT\s*([\'\"]?[\w\(\)\.]+[\'\"]?))?((?:\s+NOT)?\s+NULL)?\s*(IDENTITY)?(?:\s+AFTER\s+\w+)?(?:,|$)/im';
    }

    public function getSQL($matches, $table) {
        $filled = array_merge($matches, array_fill_keys(range(0, 5), null));
        return sprintf("ALTER TABLE %s ALTER COLUMN %s %s %s", $table, $filled[1], trim($filled[3], ','), trim($filled[5]));
    }

    protected function extraCall($matches, $table) {
        $this
                ->manageDefaults($matches, $table)
                ->manageRename($matches, $table);
    }

    public function manageDefaults($matches, $table) {
        $defaultValue = str_replace("'", "''", $matches[4]);
        $column = $matches[1];
        if ($defaultValue === "") {
            return $this;
        }
        $sql = "DECLARE @Command nvarchar(max), @ConstaintName nvarchar(max), @TableName nvarchar(max),@ColumnName nvarchar(max)
SET @TableName = '$table'
SET @ColumnName ='$column'
SELECT @ConstaintName = name
    FROM sys.default_constraints
    WHERE parent_object_id = object_id(@TableName)
        AND parent_column_id = columnproperty(object_id(@TableName), @ColumnName, 'ColumnId')
SELECT @Command = 'ALTER TABLE '+@TableName+' drop constraint '+ @ConstaintName
IF @Command IS NOT NULL
BEGIN
    EXECUTE sp_executeSQL @Command
    SELECT @Command = 'ALTER TABLE '+@TableName+' ADD CONSTRAINT '+@ConstaintName+' DEFAULT $defaultValue FOR ' + @ColumnName
    EXECUTE sp_executeSQL @Command
END";
        $this->getSqlChange()->addStatement($sql);
        return $this;
    }

    public function manageRename($matches, $table) {
        if ($matches[1] === $matches[2]) { //Same column name no change
            return $this;
        }
        $sql = sprintf("sp_rename '%s.%s', '%s', 'COLUMN'", $table, $matches[1], $matches[2]);
        $this->getSqlChange()->addStatement($sql);
        return $this;
    }

}
