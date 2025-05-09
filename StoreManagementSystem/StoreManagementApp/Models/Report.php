<?php
include_once "Model.php";

class Report extends Model
{
    public $reportId;
    public $date;
    public $earnings;
    public $profits;
    public $description;
    public $isActive;

    function __construct($param = null)
    {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT * FROM reports WHERE reportId = ? AND isActive = 1");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row)
    {
        $this->reportId = $row->reportId;
        $this->date = $row->date;
        $this->earnings = $row->earnings;
        $this->profits = $row->profits;
        $this->description = $row->description;
        $this->isActive = $row->isActive;
    }

    public static function listFilteredSorted($sort, $dir)
    {
        $allowedSorts = ['date', 'earnings', 'profits', 'description'];
        if (!in_array($sort, $allowedSorts)) $sort = 'date';
        $dir = ($dir === 'DESC') ? 'DESC' : 'ASC';

        $conn = Model::connect();
        $sql = "SELECT * FROM reports WHERE isActive = 1";

        $sql .= " ORDER BY $sort $dir";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $list = [];
        while ($row = $result->fetch_object()) {
            $list[] = new Report($row);
        }
        $stmt->close();
        return $list;
    }
    public static function add($data)
    {
        $conn = Model::connect();
        $sql = "INSERT INTO reports (date, earnings, profits, description, isActive) VALUES (?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $currentDate = date('Y-m-d');
        $stmt->bind_param("sdds",
            $currentDate,
            $data['earnings'],
            $data['profits'],
            $data['description']
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update($data)
    {
        $conn = Model::connect();
        $sql = "UPDATE reports SET date = ?, earnings = ?, profits = ?, description = ? WHERE reportId = ?";
        $stmt = $conn->prepare($sql);

        $currentDate = date('Y-m-d');

        $stmt->bind_param("sddsi", $currentDate, $data['earnings'], $data['profits'],
            $data['description'], $this->reportId);
        $stmt->execute();
        $stmt->close();
    }

    public static function delete($ids)
    {
        $conn = Model::connect();
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $conn->prepare("UPDATE reports SET isActive = 0 WHERE reportId IN ($in)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $stmt->close();
    }
    public static function viewDeleted()
    {
        $conn = Model::connect();
        $sql = "SELECT * FROM reports WHERE isActive = 0";
        $result = $conn->query($sql);

        $list = [];
        while ($row = $result->fetch_object()) {
            $report = new Report($row);
            $list[] = $report;
        }
        return $list;
    }

    public static function restore($id)
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE reports SET isActive = 1 WHERE reportId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
