<?php

// Konfigurasi database
$host = "localhost";
$username = "root";
$password = "";
$database = "sampledatabase";

// Koneksi ke database menggunakan PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Fungsi untuk menampilkan data dari tabel Customers dan Products
function showData() {
    global $pdo;

    // Query untuk mengambil data dari tabel Customers dan Products
    $sql = "SELECT * FROM customers, products";

    // Eksekusi query dan ambil hasilnya
    $stmt = $pdo->query($sql);

    // Cek apakah query mengembalikan hasil
    if ($stmt->rowCount() > 0) {
        // Menampilkan data dalam bentuk tabel
        echo "<table>";
        echo "<tr>";
        echo "<th>Customer ID</th>";
        echo "<th>Customer Name</th>";
        echo "<th>Product ID</th>";
        echo "<th>Product Name</th>";
        echo "</tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row["CustomerID"] . "</td>";
            echo "<td>" . $row["CustomerName"] . "</td>";
            echo "<td>" . $row["ProductID"] . "</td>";
            echo "<td>" . $row["ProductName"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data yang ditemukan.";
    }
}

// Fungsi untuk menambah data ke dalam tabel Customers atau Products
function addData($table, $data) {
    global $pdo;

    // Buat query untuk menambah data ke dalam tabel
    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

    // Eksekusi query dengan mengikat data parameter
    $stmt = $pdo->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->execute();

    // Cek apakah data berhasil ditambahkan
    if ($stmt->rowCount() > 0) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Data gagal ditambahkan.";
    }
}

// Fungsi untuk mengubah data di dalam tabel Customers atau Products
function updateData($table, $data, $id) {
    global $pdo;

    // Buat query untuk mengubah data di dalam tabel
    $set = implode(", ", array_map(function ($col) {
        return "$col=:$col";
    }, array_keys($data)));
    $sql = "UPDATE $table SET $set WHERE ID=:ID";

    // Eksekusi query dengan mengikat data parameter
    $stmt = $pdo->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->bindParam(":ID", $id);
    $stmt->execute();
// Cek apakah data berhasil diubah
if ($stmt->rowCount() > 0) {
    echo "Data berhasil diubah.";
    } else {
    echo "Data gagal diubah.";
    }
    }
    
    // Fungsi untuk menghapus data dari tabel Customers atau Products
    function deleteData($table, $id) {
    global $pdo;
    // Buat query untuk menghapus data dari tabel
$sql = "DELETE FROM $table WHERE ID=:ID";

// Eksekusi query dengan mengikat data parameter
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":ID", $id);
$stmt->execute();

// Cek apakah data berhasil dihapus
if ($stmt->rowCount() > 0) {
    echo "Data berhasil dihapus.";
} else {
    echo "Data gagal dihapus.";
}
// Memanggil fungsi-fungsi untuk menampilkan, menambah, mengubah, dan menghapus data
echo "<h2>Data sebelum diubah:</h2>";
showData();

echo "<h2>Menambah data:</h2>";
addData("customers", ["CustomerID" => "C001", "CustomerName" => "John Doe"]);
addData("products", ["ProductID" => "P001", "ProductName" => "Product 1"]);

echo "<h2>Data setelah diubah:</h2>";
showData();

echo "<h2>Mengubah data:</h2>";
updateData("customers", ["CustomerName" => "Jane Doe"], 1);
updateData("products", ["ProductName" => "New Product"], 1);

echo "<h2>Data setelah diubah:</h2>";
showData();

echo "<h2>Menghapus data:</h2>";
deleteData("customers", 1);
deleteData("products", 1);

echo "<h2>Data setelah dihapus:</h2>";
showData();

// Menginstansiasi kelas PDO dan membuka koneksi ke database
$pdo = new PDO("mysql:host=localhost;dbname=sample_database", "root", "");

// Mengecek apakah koneksi berhasil dibuka atau tidak
if (!$pdo) {
    die("Koneksi gagal: " . $pdo->connect_error);
}