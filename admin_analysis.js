let studyTableIn;                     //Data table object.
let studyTableOut;                     //Data table object.
let conditionTree;                  //Condition Tree in search dialog
let conditionSearchTree;            //Condition tree on the left of graph
let drugTree;                       //Drug tree in search dialog
let drugSearchTree;                 //Drug tree on the left of graph
let modifierTree;                   //Modifier tree on the left of graph
let modifiers = [];                      // modifier array.
let searchItems;                    // all Search items of search dialog
let loadedCnt = 0;                  // the number of loaded data , 1 - graph data, 2 - table data
let graphSrcData;                   // graph origin data, which is filtered by search.
let graphDrawDetails;               // the sub data of graphSrcData to be displayed on graph
let chartGraph;                     // Graph Object
let isModifier;                     // true: draw modifier on the graph, false: not

let totalIds = [];
let inIds = [];
let outIds = []

let bgColor = [
    "rgba(255, 99, 132, 0.2)",
    "rgba(255, 159, 64, 0.2)",
    "rgba(255, 205, 86, 0.2)",
    "rgba(75, 192, 192, 0.2)",
    "rgba(54, 162, 235, 0.2)",
    "rgba(153, 102, 255, 0.2)",
    "rgba(201, 203, 207, 0.2)"];    // graph bar background color
let bdColor = [
    "rgb(255, 99, 132)",
    "rgb(255, 159, 64)",
    "rgb(255, 205, 86)",
    "rgb(75, 192, 192)",
    "rgb(54, 162, 235)",
    "rgb(153, 102, 255)",
    "rgb(201, 203, 207)"];          // graph bar border color
let conditionCheckedAuto = false;   // when click search button, condition(drug)SearchTree is initialized automatically and check all.
let modifierCheckedAuto = false;    // but this code update graph when node checked change, so it's used to prevent auto load again.
let drugCheckedAuto = false;
let loadedTreeCnt = 0;              // there are 2 main trees. 1 - condition tree, 2 - drug tree. when all trees are loaded, load graph data.
let graphShowKey = "conditions";    // graph showing key. conditions: draw condition as x axis. drugs: draw drug as x axis.

$(document).ready(function() {
    ej.base.enableRipple(true);
    initChart();
    initDatatable();
    initSearchConditionTree();
    initConditionTree();
    initSearchDrugTree();
    initDrugTree();
    initDateRangePicker();
    initModifiers();
    initGraphTab();
} );

function initGraphTab() {
    $('#graph-tab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        updateGraph();
    });
}

function resetZoom() {
    chartGraph.resetZoom();
}

function initDateRangePicker() {
    $('.date-range').daterangepicker();
    $('.date-range').val('');
    $('.date-range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
}

function initDatatable() {
    studyTableIn = $('#study-table-in').DataTable({
        bFilter: false,
        searching: false,
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollY: "70vh",
        ajax: {
            type: "POST",
            url: "read_table_data_admin_analysis.php",
            data: function ( d ) {
                let searchKeys = {};
                searchKeys.manual_ids = JSON.stringify(inIds);
                return  $.extend(d, searchKeys);
            },
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    {extend: 'excel',title: "studies"},
                    {extend: 'csv',title: "studies"},
                    {extend: 'print'},
                ]
            }
        ],
        columns: [
            //{ data: "rank" },
            { data: "nct_id" },
            { data: "title" },
            { data: "enrollment" },
            { data: "status" },
            { data: "study_types" },
            { data: "conditions" },
            { data: "interventions" },
            { data: "outcome_measures" },
            { data: "phases" },
            { data: "study_designs" },
        ],
        order: [[ 0, 'desc' ]]
    });

    studyTableOut = $('#study-table-out').DataTable({
        bFilter: false,
        searching: false,
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollY: "70vh",
        ajax: {
            type: "POST",
            url: "read_table_data_admin_analysis.php",
            data: function ( d ) {
                let searchKeys = {};
                searchKeys.manual_ids = JSON.stringify(outIds);
                return  $.extend(d, searchKeys);
            },
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    {extend: 'excel',title: "studies"},
                    {extend: 'csv',title: "studies"},
                    {extend: 'print'},
                ]
            }
        ],
        columns: [
            //{ data: "rank" },
            { data: "nct_id" },
            { data: "title" },
            { data: "enrollment" },
            { data: "status" },
            { data: "study_types" },
            { data: "conditions" },
            { data: "interventions" },
            { data: "outcome_measures" },
            { data: "phases" },
            { data: "study_designs" },
        ],
        order: [[ 0, 'desc' ]]
    });
}

function initChart() {
        var data = {
            datasets: [{
                //data: [10, 20, 30],
                borderWidth: 1
            }]
        };
          
        var options = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            responsiveAnimationDuration: 200,
            plugins: {
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                    },
                    zoom: {
                        enabled: true,
                        drag: false,
                        mode: 'x',
                        limits: {
                            max: 10,
                            min: 0.5
                        }
                    }
                }
            }
        };
          
        var ctx = document.getElementById("myChart").getContext("2d");
        chartGraph = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
}

function initConditionTree() {
    $.ajax({
        url: "read_condition_tree.php",
        success: function(response) {
            if (response) {
                try {
                    data = JSON.parse(response);
                    conditionTree.fields.dataSource = data;
                    conditionTree.refresh();
                    conditionTree.checkAll();
                    conditionTree.expandAll();

                    loadedTreeCnt++;
                    readGraphData();
                } catch (e) {
                    console.log(e);
                }
            }
        }
    });

    conditionTree = new ej.navigations.TreeView({
        fields: { id: 'nodeId', text: 'nodeText', child: 'nodeChild' },
        showCheckBox: true
    });
    conditionTree.appendTo("#condition-tree");
}

function initSearchConditionTree() {
    conditionSearchTree = new ej.navigations.TreeView({
        fields: { id: 'nodeId', text: 'nodeText', child: 'nodeChild' },
        showCheckBox: true,
        nodeChecked: function() {
            if (!conditionCheckedAuto) {
                updateGraph();
            }
        }
    });
    conditionSearchTree.appendTo("#condition-search-tree");
}

function initDrugTree() {
    $.ajax({
        url: "read_drug_tree.php",
        success: function(response) {
            if (response) {
                try {
                    data = JSON.parse(response);
                    drugTree.fields.dataSource = data;
                    drugTree.refresh();
                    drugTree.checkAll();
                    drugTree.expandAll();
                    
                    loadedTreeCnt++;
                    readGraphData();
                } catch (e) {
                    console.log(e);
                }
            }
        }
    });

    drugTree = new ej.navigations.TreeView({
        fields: { id: 'nodeId', text: 'nodeText', child: 'nodeChild' },
        showCheckBox: true
    });
    drugTree.appendTo("#drug-tree");
}

function initSearchDrugTree() {
    drugSearchTree = new ej.navigations.TreeView({
        fields: { id: 'nodeId', text: 'nodeText', child: 'nodeChild' },
        showCheckBox: true,
        nodeChecked: function() {
            if (!drugCheckedAuto) {
                updateGraph();
            }
        }
    });
    drugSearchTree.appendTo("#drug-search-tree");
}

function readGraphData() {

    // if condition & drug tree nodes are not loaded, don't search.
    if (loadedTreeCnt < 2) {
        return;
    }
    if (!searchItems) {
        readSearchItems();
    }
    showWaiting();

    // Load search tree from drug tree
    drugCheckedAuto = true;
    drugSearchTree.fields.dataSource = searchItems["drugs"];
    drugSearchTree.refresh();
    drugSearchTree.checkAll();
    drugSearchTree.expandAll();
    drugCheckedAuto = false;
    

    // Load search tree from condition tree
    conditionCheckedAuto = true;
    conditionSearchTree.fields.dataSource = searchItems["conditions"];
    conditionSearchTree.refresh();
    conditionSearchTree.checkAll();
    conditionSearchTree.expandAll();
    conditionCheckedAuto = false;

    //load graph data
    $.ajax({
        type: "POST",
        url: "read_graph_data_admin.php",
        data: searchItems,
        success: function(response) {
            try {
                graphSrcData = JSON.parse(response);
                totalIds = graphSrcData.totalIds;
                updateGraph();
            } catch(e) {
                console.log(e);
            }
            hideWaiting();
        }
    });
}

function search() {
    // Get search items
    readSearchItems();
    // Load Graph Data
    readGraphData();
    $("#search-modal").modal("hide");
}

function readSearchItems() {
    searchItems = getFormData($("#search-other-form"));
    searchItems["conditions"] = getCheckedTreeNodes("condition-tree", conditionTree);
    searchItems["drugs"] = getCheckedTreeNodes("drug-tree", drugTree);
}

function getFormData(form){
    var unindexed_array = form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        if (!n['value']) {
            return;
        }
        if (indexed_array[n['name']]) {
            if (!indexed_array[n['name']].push) {
                indexed_array[n['name']] = [indexed_array[n['name']]];
            }
            indexed_array[n['name']].push(n['value']);
        } else {
            indexed_array[n['name']] = n['value'];
        }
    });

    return indexed_array;
}

function getCheckedTreeNodes(selector, tree) {
    let checkedNodes = getCheckedNodes(selector);
    
    // console.log("function:", checkedNodes);
    checkedNodes.forEach(element => {
        let nodeObject = tree.getNodeObject(element);
        removeChildren(nodeObject.nodeChild, checkedNodes);
    });
    
    checkedNodes.forEach((element, index) => {
        checkedNodes[index] = tree.getNodeObject(element);
    });
    
    return checkedNodes;
}

function removeChildren(children, checkedNodes) {
    if (!children || children.length < 1 || !checkedNodes || checkedNodes.length < 1) {
        return;
    }
    children.forEach(element => {
        let idx = checkedNodes.indexOf(element.nodeId);
        if ( idx == -1) {
            return;
        }
        checkedNodes.splice(idx, 1);
        removeChildren(element.nodeChild, checkedNodes);
    });
}

function getCheckedNodes(id) {
    let checkedElements = $("#" + id + " .e-check").toArray();
    let checkedNodes = [];
    checkedElements.forEach(element => {
        checkedNodes.push( $(element.closest("li")).data("uid") );
    });
    return checkedNodes;
}

function hideWaiting() {
    $("#waiting").hide();
}

function showWaiting() {
    $("#waiting").show();
}

function updateGraph() {
    graphDrawDetails = [];
    let activeTabId = $("#graph-tab .active").attr("href");
    let checkedNodes;

    if (activeTabId == "#graph-tab-drug") {
        isModifier = false;
        checkedNodes = getCheckedTreeNodes("drug-search-tree", drugSearchTree);
        graphShowKey = "drugs";
    } else {
        graphShowKey = "conditions";
        if(activeTabId == "#graph-tab-modifier") {
            isModifier = true;
        } else {
            isModifier = false;
        }
        checkedNodes = getCheckedTreeNodes("condition-search-tree", conditionSearchTree);
    }
    
    // if only one leaf is checked, draw modifiers.
    if (activeTabId == "#graph-tab-condition" && checkedNodes.length == 1 && checkedNodes[0].nodeChild.length == 0) {
        isModifier = true;
    }

    let checkedModifierNodes;
    let checkedModifiers = [];
    if (isModifier) {
        checkedModifierNodes = getCheckedTreeNodes("modifier-tree", modifierTree);
        checkedModifierNodes.forEach(element => {
            checkedModifiers.push(element.nodeText);
        });
    }
    // if checked only one category and has children, display the children
    if (checkedNodes.length == 1 && checkedNodes[0].nodeChild.length > 0) {
        checkedNodes = checkedNodes[0].nodeChild;
    }

    drawGraph(checkedNodes, checkedModifiers);
}

function drawGraph(nodes, checkedModifiers) {
    let graphLabels = [];
    let graphDrawData = [];
    let backgroundColors = [];
    let borderColors = [];
    let chartCnt = 0;

    inIds = [];

    nodes.forEach(node => {
        // if modifier, extract all data for modifiers.
        let id = node.nodeId.substr(10);
        // show all child node data
        let nCnt = graphSrcData[graphShowKey][id]["count"]["All"];

        let ids = graphSrcData[graphShowKey][id]["studyIds"];
        ids.forEach(function(val) {
            if (inIds.indexOf(val) == -1) inIds.push(Number.parseInt(val));
        })
            // if (nCnt > 0) {
            graphLabels.push(node.nodeText);
            graphDrawData.push(nCnt);
            graphDrawDetails.push({node: node, cnt: nCnt});
            backgroundColors.push(bgColor[chartCnt % 7]);
            borderColors.push(bdColor[chartCnt % 7]);
            chartCnt++;
            // }
            if (isModifier) {
                checkedModifiers.forEach( modifier=> {
                    let nCnt = graphSrcData[graphShowKey][id]["count"][modifier];
                    if (nCnt > 0) {
                        graphLabels.push(modifier + " - " + node.nodeText);
                        graphDrawData.push(nCnt);
                        graphDrawDetails.push({node: node, modifier: modifier, cnt: nCnt});
                        backgroundColors.push(bgColor[chartCnt % 7]);
                        borderColors.push(bdColor[chartCnt % 7]);
                        chartCnt++;
                    }
                });
            }
    });
    outIds = totalIds.filter(id => !inIds.includes(id));
    console.log(inIds, outIds);
    chartGraph.data.labels = graphLabels;
    chartGraph.data.datasets[0].data = graphDrawData;
    chartGraph.data.datasets[0].backgroundColor = backgroundColors;
    chartGraph.data.datasets[0].borderColor = borderColors;
    chartGraph.update();
}
// Read modifiers
function initModifiers() {
    $.ajax({
        url: "read_modifier.php",
        success: function(response) {
            if (response) {
                try {
                    modifiers = JSON.parse(response);
                    let modifierTreeData = [];
                    let id = 0;
                    modifiers.forEach(modifier => {
                        modifierTreeData.push({nodeId: "MODIFIERS-" + id, nodeText: modifier["modifier"]});
                        id++;
                    });
                    modifierCheckedAuto = true;
                    modifierTree.fields.dataSource = modifierTreeData;
                    modifierTree.refresh();
                    modifierTree.checkAll();
                    modifierCheckedAuto = false;
                } catch (e) {
                    console.log(e);
                }
            }
        }
    });
    modifierTree = new ej.navigations.TreeView({
        fields: { id: 'nodeId', text: 'nodeText', child: 'nodeChild' },
        showCheckBox: true,
        allowDragAndDrop: true,
        allowDropChild: false,
        allowDropSibling: false,
        nodeDropped: function(args) {
            updateGraph();
        },
        nodeChecked: function() {
            if (!modifierCheckedAuto) {
                updateGraph();
            }
        },
        nodeDragStop: function(args) {
            if (args.dropLevel > 1) {
                args.cancel = true;
            }
        }
    });
    modifierTree.appendTo("#modifier-tree");
}

function updateDataTables() {
    // Load table data
    studyTableIn.ajax.reload();
    studyTableOut.ajax.reload();
}

function searchCorona() {
    conditionTree.uncheckAll();
    conditionTree.checkedNodes = ["CONDITION-141"];
    conditionTree.refresh();
    search();
}

function searchCancer() {
    conditionTree.uncheckAll();
    conditionTree.checkedNodes = ["CONDITION-81"];
    conditionTree.refresh();
    search();
}