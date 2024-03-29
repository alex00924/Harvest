<?php
    // In order to speed up, calculate all study ids related all conditions in hierarchy.
    $rootPath = $_SERVER['DOCUMENT_ROOT'];
    $runningCLI = false;

    if (!isset($rootPath) || strlen($rootPath) < 1) {
        $rootPath = __DIR__ . "/../../";
        $runningCLI = true;
    }
    $logMethodFile = true;
    $conditionCalcLogFile = fopen($rootPath . "/logs/calculate_study_condition_log.txt", "w") or die("Unable to open file!");
    fwrite($conditionCalcLogFile, date("Y-m-d h:i:sa"));
    
    if (!isset($isScraping)) {
        require_once $rootPath . "/db_connect.php";
        require_once $rootPath . "/enable_error_report.php";
        require_once $rootPath . "/admin/graph_history.php";
    }

    $log = "\r\n-----------------------Calculate Study Ids Related with Condition Hierarchy----------------------------";
    logOrPrintConditions($log);

    $totalData = array();
    // $query = "DELETE FROM condition_hierarchy_modifier_stastics";
    // mysqli_query($conn, $query);
    mysqli_autocommit($conn,FALSE);

    calculateStudyConditions();

    updateGraphHistory();
    
    if (!mysqli_commit($conn)) {
        $log = "Commit transaction failed";
        logOrPrintConditions($log);
    }

    if ($logMethodFile) {
        fclose($conditionCalcLogFile);
    }

    function calculateStudyConditions() {
        global $totalData;
        $modifiers = readModifiers();
        $conditions = readAllHierarchy();

        foreach($modifiers as $modifier) {
            $log = "\r\n-----------------------" . $modifier["modifier"] . "----------------------------";
            logOrPrintConditions($log);

            $totalData = $conditions;
            changeSpecialCaracters();
            mysqlReconnect();
            calculateStudyIds($modifier["modifier"], $modifier["category"]);
            mergeIds();
            mysqlReconnect();
            saveData($modifier["id"], $modifier["category"]);
        }
    }

    function changeSpecialCaracters() {
        global $totalData;

        foreach($totalData as $key=>$val) {
            $totalData[$key]["condition_name"] = str_replace("'", "\'", $totalData[$key]["condition_name"]);
        }
    }

    function mysqlReadAll($query) {
        global $conn;
        
        $result = mysqli_query($conn, $query);
        if (!$result || mysqli_num_rows($result) < 1) {
            return array();
        }
        // Fetch all
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // Free result set
        mysqli_free_result($result);
        return isset($data) ? $data : array();
    }

    function mysqlRowCnt($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        if (!$result) {
            $log = "ERROR in Row Cnt. THe query is : " . $query ;
            logOrPrintConditions($log);
        }
        $nCnt = mysqli_num_rows($result);
        // Free result set
        mysqli_free_result($result);
        return $nCnt;
    }
    // Read All Modifiers
    function readModifiers() {
        $query = "SELECT * FROM modifiers";
        return mysqlReadAll($query);
    }

    //Read All conditions in hierarchy
    function readAllHierarchy() {
        $query = "SELECT `id`, `condition_name`, `synonym`, `parent_id`, `condition_id`, `category_id` FROM condition_hierarchy_view";
        $hierarchyData = mysqlReadAll($query);
        foreach($hierarchyData as $key => $element) {
            $hierarchyData[$key]["leaf"] = true;
            foreach($hierarchyData as $subKey => $subElement) {
                if ($element["id"] == $subElement["parent_id"]) {
                    $hierarchyData[$key]["leaf"] = false;
                    break;
                }
            }
        }
        return $hierarchyData;
    }

    // Calculate study ids related with condition name
    function calculateStudyIds($modifier, $modifier_category_id) {
        global $totalData;
        global $log;
        $nCnt = 0;
        foreach($totalData as $key=>$condition) {
            
            $totalData[$key]["study_ids"] = array();

            if ($modifier_category_id != 0 && $condition["category_id"] != $modifier_category_id) {
                continue;
            }

            $start = time();
            $query = "SELECT `nct_id` FROM study_id_conditions WHERE ( " . generateSearchString('condition', $condition["condition_name"]);
            if (isset($condition["synonym"]) && strlen($condition["synonym"]) > 0) {
                $synonyms = explode(",", $condition["synonym"]);
                foreach($synonyms as $synonym) {
                    $query .= " OR " . generateSearchString('condition', trim($synonym));
                }
            }
            $query .= ") ";
            if (strlen($modifier) > 0 && $modifier != "NONE") {
                $query .= " AND  `condition` LIKE '%" . $modifier . "%' ";
            }
            $query .= " GROUP BY `nct_id`";

            $nctIds = mysqlReadAll($query);
            
            foreach($nctIds as $id) {
                $totalData[$key]["study_ids"][$id["nct_id"]] = '';
            }
            
            $end = time();
            $log = "\r\nCalculate Study Id - ". $condition["condition_name"] . " : " . time_elapsed_string($end-$start) .
                    ", Count: " . count($nctIds);
            logOrPrintConditions($log);
            $nCnt++;
            if ($nCnt > 30) {
                $nCnt = 0;
                mysqlReconnect();
            }
        }
    }

    function generateSearchString($column, $value)
    {
        $res = ' (';
        $res .= '`' . $column . '` LIKE "%' . $value . ' %"';
        $res .= ' OR `' . $column . '` LIKE "%' . $value . ',%"';
        $res .= ' OR `' . $column . '` LIKE "%' . $value . '.%"';
        $res .= ' OR `' . $column . '` LIKE "%' . $value . ')%"';
        $res .= ' OR `' . $column . '` LIKE "%' . $value . '"';
		$res .= ' OR `' . $column . '` LIKE "%' . $value . '|%"';
		$res .= ' OR `' . $column . '` LIKE "%' . $value . 's %"';
		$res .= ' OR `' . $column . '` LIKE "%' . $value . 's"';
        $res .=') ';
        return $res;
    }

    // merge Study Ids
    function mergeIds() {
        
        $log = "\r\nMerging...";
        logOrPrintConditions($log);
        
        global $totalData;

        // foreach($totalData as $key=>$condition) {
        //     if ($condition["parent_id"] == 0) {
        //         mergeParentChild($key);
        //     }
        // }
        $start = time();
        foreach($totalData as $key => $condition) {
            if (isset($condition["leaf"]) && $condition["leaf"]) {
                mergeChildParent($key);
            }
        }

        foreach($totalData as $key => $condition) {
            $log = "\r\nCalculate Study Id - ". $condition["condition_name"] . " : "  . count($condition['study_ids']);
            logOrPrintConditions($log);
        }
        
        $log ="\r\n" . time_elapsed_string(time()-$start) . "\r\nMerge complete";
        logOrPrintConditions($log);
        
    }

    // merge Parent -> Child
    function mergeParentChild($parentKey) {
        global $totalData;
        $isLeaf = true;
        foreach($totalData as $key => $condition) {
            if ($condition["parent_id"] != $totalData[$parentKey]["id"]) {
                continue;
            }
            $isLeaf = false;
            $totalData[$key]["study_ids"] = mergeArray($totalData[$key]["study_ids"], $totalData[$parentKey]["study_ids"]);
            mergeParentChild($key);
        }
        if ($isLeaf) {
            $totalData[$parentKey]["leaf"] = true;
        }
    }

    //merge Child -> Parent
    function mergeChildParent($childKey) {
        global $totalData;

        // Get Parent Node
        foreach($totalData as $key => $condition) {
            if ($condition["id"] == $totalData[$childKey]["parent_id"])  {
                if (count($totalData[$key]["study_ids"]) < 1) {
                    $totalData[$key]["study_ids"] = $totalData[$childKey]["study_ids"];
                } else {
                    foreach($totalData[$childKey]["study_ids"] as $studyIdKey => $val) {
                        $totalData[$key]["study_ids"][$studyIdKey] = '';
                    }
                }
                mergeChildParent($key);
                break;
            }
        }
    }

    function mergeArray($array1, $array2) {
        $merged = $array1;
        foreach($array2 as $val2) {
            if (!in_array($val2, $array1)) {
                array_push($merged, $val2);
            }
        }
        return $merged;
    }

    function printStudyIdCnts($explain) {
        global $totalData;
        $log = "\r\n $explain:";
        foreach($totalData as $key=>$condition) {
            $log .= "\r\n" .  $condition["condition_name"] . ": " . count($condition["study_ids"]);
        }
        logOrPrintConditions($log);
    }
    // Calculate elapsed time
    function time_elapsed_string($secs){
        $bit = array(
            'y' => $secs / 31556926 % 12,
            'w' => $secs / 604800 % 52,
            'd' => $secs / 86400 % 7,
            'h' => $secs / 3600 % 24,
            'm' => $secs / 60 % 60,
            's' => $secs % 60
            );
        $ret[] = "";
        foreach($bit as $k => $v)
            if($v > 0)
                $ret[] = $v . $k;
            
        return join(' ', $ret);
    }
    
    function saveData($modifierID, $modifier_category_id) {
        global $totalData;
        global $conn;

        foreach($totalData as $data) {
            if ($modifier_category_id != 0 && $data["category_id"] != $modifier_category_id) {
                continue;
            }
            $studyIds = array_keys($data["study_ids"]);
            $query = "SELECT `modifier_id` FROM `condition_hierarchy_modifier_stastics` WHERE `modifier_id` = $modifierID AND `hierarchy_id` = " . $data["id"];
            $nCnt = mysqlRowCnt($query);
            if ($nCnt < 1) {
                $query = "INSERT INTO `condition_hierarchy_modifier_stastics` (`hierarchy_id`, `modifier_id`, `condition_id`, `condition_name`, `study_ids`)";
                $query .= "VALUES ('" . $data["id"] . "', '$modifierID', '" . $data["condition_id"] . "', '" . $data["condition_name"] . "', '" . implode(",", $studyIds) . "'); ";
            } else {
                $query = "UPDATE `condition_hierarchy_modifier_stastics` SET `study_ids` = '" . implode(",", $studyIds) . "' WHERE  `modifier_id` = $modifierID AND `hierarchy_id` = " . $data["id"];
            }
            mysqli_query($conn, $query);
        }
    }

    function logOrPrintConditions($log) {
        global $logMethodFile;
        global $conditionCalcLogFile;
        global $_POST;

        if (isset($_POST) && isset($_POST["post"])) {
            return;
        }

        if ($logMethodFile) {
            fwrite($conditionCalcLogFile, $log);
        } else {
            echo $log;
            //ob_flush();
            flush();
        }
    }
?>