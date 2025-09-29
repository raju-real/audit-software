<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public static function sendMessage($mobile, $message)
    {
        $url = "http://66.45.237.70/api.php";
        $data = array(
            'username' => "egrocery",
            'password' => "mahtab@2025",
            'number' => $mobile,
            'message' => $message
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|", $smsresult);
        $sendstatus = $p[0];
    }

    public static function create2FaApplication(): ?array
    {
        // It's highly recommended to store sensitive information like API keys
        // in your .env file and access them via the config() helper.
        // For example: INFOBIP_API_KEY="App be30edf263adb0fb84911c1829efbeff-6f8c4d9b-07bb-4171-aa3a-940ccaf0ddf8"
        $apiKey = 'be30edf263adb0fb84911c1829efbeff-6f8c4d9b-07bb-4171-aa3a-940ccaf0ddf8';
        $apiUrl = 'ypmjzd.api.infobip.com';

        // Define the request body as an associative array
        $requestBody = [
            "name" => "2fa test application",
            "enabled" => true,
            "configuration" => [
                "pinAttempts" => 10,
                "allowMultiplePinVerifications" => true,
                "pinTimeToLive" => "15m",
                "verifyPinLimit" => "1/3s",
                "sendPinPerApplicationLimit" => "100/1d",
                "sendPinPerPhoneNumberLimit" => "10/1d"
            ]
        ];

        try {
            // Make the POST request using Laravel's HTTP client
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($apiUrl, $requestBody); // Pass the array directly as the body

            // Check if the request was successful (status code 2xx)
            if ($response->successful()) {
                // Return the JSON response from Infobip as an array
                return $response->json();
            } else {
                // Log the error for debugging purposes
                Log::error('Infobip 2FA Application Creation Error:', [
                    'status' => $response->status(),
                    'reason' => $response->reason(),
                    'body' => $response->body(),
                    'infobip_error' => $response->json(), // Include Infobip's error response if available
                ]);
                return null; // Indicate failure
            }
        } catch (\Exception $e) {
            // Catch any network or other exceptions
            Log::error('Infobip 2FA Application Creation Exception:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null; // Indicate failure
        }
    }


}
