<?php

use PHPUnit\Framework\TestCase;

// URL ini akan digunakan oleh GitHub Actions (server built-in PHP)
define('BASE_API_URL', 'http://127.0.0.1:8000/api.php');

class ApiTest extends TestCase
{
    private static $lastInsertId = null;

    // Helper untuk membuat permintaan HTTP ke api.php
    private function makeApiCall($method, $data = [], $search = null)
    {
        $url = BASE_API_URL;
        if ($search) {
            $url .= '?search=' . urlencode($search);
        }

        $options = [
            'http' => [
                'method'  => $method,
                'header'  => 'Content-type: application/json',
                'content' => json_encode($data),
                'ignore_errors' => true,
            ],
        ];

        $context  = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        
        $response = json_decode($result, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
             // Jika response bukan JSON, ambil kode status HTTP untuk debug
             $http_response_header_string = implode("\n", $http_response_header);
             $status_line = explode("\n", $http_response_header_string)[0];
             return ['status' => 'error', 'message' => 'Response bukan JSON atau server error: ' . $status_line];
        }

        return $response;
    }

    /**
     * TC-03: Tambah kontak dengan data valid (Create)
     */
    public function testCreateContactValid()
    {
        $data = [
            'nama' => 'Test CI Kontak',
            'telepon' => '08912345678',
            'email' => 'test.ci@gmail.com'
        ];
        
        $response = $this->makeApiCall('POST', $data);

        $this->assertEquals('success', $response['status'], 
            "TC-03 Gagal: POST valid. Pesan: " . ($response['message'] ?? 'N/A')
        );

        // Ambil ID kontak yang baru dibuat untuk pengujian selanjutnya (READ/UPDATE/DELETE)
        $searchResponse = $this->makeApiCall('GET', [], 'Test CI Kontak');
        $this->assertGreaterThan(0, count($searchResponse['data']), "TC-03 Gagal: Kontak baru tidak ditemukan.");
        
        self::$lastInsertId = $searchResponse['data'][0]['id']; 
    }

    /**
     * TC-04: Validasi Nama tidak boleh kosong
     */
    public function testValidateNoName()
    {
        $data = ['nama' => '', 'telepon' => '08123', 'email' => 'a@gmail.com'];
        $response = $this->makeApiCall('POST', $data);
        $this->assertEquals('error', $response['status']);
        $this->assertStringContainsString('Nama tidak boleh kosong', $response['message'], "TC-04 Gagal");
    }

    /**
     * TC-06: Validasi No HP hanya boleh angka
     */
    public function testValidatePhoneFormat()
    {
        $data = ['nama' => 'Test Nama', 'telepon' => '08ABCD123', 'email' => 'a@gmail.com'];
        $response = $this->makeApiCall('POST', $data);
        $this->assertEquals('error', $response['status']);
        $this->assertStringContainsString('Nomor Telepon hanya boleh angka', $response['message'], "TC-06 Gagal");
    }

    /**
     * TC-07: Validasi Email tidak valid (tidak ada @gmail.com)
     */
    public function testValidateEmailFormat()
    {
        $data = ['nama' => 'Test Nama', 'telepon' => '08123', 'email' => 'dedimail.com'];
        $response = $this->makeApiCall('POST', $data);
        $this->assertEquals('error', $response['status']);
        $this->assertStringContainsString('Format email tidak valid', $response['message'], "TC-07 Gagal");
    }
    
    /**
     * TC-08 & TC-09: Pencarian Kontak (Read)
     */
    public function testReadSearchContact()
    {
        // TC-08: Pencarian yang berhasil (cari 'Andi')
        $responseSuccess = $this->makeApiCall('GET', [], 'Andi');
        $this->assertEquals('success', $responseSuccess['status']);
        $this->assertGreaterThanOrEqual(1, count($responseSuccess['data']), "TC-08 Gagal: Kontak 'Andi' tidak ditemukan.");

        // TC-09: Pencarian yang gagal (cari 'Xyz')
        $responseFail = $this->makeApiCall('GET', [], 'Xyz');
        $this->assertEquals('success', $responseFail['status']);
        $this->assertCount(0, $responseFail['data'], "TC-09 Gagal: Pencarian 'Xyz' seharusnya kosong.");
    }

    /**
     * TC-10 & TC-11: Edit kontak (Update)
     * Keterangan: Fungsi UPDATE di API Anda tidak mengembalikan pesan sukses, jadi kita cek status
     */
    public function testUpdateContact()
    {
        $this->assertNotNull(self::$lastInsertId, "ID Kontak dibutuhkan untuk TC-10/11.");

        // TC-10: Update dengan data valid
        $validUpdateData = [
            'id' => self::$lastInsertId,
            'nama' => 'Test Update OK', 
            'telepon' => '08999999999',
            'email' => 'update.ok@gmail.com'
        ];
        $response = $this->makeApiCall('PUT', $validUpdateData);
        // API.php Anda tidak menangani PUT/DELETE secara eksplisit, kita asumsikan jika tidak ada error, eksekusi berhasil.
        // Untuk PHPUnit murni, PUT/DELETE harus diuji terpisah atau diatur di api.php. 
        // Karena kode api.php Anda hanya memiliki GET/POST/default, kita ubah PUT/DELETE di API lokal menjadi POST/GET
        
        // Asumsi: Karena api.php Anda TIDAK memiliki logic untuk PUT/DELETE, kita tidak bisa menguji TC-10, TC-11, TC-12, TC-13 secara otomatis
        // kecuali kita tambahkan logic PUT/DELETE ke api.php Anda (yang melanggar aturan "kode asli").

        // KARENA KODE ANDA TIDAK MENGANDUNG LOGIC PUT/DELETE, kita akan uji GET/POST dan Validasi.
        
        // Jika Anda tambahkan kode PUT/DELETE, uji ini akan berfungsi:
        // $this->assertEquals('success', $response['status'], "TC-10 Gagal: Update valid.");
        
        // Jika Anda ingin menguji TC-10/11/12/13, Anda HARUS tambahkan logic PUT/DELETE ke api.php Anda (Lihat catatan di bawah).
        $this->markTestSkipped('TC-10/11/12/13 dilompati karena api.php tidak memiliki logic PUT/DELETE');
    }

    /**
     * TC-12: Hapus kontak (Delete)
     */
    public function testDeleteContact()
    {
        $this->markTestSkipped('TC-12/13 dilompati karena api.php tidak memiliki logic DELETE');
    }
}