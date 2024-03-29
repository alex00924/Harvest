<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/db_connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/enable_error_report.php";

    if (!isset($_POST) || !isset($_POST["action"])) {
        exit;
    }

    switch($_POST["action"]) {
        case "UPDATE PARENT":
            $currentId = $_POST["currentId"];
            $parentId = isset($_POST["parentId"]) ? $_POST["parentId"] : 0;
            $prev_parentId = isset($_POST["prev_parentId"]) ? $_POST["prev_parentId"] : -1;
            $category = $_POST["category"];
            $prev_category = $_POST["prev_category"];
        
            // if dropped on unmanaged category, delete the node in hierarchy.
            if ($category == 0) {
                if ($prev_category != 0) {
                    $query = "DELETE FROM `drug_hierarchy` WHERE `id` = $currentId";
                    mysqli_query($conn, $query);
                }
                break;
            }

            //if category is equal with prev category, update parent id
            if ($category == $prev_category) {
                $query = "UPDATE `drug_hierarchy` SET `parent_id` = $parentId WHERE `id` = '$currentId'";
                mysqli_query($conn, $query);
                break;
            }

            if ($prev_category == 0) {
                $drug_id = $currentId;
            } else {
                $query = "SELECT drug_id FROM drug_hierarchy WHERE id=$currentId;";
                $result = mysqli_query($conn, $query);
                // if exist, update
                if (mysqli_num_rows($result) < 1) {
                    break;
                }
                $row = mysqli_fetch_assoc($result);
                mysqli_free_result($result);
                $drug_id = $row["drug_id"];
            }
            $query = "INSERT INTO `drug_hierarchy` (`drug_id`, `parent_id`, `category_id`) VALUES ('$drug_id', '$parentId', '$category'); ";
            mysqli_query($conn, $query);
            break;
            
            // // If current node has child nodes, update all childs's categoryid.
            // if ($hasChildren) {
            //     $children = getChildren($currentId);
            //     if(isset($children)) {
            //         mysqli_autocommit($conn,FALSE);
            //         updateCategories($children, $category);
            //         mysqli_commit($conn);
    
            //         echo json_encode($children);
            //     }
            // }
        break;

        case "UPDATE TEXT":
            $editedId = $_POST["editedId"];
            $newText = $_POST["newText"];
            $category = $_POST["categoryId"];
            if ($category == 0) {
                $drug_id = $editedId;
            } else {
                $query = "SELECT drug_id FROM drug_hierarchy WHERE id=$editedId;";
                $result = mysqli_query($conn, $query);
                // if exist, update
                if (mysqli_num_rows($result) < 1) {
                    break;
                }
                $row = mysqli_fetch_assoc($result);
                mysqli_free_result($result);
                $drug_id = $row["drug_id"];
            }
            $query = "UPDATE `drugs` SET `drug_name` = '$newText' WHERE `id` = '$drug_id'";
            mysqli_query($conn, $query);
        break;
    }

    mysqli_close($conn);

    // function getChildren($parentId) {
    //     global $conn;
        
    //     $sql = "SELECT * FROM `drugs` WHERE `parentid` =$parentId";
    //     $result = mysqli_query($conn, $sql);
    //     if (mysqli_num_rows($result) < 1) {
    //         return;
    //     }
    //     // Fetch all
    //     $arrData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //     // Free result set
    //     mysqli_free_result($result);

    //     foreach($arrData as $key=>$data) {
    //         $arrData[$key]["nodeChild"] = getChildren($data["id"]);
    //     }
    //     return $arrData;
    // }

    // function updateCategories($children, $category) {
    //     global $conn;

    //     foreach($children as $child) {
    //         $childId = $child["id"];
    //         $query = "UPDATE `drugs` SET `categoryid` = $category WHERE `id` = '$childId'";
    //         mysqli_query($conn, $query);
    //         if (isset($child["nodeChild"])) {
    //             updateCategories($child["nodeChild"], $category);
    //         }
    //     }
    // }
?>