<?php
require_once("../../../config/database.php");
require_once("model.php");
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
session_start(); 
if ( !isset($_SESSION['session_username']) or !isset($_SESSION['session_id']) or !isset($_SESSION['session_level']) or !isset($_SESSION['session_kode_akses']) or !isset($_SESSION['session_hak_akses']) )
{
  echo '<div class="callout callout-danger">
          <h4>Session Berakhir!!!</h4>
          <p>Silahkan logout dan login kembali. Terimakasih.</p>
        </div>';
} else {
$db = new db();
if(isset($_POST['controller'])) {
  $controller = $_POST['controller'];
} else {
  $controller = "";
}
$username = $_SESSION['session_username'];
$id_menus = 5; 
$cekMenusUser = $db->cekMenusUser($username,$id_menus); 
    foreach($cekMenusUser[1] as $data){
      $create = $data['c'];
      $read = $data['r'];
      $update = $data['u'];
      $delete = $data['d'];
      $nama_menus = $data['nama_menus'];
      $keterangan = $data['keterangan'];
    }
if($cekMenusUser[2] == 1) {

// start - controller
if($controller == 'get_menu'){
  if (isset($_POST['kriteria'])) {
    $kriteria = $_POST['kriteria'];
    $getMenu = $db->getMenu($kriteria);
    $data = array();
      $data[] = array("id"=>"", "text"=>"-- Pilih --");
    foreach($getMenu[1] as $option){
      $data[] = array("id"=>$option['id_menu'], "text"=>$option['nama_menu']);
    } 
    echo json_encode($data);
  }
} else if($controller == 'delete' && $delete == "y"){
  $id = $_POST['id'];
 
  $run = $db->delete($id);
  $retval['status'] = $run[0];
  $retval['title'] = $run[1];
  $retval['message'] = $run[2];
  
  echo json_encode($retval);
} else if($controller == 'create' && $create == "y"){
  $nama_menu_sub = htmlspecialchars($_POST['nama_menu_sub']);
  $urut_menu_sub = htmlspecialchars($_POST['urut_menu_sub']);
  $icon_menu_sub = htmlspecialchars($_POST['icon_menu_sub']);
  $id_menu = htmlspecialchars($_POST['id_menu']);

  $run = $db->create($nama_menu_sub,$urut_menu_sub,$icon_menu_sub,$id_menu);
  $retval['status'] = $run[0];
  $retval['title'] = $run[1];
  $retval['message'] = $run[2];
  
  echo json_encode($retval);
} else if($controller == 'update' && $update == "y"){
  $id = htmlspecialchars($_POST['id_menu_sub']);
  $nama_menu_sub = htmlspecialchars($_POST['nama_menu_sub']);
  $urut_menu_sub = htmlspecialchars($_POST['urut_menu_sub']);
  $icon_menu_sub = htmlspecialchars($_POST['icon_menu_sub']);
  $id_menu = htmlspecialchars($_POST['id_menu']);

  $run = $db->update($id,$nama_menu_sub,$urut_menu_sub,$icon_menu_sub,$id_menu);
  $retval['status'] = $run[0];
  $retval['title'] = $run[1];
  $retval['message'] = $run[2];
  
  echo json_encode($retval);
} else {
  $retval['status'] = false;
  $retval['message'] = "Tidak memiliki hak akses.";
  $retval['title'] = "Error!";
  echo json_encode($retval); 
}
// end - controller

}}} else {
  header("HTTP/1.1 401 Unauthorized");
  exit;
} ?>