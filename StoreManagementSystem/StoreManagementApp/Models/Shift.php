<?php
include_once "Model.php";

class Shift extends Model
{
    public $shiftId;
    public $userId;
    public $day;
    public $username;
    public $startTime;
    public $endTime;

    function __construct($param = null)
    {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT s.*, u.username FROM shifts s JOIN users u ON u.id = s.userId WHERE s.shiftId = ?");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row)
    {
        $this->shiftId = $row->shiftId;
        $this->userId = $row->userId;
        $this->day = $row->day;
        $this->startTime = $row->startTime;
        $this->endTime = $row->endTime;
        $this->username = $row->username;
    }

    public static function list()
    {
        $conn = Model::connect();
        $sql = "SELECT s.*, u.username FROM shifts s JOIN users u ON u.id = s.userId";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $list = [];
        while ($row = $result->fetch_object()) {
            $list[] = new Shift($row);
        }
        $stmt->close();
        return $list;
    }

    public static function add($data)
    {
        $conn = Model::connect();
        $sql = "SELECT COUNT(*) AS count FROM shifts 
        WHERE userId = ? AND day = ? 
        AND NOT (endTime <= ? OR startTime >= ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $data['userId'], $data['day'], $data['startTime'], $data['endTime']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['count'] > 0) {
            throw new Exception("Shift overlaps with existing one!");
        }
        if ($data['startTime'] >= $data['endTime']) {
            throw new Exception("End time must be after start time.");
        }

        $sql = "INSERT INTO shifts (userId, day, startTime, endTime) 
            VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss",
            $data['userId'],
            $data['day'],
            $data['startTime'],
            $data['endTime']
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update($data)
    {
        $conn = Model::connect();


        $sql = "SELECT COUNT(*) AS count FROM shifts 
        WHERE userId = ? AND day = ? 
        AND NOT (endTime <= ? OR startTime >= ?)
        AND shiftId != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssi", $data['userId'], $data['day'], $data['startTime'], $data['endTime'], $this->shiftId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['count'] > 0) {
            throw new Exception("Shift overlaps with existing one!");
        }
        if ($data['startTime'] >= $data['endTime']) {
            throw new Exception("End time must be after start time.");
        }


        $sql = "UPDATE shifts SET userId = ?, day = ?, startTime = ?, endTime = ? WHERE shiftId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssi", $data['userId'], $data['day'], $data['startTime'],
            $data['endTime'], $this->shiftId);
        $stmt->execute();
        $stmt->close();
    }
    public static function delete($id)
    {
        $conn = Model::connect();
        $sql = "DELETE FROM shifts WHERE shiftId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
