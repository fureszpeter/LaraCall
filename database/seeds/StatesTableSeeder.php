<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('states')->delete();
        
        \DB::table('states')->insert(array (
            0 => 
            array (
                'id' => 1,
                'stateName' => 'Alaska',
                'stateCode' => 'AK',
                'country_id' => 233,
            ),
            1 => 
            array (
                'id' => 2,
                'stateName' => 'Alabama',
                'stateCode' => 'AL',
                'country_id' => 233,
            ),
            2 => 
            array (
                'id' => 3,
                'stateName' => 'American Samoa',
                'stateCode' => 'AS',
                'country_id' => 233,
            ),
            3 => 
            array (
                'id' => 4,
                'stateName' => 'Arizona',
                'stateCode' => 'AZ',
                'country_id' => 233,
            ),
            4 => 
            array (
                'id' => 5,
                'stateName' => 'Arkansas',
                'stateCode' => 'AR',
                'country_id' => 233,
            ),
            5 => 
            array (
                'id' => 6,
                'stateName' => 'California',
                'stateCode' => 'CA',
                'country_id' => 233,
            ),
            6 => 
            array (
                'id' => 7,
                'stateName' => 'Colorado',
                'stateCode' => 'CO',
                'country_id' => 233,
            ),
            7 => 
            array (
                'id' => 8,
                'stateName' => 'Connecticut',
                'stateCode' => 'CT',
                'country_id' => 233,
            ),
            8 => 
            array (
                'id' => 9,
                'stateName' => 'Delaware',
                'stateCode' => 'DE',
                'country_id' => 233,
            ),
            9 => 
            array (
                'id' => 10,
                'stateName' => 'District of Columbia',
                'stateCode' => 'DC',
                'country_id' => 233,
            ),
            10 => 
            array (
                'id' => 11,
                'stateName' => 'Federated States of Micronesia',
                'stateCode' => 'FM',
                'country_id' => 233,
            ),
            11 => 
            array (
                'id' => 12,
                'stateName' => 'Florida',
                'stateCode' => 'FL',
                'country_id' => 233,
            ),
            12 => 
            array (
                'id' => 13,
                'stateName' => 'Georgia',
                'stateCode' => 'GA',
                'country_id' => 233,
            ),
            13 => 
            array (
                'id' => 14,
                'stateName' => 'Guam',
                'stateCode' => 'GU',
                'country_id' => 233,
            ),
            14 => 
            array (
                'id' => 15,
                'stateName' => 'Hawaii',
                'stateCode' => 'HI',
                'country_id' => 233,
            ),
            15 => 
            array (
                'id' => 16,
                'stateName' => 'Idaho',
                'stateCode' => 'ID',
                'country_id' => 233,
            ),
            16 => 
            array (
                'id' => 17,
                'stateName' => 'Illinois',
                'stateCode' => 'IL',
                'country_id' => 233,
            ),
            17 => 
            array (
                'id' => 18,
                'stateName' => 'Indiana',
                'stateCode' => 'IN',
                'country_id' => 233,
            ),
            18 => 
            array (
                'id' => 19,
                'stateName' => 'Iowa',
                'stateCode' => 'IA',
                'country_id' => 233,
            ),
            19 => 
            array (
                'id' => 20,
                'stateName' => 'Kansas',
                'stateCode' => 'KS',
                'country_id' => 233,
            ),
            20 => 
            array (
                'id' => 21,
                'stateName' => 'Kentucky',
                'stateCode' => 'KY',
                'country_id' => 233,
            ),
            21 => 
            array (
                'id' => 22,
                'stateName' => 'Louisiana',
                'stateCode' => 'LA',
                'country_id' => 233,
            ),
            22 => 
            array (
                'id' => 23,
                'stateName' => 'Maine',
                'stateCode' => 'ME',
                'country_id' => 233,
            ),
            23 => 
            array (
                'id' => 24,
                'stateName' => 'Marshall Islands',
                'stateCode' => 'MH',
                'country_id' => 233,
            ),
            24 => 
            array (
                'id' => 25,
                'stateName' => 'Maryland',
                'stateCode' => 'MD',
                'country_id' => 233,
            ),
            25 => 
            array (
                'id' => 26,
                'stateName' => 'Massachusetts',
                'stateCode' => 'MA',
                'country_id' => 233,
            ),
            26 => 
            array (
                'id' => 27,
                'stateName' => 'Michigan',
                'stateCode' => 'MI',
                'country_id' => 233,
            ),
            27 => 
            array (
                'id' => 28,
                'stateName' => 'Minnesota',
                'stateCode' => 'MN',
                'country_id' => 233,
            ),
            28 => 
            array (
                'id' => 29,
                'stateName' => 'Mississippi',
                'stateCode' => 'MS',
                'country_id' => 233,
            ),
            29 => 
            array (
                'id' => 30,
                'stateName' => 'Missouri',
                'stateCode' => 'MO',
                'country_id' => 233,
            ),
            30 => 
            array (
                'id' => 31,
                'stateName' => 'Montana',
                'stateCode' => 'MT',
                'country_id' => 233,
            ),
            31 => 
            array (
                'id' => 32,
                'stateName' => 'Nebraska',
                'stateCode' => 'NE',
                'country_id' => 233,
            ),
            32 => 
            array (
                'id' => 33,
                'stateName' => 'Nevada',
                'stateCode' => 'NV',
                'country_id' => 233,
            ),
            33 => 
            array (
                'id' => 34,
                'stateName' => 'New Hampshire',
                'stateCode' => 'NH',
                'country_id' => 233,
            ),
            34 => 
            array (
                'id' => 35,
                'stateName' => 'New Jersey',
                'stateCode' => 'NJ',
                'country_id' => 233,
            ),
            35 => 
            array (
                'id' => 36,
                'stateName' => 'New Mexico',
                'stateCode' => 'NM',
                'country_id' => 233,
            ),
            36 => 
            array (
                'id' => 37,
                'stateName' => 'New York',
                'stateCode' => 'NY',
                'country_id' => 233,
            ),
            37 => 
            array (
                'id' => 38,
                'stateName' => 'North Carolina',
                'stateCode' => 'NC',
                'country_id' => 233,
            ),
            38 => 
            array (
                'id' => 39,
                'stateName' => 'North Dakota',
                'stateCode' => 'ND',
                'country_id' => 233,
            ),
            39 => 
            array (
                'id' => 40,
                'stateName' => 'Northern Mariana Islands',
                'stateCode' => 'MP',
                'country_id' => 233,
            ),
            40 => 
            array (
                'id' => 41,
                'stateName' => 'Ohio',
                'stateCode' => 'OH',
                'country_id' => 233,
            ),
            41 => 
            array (
                'id' => 42,
                'stateName' => 'Oklahoma',
                'stateCode' => 'OK',
                'country_id' => 233,
            ),
            42 => 
            array (
                'id' => 43,
                'stateName' => 'Oregon',
                'stateCode' => 'OR',
                'country_id' => 233,
            ),
            43 => 
            array (
                'id' => 44,
                'stateName' => 'Palau',
                'stateCode' => 'PW',
                'country_id' => 233,
            ),
            44 => 
            array (
                'id' => 45,
                'stateName' => 'Pennsylvania',
                'stateCode' => 'PA',
                'country_id' => 233,
            ),
            45 => 
            array (
                'id' => 46,
                'stateName' => 'Puerto Rico',
                'stateCode' => 'PR',
                'country_id' => 233,
            ),
            46 => 
            array (
                'id' => 47,
                'stateName' => 'Rhode Island',
                'stateCode' => 'RI',
                'country_id' => 233,
            ),
            47 => 
            array (
                'id' => 48,
                'stateName' => 'South Carolina',
                'stateCode' => 'SC',
                'country_id' => 233,
            ),
            48 => 
            array (
                'id' => 49,
                'stateName' => 'South Dakota',
                'stateCode' => 'SD',
                'country_id' => 233,
            ),
            49 => 
            array (
                'id' => 50,
                'stateName' => 'Tennessee',
                'stateCode' => 'TN',
                'country_id' => 233,
            ),
            50 => 
            array (
                'id' => 51,
                'stateName' => 'Texas',
                'stateCode' => 'TX',
                'country_id' => 233,
            ),
            51 => 
            array (
                'id' => 52,
                'stateName' => 'Utah',
                'stateCode' => 'UT',
                'country_id' => 233,
            ),
            52 => 
            array (
                'id' => 53,
                'stateName' => 'Vermont',
                'stateCode' => 'VT',
                'country_id' => 233,
            ),
            53 => 
            array (
                'id' => 54,
                'stateName' => 'Virgin Islands',
                'stateCode' => 'VI',
                'country_id' => 233,
            ),
            54 => 
            array (
                'id' => 55,
                'stateName' => 'Virginia',
                'stateCode' => 'VA',
                'country_id' => 233,
            ),
            55 => 
            array (
                'id' => 56,
                'stateName' => 'Washington',
                'stateCode' => 'WA',
                'country_id' => 233,
            ),
            56 => 
            array (
                'id' => 57,
                'stateName' => 'West Virginia',
                'stateCode' => 'WV',
                'country_id' => 233,
            ),
            57 => 
            array (
                'id' => 58,
                'stateName' => 'Wisconsin',
                'stateCode' => 'WI',
                'country_id' => 233,
            ),
            58 => 
            array (
                'id' => 59,
                'stateName' => 'Wyoming',
                'stateCode' => 'WY',
                'country_id' => 233,
            ),
            59 => 
            array (
                'id' => 60,
                'stateName' => 'Armed Forces Africa',
                'stateCode' => 'AE',
                'country_id' => 233,
            ),
            60 => 
            array (
                'id' => 61,
            'stateName' => 'Armed Forces Americas (except Canada)',
                'stateCode' => 'AA',
                'country_id' => 233,
            ),
            61 => 
            array (
                'id' => 62,
                'stateName' => 'Armed Forces Canada',
                'stateCode' => 'AE',
                'country_id' => 233,
            ),
            62 => 
            array (
                'id' => 63,
                'stateName' => 'Armed Forces Europe',
                'stateCode' => 'AE',
                'country_id' => 233,
            ),
            63 => 
            array (
                'id' => 64,
                'stateName' => 'Armed Forces Middle East',
                'stateCode' => 'AE',
                'country_id' => 233,
            ),
            64 => 
            array (
                'id' => 65,
                'stateName' => 'Armed Forces Pacific',
                'stateCode' => 'AP',
                'country_id' => 233,
            ),
        ));
        
        
    }
}
