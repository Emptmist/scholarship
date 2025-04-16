<?php
header('Content-Type: application/json; charset=utf-8');
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

$filter = isset($_GET['filter']) && in_array($_GET['filter'], ['today', 'week', 'month']) ? $_GET['filter'] : 'today';
$today = (new DateTime())->format('Y-m-d');

$response = [];

if ($filter == 'today') {
    $sql = "SELECT scholarship_no, scholarship_name, start_of_applications, end_of_applications 
            FROM tbl_scholarship 
            WHERE start_of_applications = '$today' 
            OR end_of_applications = '$today'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response['data'] = [];
        while ($row = $result->fetch_assoc()) {
            $startDate = new DateTime($row["start_of_applications"]);
            $endDate = new DateTime($row["end_of_applications"]);
            $response['data'][] = [
                'scholarship_name' => htmlspecialchars($row["scholarship_name"]),
                'start_date' => $startDate->format('F j, Y'),
                'end_date' => $endDate->format('F j, Y')
            ];
        }
    } else {
        $response['data'] = 'No Event today';
    }
} elseif ($filter == 'week') {
    $startOfWeek = (new DateTime())->modify('this week Monday')->format('Y-m-d');
    $endOfWeek = (new DateTime())->modify('this week Sunday')->format('Y-m-d');

    $sql = "SELECT scholarship_no, scholarship_name, start_of_applications, end_of_applications 
            FROM tbl_scholarship 
            WHERE (start_of_applications BETWEEN '$startOfWeek' AND '$endOfWeek')
               OR (end_of_applications BETWEEN '$startOfWeek' AND '$endOfWeek')";
            
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $response['data'] = [];
        while ($row = $result->fetch_assoc()) {
            $startDate = new DateTime($row["start_of_applications"]);
            $endDate = new DateTime($row["end_of_applications"]);
            $response['data'][] = [
                'scholarship_name' => htmlspecialchars($row["scholarship_name"]),
                'start_date' => $startDate->format('F j, Y'),
                'end_date' => $endDate->format('F j, Y')
            ];
        }
    } else {
        $response['data'] = 'No scholarships found for this week.';
    }
} elseif ($filter == 'month') {
    $sql = "SELECT MIN(start_of_applications) AS min_start, MAX(end_of_applications) AS max_end
            FROM tbl_scholarship";
    $result = $conn->query($sql);
    $dateRange = $result->fetch_assoc();

    if ($dateRange) {
        $startOfMonth = new DateTime($dateRange['min_start']);
        $endOfMonth = new DateTime($dateRange['max_end']);

        $response['start'] = $startOfMonth->format('F j, Y');
        $response['end'] = $endOfMonth->format('F j, Y');

        $sql = "SELECT DISTINCT start_of_applications, end_of_applications
                FROM tbl_scholarship 
                WHERE start_of_applications <= '{$endOfMonth->format('Y-m-d')}' 
                AND end_of_applications >= '{$startOfMonth->format('Y-m-d')}'
                ORDER BY start_of_applications"; 

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $response['dates'] = [];
            $response['end_dates'] = [];
            while ($row = $result->fetch_assoc()) {
                $response['dates'][] = $row["start_of_applications"];
                $response['end_dates'][] = $row["end_of_applications"];
            }
        } else {
            $response['dates'] = [];
            $response['end_dates'] = [];
        }

        // Fetch scholarship data for the month view
        $dataSql = "SELECT scholarship_no, scholarship_name, start_of_applications, end_of_applications 
                    FROM tbl_scholarship 
                    WHERE start_of_applications <= '{$endOfMonth->format('Y-m-d')}' 
                    AND end_of_applications >= '{$startOfMonth->format('Y-m-d')}'
                    ORDER BY start_of_applications"; // Order by start date in descending order

        $dataResult = $conn->query($dataSql);
        if ($dataResult->num_rows > 0) {
            $response['data'] = [];
            while ($row = $dataResult->fetch_assoc()) {
                $startDate = new DateTime($row["start_of_applications"]);
                $endDate = new DateTime($row["end_of_applications"]);
                $response['data'][] = [
                    'scholarship_name' => htmlspecialchars($row["scholarship_name"]),
                    'start_date' => $startDate->format('F j, Y'),
                    'end_date' => $endDate->format('F j, Y')
                ];
            }
        } else {
            $response['data'] = 'No scholarships found for this month.';
        }
        
    } else {
        $response['dates'] = [];
        $response['end_dates'] = [];
    }
}

$conn->close();

echo json_encode($response);
?>
