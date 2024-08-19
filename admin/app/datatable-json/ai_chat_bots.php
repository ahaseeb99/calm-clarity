<?php
include '../../global/datatable-json/includes.php';

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;
//define index of column
$columns = array(
    'cb.position',
    'cb.name',
    'cb.role',
    'c.title',
    'cb.active',
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if (!empty($params['search']['value'])) {
    $where .= " WHERE ";
    $where .= " ( cb.name LIKE '%" . $params['search']['value'] . "%' ";
    $where .= " OR cb.active LIKE '%" . $params['search']['value'] . "%' ";
    $where .= " OR cb.welcome_message LIKE '%" . $params['search']['value'] . "%' ";
    $where .= " OR cb.prompt LIKE '%" . $params['search']['value'] . "%' ";
    $where .= " OR cb.role LIKE '" . $params['search']['value'] . "%' )";
}

// getting total number records without any search
$sql = "SELECT cb.*, c.title category, c.translations category_translations FROM `" . $config['db']['pre'] . "ai_chat_bots` as cb
INNER JOIN `" . $config['db']['pre'] . "ai_chat_bots_categories` as c ON c.id = cb.category_id ";

$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if (isset($where) && $where != '') {
    $sqlTot .= $where;
    $sqlRec .= $where;
}

$sqlRec .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "  LIMIT " . $params['start'] . " ," . $params['length'] . " ";

$queryTot = $pdo->query($sqlTot);
$totalRecords = $queryTot->rowCount();
$queryRecords = $pdo->query($sqlRec);

//iterate on results row and create new index array of data
foreach ($queryRecords as $row) {

    $id = $row['id'];
    $title = escape($row['name']);

    $row['translations'] = json_decode((string) $row['translations'], true);
    $role = !empty($row['translations'][$config['lang_code']]['role'])
        ? $row['translations'][$config['lang_code']]['role']
        : $row['role'];
    $role = escape($role);

    $image = !empty($row['image']) ? $row['image'] : 'default_user.png';
    if(!empty($row['image']))
        $img_url = $config['site_url'].'storage/chat-bots/'.$row['image'];
    else
        $img_url = get_avatar_url_by_name($row['name']);

    $status = $row['active']
        ? '<div class="badge badge-primary">'.__('Enabled').'</div>'
        : '<div class="badge badge-secondary">'.__('Disabled').'</div>';

    $row['category_translations'] = json_decode((string) $row['category_translations'], true);
    $category = !empty($row['category_translations'][$config['lang_code']]['title'])
        ? $row['category_translations'][$config['lang_code']]['title']
        : $row['category'];
    $category = escape($category);

    $rows = array();
    $rows[] = '<td><i class="icon-feather-menu quick-reorder-icon"
                                       title="'.__('Reorder').'"></i> <span class="d-none">'.$id.'</span></td>';
    $rows[] = '<td>
                <div class="d-flex align-items-center">
                        <img src="' . $img_url . '" alt="' . $title . '" width="60">
                    <div class="ml-3">
                        <div><strong>' . $title . '</strong></div>
                    </div>
                </div>
            </td>';
    $rows[] = '<td class="hidden-xs">' . $role . '</td>';
    $rows[] = '<td class="hidden-xs">' . $category . '</td>';
    $rows[] = '<td>' . $status . '</td>';
    $rows[] = '<td class="text-center">
                <div class="btn-group">
                <a href="#" title="' . __('Edit') . '" data-url="panel/ai_chat_bots.php?id=' . $id . '" data-toggle="slidePanel"  class="btn-icon mr-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                </div>
            </td>';
    $rows[] = '<td>
                <div class="checkbox">
                <input type="checkbox" id="check_' . $id . '" value="' . $id . '" class="quick-check">
                <label for="check_' . $id . '"><span class="checkbox-icon"></span></label>
            </div>
            </td>';
    $rows['DT_RowId'] = $id;
    $data[] = $rows;
}

$json_data = array(
    "draw" => intval($params['draw']),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalRecords),
    "data" => $data   // total data array
);

echo json_encode($json_data);