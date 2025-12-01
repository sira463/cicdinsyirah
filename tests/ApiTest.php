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
                // Pastikan data kosong di-encode sebagai '{}' untuk PUT/DELETE
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
     *  Tambah kontak dengan data valid (Create)
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
        
        // Simpan ID yang baru dibuat
        self::$lastInsertId = $searchResponse['data'][0]['id']; 
    }

    /**
     *  Validasi Nama tidak boleh kosong
     */
    public function testValidateNoName()
    {
        $data = ['nama' => '', 'telepon' => '08123', 'email' => 'a@gmail.com'];
        $response = $this->makeApiCall('POST', $data);
        $this->assertEquals('error', $response['status']);
        $this->assertStringContainsString('Nama tidak boleh kosong', $response['message'], "TC-04 Gagal");
    }

    /**
     *  Validasi No HP hanya boleh angka
     */
    public function testValidatePhoneFormat()
    {
        $data = ['nama' => 'Test Nama', 'telepon' => '08ABCD123', 'email' => 'a@gmail.com'];
        $response = $this->makeApiCall('POST', $data);
        $this->assertEquals('error', $response['status']);
        $this->assertStringContainsString('Nomor Telepon hanya boleh angka', $response['message'], "TC-06 Gagal");
    }

    /**
     *  Validasi Email tidak valid (tidak ada @gmail.com)
     */
    public function testValidateEmailFormat()
    {
        $data = ['nama' => 'Test Nama', 'telepon' => '08123', 'email' => 'dedimail.com'];
        $response = $this->makeApiCall('POST', $data);
        $this->assertEquals('error', $response['status']);
        $this->assertStringContainsString('Format email tidak valid', $response['message'], "TC-07 Gagal");
    }
    
    /**
     *  Pencarian Kontak (Read)
     */
    public function testReadSearchContact()
    {
        //  Pencarian yang berhasil (cari 'Andi')
        $responseSuccess = $this->makeApiCall('GET', [], 'Andi');
        $this->assertEquals('success', $responseSuccess['status']);
        // Asumsi data 'Andi' sudah ada di database
        $this->assertGreaterThanOrEqual(1, count($responseSuccess['data']), "TC-08 Gagal: Kontak 'Andi' tidak ditemukan."); 

        //  Pencarian yang gagal (cari 'Xyz')
        $responseFail = $this->makeApiCall('GET', [], 'Xyz');
        $this->assertEquals('success', $responseFail['status']);
        $this->assertCount(0, $responseFail['data'], "TC-09 Gagal: Pencarian 'Xyz' seharusnya kosong.");
    }

    /**
     *  Edit kontak (Update)
     * 
     */
    public function testUpdateContact()
    {
        $this->assertNotNull(self::$lastInsertId, "ID Kontak dibutuhkan untuk TC-10/11.");

        
        $validUpdateData = [
            'id' => self::$lastInsertId,
            'nama' => 'Test Update OK', // Nama baru
            'telepon' => '08999999999',
            'email' => 'update.ok@gmail.com'
        ];
        
        
        $response = $this->makeApiCall('PUT', $validUpdateData);

        // Cek apakah update berhasil
        $this->assertEquals('success', $response['status'], 
            "TC-10 Gagal: Update valid. Pesan: " . ($response['message'] ?? 'N/A')
        );
        
        // Cek apakah data di database sudah berubah
        $verificationResponse = $this->makeApiCall('GET', [], 'Test Update OK');
        
        $this->assertEquals(1, count($verificationResponse['data']), "TC-11 Gagal: Kontak hasil update tidak ditemukan.");
        $updatedContact = $verificationResponse['data'][0];
        
        $this->assertEquals('Test Update OK', $updatedContact['nama'], "TC-11 Gagal: Nama tidak terupdate.");
        $this->assertEquals('08999999999', $updatedContact['telepon'], "TC-11 Gagal: Telepon tidak terupdate.");
        $this->assertEquals('update.ok@gmail.com', $updatedContact['email'], "TC-11 Gagal: Email tidak terupdate.");
    }

    /**
     *  Hapus kontak (Delete)
     * 
     */
    public function testDeleteContact()
    {
        $this->assertNotNull(self::$lastInsertId, "ID Kontak dibutuhkan untuk TC-12.");

        $deleteData = ['id' => self::$lastInsertId];
        
        
        $response = $this->makeApiCall('DELETE', $deleteData);

        //  Cek apakah delete berhasil
        $this->assertEquals('success', $response['status'], 
            "TC-12 Gagal: Delete kontak. Pesan: " . ($response['message'] ?? 'N/A')
        );

        
        $verificationResponse = $this->makeApiCall('GET', [], 'Test Update OK'); 
        
        $this->assertCount(0, $verificationResponse['data'], "TC-12 Gagal: Kontak masih ditemukan setelah dihapus.");
        
        
        self::$lastInsertId = null;
    }
}
