@extends('zainiklab.installer.layout')

@section('title', 'Configuration')

@section('content')
<div class="section-wrap-body">

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{$errors->first()}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="primary-form">
      <form action="{{ route('ZaiInstaller::final') }}" method="POST">
        @csrf
        <div class="single-section">
          <h4 class="section-title">Please enter your application details</h4>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="AppName">App Name</label>
                <input type="text" class="form-control" id="AppName" name="app_name" value="{{ $_ENV['APP_NAME'] }}" placeholder="ZaiInstaller" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="AppURL">App URL</label>
                <input type="text" class="form-control" id="AppURL" name="app_url" value="{{ $_ENV['APP_URL'] }}" placeholder="http://localhost:8000" />
              </div>
            </div>
          </div>
        </div>
        <div class="single-section">
            <h4 class="section-title">Please enter your database connection details</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="DatabaseHost">Database Host</label>
                  <input type="text" class="form-control" id="DatabaseHost" name="db_host" value="{{ $_ENV['DB_HOST'] }}" placeholder="localhost" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="DatabaseUser">Database User</label>
                  <input type="text" class="form-control" id="DatabaseUser" name="db_user" value="{{ $_ENV['DB_USERNAME'] }}" placeholder="root" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="DatabaseName">Database Name</label>
                  <input type="text" class="form-control" id="DatabaseName" name="db_name" value="{{ $_ENV['DB_DATABASE'] }}" placeholder="zai_news" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="Password">Password</label>
                  <input type="password" class="form-control" id="Password" name="db_password" value="{{ $_ENV['DB_PASSWORD'] }}" placeholder="password" />
                </div>
              </div>
            </div>
        </div>
        <div class="single-section">
            <h4 class="section-title">Please enter your SMTP details</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailHost">Mail Host</label>
                  <input type="text" class="form-control" id="MailHost" name="mail_host" value="{{ $_ENV['MAIL_HOST'] }}" placeholder="mailhog" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailPort">Port</label>
                  <input type="text" class="form-control" id="MailPort" name="mail_port" value="{{ $_ENV['MAIL_PORT'] }}" placeholder="root" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailUsername">Username</label>
                  <input type="text" class="form-control" id="MailUsername" name="mail_username" value="{{ $_ENV['MAIL_USERNAME'] }}" placeholder="zai_news" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailPassword">Password</label>
                  <input type="password" class="form-control" id="MailPassword" name="mail_password" value="{{ $_ENV['MAIL_PASSWORD'] }}" placeholder="password" />
                </div>
              </div>
            </div>
        </div>
        <div class="single-section">
          <h4 class="section-title">Please enter your Item purchase code</h4>
          <div class="form-group">
            <label for="purchasecode">Item purchase code</label>
            <input type="text" class="form-control" id="purchasecode" name="purchasecode" value="NHLE-L6MI-4GE4-ETEV" placeholder="NHLE-L6MI-4GE4-ETEV" />
          </div>
        </div>
        <div class="row">
          <div class="col-6">
              <button class="primary-btn">Close</button>
          </div>
          <div class="col-6">
              <button class="primary-btn next" type="submit">Next</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
