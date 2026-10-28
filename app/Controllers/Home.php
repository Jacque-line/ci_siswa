<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $siswaModel = new SiswaModel();

        // Ambil urutan sorting (default: A - Z)
        $sort = $this->request->getGet('sort') === 'desc' ? 'DESC' : 'ASC';

        // Batasi 5 data per halaman dan urutkan berdasarkan nama
        $data['siswa'] = $siswaModel->orderBy('nama', $sort)->paginate(5);
        $data['pager'] = $siswaModel->pager;
        $data['sort']  = $sort;

        return view('siswa_view', $data);
    }

    // Method untuk menyimpan data siswa baru
    public function tambah()
    {
        $siswaModel = new SiswaModel();

        $siswaModel->save([
            'nis'   => $this->request->getPost('nis'),
            'nama'  => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        return redirect()->to(base_url());
    }

    // Method untuk memperbarui data siswa
    public function edit($id)
    {
        $siswaModel = new SiswaModel();

        // Memperbarui data berdasarkan ID dari masukan form
        $siswaModel->update($id, [
            'nis'   => $this->request->getPost('nis'),
            'nama'  => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        // Kembali ke halaman utama
        return redirect()->to(base_url());
    }

    // Method untuk menghapus data siswa
    public function hapus($id)
    {
        $siswaModel = new SiswaModel();

        // Hapus data berdasarkan ID
        $siswaModel->delete($id);

        // Kembali ke halaman utama
        return redirect()->to(base_url());
    }
}
