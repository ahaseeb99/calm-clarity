<?php
include '../../global/datatable-json/includes.php';

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;

//define index of column
$columns = array(
    'position',
    'name',
    'price',
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
    $where .=" WHERE ";
    $where .=" ( name LIKE '".$params['search']['value']."%' )";
}

// getting total number records without any search
$sql = "SELECT * FROM `".$config['db']['pre']."prepaid_plans` ";
$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if(isset($where) && $where != '') {

    $sqlTot .= $where;
    $sqlRec .= $where;
}


$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = $pdo->query($sqlTot);
$totalRecords = $queryTot->rowCount();
$queryRecords = $pdo->query($sqlRec);

//iterate on results row and create new index array of data
foreach ($queryRecords as $row) {

    $id = $row['id'];
    $plan_name = $row['name'];
    $price = $row['price'];

    $row0 = '<td><i class="icon-feather-menu quick-reorder-icon" title="'.__('Reorder').'"></i> <span class="d-none">'.$id.'</span></td>';
    $row1 = '<td>'.$plan_name.'</td>';
    $row2 = '<td>'.price_format($price).'</td>';
    $row3 = '<td class="text-center">
                <div class="btn-group">
                    <a href="#" title="'.__('Edit').'" class="btn-icon mr-1" data-tippy-placement="top" data-url="panel/prepaid_plan_add.php?id='.$id.'" data-toggle="slidePanel"><i class="icon-feather-edit"></i></a>
                    <a href="#" title="'.__('Delete').'" class="btn-icon btn-danger item-js-delete" data-tippy-placement="top" data-ajax-action="deletePrepaidPlan"><i class="icon-feather-trash-2"></i></a>
                </div>
            </td>';

    $value = array(
        "DT_RowId" => $id,
        0 => $row0,
        1 => $row1,
        2 => $row2,
        3 => $row3,
    );
    $data[] = $value;
}

$json_data = array(
    "draw"            => intval( $params['draw'] ),
    "recordsTotal"    => intval( $totalRecords ),
    "recordsFiltered" => intval($totalRecords),
    "data"            => $data
);

echo json_encode($json_data);