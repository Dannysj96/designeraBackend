<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Andhra Pradesh' => ['Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool', 'Tirupati'],
            'Arunachal Pradesh' => ['Itanagar', 'Naharlagun', 'Pasighat', 'Tawang'],
            'Assam' => ['Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon'],
            'Bihar' => ['Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Purnia', 'Darbhanga'],
            'Chhattisgarh' => ['Raipur', 'Bhilai', 'Bilaspur', 'Korba', 'Durg'],
            'Goa' => ['Panaji', 'Margao', 'Vasco da Gama', 'Mapusa'],
            'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Gandhinagar'],
            'Haryana' => ['Gurugram', 'Faridabad', 'Panipat', 'Ambala', 'Hisar', 'Karnal'],
            'Himachal Pradesh' => ['Shimla', 'Dharamshala', 'Solan', 'Mandi', 'Kullu', 'Manali'],
            'Jharkhand' => ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Deoghar'],
            'Karnataka' => ['Bengaluru', 'Mysuru', 'Hubballi', 'Mangaluru', 'Belagavi', 'Davangere'],
            'Kerala' => ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Kannur'],
            'Madhya Pradesh' => ['Indore', 'Bhopal', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar'],
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur', 'Thane', 'Nashik', 'Chhatrapati Sambhajinagar', 'Solapur', 'Kolhapur'],
            'Manipur' => ['Imphal', 'Thoubal', 'Bishnupur', 'Churachandpur'],
            'Meghalaya' => ['Shillong', 'Tura', 'Jowai', 'Nongpoh'],
            'Mizoram' => ['Aizawl', 'Lunglei', 'Champhai', 'Serchhip'],
            'Nagaland' => ['Kohima', 'Dimapur', 'Mokokchung', 'Tuensang'],
            'Odisha' => ['Bhubaneswar', 'Cuttack', 'Rourkela', 'Berhampur', 'Sambalpur'],
            'Punjab' => ['Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Mohali'],
            'Rajasthan' => ['Jaipur', 'Jodhpur', 'Kota', 'Bikaner', 'Ajmer', 'Udaipur'],
            'Sikkim' => ['Gangtok', 'Namchi', 'Geyzing', 'Mangan'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli'],
            'Telangana' => ['Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Khammam'],
            'Tripura' => ['Agartala', 'Dharmanagar', 'Udaipur', 'Kailashahar'],
            'Uttar Pradesh' => ['Lucknow', 'Kanpur', 'Varanasi', 'Agra', 'Noida', 'Prayagraj', 'Ghaziabad', 'Meerut', 'Bareilly', 'Gorakhpur', 'Aligarh'],
            'Uttarakhand' => ['Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rishikesh', 'Nainital'],
            'West Bengal' => ['Kolkata', 'Howrah', 'Siliguri', 'Durgapur', 'Asansol', 'Bardhaman'],
            'Andaman and Nicobar Islands' => ['Port Blair'],
            'Chandigarh' => ['Chandigarh'],
            'Dadra and Nagar Haveli and Daman and Diu' => ['Daman', 'Diu', 'Silvassa'],
            'Delhi' => ['New Delhi', 'North Delhi', 'South Delhi', 'East Delhi', 'West Delhi', 'Central Delhi'],
            'Jammu and Kashmir' => ['Srinagar', 'Jammu', 'Anantnag', 'Baramulla'],
            'Ladakh' => ['Leh', 'Kargil'],
            'Lakshadweep' => ['Kavaratti', 'Agatti'],
            'Puducherry' => ['Puducherry', 'Karaikal', 'Mahe', 'Yanam'],
        ];

        foreach ($locations as $stateName => $cities) {
            $state = Location::firstOrCreate(
                ['name' => $stateName, 'state_id' => 0]
            );

            foreach ($cities as $cityName) {
                Location::firstOrCreate(
                    ['name' => $cityName, 'state_id' => $state->id]
                );
            }
        }
    }
}
