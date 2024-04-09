<?php
class Database
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function executeQuery($sql)
    {
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data_row = array();
                foreach ($row as $r) {
                    array_push($data_row, $r);
                }
                array_push($data, $data_row);
            }
        }
        return $data;
    }

    public function updateRecord($data, $table, $id)
    {
        $update = "";
        foreach ($data as $key => $value) {
            $update .= $key . "='" . $value . "',";
        }
        $update = substr($update, 0, -1);
        $primary_key = array_keys($id)[0];
        $key_value = $id[$primary_key];
        $sql = "UPDATE $table SET {$update} WHERE $primary_key = $key_value";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function deleteRecord($table, $id)
    {
        $primary_key = array_keys($id)[0];
        $key_value = $id[$primary_key];
        $sql = "DELETE FROM $table WHERE $primary_key = $key_value";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function showRecords($table, $condition = null)
    {
        $sql = "Select * from $table";
        if ($condition != null) {
            $sql .= " $condition";
        }
        return $this->executeQuery($sql);
    }

    public function showAll($table)
    {
        $sql = "Select * from $table";
        return $this->executeQuery($sql);
    }

    public function addRecord($data, $table)
    {
        $tbl_columns = implode(",", array_keys($data));
        $tbl_values = implode("','", $data);
        $sql = "INSERT INTO $table($tbl_columns) VALUES ('$tbl_values')";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}
