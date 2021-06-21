<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\FarmerDetails;
use App\Models\OfficerDetails;
use App\Models\RetailerDetails;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = 'Admin';
        $user->last_name = 'Nahid';
        $user->username = 'admin123';
        $user->mobile_number = '01857823870';
        $user->email = 'admin@gmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('password');
        $user->save();

        // Laravel sanctum
        $user->createToken('user-access-control', ['access-dashboard', 'product-view', 'product:store', 'product:update', 'product:delete']);
        //$user->createToken('token_name', ['permission_1', 'permission_2']);
        //$user->assignRole('developer');
        $user->assignRole(['developer', 'super admin']);


        ///////////////////////////////////////////////////
        $farmer = new User();
        $farmer->first_name = ucfirst('Rofiqul');
        $farmer->last_name = ucfirst('haque');
        $farmer->username = 'rofiq_fa';
        $farmer->mobile_number = '01869905656';
        $farmer->postal_code = 1205;
        $farmer->email = 'rofiq@gmail.com';
        $farmer->email_verified_at = now();
        $farmer->password = Hash::make('password');
        $farmer->avatar = '/storage/images/users/farmer1.jpg';
        $farmer->save();
        $farmer->assignRole('farmer');

        $userDetails = new FarmerDetails();
        $userDetails->user_id = $farmer->id;
        $userDetails->acres = 2.4;
        $userDetails->farmer_type = 'Crop';
        $userDetails->save();

        $address = new Address();
        $address->user_id = $farmer->id;
        $address->address = 'Road 32, Dhanmondi Dhaka';
        $address->country_id = 18;
        $address->state_id = 349;
        $address->save();


        $retailer = new User();
        $retailer->first_name = ucfirst('Md. Jahid');
        $retailer->last_name = ucfirst('Hassan');
        $retailer->username = 'jahid_re';
        $retailer->mobile_number = '01867856656';
        $retailer->postal_code = 1205;
        $retailer->email = 'jahid@gmail.com';
        $retailer->email_verified_at = now();
        $retailer->password = Hash::make('password');
        $retailer->avatar = '/storage/images/users/retailer2.jpg';
        $retailer->save();
        $retailer->assignRole('retailer');

        $userDetails = new RetailerDetails();
        $userDetails->user_id = $retailer->id;
        $userDetails->retailer_interest = 'Fruits';
        $userDetails->save();

        $address = new Address();
        $address->user_id = $retailer->id;
        $address->address = 'Road 32, Dhanmondi Dhaka';
        $address->country_id = 18;
        $address->state_id = 348;
        $address->save();


        $retailer = new User();
        $retailer->first_name = ucfirst('Kazi Yunus ');
        $retailer->last_name = ucfirst('Ahmed');
        $retailer->username = 'younus_re';
        $retailer->mobile_number = '01861245616';
        $retailer->postal_code = 1205;
        $retailer->email = 'younus_bd@gmail.com';
        $retailer->email_verified_at = now();
        $retailer->password = Hash::make('password');
        $retailer->avatar = '/storage/images/users/retailer1.jpg';
        $retailer->save();
        $retailer->assignRole('retailer');

        $userDetails = new RetailerDetails();
        $userDetails->user_id = $retailer->id;
        $userDetails->retailer_interest = 'Fruits';
        $userDetails->save();

        $address = new Address();
        $address->user_id = $retailer->id;
        $address->address = 'Road 32, Dhanmondi Dhaka';
        $address->country_id = 18;
        $address->state_id = 348;
        $address->save();


        $officer = new User();
        $officer->first_name = ucfirst('Razu');
        $officer->last_name = ucfirst('Ahmed');
        $officer->username = 'razu_of';
        $officer->mobile_number = '01869341346';
        $officer->postal_code = 1205;
        $officer->email = 'razu36@gmail.com';
        $officer->email_verified_at = now();
        $officer->password = Hash::make('password');
        $officer->avatar = '/storage/images/users/officer1.jpeg';
        $officer->status = 'active';
        $officer->save();
        $officer->assignRole('agricultural-officer');

        $userDetails = new OfficerDetails();
        $userDetails->user_id = $officer->id;
        $userDetails->office_name = 'Bongobondhu krishi office, dhaka.';
        $userDetails->job_title = 'Field officer';
        $userDetails->certificate = '/storage/users/document/certificate_2.pdf';
        $userDetails->save();

        $address = new Address();
        $address->user_id = $officer->id;
        $address->address = 'Road 32, Dhanmondi Dhaka';
        $address->country_id = 18;
        $address->state_id = 349;
        $address->save();


        $officer = new User();
        $officer->first_name = ucfirst('Mohammed Mozammal');
        $officer->last_name = ucfirst('Haque');
        $officer->username = 'mozammal_of';
        $officer->mobile_number = '01849344556';
        $officer->postal_code = 1205;
        $officer->email = 'mozammal123@gmail.com';
        $officer->email_verified_at = now();
        $officer->password = Hash::make('password');
        $officer->avatar = '/storage/images/users/officer2.jpg';
        $officer->status = 'pending';
        $officer->save();
        $officer->assignRole('agricultural-officer');

        $userDetails2 = new OfficerDetails();
        $userDetails2->user_id = $officer->id;
        $userDetails2->office_name = 'Bongobondhu krishi office, dhaka.';
        $userDetails2->job_title = 'Field officer';
        $userDetails2->certificate = '/storage/users/document/certificate_1.pdf';
        $userDetails2->save();

        $address = new Address();
        $address->user_id = $officer->id;
        $address->address = 'Road 32, Dhanmondi Dhaka';
        $address->country_id = 18;
        $address->state_id = 349;
        $address->save();


        $user = new User();
        $user->first_name = 'Nahid';
        $user->last_name = 'Ferdous';
        $user->username = 'nahid_cu';
        $user->mobile_number = '01157832230';
        $user->email = 'nahid@gmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole(['customer']);


        $user = new User();
        $user->first_name = 'Rupali';
        $user->last_name = 'Akhter';
        $user->username = 'rupali_cu';
        $user->mobile_number = '01857112870';
        $user->email = 'rupali@gmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole(['customer']);

        $user = new User();
        $user->first_name = 'Customer';
        $user->last_name = 'Three';
        $user->username = 'customer3';
        $user->mobile_number = '01851232870';
        $user->email = 'customer3@gmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('customer3@gmail.com');
        $user->save();
        $user->assignRole(['customer']);





        $farmer = new User();
        $farmer->first_name = ucfirst('Nawaab Syed ');
        $farmer->last_name = ucfirst('Shamsul Huda');
        $farmer->username = 'Syed_far';
        $farmer->mobile_number = '01819905156';
        $farmer->postal_code = 1205;
        $farmer->email = 'sayed@gmail.com';
        $farmer->email_verified_at = now();
        $farmer->password = Hash::make('password');
        $farmer->avatar = '/storage/images/users/farmer3.jpg';
        $farmer->save();
        $farmer->assignRole('farmer');

        $userDetails = new FarmerDetails();
        $userDetails->user_id = $farmer->id;
        $userDetails->acres = 5;
        $userDetails->farmer_type = 'Corn';
        $userDetails->save();

        $address = new Address();
        $address->user_id = $farmer->id;
        $address->address = 'Road 32, Dhanmondi Dhaka';
        $address->country_id = 18;
        $address->state_id = 349;
        $address->save();


        $farmer = new User();
        $farmer->first_name = ucfirst('Khwaja');
        $farmer->last_name = ucfirst('Salimullah');
        $farmer->username = 'salimullah_far';
        $farmer->mobile_number = '01819945156';
        $farmer->postal_code = 1205;
        $farmer->email = 'salimullah@gmail.com';
        $farmer->email_verified_at = now();
        $farmer->password = Hash::make('password');
        $farmer->avatar = '/storage/images/users/farmer4.jpg';
        $farmer->save();
        $farmer->assignRole('farmer');

        $userDetails = new FarmerDetails();
        $userDetails->user_id = $farmer->id;
        $userDetails->acres = 8;
        $userDetails->farmer_type = 'Vegetables';
        $userDetails->save();

        $address = new Address();
        $address->user_id = $farmer->id;
        $address->address = 'Road 32, Dhanmondi Dhaka';
        $address->country_id = 18;
        $address->state_id = 349;
        $address->save();



    }
}
