<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Pengajuan_Expanse extends CI_Controller {

		public function __construct()
		{
			parent::__construct();
			$this->load->model('AdminModel');
		}
	
		public function index()
		{
			$this->load->view('_partials/head');
			$this->load->view('_partials/navbar');
			$this->load->view('_partials/sidebar');
			$this->load->view('admin/pengajuan_expanse');
			$this->load->view('_partials/footer');
			$this->load->view('_partials/plugin');
			$this->load->view('services/admin/pengajuan_expanse');
		}

		public function view_pengajuan()
		{
			$html = '';
			$data = $this->AdminModel->view_pengajuan_expanse();

			foreach ($data as $dp) {
				if ($dp->status == 2) {
    				$badge = '<button class="badge badge-info selesaikan_pengajuan ml-lg-1 mb-1" data-id="'.$dp->id.'" data-no="'.$dp->no_pengajuan.'" data-uang="Rp. '.number_format($dp->jumlah_uang).'" data-keterangan="'.$dp->keterangan.'">Upload</button>
							</button>
							<button class="badge badge-warning proses_pengajuan ml-lg-1 mb-1" data-id="'.$dp->id.'">Kirim</button>';
    			}if ($dp->status == 3) {
    				$badge = '<button class="badge badge-warning">'.$dp->status_pengajuan.'</button>';
    			}if ($dp->status == 4) {
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

		public function view_detail_pengajuan_expanse()
		{
			$html = '';
			$id = $this->input->post('id');

			$data = $this->AdminModel->view_detail_pengajuan_expanse($id);
			$no = 1;
			foreach ($data as $dp) {

				if ($dp->foto != NULL) {
					$button = '<span class="fa fa-check text-success"></span>';
				}else{
					$button = '<a class="delete-detail ml-lg-1 mb-1" style="cursor:pointer" data-id="'.$dp->id.'" data-id_pengajuan="'.$id.'">
								<span class="fa fa-trash-alt text-danger"></span>
								</a>
								<a class="upload-detail ml-lg-1 mb-1" style="cursor:pointer" data-id="'.$dp->id.'" data-deskripsi="'.$dp->deskripsi.'" data-id_pengajuan="'.$id.'" data-qty="'.$dp->qty.'" data-satuan="'.$dp->satuan.'" data-biaya="'.$dp->biaya.'"><span class="fa fa-file-upload text-info"></span>
								</a>';
				}
				
				$html .= '<tr>
							<th class="text-center align-middle">'.$no++.'</th>
							<th class="align-middle">'.$dp->deskripsi.'</th>
							<td class="align-middle">'.$dp->qty.' '.$dp->satuan.'</td>
							<td class="align-middle">Rp. '.number_format($dp->biaya).'</td>
							<td class="align-middle">Rp. '.number_format($dp->biaya * $dp->qty).'</td>
							<td class="align-middle text-center">'.$button.'</td>
						</tr>';

			}

			echo $html;
		}

		public function grand_total_biaya_expanse()
		{
			$id = $this->input->post('id');

			$data = $this->AdminModel->validasi_saldo_expanse($id);
			echo 'Rp. '.number_format($data->total);
		}

	}
	/* End of file Pengajuan_Expanse.php */
	/* Location: ./application/controllers/karyawan/Pengajuan_Expanse.php */
?>