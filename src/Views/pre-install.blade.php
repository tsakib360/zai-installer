@extends('zainiklab.installer.layout')

@section('title', 'Home')

@section('content')
<div class="section-wrap-body">
    <div class="single-section">
        <h4 class="section-title">Please configure your PHP settings  to match following requirements</h4>
        <div class="primary-table">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">PHP Settings</th>
                        <th scope="col">Current Version</th>
                        <th scope="col">Required Version</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>PHP Version</td>
                        <td><strong>{{ phpversion() }}</strong></td>
                        <td><strong>7.2+</strong></td>
                        <td><span class="status {{ phpversion() < 7.2 ? 'error' : '' }}">{{ phpversion() < 7.2 ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="single-section">
        <h4 class="section-title">Please make sure the extension/settings listed below are installed/enabled</h4>
        <div class="primary-table">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Extensions/Settings</th>
                        <th scope="col">Current Settings</th>
                        <th scope="col">Required Settings</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>MySQLi</td>
                        <td><strong>{{ !extension_loaded('mysqli') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('mysqli') ? 'error' : '' }}">{{ !extension_loaded('mysqli') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>GD</td>
                        <td><strong>{{ !extension_loaded('gd') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('gd') ? 'error' : '' }}">{{ !extension_loaded('gd') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>cURL</td>
                        <td><strong>{{ function_exists('curl_version') ? 'On' : 'Off' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ function_exists('curl_version') ? '' : 'error' }}">{{ function_exists('curl_version') ? 'Ok' : 'Error' }}</span></td>
                      </tr>
                      <tr>
                        <td>allow_url_fopen</td>
                        <td><strong>{{ ini_get('allow_url_fopen') ? 'On' : 'Off' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ ini_get('allow_url_fopen') ? '' : 'error' }}">{{ ini_get('allow_url_fopen') ? 'Ok' : 'Error' }}</span></td>
                      </tr>
                      <tr>
                        <td>OpenSSL PHP Extension</td>
                        <td><strong>{{ !extension_loaded('openssl') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('openssl') ? 'error' : '' }}">{{ !extension_loaded('openssl') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>PDO PHP Extension</td>
                        <td><strong>{{ !extension_loaded('pdo') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('pdo') ? 'error' : '' }}">{{ !extension_loaded('pdo') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>BCMAth PHP Extension</td>
                        <td><strong>{{ !extension_loaded('bcmath') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('bcmath') ? 'error' : '' }}">{{ !extension_loaded('bcmath') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>Ctype PHP Extension</td>
                        <td><strong>{{ !extension_loaded('ctype') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('ctype') ? 'error' : '' }}">{{ !extension_loaded('ctype') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>Fileinfo PHP Extension</td>
                        <td><strong>{{ !extension_loaded('fileinfo') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('fileinfo') ? 'error' : '' }}">{{ !extension_loaded('fileinfo') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>MBstring PHP Extension</td>
                        <td><strong>{{ !extension_loaded('mbstring') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('mbstring') ? 'error' : '' }}">{{ !extension_loaded('mbstring') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>Tokenizer PHP Extension</td>
                        <td><strong>{{ !extension_loaded('tokenizer') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('tokenizer') ? 'error' : '' }}">{{ !extension_loaded('tokenizer') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>XML PHP Extension</td>
                        <td><strong>{{ !extension_loaded('xml') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('xml') ? 'error' : '' }}">{{ !extension_loaded('xml') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      <tr>
                        <td>Json PHP Extension</td>
                        <td><strong>{{ !extension_loaded('json') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('json') ? 'error' : '' }}">{{ !extension_loaded('json') ? 'Error' : 'Ok' }}</span></td>
                      </tr>
                      {{-- <tr>
                        <td>date.timezone</td>
                        <td><strong>{{ !extension_loaded('date.timezone') ? 'Off' : 'On' }}</strong></td>
                        <td><strong>On</strong></td>
                        <td><span class="status {{ !extension_loaded('date.timezone') ? 'error' : '' }}">{{ !extension_loaded('date.timezone') ? 'Error' : 'Ok' }}</span></td>
                      </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="single-section">
        <h4 class="section-title">Please make sure you have set  the Writable permission on the following folders/files :</h4>
        <ul class="permission-lsit">
            <li>
                <span class="permission-text">./routes</span>
                <span class="status {{ File::exists(base_path('routes')) && $route_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('routes')) && $route_value == 1 ? 'Ok' : 'Error' }}</span>
            </li>
            <li>
                <span class="permission-text">./resources</span>
                <span class="status {{ File::exists(base_path('resources')) && $resource_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('resources')) && $resource_value == 1 ? 'Ok' : 'Error' }}</span>
            </li>
            <li>
                <span class="permission-text">./public</span>
                <span class="status {{ File::exists(base_path('public')) && $public_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('public')) && $public_value == 1 ? 'Ok' : 'Error' }}</span>
            </li>
            <li>
                <span class="permission-text">./storage</span>
                <span class="status {{ File::exists(base_path('storage')) && $storage_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('storage')) && $storage_value == 1 ? 'Ok' : 'Error' }}</span>
            </li>
            <li>
                <span class="permission-text">.env</span>
                <span class="status {{ File::exists(base_path('.env')) && $env_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('.env')) && $env_value == 1 ? 'Ok' : 'Error' }}</span>
            </li>
        </ul>
    </div>
    <div>
        <div class="row">
            <div class="col-6">
                <button class="primary-btn">Close</button>
            </div>
            <div class="col-6">
                <form action="{{ route('ZaiInstaller::server-validation') }}" method="post">
                    @csrf
                    <input type="hidden" name="routes" value="{{ File::exists(base_path('routes')) && $route_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="resources" value="{{ File::exists(base_path('resources')) && $resource_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="public" value="{{ File::exists(base_path('public')) && $public_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="storage" value="{{ File::exists(base_path('storage')) && $storage_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="env" value="{{ File::exists(base_path('.env')) && $env_value == 1 ? 1 : 0 }}">
                    <button class="primary-btn next" type="submit">Next</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
