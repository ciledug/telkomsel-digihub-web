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
    <h1>Telco Stand-Alone (SA) Test</h1>
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

            <form id="form-request-v02" class="row g-3 needs-validation" method="POST" action="{{ route('telco_v02.send') }}">
              {{ csrf_field() }}

              <div class="col-lg-6">
                <div class="col-md-12 input-client-id">
                  <div class="form-floating">
                    <input type="text" class="form-control input-fields bg-light disabled" id="input-client-id" name="input_client_id" placeholder="Client ID" value="{{ $profile->client_id }}" required readonly="readonly">
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

                <div class="col-md-12 mt-3 input-enc-key">
                  <div class="form-floating">
                      <input type="text" class="form-control input-fields" id="input-enc-key" name="input_enc_key" placeholder="Encryption key from Telkomsel" value="Encryption key from Telkomsel" disabled="disabled">
                      <label for="input-enc-key">Encryption Key</label>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-6">
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

                <div class="col-md-12 mt-3 mb-3">
                  <div class="form-floating">
                    <textarea class="form-control" id="container-request-ciphered-text" name="input_ciphered_text" style="height:150px;" placeholder="Ciphered text" required>
                      {{ old('input_ciphered_text') }}
                    </textarea>
                    <label for="container-request-ciphered-text" class="form-label">Ciphered Text</label>
                  </div>
                </div>

                <div class="col-md-12 mt-3 mb-3 text-end">
                  <button type="button" id="btn-dialog-enc-dec-instructions" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#dialog-enc-dec-instructions">
                    Ciphered-Text Information
                  </button>
                </div>
                
                <!--
                <div class="col-md-12 input-rows input-msisdn">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-msisdn" name="input-msisdn" min="1000000000000" max="6289999999999" placeholder="62xxxxxxxxxxx">
                    <label for="input-msisdn">MSISDN / Key (628xxxxxxxxxxx)</label>
                  </div>
                </div>
                -->
                
                <!-- location scoring -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-location-scoring">
                  <fieldset class="row">
                    <legend class="col-form-label col-sm-3 pt-0">Address Type</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-home-work" id="radio-home-work-yes" value="1">
                        <label class="form-check-label" for="radio-home-work-yes">Home</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-home-work" id="radio-home-work-no" value="0">
                        <label class="form-check-label" for="radio-home-work-no">Work</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-location-scoring">
                  <fieldset class="row">
                    <legend class="col-form-label col-sm-3 pt-0">Address Info</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-address-info" id="radio-address-info-geolocation" value="geolocation">
                        <label class="form-check-label" for="radio-address-info-geolocation">Geolocation</label>
                      </div>
                      
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-address-info" id="radio-address-info-address" value="address">
                        <label class="form-check-label" for="radio-address-info-address">Address</label>
                      </div>
                      
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-address-info" id="radio-address-info-zipcode" value="zipcode">
                        <label class="form-check-label" for="radio-address-info-zipcode">ZIP Code</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                
                <div class="row">
                  <div class="col-md-6 mt-3 input-rows input-location-scoring row-address-info row-address-info-geolocation">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="input-latitude" name="input-latitude" placeholder="-6.247895">
                      <label for="input-latitude">Latitude</label>
                    </div>
                  </div>
                  
                  <div class="col-md-6 mt-3 input-rows input-location-scoring row-address-info row-address-info-geolocation">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="input-longitude" name="input-longitude" placeholder="106.821312">
                      <label for="input-longitude">Longitude</label>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-location-scoring row-address-info row-address-info-address">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" id="input-address" name="input-address" style="height:100px;"></textarea>
                    <label for="input-address">Address</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-location-scoring row-address-info row-address-info-zipcode">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="input-zip-code" name="input-zip-code" min="10000" max="99999" maxlength="5" placeholder="ZIP Code">
                    <label for="input-zip-code">ZIP Code</label>
                  </div>
                </div>
                -->
                

                <!-- ktp match -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-ktp-match">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="input-nik" name="input-nik" min="1000000000000000" max="9999999999999999" maxlength="16" placeholder="NIK">
                    <label for="input-nik">Nomor Induk Kependudukan (NIK)</label>
                  </div>
                </div>
                -->
                
                
                <!-- last location -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-last-location">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="input-param" name="input-param" maxlength="30" placeholder="Param (name of city to check)">
                    <label for="input-param">Param (name of city to check)</label>
                  </div>
                </div>
                -->
                
                
                <!-- telco ses -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-interest input-telco-ses">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="input-partner-name" name="input-partner-name" maxlength="30" placeholder="Partner Name">
                    <label for="input-partner-name">Partner Name</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-telco-ses">
                  <div class="form-floating">
                    <input type="text" class="form-control input-fields" id="input-consent-id" name="input-consent-id" maxlength="30" placeholder="Consent ID">
                    <label for="input-consent-id" class="col-form-label">Consent ID</label>
                  </div>
                </div>
                -->
                
                
                <!-- 1-imei-multiple-number -->
                <!--
                <div class="col-md-12 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-imei" name="input-imei" min="6280000000000" max="999999999999999" value="350742139251246" placeholder="62xxxxxxxxxxx">
                    <label for="input-imei">IMEI / Key</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="input-param-1-imei-multiple-number" name="input-param-1-imei-multiple-number" maxlength="30" placeholder="Param (number of previous days to check)">
                    <label for="input-param-1-imei-multiple-number">Param (number of previous days to check from today)</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-min" name="input-min" min="0" max="9" maxlength="1" placeholder="Min (count of min. phone numbers to check)">
                    <label for="input-min" class="col-form-label">Min (count of min. phone numbers to check)</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-max" name="input-max" min="0" max="9" placeholder="Max (count of max. phone numbers to check)">
                    <label for="input-max" class="col-form-label">Max (count of max. phone numbers to check)</label>
                  </div>
                </div>
                -->
                
                <!-- telco score bin 25 -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-telco-score-bin-25">
                  <fieldset class="row">
                    <legend class="col-form-label col-sm-3 pt-0">SRD Flag</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-srd-flag" id="radio-srd-flag-yes" value="1">
                        <label class="form-check-label" for="radio-srd-flag-yes">Yes</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-srd-flag" id="radio-srd-flag-no" value="0">
                        <label class="form-check-label" for="radio-srd-flag-no">No</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                -->
              </div>
              
              <hr class="mt-4">
              
              <div class="text-center">
                <button type="submit" id="btn-submit-request" class="btn btn-primary">Submit</button>
                <input type="hidden" id="selected-product" name="selected_product" value="">
                <input type="hidden" id="selected-address-info" name="selected_address_info" value="">
                {{ csrf_field() }}
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Sent Request for <span id="container-api-request-title"></span></h5>
            <form class="row g-3" id="form-input" name="form-input">
              <div class="col-12">
                <label for="container-request-raw-data" class="form-label">Raw Data</label>
                <textarea class="form-control" id="container-request-raw-data" style="height:348px;"></textarea>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Respond for <span id="container-api-response-title"></span></h5>
            
            <form class="row g-3">
              <div class="col-12">
                <label for="container-respond-raw-data" class="form-label">Raw Data</label>
                <textarea class="form-control" id="container-respond-raw-data" style="height:200px;"></textarea>
              </div>
              
              <div class="col-12">
                <label for="container-respond-deciphered-ciphertext" class="form-label">Deciphered Cipher Text</label>
                <textarea class="form-control" id="container-respond-deciphered-ciphertext" style="height:100px;"></textarea>
              </div>
            </form>
          
          </div>
        </div>
      </div>
    </div>
    
    <!-- dialog modal enc-dec ciphered-text -->
    <div class="modal fade" id="dialog-enc-dec-instructions" tabindex="-1" style="display:none;" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">CIphered Text Encryption-Decryption Code Samples</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <p>
              Ciphered-Text is actually an encrypted-string or randomized-string produced by scrambling some strings or texts in order to hide the real texts or
              messages which one wants to send.
            </p>
            <p class="mb-4">
              Below you can examine samples from some programming languages on how to produce the ciphered-text for Telkomsel Telco.
            </p>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="go-tab" data-bs-toggle="tab" data-bs-target="#go" type="button" role="tab" aria-controls="go" aria-selected="true">Go</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="java-tab" data-bs-toggle="tab" data-bs-target="#java" type="button" role="tab" aria-controls="java" aria-selected="false" tabindex="-1">Java</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="php-tab" data-bs-toggle="tab" data-bs-target="#php" type="button" role="tab" aria-controls="php" aria-selected="false" tabindex="-1">PHP</button>
              </li>
            </ul>

            <div class="tab-content pt-2" id="tabs-content">
              <div class="tab-pane fade active show" id="go" role="tabpanel" aria-labelledby="home-tab">
                <pre>
                  package main
                  
                  import (
                    "bytes"
                    "errors"
                    "fmt"
                    
                    "crypto/aes"
                    "crypto/cipher"
                    "crypto/rand"
                    "crypto/sha256"
                    "encoding/base64"
                  )
                  
                  // AESCBCEncrypt will encrypt plaint text with aes-256 cbc mode
                  // and pkcs7 padding, then return an encoded base64 string.
                  func AESCBCEncrypt(plainText string, secretKey string) (string, error) {
                    // aes using 16 byte block size
                    blockSize := 16
                    
                    // we want aes-256 so we need  256 bit (32 byte) secretKey
                    // here we use sha256 for creating 256 bit (32 byte) key
                    bKey := sha256.Sum256([]byte(secretKey))
                    
                    // The IV needs to be unique, but not secure. Therefore it's common to
                    // include it at the beginning of the cipherText.
                    // iv must be the same size as blocksize
                    iv := make([]byte, blockSize)
                    
                    // assign randomize iv
                    rand.Read(iv)
                    
                    // CBC mode works on blocks so plaintexts may need to be padded to the
                    // next whole block. If the original plainText lengths are not a multiple of the block size,
                    // padding must be added when encrypting.
                    // pad the plainText with pkcs7
                    bPlainText := PKCS7Padding([]byte(plainText), blockSize)
                    
                    // create empty byte as big as plainText that
                    // has been padded to store encrypted text later on
                    bCipherText := make([]byte, len(bPlainText))
                    
                    // create cipher block from bKey
                    cipherBlock, _ := aes.NewCipher(bKey[:])
                    
                    // create new mode with cipherBlock key and iv
                    mode := cipher.NewCBCEncrypter(cipherBlock, iv)
                    
                    // encrypt bPlainText and store to the bCipherText
                    mode.CryptBlocks(bCipherText, bPlainText)
                    
                    // append iv to the beginning bCipherText
                    bCipherText = append(iv, bCipherText...)
                    
                    // encode bCipherText with base64
                    return base64.StdEncoding.EncodeToString(bCipherText), nil
                  }
                  
                  // AESCBCDecrypt will decrypt base64 ciphertext with aes-256 cbc mode
                  // and pkcs7 unpadding then return a plain text string.
                  func AESCBCDecrypt(cipherText string, secretKey string) (string, error) {
                    // aes using 16 byte block size
                    blockSize := 16
                    
                    // we want aes-256 so we need  256 bit (32 byte) secretKey
                    // here we use sha256 for creating 256 bit (32 byte) key
                    bKey := sha256.Sum256([]byte(secretKey))
                    
                    // decode base64 from cipherText
                    bCipherText, _ := base64.StdEncoding.DecodeString(cipherText)
                    
                    if len(bCipherText)%blockSize != 0 || len(bCipherText) < blockSize {
                      return "", errors.New("ciphertext length (" + fmt.Sprint(len(bCipherText)) + ") is not multiple of the block size")
                    }
                    
                    // The IV needs to be unique, but not secure. Therefore it's common to
                    // include it at the beginning of the ciphertext.
                    // here we copy the first blockSize byte from bCipherText
                    iv := bCipherText[:blockSize]
                    
                    // remove iv from the bCipherText prefix
                    bCipherText = bCipherText[len(iv):]
                    
                    // create empty byte based on bCipherText byte
                    // to store decrypted text later on
                    bPlaintext := make([]byte, len(bCipherText))
                    
                    // create cipher block from bKey
                    cipherBlock, _ := aes.NewCipher(bKey[:])
                    
                    // create new mode with cipher block key and iv
                    mode := cipher.NewCBCDecrypter(cipherBlock, iv)
                    
                    // decrypt bCipherText and store to the bPlaintext
                    mode.CryptBlocks(bPlaintext, bCipherText)
                    
                    // If the original plaintext lengths are not a multiple of the block size,
                    // padding that have been added when encrypting would be removed at this point.
                    bPlaintext, err := PKCS7UnPadding(bPlaintext, blockSize)
                    return string(bPlaintext), err
                  }
                  
                  // PKCS7Padding pad the plaintext with pkcs7 method,
                  // it will fill the blocksize (multiplication) with the int reminder of blocksize
                  func PKCS7Padding(src []byte, blockSize int) []byte {
                    paddingValue := (blockSize - len(src) % blockSize)
                    padtext := bytes.Repeat([]byte{byte(paddingValue)}, paddingValue)
                    return append(src, padtext...)
                  }
                  
                  // PKCS7UnPadding unpad the plaintext with pkcs7 method,
                  // it will substring original string from the block with the padded value int
                  func PKCS7UnPadding(origData []byte, blockSize int) ([]byte, error) {
                    length := len(origData)
                    
                    // take padded int value form last string
                    unpadding := int(origData[length - 1])
                    
                    // check max padding from blocksize (16 byte)
                    if blockSize < unpadding {
                      return nil, errors.New("invalid unpadding length (" + fmt.Sprint(unpadding) + "), bad EncryptionKey or IV")
                    }
                    
                    return origData[:(length - unpadding)], nil
                  }
                  
                  func main() {
                    // Encryption Test
                    // -----------------------
                    plainText1 := `{
                      "transaction_id": "SOCIALECONOMY-TEST001",
                      "msisdn": "628111243030",
                      "consentID": "consent001",
                      "partner_name": "testpartner"
                    }`
                    secretKey1 := "telkomselS3cr3tK3y"
                    cipherText1, _ := AESCBCEncrypt(plainText1, secretKey1)
                    fmt.Println("encrypted text: ", cipherText1)
                    
                    // Decryption Test
                    // -----------------------
                    cipherText2 := cipherText1
                    secretKey2 := "telkomselS3cr3tK3y"
                    plainText2, _ := AESCBCDecrypt(cipherText2, secretKey2)
                    fmt.Println("plain text: ", plainText2)
                  }
                </pre>
              </div>

              <div class="tab-pane fade" id="java" role="tabpanel" aria-labelledby="profile-tab">
                <pre>
                  package src;

                  import java.nio.charset.StandardCharsets;
                  import java.security.InvalidAlgorithmParameterException;
                  import java.security.InvalidKeyException;
                  import java.security.MessageDigest;
                  import java.security.NoSuchAlgorithmException;
                  import java.security.SecureRandom;
                  import java.security.spec.InvalidKeySpecException;
                  import java.util.Arrays;
                  import java.util.Base64;
                  
                  import javax.crypto.BadPaddingException;
                  import javax.crypto.Cipher;
                  import javax.crypto.IllegalBlockSizeException;
                  import javax.crypto.NoSuchPaddingException;
                  import javax.crypto.spec.IvParameterSpec;
                  import javax.crypto.spec.SecretKeySpec;
                  
                  import org.json.JSONException;
                  import org.json.JSONObject;
                  
                  public class AESCBC {
                    // AES256CBCEncrypt will encrypt plaint text with aes-256 cbc mode
                    // and pkcs7 padding, then return an encoded base64 string.
                    public static String encrypt(String plainText, String secretKey) {
                      try {
                        // aes using 16 byte block size
                        Integer blockSize = 16;
                        
                        // we want aes-256 so we need  256 bit (32 byte) secretKey
                        // here we use sha256 for creating 256 bit (32 byte) key
                        MessageDigest digest = MessageDigest.getInstance("SHA-256");
                        byte[] bKey = digest.digest(secretKey.getBytes(StandardCharsets.UTF_8));
                        SecretKeySpec skeySpec = new SecretKeySpec(bKey, "AES");
                        
                        // The IV needs to be unique, but not secure. Therefore it's common to
                        // include it at the beginning of the cipherText.
                        // iv must be the same size as blocksize
                        SecureRandom randomSecureRandom = new SecureRandom();
                        byte[] iv = new byte[blockSize];
                        randomSecureRandom.nextBytes(iv);
                        IvParameterSpec ivParams = new IvParameterSpec(iv);
                        
                        // CBC mode works on blocks so plaintexts may need to be padded to the
                        // next whole block. If the original plainText lengths are not a multiple of the block size,
                        // padding must be added when encrypting.
                        // create cipher block with AES/CBC/PKCS5PADDING
                        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
                        
                        // init cipher
                        cipher.init(Cipher.ENCRYPT_MODE, skeySpec, ivParams);
                        
                        // encrypt bPlainText and store to the bCipherText
                        byte[] bCipherText = cipher.doFinal(plainText.getBytes());
                        
                        // append iv and bCipherText
                        byte[] finalCipherText = new byte[iv.length + bCipherText.length];
                        
                        // append iv to the beginning
                        System.arraycopy(iv, 0, finalCipherText, 0, iv.length);
                        
                        // append bCipherText after the iv
                        System.arraycopy(bCipherText, 0, finalCipherText, iv.length, bCipherText.length);
                        
                        // encode bCipherText with base64
                        return Base64.getEncoder().encodeToString(finalCipherText);

                      } catch (Exception ex) {
                        ex.printStackTrace();
                      }
                      
                      return null;
                    }
                    
                    // AES256CBCDecrypt will decrypt base64 ciphertext with aes-256 cbc mode
                    // and pkcs5 unpadding then return a plain text string.
                    public static String decrypt(String cipherText, String secretKey) {
                      try {
                        // aes using 16 byte block size
                        Integer blockSize = 16;
                        
                        // we want aes-256 so we need  256 bit (32 byte) secretKey
                        // here we use sha256 for creating 256 bit (32 byte) key
                        MessageDigest digest = MessageDigest.getInstance("SHA-256");
                        byte[] bKey = digest.digest(secretKey.getBytes(StandardCharsets.UTF_8));
                        SecretKeySpec skeySpec = new SecretKeySpec(bKey, "AES");
                        
                        // decode base64 from cipherText
                        byte[] bCipherText = Base64.getDecoder().decode(cipherText);
                        
                        // The IV needs to be unique, but not secure. Therefore it's common to
                        // include it at the beginning of the ciphertext.
                        // here we copy the first blockSize byte from bCipherText
                        byte[] iv = new byte[blockSize];
                        System.arraycopy(bCipherText, 0, iv, 0, iv.length);
                        IvParameterSpec ivParams = new IvParameterSpec(iv);
                        
                        // remove iv from the bCipherText prefix
                        bCipherText = Arrays.copyOfRange(bCipherText, iv.length, bCipherText.length);
                        
                        // CBC mode works on blocks so plaintexts may need to be padded to the
                        // next whole block. If the original plainText lengths are not a multiple of the block size,
                        // padding must be added when encrypting.
                        // create cipher block with AES/CBC/PKCS5PADDING
                        Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
                        
                        // init cipher
                        cipher.init(Cipher.DECRYPT_MODE, skeySpec, ivParams);
                        
                        // decrypt bCipherText and store to the bPlaintext
                        byte[] bPlaintext = cipher.doFinal(bCipherText);
                        
                        return new String(bPlaintext);

                      } catch (Exception ex) {
                        ex.printStackTrace();
                      }
                      
                      return null;
                    }
                    
                    public static void main(String[] args) throws
                      NoSuchAlgorithmException,
                      InvalidKeySpecException,
                      InvalidKeyException,
                      NoSuchPaddingException,
                      InvalidAlgorithmParameterException,
                      BadPaddingException,
                      IllegalBlockSizeException,
                      JSONException
                    {
                      // Encryption Test
                      // -----------------------
                      JSONObject jsonObj = new JSONObject();
                      jsonObj.put("transaction_id", "SOCIALECONOMY-TEST001");
                      jsonObj.put("msisdn", "628111243030");
                      jsonObj.put("consentID", "consent001");
                      jsonObj.put("partner_name", "testpartner");
                      
                      String plainText1 = jsonObj.toString();
                      String secretKey1 = "telkomselS3cr3tK3y";
                      String cipherText1 = AESCBC.encrypt(plainText1, secretKey1);
                      System.out.println("encrypted text: " + cipherText1);
                      
                      // Decryption Test
                      // -----------------------
                      String cipherText2 = cipherText1;
                      String secretKey2 = "telkomselS3cr3tK3y";
                      String plainText2 = AESCBC.decrypt(cipherText2, secretKey2);
                      System.out.println("plain text: " + plainText2);
                    }
                  }
                </pre>
              </div>

              <div class="tab-pane fade" id="php" role="tabpanel" aria-labelledby="contact-tab">
                <pre>
                  &#60;?php
                  
                    define('AES_256_CBC', 'aes-256-cbc');
                  
                    // AESCBCEncrypt will encrypt plaint text with aes-256 cbc mode
                    // and pkcs7 padding, then return an encoded base64 string.
                    function AESCBCEncrypt($plainText, $secretKey) {
                      // aes using 16 byte block size
                      $blockSize = openssl_cipher_iv_length(AES_256_CBC);
                    
                      // we want aes-256 so we need  256 bit (32 byte) secretKey
                      // here we use sha256 for creating 256 bit (32 byte) key
                      $bKey = hash('sha256', $secretKey, true);
                    
                      // The IV needs to be unique, but not secure. Therefore it's common to
                      // include it at the beginning of the cipherText.
                      // iv must be the same size as blocksize
                      $iv = openssl_random_pseudo_bytes($blockSize);
                    
                      // CBC mode works on blocks so plaintexts may need to be padded to the
                      // next whole block. If the original plainText lengths are not a multiple of the block size,
                      // padding must be added when encrypting.
                      // encrypt bPlainText with pkcs7 padding
                      $encrypted = openssl_encrypt($plainText, AES_256_CBC, $bKey, OPENSSL_RAW_DATA, $iv);
                    
                      // append iv to the beginning bCipherText
                      $cipherText = $iv . $encrypted;
                    
                      // encode bCipherText with base64
                      return base64_encode($cipherText);
                    }
                  
                    // AESCBCDecrypt will decrypt base64 ciphertext with aes-256 cbc mode
                    // and pkcs7 unpadding then return a plain text string.
                    function AESCBCDecrypt($cipherText, $secretKey) {
                      // aes using 16 byte block size
                      $blockSize = openssl_cipher_iv_length(AES_256_CBC);
                    
                      // we want aes-256 so we need  256 bit (32 byte) secretKey
                      // here we use sha256 for creating 256 bit (32 byte) key
                      $bKey = hash('sha256', $secretKey, true);
                    
                      // decode base64 from cipherText
                      $bCipherText = base64_decode($cipherText);
                    
                      // The IV needs to be unique, but not secure. Therefore it's common to
                      // include it at the beginning of the ciphertext.
                      // here we copy the first blockSize byte from bCipherText
                      $iv = substr($bCipherText, 0, $blockSize);
                    
                      // remove iv from the bCipherText prefix
                      $bFinalCipherText = substr($bCipherText, $blockSize);
                    
                      // decrypt cipherText and store to the bPlaintext
                      $bPlaintext = openssl_decrypt($bFinalCipherText, AES_256_CBC, $bKey, OPENSSL_RAW_DATA, $iv);

                      return $bPlaintext;
                    }
                  
                    // Encryption Test
                    // -----------------------
                    $plainText1 = '{
                      "transaction_id": "SOCIALECONOMY-TEST001",
                      "msisdn": "628111243030",
                      "consentID": "consent001",
                      "partner_name": "testpartner"
                    }';
                    $secretKey1 = "telkomselS3cr3tK3y";
                    $cipherText1 = AESCBCEncrypt($plainText1, $secretKey1);
                    echo "encrypted text: ", $cipherText1, "\n";
                  
                    // Decryption Test
                    // -----------------------
                    $cipherText2 = $cipherText1;
                    $secretKey2 = "telkomselS3cr3tK3y";
                    $plainText2 = AESCBCDecrypt($cipherText2, $secretKey2);
                    echo "plain text: ", $plainText2, "\n";

                  ?&#62;
                </pre>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  </section>
</main>

@push('javascript')
<script type="text/javascript">
  var tempApiRequest = [];
  var tempApiResponses = [];
  var selectedProduct = $('#selected-product').val().toLowerCase();
  
  function prepareProductsDropDown() {
    $('#input-product-id').change(function(e) {
      $('#selected-product').val(($(this).val()));
      selectedProduct = $('#selected-product').val().toLowerCase();
      updateForm();
    });
  };
  
  function updateForm() {
    $('.input-rows').hide();
    $('.input-msisdn').show();
    
    var title = '';
    var apiRequest = '';
    var apiResponse = '';
    var decipheredText = '';
    
    switch(selectedProduct) {
      case 'idver': $('.input-location-scoring').show(); title = 'Location Scoring'; break;
      case 'ktpscore': $('.input-ktp-match').show(); title = 'KTP Match'; break;
      case 'recycle': $('.input-recycle-number').show(); title = 'Recycle Number'; break;
      case 'roaming2': $('.input-active-roaming').show(); title = 'Active Roaming'; break;
      case 'lastloc2': $('.input-last-location').show(); title = 'Last Location'; break;
      case 'loyalist': $('.input-interest').show(); title = 'Interest'; break;
      case 'telcoses': $('.input-telco-ses').show(); title = 'TelcoSES'; break;
      case 'substat2': title = 'Active Status'; break;
      case 'numberswitching2': $('.input-msisdn').hide(); $('.input-one-imei-multiple-number').show(); title = '1 IMEI Multiple Number'; break;
      case 'forwarding2': title = 'Call Forwarding Status'; break;
      case 'simswap': title = 'SIM Swap'; break;
      case 'tscore': $('.input-telco-score-bin-25').show(); title = 'Telco Score BIN 25'; break;
    }
    
    var existingRequest = tempApiRequest[selectedProduct];
    var existingResponse = tempApiResponses[selectedProduct];
    
    if (existingRequest !== undefined) {
      apiRequest = existingRequest.request;
    }
    
    if (existingResponse !== undefined) {
      apiResponse = existingResponse.api_response;
      
      if (parseInt(apiResponse.transaction.status_code, 10) === 0) {
        decipheredText = existingResponse.result;
      }
    }
    
    $('#container-api-request-title').text(title);
		$('#container-api-response-title').text(title);
		$('#container-request-raw-data').val(JSON.stringify(apiRequest));
    $('#container-respond-raw-data').val(JSON.stringify(apiResponse));
    $('#container-respond-deciphered-ciphertext').val(JSON.stringify(decipheredText));
  };
  
  function prepareAddressType() {
    $("input[name='radio-products']").click(function(e) {
      $('#selected-product').val(($(this).val()));
      selectedProduct = $('#selected-product').val().toLowerCase();
      updateForm();
    });
  };
  
  function prepareAddressInfo() {
    $('input[name="radio-address-info"]').click(function(e) {
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
      
      var theForm = $('form')[0];
      var formData = new FormData(theForm);
      formData.append('_token', '{{ csrf_token() }}');
      formData.submit();

      // submitData(formData);
    });
  };
  
  function submitData(formData) {
    $('#btn-submit').prop('disabled', true);
    $('#container-request-raw-data').empty();
		$('#container-respond-raw-data').empty();
    $('#container-respond-deciphered-ciphertext').empty();
    
    $.ajax({
      type: 'POST',
      enctype: 'multipart/form-data',
      url: '{{ route('telco_v02.send') }}',
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      success: function(response) {
        console.log(response);
        
        if (response.api_response !== undefined) {
          var statusCode = parseInt(response.api_response.transaction.status_code, 10);
          if (statusCode == 0) {
            $('#container-respond-deciphered-ciphertext').val(JSON.stringify(response.result));
          }
          
          $('#container-request-raw-data').val(JSON.stringify(response.request));
				  $('#container-respond-raw-data').val(JSON.stringify(response.api_response));
				  
				  tempApiRequest[selectedProduct] = response;
          tempApiResponses[selectedProduct] = response;
        }
      },
      error: function(error) {
        console.log('error: ' + error.responseText);
        $('#container-respond-raw-data').val(JSON.stringify(error.responseText));
      }
    })
    .always(function() {
      $('#btn-submit').prop('disabled', false);
    });
  };
  
  $(document).ready(function() {
    prepareProductsDropDown();
    prepareAddressType();
    prepareAddressInfo();
    // prepareSubmitButton();
    
    $('.input-rows').hide();

    $('#form-request').submit(function() {
      $('#btn-submit-request').addClass('disabled');
    });
  });
</script>
@endpush

@include('layouts.include_page_footer')
@include('layouts.include_js')