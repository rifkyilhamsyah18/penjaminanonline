<!-- Content Wrapper. Contains page content --> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengajuan Expanse</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url($this->session->userdata('link').'/Dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Pengajuan Expanse</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid mt-3">
        <div class="row">
          <div class="col-12">
            <div class="row">

                <div class="col-md-4">

                  <!-- <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control form-control-sm float-right" id="reservation">
                    </div>
                  </div> -->

                </div>
                
            </div>
            <div class="card mt-2">
              <!-- <div class="card-header">
                <h3 class="card-title">DAFTAR PENGAJUAN Expanse</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="pengajuan" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th class="align-middle">NO PENGAJUAN</th>
                      <th class="align-middle">TANGGAL</th>
                      <th class="align-middle">TOTAL PENGAJUAN</th>
                      <th class="align-middle">KETERANGAN</th>
                      <th class="align-middle">STATUS</th>
                    </tr>
                  </thead>
                  <tbody id="show_pengajuan">
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="selesaikan-pengajuan-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Selesaikan Pengajuan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <table>
              <tr>
                <td>No Pengajuan</td>
                <td class="px-2">:</td>
                <td id="view_no"></td>
              </tr>
              <tr>
                <td>Jumlah Uang</td>
                <td class="px-2">:</td>
                <td id="view_jum_uang"></td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td class="px-2">:</td>
                <td id="view_keterangan"></td>
              </tr>
            </table>
          </div>
          <div class="row mt-4 table-responsive">
            <table class="table table-sm table-bordered">
              <thead>
                <th class="text-center">No</th>
                <th>Deskripsi</th>
                <th>QTY</th>
                <th>Harga Satuan</th>
                <th colspan="3">Total</th>
              </thead>
              <tbody id="show_detail_pengajuan"></tbody>
              <tfoot>
                <th colspan="4" class="text-right">Grand Total</th>
                <th colspan="3" id="grand_total"></th>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
            <div class="row">
              <div class="col-md">
                <input type="hidden" name="id_pengajuan">
                <div class="form-group">
                  <label>Deskripsi</label>
                  <input type="text" class="form-control form-control-sm" name="deskripsi_detail">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">

                  <label>QTY</label>
                  <div class="input-group input-group-sm mb-3">
                    <input type="text" class="form-control form-control-sm" name="qty_detail">
                    <div class="input-group-prepend">
                      <select class="form-control form-control-sm" name="satuan_detail">
                        <option value="Unit">Unit</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Meter">Meter</option>
                        <option value="Liter">Liter</option>
                      </select>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-md">
                <div class="form-group">
                  <label>Biaya</label>
                  <input type="text" name="biaya_detail" class="form-control form-control-sm currency">
                </div>
              </div>

              <div class="col-md">
                <div class="form-group">
                  <label>Total Biaya</label>
                  <input type="text" class="form-control form-control-sm currency" id="total_biaya">
                </div>
              </div>
            </div>
            <button type="click" class="btn btn-sm btn-primary" id="btn-add-detail">Tambah</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="upload-detail-modal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title">Upload Pengajuan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-upload-pengajuan" method="POST">
              <input type="hidden" name="id_pengajuan_upload">
              <input type="hidden" name="id_upload">
              <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" class="form-control form-control-sm" name="deskripsi_detail_upload">
              </div>

              <div class="form-group">

                <label>QTY</label>
                <div class="input-group input-group-sm mb-3">
                  <input type="text" class="form-control form-control-sm" name="qty_detail_upload">
                  <div class="input-group-prepend">
                    <select class="form-control form-control-sm" name="satuan_detail_upload">
                      <option value="Unit">Unit</option>
                      <option value="Pcs">Pcs</option>
                      <option value="Meter">Meter</option>
                      <option value="Liter">Liter</option>
                    </select>
                  </div>
                </div>

              </div>

              <div class="form-group">
                <label>Biaya</label>
                <input type="text" name="biaya_detail_upload" class="form-control form-control-sm currency">
              </div>

              <div class="form-group">
                <label>Total Biaya</label>
                <input type="text" class="form-control form-control-sm currency" id="total_biaya_upload">
              </div>

              <div class="form-group">
                <label for="customFile">Upload Bukti</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="bukti_upload" id="customFile">
                  <label class="custom-file-label" for="customFile">Pilih File</label>
                </div>
              </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
          <button type="buttn" id="btn-upload-detail" class="btn btn-outline-light">Upload</button>
        </div>
          </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal