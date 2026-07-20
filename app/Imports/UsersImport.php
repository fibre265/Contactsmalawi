<?php

namespace App\Imports;

use App\Models\User;
use App\Models\District;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersImport
{
    /**
     * Native CSV Parser
     */
    public static function importFromCsv($filePath)
    {
        if (($handle = fopen($filePath, "r")) === FALSE) {
            return false;
        }

        // Read header row and normalize to lowercase
        $rawHeaders = fgetcsv($handle, 1000, ",");
        if (!$rawHeaders) {
            fclose($handle);
            return false;
        }

        // Clean headers (remove BOMs/hidden spaces)
        $headers = array_map(function($h) {
            return strtolower(trim(preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/', '', $h)));
        }, $rawHeaders);

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($headers) !== count($data)) {
                continue;
            }

            $row = array_combine($headers, array_map('trim', $data));

            // Extract phone number from 'phonenumber' or 'email' header
            $phoneNumber = trim($row['phonenumber'] ?? $row['email'] ?? '');

            // Skip empty rows or duplicate numbers in the 'email' column
            if (empty($phoneNumber) || User::where('email', $phoneNumber)->exists()) {
                Log::info("Skipping row for number: {$phoneNumber} (empty or duplicate)");
                continue;
            }

            // Relationship lookups
            $district = District::where('district', 'LIKE', trim($row['district'] ?? ''))->first();
            $category = Category::where('category', 'LIKE', trim($row['category'] ?? ''))->first();
            $region   = Region::where('region', 'LIKE', trim($row['region'] ?? ''))->first();

            User::create([
                'name'                => $row['name'] ?? 'Unknown',
                'township'            => $row['township'] ?? 'N/A',
                'password'            => Hash::make($row['password'] ?? 'Welcome@123'),
                'picture'             => null,
                'email'               => $phoneNumber, // Saves phone number into DB email column
                'is_approved'         => isset($row['is_approved']) ? (int)$row['is_approved'] : 1,
                'district_id'         => $district ? $district->id : 1,
                'category_id'         => $category ? $category->id : 1,
                'region_id'           => $region ? $region->id : 1,
                'working_votes'       => 0,
                'not_working_votes'   => 0,
                'verification_status' => 'verified',
            ]);
        }

        fclose($handle);
        return true;
    }
}