@include('layouts.include_page_header')
@include('layouts.include_sidebar')

<style>
span#container-api-request-title {
    all: revert;
}

span#container-api-response-title {
    all: revert;
}
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Telco Test</h1>
        <!--
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        -->
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Request Data</h5>

                        <div id="alert-telco-request-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            Please check your input form. Make sure all input fields are filled.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div id="alert-telco-login-needed" class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            Login API needed.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div id="alert-telco-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            <span id="alert-telco-error-message"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <form id="form-request-v01" class="row g-3 needs-validation" method="POST" action="{{ route('telco_v01.send') }}">
                            {{ csrf_field() }}
                            
                            <div class="col-lg-6">
                                <div class="col-md-12 input-client-id">
                                    <div class="form-floating">
                                        <input type="text" class="form-control input-fields bg-light disabled" id="input-client-id" name="input_client_id" placeholder="Client ID" value="{{ $profile->client_id }}" readonly="readonly">
                                        <label for="input-client-id">Client ID</label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3 input-transaction-id">
                                  <div class="form-floating">
                                    <input type="text" class="form-control input-fields" id="input-transaction-id" name="input_transaction_id" placeholder="Transaction ID" value="{{ old('input_transaction_id') }}" required>
                                    <label for="input-transaction-id">Transaction ID</label>
                                  </div>
                                </div>
                                
                                <div class="col-md-12 mt-3 input-consent">
                                    <div class="form-floating">
                                        <input type="text" class="form-control input-fields" id="input-consent" name="input_consent" placeholder="Consent" value="{{ old('input_consent') }}" required>
                                        <label for="input-consent">Consent</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <!-- product ids -->
                                <div class="col-md-12 input-product-id">
                                    <div class="form-floating">
                                        <select class="form-select" id="input-product-id" name="input_product_id" aria-label="State" required>
                                            <option value=""></option>
                                            @foreach ($products AS $keyProduct => $valueProduct)
                                            <option value="{{ $valueProduct->telco_name }}">{{ $valueProduct->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="input-product-id">Product API</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mt-3 input-rows input-msisdn">
                                    <div class="form-floating">
                                        <input type="number" class="form-control input-fields" id="input-msisdn" name="input_msisdn" min="1000000000000" max="6289999999999" placeholder="62812xxxxxxxx, 62821xxxxxxxx">
                                        <label for="input-msisdn">MSISDN / Key (eg. 62812xxxxxxxx)</label>
                                    </div>
                                </div>
                                
                                <!-- location scoring -->
                                <div class="col-md-12 mt-3 input-rows input-location-scoring-address-type">
                                    <fieldset class="row">
                                        <legend class="col-form-label col-sm-3 pt-0">Address Info</legend>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radio_home_work" id="radio-home-work-yes" value="1">
                                                <label class="form-check-label" for="radio-home-work-yes">
                                                    Home
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radio_home_work" id="radio-home-work-no" value="0">
                                                <label class="form-check-label" for="radio-home-work-no">
                                                    Work
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                    
                                <div class="col-md-12 mt-3 input-rows input-location-scoring-address-info">
                                    <fieldset class="row">
                                        <legend class="col-form-label col-sm-3 pt-0">Address Type</legend>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radio_address_info" id="radio-address-info-geolocation" value="geolocation">
                                                <label class="form-check-label" for="radio-address-info-geolocation">
                                                    Geolocation
                                                </label>
                                            </div>
                        
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radio_address_info" id="radio-address-info-address" value="address">
                                                <label class="form-check-label" for="radio-address-info-address">
                                                    Address
                                                </label>
                                            </div>
                        
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radio_address_info" id="radio-address-info-zipcode" value="zipcode">
                                                <label class="form-check-label" for="radio-address-info-zipcode">
                                                    ZIP Code
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mt-3 input-rows input-location-scoring row-address-info row-address-info-geolocation">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="input-latitude" name="input_latitude" placeholder="-6.247895">
                                            <label for="input-latitude">Latitude</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-3 input-rows input-location-scoring row-address-info row-address-info-geolocation">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="input-longitude" name="input_longitude" placeholder="106.821312">
                                            <label for="input-longitude">Longitude</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3 input-rows input-location-scoring row-address-info row-address-info-address">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Address" id="input-address" name="input_address" style="height:100px;"></textarea>
                                        <label for="input-address">Address</label>
                                    </div>
                                </div>
                    
                                <div class="col-md-12 mt-3 input-rows input-location-scoring row-address-info row-address-info-zipcode">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="input-zip-code" name="input_zip_code" min="10000" max="99999" maxlength="5" placeholder="ZIP Code">
                                        <label for="input-zip-code">ZIP Code</label>
                                    </div>
                                </div>
                    
                                <!-- ktp match -->
                                <div class="col-md-12 mt-3 input-rows input-ktp-match">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="input-nik" name="input_nik" min="1000000000000000" max="9999999999999999" maxlength="16" placeholder="NIK">
                                        <label for="input-nik">Nomor Induk Kependudukan (NIK)</label>
                                    </div>
                                </div>
                    
                                <!-- last location -->
                                <div class="col-md-12 mt-3 input-rows input-last-location">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="input-param" name="input_param" maxlength="30" placeholder="Param (name of city to check)">
                                        <label for="input-param">Param (name of city to check)</label>
                                    </div>
                                </div>
                
                                <!-- telco ses -->
                                <div class="col-md-12 mt-3 input-rows input-interest input-telco-ses">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="input-partner-name" name="input_partner_name" maxlength="30" placeholder="Partner Name">
                                        <label for="input-partner-name">Partner Name</label>
                                    </div>
                                </div>
                    
                                <div class="col-md-12 mt-3 input-rows input-telco-ses">
                                    <div class="form-floating">
                                        <input type="text" class="form-control input-fields" id="input-consent-id" name="input_consent_id" maxlength="30" placeholder="Consent ID">
                                        <label for="input-consent-id" class="col-form-label">Consent ID</label>
                                    </div>
                                </div>
                    
                                <!-- 1-imei-multiple-number -->
                                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                                    <div class="form-floating">
                                        <input type="number" class="form-control input-fields" id="input-imei" name="input_imei" min="6280000000000" max="999999999999999" value="" placeholder="350742139251246">
                                        <label for="input-imei">IMEI / Key (eg. 350742139251246)</label>
                                    </div>
                                </div>
                
                                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="input-param-1-imei-multiple-number" name="input_param_1_imei_multiple_number" maxlength="30" placeholder="Param (number of previous days to check)">
                                        <label for="input-param-1-imei-multiple-number">Param (number of previous days to check)</label>
                                    </div>
                                </div>
                    
                                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                                    <div class="form-floating">
                                        <input type="number" class="form-control input-fields" id="input-min" name="input_min" min="0" max="9" maxlength="1" placeholder="Min (count of min. phone numbers to check)">
                                        <label for="input-min" class="col-form-label">Min (count of min. phone numbers to check)</label>
                                    </div>
                                </div>
                    
                                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                                    <div class="form-floating">
                                        <input type="number" class="form-control input-fields" id="input-max" name="input_max" min="0" max="9" placeholder="Max (count of max. phone numbers to check)">
                                        <label for="input-max" class="col-form-label">Max (count of max. phone numbers to check)</label>
                                    </div>
                                </div>
                
                                <!-- telco score bin 25 -->
                                <div class="col-md-12 mt-3 input-rows input-telco-score-bin-25">
                                    <fieldset class="row">
                                        <legend class="col-form-label col-sm-3 pt-0">SRD Flag</legend>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radio_srd_flag" id="radio-srd-flag-yes" value="1">
                                                <label class="form-check-label" for="radio-srd-flag-yes">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radio_srd_flag" id="radio-srd-flag-no" value="0">
                                                <label class="form-check-label" for="radio-srd-flag-no">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            {{--
                            <div class="col-lg-12">
                                <textarea class="form-control" style="height:100px;" readonly>{{ session('api_token') }}</textarea>
                            </div>
                            --}}

                            <hr>

                            <div class="text-center">
                                <button type="submit" id="btn-submit" class="btn btn-primary btn-modal-spinner">Submit</button>
                                <input type="hidden" id="selected-product" name="selected-product" value="">
                                <input type="hidden" id="selected-address-info" name="selected-address-info" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Request for <span id="container-api-request-title"></span></h5>

                        <form class="row g-3" id="form-input" name="form-input">
                            <div class="col-12">
                                <label for="container-request-raw-data" class="form-label">Raw Data</label>
                                <textarea class="form-control" id="container-request-raw-data" style="height:428px;" readonly></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Response for <span id="container-api-response-title"></span></h5>
              
                        <form class="row g-3">
                            <div class="col-12">
                                <label for="container-respond-raw-data" class="form-label">Raw Data</label>
                                <textarea class="form-control" id="container-respond-raw-data" style="height:280px;" readonly></textarea>
                            </div>
                
                            <div class="col-12">
                                <label for="container-respond-deciphered-ciphertext" class="form-label">Result Data</label>
                                <textarea class="form-control" id="container-respond-deciphered-ciphertext" style="height:100px;" readonly></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@push('javascript')
<script type="text/javascript">
var prevApiResponses = [];
var selectedProduct = $('#selected-product').val().toLowerCase();

function prepareProductsDropDown() {
    $('#input-product-id').change(function(e) {
        $('#selected-product').val(($(this).val()));
        selectedProduct = $('#selected-product').val().toLowerCase();
        // console.log(selectedProduct);
        updateForm();
    });
};

function updateForm() {
    $('.row-address-info').hide();
    $('.input-rows').hide();
    $('.input-rows').removeAttr('required');
    
    var title = '';
    var apiRequest = '';
    var apiResponse = '';
    var apiResult = '';
    var prevApi = undefined;

    if (selectedProduct.trim() !== '') {
        switch(selectedProduct) {
            case 'idver':
                $('.input-msisdn').attr('required', 'required'); $('.input-msisdn').show();
                $('.input-location-scoring-address-type').show();
                $('.input-location-scoring-address-info').show();
                title = 'Location Scoring';
                break;
            case 'ktpscore': $('.input-msisdn').show(); $('.input-ktp-match').show(); title = 'KTP Match'; break;
            case 'recycle': $('.input-msisdn').show(); $('.input-recycle-number').show(); title = 'Recycle Number'; break;
            case 'roaming2': $('.input-msisdn').show(); $('.input-active-roaming').show(); title = 'Active Roaming'; break;
            case 'lastloc2': $('.input-msisdn').show(); $('.input-last-location').show(); title = 'Last Location'; break;
            case 'loyalist': $('.input-msisdn').show(); $('.input-interest').show(); title = 'Interest'; break;
            case 'telcoses': $('.input-msisdn').show(); $('.input-telco-ses').show(); title = 'TelcoSES'; break;
            case 'substat2': $('.input-msisdn').show(); title = 'Active Status'; break;
            case 'numberswitching2': $('.input-msisdn').hide(); $('.input-one-imei-multiple-number').show(); title = '1 IMEI Multiple Number'; break;
            case 'forwarding2': $('.input-msisdn').show(); title = 'Call Forwarding Status'; break;
            case 'simswap': $('.input-msisdn').show(); title = 'SIM Swap'; break;
            case 'tscore': $('.input-telco-score-bin-25').show(); title = 'Telco Score BIN 25'; break;
        }

        prevApi = prevApiResponses[selectedProduct];
        // console.log(prevApi);
    }

    if (prevApi !== undefined) {
        if (prevApi.api_request !== undefined) {
            apiRequest = prevApi.data.api_request;
        }
        
        if (prevApi.api_response !== undefined) {
            apiResponse = prevApi.data.api_response;
        }

        if (prevApi.api_result !== undefined) {
            apiResult = prevApi.data.api_result;
        }
    }
    
    $('#container-api-request-title').text(title);
    $('#container-api-response-title').text(title);
    $('#container-request-raw-data').val(JSON.stringify(apiRequest));
    $('#container-respond-raw-data').val(JSON.stringify(apiResponse));
    $('#container-respond-deciphered-ciphertext').val(JSON.stringify(apiResult));
};

function prepareAddressType() {
    $("input[name='radio_home_work']").click(function(e) {
        $('#selected-product').val(($(this).val()));
        selectedProduct = $('#selected-product').val().toLowerCase();
    });
};

function prepareAddressInfo() {
    $('input[name="radio_address_info"]').click(function(e) {
        var addressInfo = $('#selected-address-info').val($(this).val());
        
        $('.row-address-info').hide();
        
        switch(addressInfo.val()) {
            case 'geolocation': $('.row-address-info-geolocation').show(); break;
            case 'address': $('.row-address-info-address').show(); break;
            case 'zipcode': $('.row-address-info-zipcode').show(); break;
            default: break;
        }
    });
};

function prepareSubmitButton() {
    $('#btn-submit').click(function(e) {
        e.preventDefault();

        var okSubmit = true;

        $('#alert-telco-login-needed').hide();
        if ($('#input-transaction-id').val().trim() === '') okSubmit = false;
        if ($('#input-consent').val().trim() === '') okSubmit = false;
        
        if (okSubmit) {
            $('#alert-telco-request-error').hide();
            
            var theForm = $('form#form-request-v01')[0];
            var formData = new FormData(theForm);
            submitData(formData);
        }
        else {
            $('#alert-telco-request-error').show();
        }
    });
};

function submitData(formData) {
    $('#btn-submit').prop('disabled', true);
    $('#container-request-raw-data').empty();
    $('#container-respond-raw-data').empty();
    $('#container-respond-deciphered-ciphertext').empty();

    $('#alert-telco-error-message').text('');
    $('#alert-telco-error').hide();
    
    $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        url: '{{ route('telco_v01.send') }}',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            // console.log(apiResponse);

            if (response.code !== 200) {
                // console.log(apiResponse.message);
                $('#alert-telco-error-message').text(response.message);
                $('#alert-telco-error').show();
            }
            else {
                if (response.data.api_request !== undefined) {
                    $('#container-request-raw-data').val(JSON.stringify(response.data.api_request));
                }
                
                if (response.data.api_response !== undefined) {
                    $('#container-respond-raw-data').val(JSON.stringify(response.data.api_response));
                }

                if (response.data.api_result !== undefined) {
                    $('#container-respond-deciphered-ciphertext').val(JSON.stringify(response.data.api_result));
                }
                else {
                    $('#container-respond-deciphered-ciphertext').val('');
                }

                prevApiResponses[selectedProduct] = response;
                // console.log(prevApiResponses);
            }
        },
        error: function(error) {
            console.log('error: ' + error.responseText);
            $('#alert-telco-error-message').text(error.responseText);
            $('#alert-telco-error').show();
            $('#container-respond-raw-data').val(JSON.stringify(error.responseText));
        }
    })
    .always(function() {
        $('#btn-submit').prop('disabled', false);
        hideProgressScreen();
    });
};

$(document).ready(function() {
    prepareProductsDropDown();
    prepareAddressType();
    prepareAddressInfo();
    prepareSubmitButton();
    
    $('#input-product-id').val('').trigger('change');

    $('.btn-modal-spinner').click(function(e) {
        showProgressScreen();
    });
});
</script>
@endpush

@include('layouts.include_page_footer')
@include('layouts.include_js')