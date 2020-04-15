<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/db_connect.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/enable_error_report.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/generate_query_condition.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/modifier/read_modifiers.php";
    
    if (!isset($_POST) || !isset($_POST["conditions"])) {
        echo "Invalid Parameters";
        exit;
    }

    $otherSearch = generateOtherSearchQuery($_POST);

    $conditionTree = $_POST["conditions"];
    $drugTree = $_POST["drugs"];

    $conditions = array();
    getAllConditions($conditionTree);
    
    $drugs = array();
    getAllDrugs($drugTree);

    $filteredIds = array(); // array of key as filtered study id
    $filteredIdVals = array();
    searchStudies();
    
    $modifiers = readAllModifiers();
    calculateCnts();

    $response = array();
    $response["conditions"] = $conditions;
    $response["drugs"] = $drugs;
    $response["totalIds"] = $filteredIdVals;

    echo json_encode($response, JSON_INVALID_UTF8_IGNORE);


    ////////////////////////////////GET ALL CONDITIONS////////////////////////////////////////
    function getAllConditions($conditionTree) {
        global $conditions;

        if (!isset($conditionTree) || count($conditionTree) < 1) {
            return array();
        }
        // If All conditions are checked, not calculate
        if ($conditionTree[0]["nodeId"] == "ROOT") {
            if (!isset($conditionTree[0]["nodeChild"])) {
                return array();
            }
            $conditionTree = $conditionTree[0]["nodeChild"];
        }

        foreach($conditionTree as $node) {
            $key = substr($node["nodeId"], 10);
            $conditions[$key]["condition_name"] = $node["nodeText"];
            addChildNode($node);
        }
    }
    function addChildNode($node) {
        global $conditions;

        if (!isset($node["nodeChild"]) || count($node["nodeChild"]) < 1) {
            return;
        }
        foreach($node["nodeChild"] as $node) {
            $key = substr($node["nodeId"], 10);
            $conditions[$key] = array();
            addChildNode($node);
        }
    }
    
    ////////////////////////////////GET ALL DRUGS////////////////////////////////////////
    function getAllDrugs($drugTree) {
        global $drugs;
        global $parentDrugs;

        if (!isset($drugTree) || count($drugTree) < 1) {
            return array();
        }
        // If All conditions are checked, not calculate
        if ($drugTree[0]["nodeId"] == "ROOT") {
            if (!isset($drugTree[0]["nodeChild"])) {
                return array();
            }
            $drugTree = $drugTree[0]["nodeChild"];
        }

        foreach($drugTree as $node) {
            $key = substr($node["nodeId"], 10);
            $drugs[$key]["drug_name"] = $node["nodeText"];
            addChildNode_Drug($node);
        }
    }
    function addChildNode_Drug($node) {
        global $drugs;

        if (!isset($node["nodeChild"]) || count($node["nodeChild"]) < 1) {
            return;
        }
        foreach($node["nodeChild"] as $node) {
            $key = substr($node["nodeId"], 10);
            $drugs[$key] = array();
            addChildNode_Drug($node);
        }
    }

    ////////////////////////////EXTRACT study IDs related with condition///////////////////////////////////
    ///////Condition///////
    function getStudyIds_Condition($conditionId, $modifierId) {
        $query = "SELECT `study_ids` FROM condition_hierarchy_modifier_stastics WHERE `hierarchy_id` = $conditionId AND `modifier_id` = $modifierId";
        $statistics = mysqlReadFirst($query);
        $ids = array();
        $strIds = trim(trim($statistics["study_ids"]), ",");
        if (!isset($statistics) || !isset($strIds) || strlen($strIds) < 1) {
            return $ids;
        }

        return explode(",", $strIds);
    }

    ///////Drugs///////
    function getStudyIds_Drug($drugId) {
        $query = "SELECT `study_ids` FROM drug_hierarchy WHERE `id` = $drugId";
        $statistics = mysqlReadFirst($query);
        $ids = array();
        $strIds = trim(trim($statistics["study_ids"]), ",");
        if (!isset($statistics) || !isset($strIds) || strlen($strIds) < 1) {
            return $ids;
        }

        return explode(",", $strIds);
    }
 
    //////////////////////////////////EXTRACT STUDY IDS IN search terms////////////////////////////////////////////
    function searchStudies() {
        global $otherSearch;
        global $filteredIdVals;

        $query = "SELECT `nct_id` from studies WHERE TRUE ";
        if (strlen($otherSearch) > 0) {
            $query .= " AND " . $otherSearch;
        }

        if (strlen($otherSearch) > 0) {
            $searchedRes = mysqlReadAll($query);

            foreach($searchedRes as $row) {
                $filteredIdVals[] = strval($row["nct_id"]);
            }
        }
    }
    
    function calculateCnts() {
        global $conditions;
        global $modifiers;
        global $drugs;
        global $filteredIdVals;
        global $otherSearch;
        
        $isAll = strlen($otherSearch) < 1;

        // Condition
        foreach($conditions as $key => $condition) {
            $conditions[$key]["studyIds"] = getStudyIds_Condition($key, 1);
            if (!$isAll)
                $conditions[$key]["studyIds"] = arrayIntersection($conditions[$key]["studyIds"], $filteredIdVals);
            foreach($modifiers as $modifier) {
                $condition_studyIds = getStudyIds_Condition($key, $modifier["id"]);
                if (!$isAll)
                    $condition_studyIds = arrayIntersection($condition_studyIds, $filteredIdVals);
                $conditions[$key]["modifier"][$modifier["modifier"]]["studyIds"] = $condition_studyIds;
            }
        }
        
        // Drug
        foreach($drugs as $key => $drug) {
            $drugs[$key]["studyIds"] = getStudyIds_Drug($key);
            if (!$isAll)
                $drugs[$key]["studyIds"] = arrayIntersection($drugs[$key]["studyIds"], $filteredIdVals);
        }
    }

    function arrayIntersection($arr1, $arr2)
    {
        return array_values(array_intersect($arr1, $arr2));
    }

    function arrayIntersectByKey($arr1, $arr2)
    {
        return array_intersect_key($arr1, $arr2);
    }
?>