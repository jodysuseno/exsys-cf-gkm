@extends('layout.main')

@section('container')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-user"></i> Data Admin</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Tambah Data Admin</h3>
        <div class="tile-body">
          <form>
            <div class="form-group">
              <input type="hidden" name="role" value="admin">
              <label class="control-label">Nama</label>
              <input class="form-control" type="text" name="nama">
            </div>
            <div class="form-group">
              <label class="control-label">Email</label>
              <input class="form-control" type="email" name="email">
            </div>
            <div class="form-group">
              <label class="control-label">password</label>
              <input class="form-control" type="password" name="password">
            </div>
            <div class="form-group">
              <label class="control-label">repassword</label>
              <input class="form-control" type="password" name="repassword">
            </div>
            <div class="form-group">
              <label class="control-label">NIP</label>
              <input class="form-control" type="number" name="nip">
            </div>
            <div class="form-group">
              <label class="control-label">Telp</label>
              <input class="form-control" type="number" name="phone">
            </div>
            <div class="form-group">
              <label class="control-label">Gender</label>
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="gender" checked>Male
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="gender">Female
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Identity Proof</label>
              <input class="form-control" type="file">
            </div>
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox">I accept the terms and conditions
                </label>
              </div>
            </div>
          </form>
        </div>
        <div class="tile-footer">
          <button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection