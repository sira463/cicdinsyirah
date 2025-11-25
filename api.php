<?php
header('Content-Type: application/json');

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_kontak_sederhana');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die(json_encode(['status'=>'error','message'=>'Koneksi database gagal: '.$conn->connect_error]));
}

function validate_input($data){
    $errors = [];
    if(empty($data['nama'])){
        $errors[] = 'Nama tidak boleh kosong';
    }
    if(empty($data['telepon']) || !preg_match('/^[0-9]+$/', $data['telepon'])){
        $errors[] = 'Nomor Telepon hanya boleh angka';
    }
    if(!empty($data['email'])){
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Format email tidak valid';
        } elseif(!preg_match('/@gmail\.com$/', $data['email'])){
            $errors[] = 'Format email tidak valid';
        }
    }
    return $errors;
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        $search = $_GET['search'] ?? '';
        $sql = "SELECT id, nama, telepon, email FROM kontak";
        if(!empty($search)){
            $sql .= " WHERE nama LIKE ?";
        }
        $stmt = $conn->prepare($sql);
        if(!empty($search)){
            $searchTerm = '%'.$search.'%';
            $stmt->bind_param("s", $searchTerm);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $kontak = [];
        while($row = $result->fetch_assoc()){
            $kontak[] = $row;
        }
        echo json_encode(['status'=>'success','data'=>$kontak]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $errors = validate_input($data);
        if(!empty($errors)){
            echo json_encode(['status'=>'error','message'=>implode(', ', $errors)]);
            break;
        }
        $sql = "INSERT INTO kontak (nama, telepon, email) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $data['nama'], $data['telepon'], $data['email']);
        if($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Kontak berhasil disimpan']);
        } else {
            echo json_encode(['status'=>'error','message'=>$stmt->error]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if(!isset($data['id'])){
            echo json_encode(['status'=>'error','message'=>'ID kontak tidak ditemukan']);
            break;
        }
        $errors = validate_input($data);
        if(!empty($errors)){
            echo json_encode(['status'=>'error','message'=>implode(', ', $errors)]);
            break;
        }
        $sql = "UPDATE kontak SET nama=?, telepon=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $data['nama'], $data['telepon'], $data['email'], $data['id']);
        if($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Kontak berhasil diperbarui']);
        } else {
            echo json_encode(['status'=>'error','message'=>$stmt->error]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        if(!isset($data['id'])){
            echo json_encode(['status'=>'error','message'=>'ID kontak tidak ditemukan']);
            break;
        }
        $sql = "DELETE FROM kontak WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $data['id']);
        if($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Kontak berhasil dihapus']);
        } else {
            echo json_encode(['status'=>'error','message'=>$stmt->error]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['status'=>'error','message'=>'Metode tidak diizinkan']);
        break;
}
$conn->close();
?>
