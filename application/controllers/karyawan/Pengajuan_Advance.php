<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Pengajuan_Advance extends CI_Controller {

		public function __construct()
		{
			parent::__construct();
			$this->load->model('PengajuanModel');
		}
	
		public function index()
		{
			// print_r($_SESSION['level']);exit;
			$this->load->view('_partials/head');
			$this->load->view('_partials/navbar');
			$this->load->view('_partials/sidebar');
			if($_SESSION['level'] = 2){
				$this->load->view('karyawan/pengajuan_advance');
			} else {
				$this->load->view('direktur/pengajuan_advance');
			}
			$this->load->view('_partials/footer');
			$this->load->view('_partials/plugin');
			if($_SESSION['level'] = 2){
				$this->load->view('services/karyawan/pengajuan_advance');
			} else {
				$this->load->view('services/karyawan/pengajuan_advance');
			}
			
		}

		public function get_no()
		{
			$data = $this->PengajuanModel->get_no_pengajuan();
			echo json_encode($data);
		}

		public function new_pengajuan()
		{
			$data['no_pengajuan'] = $this->input->post('no_pengajuan');
			$data['jumlah_uang'] = $this->input->post('jumlah_uang');
			$data['keterangan'] = $this->input->post('keterangan');
			$data['id_karyawan'] =$this->session->userdata('id');
			$data['status'] = 0;
			$data['tgl_pengajuan'] = date('Y-m-d H:i:s');

			$res = $this->PengajuanModel->new_pengajuan($data);
			
			$respond = array(
				'status' => 'success',
				'title' => 'SUKSES !!!',
				'message' => 'Pengajuan Berhasil',
			 );
			echo json_encode($respond);
		}

		public function new_detail_pengajuan()
		{
			$id = $this->input->post('id');
			$data['id_pengajuan'] = $this->input->post('id');
			$data['deskripsi'] = $this->input->post('deskripsi');
			$data['qty'] = $this->input->post('qty');
			$data['satuan'] = $this->input->post('satuan');
			$data['biaya'] = $this->input->post('biaya');

			$jumlah = $this->db->get_where('pengajuan', array('id' => $id))->row();
			$total = $this->PengajuanModel->validasi_saldo($id);

			if (($total->total + ($data['biaya'] * $data['qty'])) > $jumlah->jumlah_uang) {
				$respond = array(
					'status' => 'warning',
					'title' => 'GAGAL !!!',
					'message' => 'Jumlah Uang Melebihi Saldo Pengajuan',
					'id' => $data['id_pengajuan'],
				 );
			}else{

				$res = $this->PengajuanModel->new_detail_pengajuan($data);
				
				$respond = array(
					'status' => 'success',
					'title' => 'SUKSES !!!',
					'message' => 'Pengajuan Berhasil',
					'id' => $data['id_pengajuan'],
				 );
			}
			echo json_encode($respond);
		}

		public function edit_pengajuan()
		{
			$id = $this->input->post('id');
			$data['jumlah_uang'] = $this->input->post('jumlah_uang');
			$data['keterangan'] = $this->input->post('keterangan');

			$res = $this->PengajuanModel->edit_pengajuan($data, $id);
			
			$respond = array(
				'status' => 'success',
				'title' => 'SUKSES !!!',
				'message' => 'Berhasil Diubah',
			 );
			echo json_encode($respond);
		}

		public function view_pengajuan()
		{
			$html = '';
			$id = '';
			if ($this->session->userdata('level') == 2) {
				$id = $this->session->userdata('id');
			}
			$data = $this->PengajuanModel->view_pengajuan_advance($id);

			foreach ($data as $dp) {
				if ($dp->status == 0) {
    				$badge = '<button class="badge badge-secondary edit_pengajuan mb-1 mr-lg-1" data-id="'.$dp->id.'" data-no="'.$dp->no_pengajuan.'" data-uang="'.$dp->jumlah_uang.'" data-keterangan="'.$dp->keterangan.'">'.$dp->status_pengajuan.'</button>
							<button class="badge badge-info lihat_detail ml-lg-1 mb-1" data-id="'.$dp->id.'" data-no="'.$dp->no_pengajuan.'" data-uang="Rp. '.number_format($dp->jumlah_uang).'" data-keterangan="'.$dp->keterangan.'">Detail</button>
							</button>
							<button class="badge badge-warning proses_pengajuan ml-lg-1 mb-1" data-id="'.$dp->id.'">Kirim</button>';
    			}if ($dp->status == 1) {
    				$badge = '<button class="badge badge-warning">'.$dp->status_pengajuan.'</button><button class="badge badge-primary lihat_detail ml-lg-1 mb-1" data-id="'.$dp->id.'" data-no="'.$dp->no_pengajuan.'" data-uang="Rp. '.number_format($dp->jumlah_uang).'" data-keterangan="'.$dp->keterangan.'">Cetak</button>';
    			}if ($dp->status == 2) {
    				$badge = '<button class="badge badge-danger">'.$dp->status_pengajuan.'</button>';
    			}if ($dp->status == 3) {
    				$badge = '<button class="badge badge-success">'.$dp->status_pengajuan.'</button>';
    			}
				$html .= '<tr>
							<th class="text-center align-middle">'.$dp->no_pengajuan.'</th>
							<td class="align-middle">'.date('d-m-Y', strtotime($dp->tgl_pengajuan)).'</td>
							<td class="align-middle">Rp. '.number_format($dp->jumlah_uang).'</td>
							<td class="align-middle">'.$dp->keterangan.'</td>
							<td class="align-middle text-center">'.$badge.'</td>
						</tr>';
			}
			echo $html;
		}

		public function view_detail_pengajuan()
		{
			$html = '';
			$id = $this->input->post('id');

			$data = $this->PengajuanModel->view_detail_pengajuan_advance($id);
			$no = 1;
			foreach ($data as $dp) {
				
				$html .= '<tr>
							<th class="text-center align-middle">'.$no++.'</th>
							<th class="align-middle">'.$dp->deskripsi.'</th>
							<td class="align-middle">'.$dp->qty.' '.$dp->satuan.'</td>
							<td class="align-middle">Rp. '.number_format($dp->biaya).'</td>
							<td class="align-middle">Rp. '.number_format($dp->biaya * $dp->qty).'</td>
							<td class="align-middle text-center"><a class="delete-detail" style="cursor:pointer" data-id="'.$dp->id.'" data-id_pengajuan="'.$id.'"><span class="fa fa-trash-alt text-danger"></span></a></td>
						</tr>';

			}

			echo $html;
		}

		public function delete_detail()
		{
			$id = $this->input->post('id');
			$id_pengajuan = $this->input->post('id_pengajuan');
			$data = $this->PengajuanModel->delete_detail_pengajuan_advance($id);

			$response = array(
				'status' => 'success',
				'title' => 'SUKSES !!!',
				'message' => 'Hapus Detail Berhasil',
				'id' => $id_pengajuan,
			);

			echo json_encode($response);
		}

		public function grand_total_biaya()
		{
			$id = $this->input->post('id');

			$data = $this->PengajuanModel->validasi_saldo($id);
			echo 'Rp. '.number_format($data->total);
		}

		public function proses_pengajuan()
		{
			$id = $this->input->post('id');
			$data['status'] = 1;
			$this->PengajuanModel->edit_pengajuan($data, $id);

			$response = array(
				'status' => 'success',
				'title' => 'SUKSES !!!',
				'message' => 'Berhasil Di Proses Silahkan Tunggu Pengajuan Berhasil Di Verifikasi',
			);

			echo json_encode($response);
		}
	
	}
	
	/* End of file Pengajuan_Advance.php */
	/* Location: ./application/controllers/karyawan/Pengajuan_Advance.php */
?>