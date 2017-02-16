<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'countryCode' => 'AD',
                'countryName' => 'Andorra',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'AND',
            ),
            1 => 
            array (
                'id' => 2,
                'countryCode' => 'AE',
                'countryName' => 'United Arab Emirates',
                'currencyCode' => 'AED',
                'isoAlpha3' => 'ARE',
            ),
            2 => 
            array (
                'id' => 3,
                'countryCode' => 'AF',
                'countryName' => 'Afghanistan',
                'currencyCode' => 'AFN',
                'isoAlpha3' => 'AFG',
            ),
            3 => 
            array (
                'id' => 4,
                'countryCode' => 'AG',
                'countryName' => 'Antigua and Barbuda',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'ATG',
            ),
            4 => 
            array (
                'id' => 5,
                'countryCode' => 'AI',
                'countryName' => 'Anguilla',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'AIA',
            ),
            5 => 
            array (
                'id' => 6,
                'countryCode' => 'AL',
                'countryName' => 'Albania',
                'currencyCode' => 'ALL',
                'isoAlpha3' => 'ALB',
            ),
            6 => 
            array (
                'id' => 7,
                'countryCode' => 'AM',
                'countryName' => 'Armenia',
                'currencyCode' => 'AMD',
                'isoAlpha3' => 'ARM',
            ),
            7 => 
            array (
                'id' => 8,
                'countryCode' => 'AO',
                'countryName' => 'Angola',
                'currencyCode' => 'AOA',
                'isoAlpha3' => 'AGO',
            ),
            8 => 
            array (
                'id' => 9,
                'countryCode' => 'AQ',
                'countryName' => 'Antarctica',
                'currencyCode' => '',
                'isoAlpha3' => 'ATA',
            ),
            9 => 
            array (
                'id' => 10,
                'countryCode' => 'AR',
                'countryName' => 'Argentina',
                'currencyCode' => 'ARS',
                'isoAlpha3' => 'ARG',
            ),
            10 => 
            array (
                'id' => 11,
                'countryCode' => 'AS',
                'countryName' => 'American Samoa',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'ASM',
            ),
            11 => 
            array (
                'id' => 12,
                'countryCode' => 'AT',
                'countryName' => 'Austria',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'AUT',
            ),
            12 => 
            array (
                'id' => 13,
                'countryCode' => 'AU',
                'countryName' => 'Australia',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'AUS',
            ),
            13 => 
            array (
                'id' => 14,
                'countryCode' => 'AW',
                'countryName' => 'Aruba',
                'currencyCode' => 'AWG',
                'isoAlpha3' => 'ABW',
            ),
            14 => 
            array (
                'id' => 15,
                'countryCode' => 'AX',
                'countryName' => 'Åland',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'ALA',
            ),
            15 => 
            array (
                'id' => 16,
                'countryCode' => 'AZ',
                'countryName' => 'Azerbaijan',
                'currencyCode' => 'AZN',
                'isoAlpha3' => 'AZE',
            ),
            16 => 
            array (
                'id' => 17,
                'countryCode' => 'BA',
                'countryName' => 'Bosnia and Herzegovina',
                'currencyCode' => 'BAM',
                'isoAlpha3' => 'BIH',
            ),
            17 => 
            array (
                'id' => 18,
                'countryCode' => 'BB',
                'countryName' => 'Barbados',
                'currencyCode' => 'BBD',
                'isoAlpha3' => 'BRB',
            ),
            18 => 
            array (
                'id' => 19,
                'countryCode' => 'BD',
                'countryName' => 'Bangladesh',
                'currencyCode' => 'BDT',
                'isoAlpha3' => 'BGD',
            ),
            19 => 
            array (
                'id' => 20,
                'countryCode' => 'BE',
                'countryName' => 'Belgium',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'BEL',
            ),
            20 => 
            array (
                'id' => 21,
                'countryCode' => 'BF',
                'countryName' => 'Burkina Faso',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'BFA',
            ),
            21 => 
            array (
                'id' => 22,
                'countryCode' => 'BG',
                'countryName' => 'Bulgaria',
                'currencyCode' => 'BGN',
                'isoAlpha3' => 'BGR',
            ),
            22 => 
            array (
                'id' => 23,
                'countryCode' => 'BH',
                'countryName' => 'Bahrain',
                'currencyCode' => 'BHD',
                'isoAlpha3' => 'BHR',
            ),
            23 => 
            array (
                'id' => 24,
                'countryCode' => 'BI',
                'countryName' => 'Burundi',
                'currencyCode' => 'BIF',
                'isoAlpha3' => 'BDI',
            ),
            24 => 
            array (
                'id' => 25,
                'countryCode' => 'BJ',
                'countryName' => 'Benin',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'BEN',
            ),
            25 => 
            array (
                'id' => 26,
                'countryCode' => 'BL',
                'countryName' => 'Saint Barthélemy',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'BLM',
            ),
            26 => 
            array (
                'id' => 27,
                'countryCode' => 'BM',
                'countryName' => 'Bermuda',
                'currencyCode' => 'BMD',
                'isoAlpha3' => 'BMU',
            ),
            27 => 
            array (
                'id' => 28,
                'countryCode' => 'BN',
                'countryName' => 'Brunei',
                'currencyCode' => 'BND',
                'isoAlpha3' => 'BRN',
            ),
            28 => 
            array (
                'id' => 29,
                'countryCode' => 'BO',
                'countryName' => 'Bolivia',
                'currencyCode' => 'BOB',
                'isoAlpha3' => 'BOL',
            ),
            29 => 
            array (
                'id' => 30,
                'countryCode' => 'BQ',
                'countryName' => 'Bonaire',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'BES',
            ),
            30 => 
            array (
                'id' => 31,
                'countryCode' => 'BR',
                'countryName' => 'Brazil',
                'currencyCode' => 'BRL',
                'isoAlpha3' => 'BRA',
            ),
            31 => 
            array (
                'id' => 32,
                'countryCode' => 'BS',
                'countryName' => 'Bahamas',
                'currencyCode' => 'BSD',
                'isoAlpha3' => 'BHS',
            ),
            32 => 
            array (
                'id' => 33,
                'countryCode' => 'BT',
                'countryName' => 'Bhutan',
                'currencyCode' => 'BTN',
                'isoAlpha3' => 'BTN',
            ),
            33 => 
            array (
                'id' => 34,
                'countryCode' => 'BV',
                'countryName' => 'Bouvet Island',
                'currencyCode' => 'NOK',
                'isoAlpha3' => 'BVT',
            ),
            34 => 
            array (
                'id' => 35,
                'countryCode' => 'BW',
                'countryName' => 'Botswana',
                'currencyCode' => 'BWP',
                'isoAlpha3' => 'BWA',
            ),
            35 => 
            array (
                'id' => 36,
                'countryCode' => 'BY',
                'countryName' => 'Belarus',
                'currencyCode' => 'BYR',
                'isoAlpha3' => 'BLR',
            ),
            36 => 
            array (
                'id' => 37,
                'countryCode' => 'BZ',
                'countryName' => 'Belize',
                'currencyCode' => 'BZD',
                'isoAlpha3' => 'BLZ',
            ),
            37 => 
            array (
                'id' => 38,
                'countryCode' => 'CA',
                'countryName' => 'Canada',
                'currencyCode' => 'CAD',
                'isoAlpha3' => 'CAN',
            ),
            38 => 
            array (
                'id' => 39,
                'countryCode' => 'CC',
                'countryName' => 'Cocos [Keeling] Islands',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'CCK',
            ),
            39 => 
            array (
                'id' => 40,
                'countryCode' => 'CD',
                'countryName' => 'Democratic Republic of the Congo',
                'currencyCode' => 'CDF',
                'isoAlpha3' => 'COD',
            ),
            40 => 
            array (
                'id' => 41,
                'countryCode' => 'CF',
                'countryName' => 'Central African Republic',
                'currencyCode' => 'XAF',
                'isoAlpha3' => 'CAF',
            ),
            41 => 
            array (
                'id' => 42,
                'countryCode' => 'CG',
                'countryName' => 'Republic of the Congo',
                'currencyCode' => 'XAF',
                'isoAlpha3' => 'COG',
            ),
            42 => 
            array (
                'id' => 43,
                'countryCode' => 'CH',
                'countryName' => 'Switzerland',
                'currencyCode' => 'CHF',
                'isoAlpha3' => 'CHE',
            ),
            43 => 
            array (
                'id' => 44,
                'countryCode' => 'CI',
                'countryName' => 'Ivory Coast',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'CIV',
            ),
            44 => 
            array (
                'id' => 45,
                'countryCode' => 'CK',
                'countryName' => 'Cook Islands',
                'currencyCode' => 'NZD',
                'isoAlpha3' => 'COK',
            ),
            45 => 
            array (
                'id' => 46,
                'countryCode' => 'CL',
                'countryName' => 'Chile',
                'currencyCode' => 'CLP',
                'isoAlpha3' => 'CHL',
            ),
            46 => 
            array (
                'id' => 47,
                'countryCode' => 'CM',
                'countryName' => 'Cameroon',
                'currencyCode' => 'XAF',
                'isoAlpha3' => 'CMR',
            ),
            47 => 
            array (
                'id' => 48,
                'countryCode' => 'CN',
                'countryName' => 'China',
                'currencyCode' => 'CNY',
                'isoAlpha3' => 'CHN',
            ),
            48 => 
            array (
                'id' => 49,
                'countryCode' => 'CO',
                'countryName' => 'Colombia',
                'currencyCode' => 'COP',
                'isoAlpha3' => 'COL',
            ),
            49 => 
            array (
                'id' => 50,
                'countryCode' => 'CR',
                'countryName' => 'Costa Rica',
                'currencyCode' => 'CRC',
                'isoAlpha3' => 'CRI',
            ),
            50 => 
            array (
                'id' => 51,
                'countryCode' => 'CU',
                'countryName' => 'Cuba',
                'currencyCode' => 'CUP',
                'isoAlpha3' => 'CUB',
            ),
            51 => 
            array (
                'id' => 52,
                'countryCode' => 'CV',
                'countryName' => 'Cape Verde',
                'currencyCode' => 'CVE',
                'isoAlpha3' => 'CPV',
            ),
            52 => 
            array (
                'id' => 53,
                'countryCode' => 'CW',
                'countryName' => 'Curacao',
                'currencyCode' => 'ANG',
                'isoAlpha3' => 'CUW',
            ),
            53 => 
            array (
                'id' => 54,
                'countryCode' => 'CX',
                'countryName' => 'Christmas Island',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'CXR',
            ),
            54 => 
            array (
                'id' => 55,
                'countryCode' => 'CY',
                'countryName' => 'Cyprus',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'CYP',
            ),
            55 => 
            array (
                'id' => 56,
                'countryCode' => 'CZ',
                'countryName' => 'Czech Republic',
                'currencyCode' => 'CZK',
                'isoAlpha3' => 'CZE',
            ),
            56 => 
            array (
                'id' => 57,
                'countryCode' => 'DE',
                'countryName' => 'Germany',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'DEU',
            ),
            57 => 
            array (
                'id' => 58,
                'countryCode' => 'DJ',
                'countryName' => 'Djibouti',
                'currencyCode' => 'DJF',
                'isoAlpha3' => 'DJI',
            ),
            58 => 
            array (
                'id' => 59,
                'countryCode' => 'DK',
                'countryName' => 'Denmark',
                'currencyCode' => 'DKK',
                'isoAlpha3' => 'DNK',
            ),
            59 => 
            array (
                'id' => 60,
                'countryCode' => 'DM',
                'countryName' => 'Dominica',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'DMA',
            ),
            60 => 
            array (
                'id' => 61,
                'countryCode' => 'DO',
                'countryName' => 'Dominican Republic',
                'currencyCode' => 'DOP',
                'isoAlpha3' => 'DOM',
            ),
            61 => 
            array (
                'id' => 62,
                'countryCode' => 'DZ',
                'countryName' => 'Algeria',
                'currencyCode' => 'DZD',
                'isoAlpha3' => 'DZA',
            ),
            62 => 
            array (
                'id' => 63,
                'countryCode' => 'EC',
                'countryName' => 'Ecuador',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'ECU',
            ),
            63 => 
            array (
                'id' => 64,
                'countryCode' => 'EE',
                'countryName' => 'Estonia',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'EST',
            ),
            64 => 
            array (
                'id' => 65,
                'countryCode' => 'EG',
                'countryName' => 'Egypt',
                'currencyCode' => 'EGP',
                'isoAlpha3' => 'EGY',
            ),
            65 => 
            array (
                'id' => 66,
                'countryCode' => 'EH',
                'countryName' => 'Western Sahara',
                'currencyCode' => 'MAD',
                'isoAlpha3' => 'ESH',
            ),
            66 => 
            array (
                'id' => 67,
                'countryCode' => 'ER',
                'countryName' => 'Eritrea',
                'currencyCode' => 'ERN',
                'isoAlpha3' => 'ERI',
            ),
            67 => 
            array (
                'id' => 68,
                'countryCode' => 'ES',
                'countryName' => 'Spain',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'ESP',
            ),
            68 => 
            array (
                'id' => 69,
                'countryCode' => 'ET',
                'countryName' => 'Ethiopia',
                'currencyCode' => 'ETB',
                'isoAlpha3' => 'ETH',
            ),
            69 => 
            array (
                'id' => 70,
                'countryCode' => 'FI',
                'countryName' => 'Finland',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'FIN',
            ),
            70 => 
            array (
                'id' => 71,
                'countryCode' => 'FJ',
                'countryName' => 'Fiji',
                'currencyCode' => 'FJD',
                'isoAlpha3' => 'FJI',
            ),
            71 => 
            array (
                'id' => 72,
                'countryCode' => 'FK',
                'countryName' => 'Falkland Islands',
                'currencyCode' => 'FKP',
                'isoAlpha3' => 'FLK',
            ),
            72 => 
            array (
                'id' => 73,
                'countryCode' => 'FM',
                'countryName' => 'Micronesia',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'FSM',
            ),
            73 => 
            array (
                'id' => 74,
                'countryCode' => 'FO',
                'countryName' => 'Faroe Islands',
                'currencyCode' => 'DKK',
                'isoAlpha3' => 'FRO',
            ),
            74 => 
            array (
                'id' => 75,
                'countryCode' => 'FR',
                'countryName' => 'France',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'FRA',
            ),
            75 => 
            array (
                'id' => 76,
                'countryCode' => 'GA',
                'countryName' => 'Gabon',
                'currencyCode' => 'XAF',
                'isoAlpha3' => 'GAB',
            ),
            76 => 
            array (
                'id' => 77,
                'countryCode' => 'GB',
                'countryName' => 'United Kingdom',
                'currencyCode' => 'GBP',
                'isoAlpha3' => 'GBR',
            ),
            77 => 
            array (
                'id' => 78,
                'countryCode' => 'GD',
                'countryName' => 'Grenada',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'GRD',
            ),
            78 => 
            array (
                'id' => 79,
                'countryCode' => 'GE',
                'countryName' => 'Georgia',
                'currencyCode' => 'GEL',
                'isoAlpha3' => 'GEO',
            ),
            79 => 
            array (
                'id' => 80,
                'countryCode' => 'GF',
                'countryName' => 'French Guiana',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'GUF',
            ),
            80 => 
            array (
                'id' => 81,
                'countryCode' => 'GG',
                'countryName' => 'Guernsey',
                'currencyCode' => 'GBP',
                'isoAlpha3' => 'GGY',
            ),
            81 => 
            array (
                'id' => 82,
                'countryCode' => 'GH',
                'countryName' => 'Ghana',
                'currencyCode' => 'GHS',
                'isoAlpha3' => 'GHA',
            ),
            82 => 
            array (
                'id' => 83,
                'countryCode' => 'GI',
                'countryName' => 'Gibraltar',
                'currencyCode' => 'GIP',
                'isoAlpha3' => 'GIB',
            ),
            83 => 
            array (
                'id' => 84,
                'countryCode' => 'GL',
                'countryName' => 'Greenland',
                'currencyCode' => 'DKK',
                'isoAlpha3' => 'GRL',
            ),
            84 => 
            array (
                'id' => 85,
                'countryCode' => 'GM',
                'countryName' => 'Gambia',
                'currencyCode' => 'GMD',
                'isoAlpha3' => 'GMB',
            ),
            85 => 
            array (
                'id' => 86,
                'countryCode' => 'GN',
                'countryName' => 'Guinea',
                'currencyCode' => 'GNF',
                'isoAlpha3' => 'GIN',
            ),
            86 => 
            array (
                'id' => 87,
                'countryCode' => 'GP',
                'countryName' => 'Guadeloupe',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'GLP',
            ),
            87 => 
            array (
                'id' => 88,
                'countryCode' => 'GQ',
                'countryName' => 'Equatorial Guinea',
                'currencyCode' => 'XAF',
                'isoAlpha3' => 'GNQ',
            ),
            88 => 
            array (
                'id' => 89,
                'countryCode' => 'GR',
                'countryName' => 'Greece',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'GRC',
            ),
            89 => 
            array (
                'id' => 90,
                'countryCode' => 'GS',
                'countryName' => 'South Georgia and the South Sandwich Islands',
                'currencyCode' => 'GBP',
                'isoAlpha3' => 'SGS',
            ),
            90 => 
            array (
                'id' => 91,
                'countryCode' => 'GT',
                'countryName' => 'Guatemala',
                'currencyCode' => 'GTQ',
                'isoAlpha3' => 'GTM',
            ),
            91 => 
            array (
                'id' => 92,
                'countryCode' => 'GU',
                'countryName' => 'Guam',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'GUM',
            ),
            92 => 
            array (
                'id' => 93,
                'countryCode' => 'GW',
                'countryName' => 'Guinea-Bissau',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'GNB',
            ),
            93 => 
            array (
                'id' => 94,
                'countryCode' => 'GY',
                'countryName' => 'Guyana',
                'currencyCode' => 'GYD',
                'isoAlpha3' => 'GUY',
            ),
            94 => 
            array (
                'id' => 95,
                'countryCode' => 'HK',
                'countryName' => 'Hong Kong',
                'currencyCode' => 'HKD',
                'isoAlpha3' => 'HKG',
            ),
            95 => 
            array (
                'id' => 96,
                'countryCode' => 'HM',
                'countryName' => 'Heard Island and McDonald Islands',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'HMD',
            ),
            96 => 
            array (
                'id' => 97,
                'countryCode' => 'HN',
                'countryName' => 'Honduras',
                'currencyCode' => 'HNL',
                'isoAlpha3' => 'HND',
            ),
            97 => 
            array (
                'id' => 98,
                'countryCode' => 'HR',
                'countryName' => 'Croatia',
                'currencyCode' => 'HRK',
                'isoAlpha3' => 'HRV',
            ),
            98 => 
            array (
                'id' => 99,
                'countryCode' => 'HT',
                'countryName' => 'Haiti',
                'currencyCode' => 'HTG',
                'isoAlpha3' => 'HTI',
            ),
            99 => 
            array (
                'id' => 100,
                'countryCode' => 'HU',
                'countryName' => 'Hungary',
                'currencyCode' => 'HUF',
                'isoAlpha3' => 'HUN',
            ),
            100 => 
            array (
                'id' => 101,
                'countryCode' => 'ID',
                'countryName' => 'Indonesia',
                'currencyCode' => 'IDR',
                'isoAlpha3' => 'IDN',
            ),
            101 => 
            array (
                'id' => 102,
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'IRL',
            ),
            102 => 
            array (
                'id' => 103,
                'countryCode' => 'IL',
                'countryName' => 'Israel',
                'currencyCode' => 'ILS',
                'isoAlpha3' => 'ISR',
            ),
            103 => 
            array (
                'id' => 104,
                'countryCode' => 'IM',
                'countryName' => 'Isle of Man',
                'currencyCode' => 'GBP',
                'isoAlpha3' => 'IMN',
            ),
            104 => 
            array (
                'id' => 105,
                'countryCode' => 'IN',
                'countryName' => 'India',
                'currencyCode' => 'INR',
                'isoAlpha3' => 'IND',
            ),
            105 => 
            array (
                'id' => 106,
                'countryCode' => 'IO',
                'countryName' => 'British Indian Ocean Territory',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'IOT',
            ),
            106 => 
            array (
                'id' => 107,
                'countryCode' => 'IQ',
                'countryName' => 'Iraq',
                'currencyCode' => 'IQD',
                'isoAlpha3' => 'IRQ',
            ),
            107 => 
            array (
                'id' => 108,
                'countryCode' => 'IR',
                'countryName' => 'Iran',
                'currencyCode' => 'IRR',
                'isoAlpha3' => 'IRN',
            ),
            108 => 
            array (
                'id' => 109,
                'countryCode' => 'IS',
                'countryName' => 'Iceland',
                'currencyCode' => 'ISK',
                'isoAlpha3' => 'ISL',
            ),
            109 => 
            array (
                'id' => 110,
                'countryCode' => 'IT',
                'countryName' => 'Italy',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'ITA',
            ),
            110 => 
            array (
                'id' => 111,
                'countryCode' => 'JE',
                'countryName' => 'Jersey',
                'currencyCode' => 'GBP',
                'isoAlpha3' => 'JEY',
            ),
            111 => 
            array (
                'id' => 112,
                'countryCode' => 'JM',
                'countryName' => 'Jamaica',
                'currencyCode' => 'JMD',
                'isoAlpha3' => 'JAM',
            ),
            112 => 
            array (
                'id' => 113,
                'countryCode' => 'JO',
                'countryName' => 'Jordan',
                'currencyCode' => 'JOD',
                'isoAlpha3' => 'JOR',
            ),
            113 => 
            array (
                'id' => 114,
                'countryCode' => 'JP',
                'countryName' => 'Japan',
                'currencyCode' => 'JPY',
                'isoAlpha3' => 'JPN',
            ),
            114 => 
            array (
                'id' => 115,
                'countryCode' => 'KE',
                'countryName' => 'Kenya',
                'currencyCode' => 'KES',
                'isoAlpha3' => 'KEN',
            ),
            115 => 
            array (
                'id' => 116,
                'countryCode' => 'KG',
                'countryName' => 'Kyrgyzstan',
                'currencyCode' => 'KGS',
                'isoAlpha3' => 'KGZ',
            ),
            116 => 
            array (
                'id' => 117,
                'countryCode' => 'KH',
                'countryName' => 'Cambodia',
                'currencyCode' => 'KHR',
                'isoAlpha3' => 'KHM',
            ),
            117 => 
            array (
                'id' => 118,
                'countryCode' => 'KI',
                'countryName' => 'Kiribati',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'KIR',
            ),
            118 => 
            array (
                'id' => 119,
                'countryCode' => 'KM',
                'countryName' => 'Comoros',
                'currencyCode' => 'KMF',
                'isoAlpha3' => 'COM',
            ),
            119 => 
            array (
                'id' => 120,
                'countryCode' => 'KN',
                'countryName' => 'Saint Kitts and Nevis',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'KNA',
            ),
            120 => 
            array (
                'id' => 121,
                'countryCode' => 'KP',
                'countryName' => 'North Korea',
                'currencyCode' => 'KPW',
                'isoAlpha3' => 'PRK',
            ),
            121 => 
            array (
                'id' => 122,
                'countryCode' => 'KR',
                'countryName' => 'South Korea',
                'currencyCode' => 'KRW',
                'isoAlpha3' => 'KOR',
            ),
            122 => 
            array (
                'id' => 123,
                'countryCode' => 'KW',
                'countryName' => 'Kuwait',
                'currencyCode' => 'KWD',
                'isoAlpha3' => 'KWT',
            ),
            123 => 
            array (
                'id' => 124,
                'countryCode' => 'KY',
                'countryName' => 'Cayman Islands',
                'currencyCode' => 'KYD',
                'isoAlpha3' => 'CYM',
            ),
            124 => 
            array (
                'id' => 125,
                'countryCode' => 'KZ',
                'countryName' => 'Kazakhstan',
                'currencyCode' => 'KZT',
                'isoAlpha3' => 'KAZ',
            ),
            125 => 
            array (
                'id' => 126,
                'countryCode' => 'LA',
                'countryName' => 'Laos',
                'currencyCode' => 'LAK',
                'isoAlpha3' => 'LAO',
            ),
            126 => 
            array (
                'id' => 127,
                'countryCode' => 'LB',
                'countryName' => 'Lebanon',
                'currencyCode' => 'LBP',
                'isoAlpha3' => 'LBN',
            ),
            127 => 
            array (
                'id' => 128,
                'countryCode' => 'LC',
                'countryName' => 'Saint Lucia',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'LCA',
            ),
            128 => 
            array (
                'id' => 129,
                'countryCode' => 'LI',
                'countryName' => 'Liechtenstein',
                'currencyCode' => 'CHF',
                'isoAlpha3' => 'LIE',
            ),
            129 => 
            array (
                'id' => 130,
                'countryCode' => 'LK',
                'countryName' => 'Sri Lanka',
                'currencyCode' => 'LKR',
                'isoAlpha3' => 'LKA',
            ),
            130 => 
            array (
                'id' => 131,
                'countryCode' => 'LR',
                'countryName' => 'Liberia',
                'currencyCode' => 'LRD',
                'isoAlpha3' => 'LBR',
            ),
            131 => 
            array (
                'id' => 132,
                'countryCode' => 'LS',
                'countryName' => 'Lesotho',
                'currencyCode' => 'LSL',
                'isoAlpha3' => 'LSO',
            ),
            132 => 
            array (
                'id' => 133,
                'countryCode' => 'LT',
                'countryName' => 'Lithuania',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'LTU',
            ),
            133 => 
            array (
                'id' => 134,
                'countryCode' => 'LU',
                'countryName' => 'Luxembourg',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'LUX',
            ),
            134 => 
            array (
                'id' => 135,
                'countryCode' => 'LV',
                'countryName' => 'Latvia',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'LVA',
            ),
            135 => 
            array (
                'id' => 136,
                'countryCode' => 'LY',
                'countryName' => 'Libya',
                'currencyCode' => 'LYD',
                'isoAlpha3' => 'LBY',
            ),
            136 => 
            array (
                'id' => 137,
                'countryCode' => 'MA',
                'countryName' => 'Morocco',
                'currencyCode' => 'MAD',
                'isoAlpha3' => 'MAR',
            ),
            137 => 
            array (
                'id' => 138,
                'countryCode' => 'MC',
                'countryName' => 'Monaco',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'MCO',
            ),
            138 => 
            array (
                'id' => 139,
                'countryCode' => 'MD',
                'countryName' => 'Moldova',
                'currencyCode' => 'MDL',
                'isoAlpha3' => 'MDA',
            ),
            139 => 
            array (
                'id' => 140,
                'countryCode' => 'ME',
                'countryName' => 'Montenegro',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'MNE',
            ),
            140 => 
            array (
                'id' => 141,
                'countryCode' => 'MF',
                'countryName' => 'Saint Martin',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'MAF',
            ),
            141 => 
            array (
                'id' => 142,
                'countryCode' => 'MG',
                'countryName' => 'Madagascar',
                'currencyCode' => 'MGA',
                'isoAlpha3' => 'MDG',
            ),
            142 => 
            array (
                'id' => 143,
                'countryCode' => 'MH',
                'countryName' => 'Marshall Islands',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'MHL',
            ),
            143 => 
            array (
                'id' => 144,
                'countryCode' => 'MK',
                'countryName' => 'Macedonia',
                'currencyCode' => 'MKD',
                'isoAlpha3' => 'MKD',
            ),
            144 => 
            array (
                'id' => 145,
                'countryCode' => 'ML',
                'countryName' => 'Mali',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'MLI',
            ),
            145 => 
            array (
                'id' => 146,
                'countryCode' => 'MM',
                'countryName' => 'Myanmar [Burma]',
                'currencyCode' => 'MMK',
                'isoAlpha3' => 'MMR',
            ),
            146 => 
            array (
                'id' => 147,
                'countryCode' => 'MN',
                'countryName' => 'Mongolia',
                'currencyCode' => 'MNT',
                'isoAlpha3' => 'MNG',
            ),
            147 => 
            array (
                'id' => 148,
                'countryCode' => 'MO',
                'countryName' => 'Macao',
                'currencyCode' => 'MOP',
                'isoAlpha3' => 'MAC',
            ),
            148 => 
            array (
                'id' => 149,
                'countryCode' => 'MP',
                'countryName' => 'Northern Mariana Islands',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'MNP',
            ),
            149 => 
            array (
                'id' => 150,
                'countryCode' => 'MQ',
                'countryName' => 'Martinique',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'MTQ',
            ),
            150 => 
            array (
                'id' => 151,
                'countryCode' => 'MR',
                'countryName' => 'Mauritania',
                'currencyCode' => 'MRO',
                'isoAlpha3' => 'MRT',
            ),
            151 => 
            array (
                'id' => 152,
                'countryCode' => 'MS',
                'countryName' => 'Montserrat',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'MSR',
            ),
            152 => 
            array (
                'id' => 153,
                'countryCode' => 'MT',
                'countryName' => 'Malta',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'MLT',
            ),
            153 => 
            array (
                'id' => 154,
                'countryCode' => 'MU',
                'countryName' => 'Mauritius',
                'currencyCode' => 'MUR',
                'isoAlpha3' => 'MUS',
            ),
            154 => 
            array (
                'id' => 155,
                'countryCode' => 'MV',
                'countryName' => 'Maldives',
                'currencyCode' => 'MVR',
                'isoAlpha3' => 'MDV',
            ),
            155 => 
            array (
                'id' => 156,
                'countryCode' => 'MW',
                'countryName' => 'Malawi',
                'currencyCode' => 'MWK',
                'isoAlpha3' => 'MWI',
            ),
            156 => 
            array (
                'id' => 157,
                'countryCode' => 'MX',
                'countryName' => 'Mexico',
                'currencyCode' => 'MXN',
                'isoAlpha3' => 'MEX',
            ),
            157 => 
            array (
                'id' => 158,
                'countryCode' => 'MY',
                'countryName' => 'Malaysia',
                'currencyCode' => 'MYR',
                'isoAlpha3' => 'MYS',
            ),
            158 => 
            array (
                'id' => 159,
                'countryCode' => 'MZ',
                'countryName' => 'Mozambique',
                'currencyCode' => 'MZN',
                'isoAlpha3' => 'MOZ',
            ),
            159 => 
            array (
                'id' => 160,
                'countryCode' => 'NA',
                'countryName' => 'Namibia',
                'currencyCode' => 'NAD',
                'isoAlpha3' => 'NAM',
            ),
            160 => 
            array (
                'id' => 161,
                'countryCode' => 'NC',
                'countryName' => 'New Caledonia',
                'currencyCode' => 'XPF',
                'isoAlpha3' => 'NCL',
            ),
            161 => 
            array (
                'id' => 162,
                'countryCode' => 'NE',
                'countryName' => 'Niger',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'NER',
            ),
            162 => 
            array (
                'id' => 163,
                'countryCode' => 'NF',
                'countryName' => 'Norfolk Island',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'NFK',
            ),
            163 => 
            array (
                'id' => 164,
                'countryCode' => 'NG',
                'countryName' => 'Nigeria',
                'currencyCode' => 'NGN',
                'isoAlpha3' => 'NGA',
            ),
            164 => 
            array (
                'id' => 165,
                'countryCode' => 'NI',
                'countryName' => 'Nicaragua',
                'currencyCode' => 'NIO',
                'isoAlpha3' => 'NIC',
            ),
            165 => 
            array (
                'id' => 166,
                'countryCode' => 'NL',
                'countryName' => 'Netherlands',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'NLD',
            ),
            166 => 
            array (
                'id' => 167,
                'countryCode' => 'NO',
                'countryName' => 'Norway',
                'currencyCode' => 'NOK',
                'isoAlpha3' => 'NOR',
            ),
            167 => 
            array (
                'id' => 168,
                'countryCode' => 'NP',
                'countryName' => 'Nepal',
                'currencyCode' => 'NPR',
                'isoAlpha3' => 'NPL',
            ),
            168 => 
            array (
                'id' => 169,
                'countryCode' => 'NR',
                'countryName' => 'Nauru',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'NRU',
            ),
            169 => 
            array (
                'id' => 170,
                'countryCode' => 'NU',
                'countryName' => 'Niue',
                'currencyCode' => 'NZD',
                'isoAlpha3' => 'NIU',
            ),
            170 => 
            array (
                'id' => 171,
                'countryCode' => 'NZ',
                'countryName' => 'New Zealand',
                'currencyCode' => 'NZD',
                'isoAlpha3' => 'NZL',
            ),
            171 => 
            array (
                'id' => 172,
                'countryCode' => 'OM',
                'countryName' => 'Oman',
                'currencyCode' => 'OMR',
                'isoAlpha3' => 'OMN',
            ),
            172 => 
            array (
                'id' => 173,
                'countryCode' => 'PA',
                'countryName' => 'Panama',
                'currencyCode' => 'PAB',
                'isoAlpha3' => 'PAN',
            ),
            173 => 
            array (
                'id' => 174,
                'countryCode' => 'PE',
                'countryName' => 'Peru',
                'currencyCode' => 'PEN',
                'isoAlpha3' => 'PER',
            ),
            174 => 
            array (
                'id' => 175,
                'countryCode' => 'PF',
                'countryName' => 'French Polynesia',
                'currencyCode' => 'XPF',
                'isoAlpha3' => 'PYF',
            ),
            175 => 
            array (
                'id' => 176,
                'countryCode' => 'PG',
                'countryName' => 'Papua New Guinea',
                'currencyCode' => 'PGK',
                'isoAlpha3' => 'PNG',
            ),
            176 => 
            array (
                'id' => 177,
                'countryCode' => 'PH',
                'countryName' => 'Philippines',
                'currencyCode' => 'PHP',
                'isoAlpha3' => 'PHL',
            ),
            177 => 
            array (
                'id' => 178,
                'countryCode' => 'PK',
                'countryName' => 'Pakistan',
                'currencyCode' => 'PKR',
                'isoAlpha3' => 'PAK',
            ),
            178 => 
            array (
                'id' => 179,
                'countryCode' => 'PL',
                'countryName' => 'Poland',
                'currencyCode' => 'PLN',
                'isoAlpha3' => 'POL',
            ),
            179 => 
            array (
                'id' => 180,
                'countryCode' => 'PM',
                'countryName' => 'Saint Pierre and Miquelon',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'SPM',
            ),
            180 => 
            array (
                'id' => 181,
                'countryCode' => 'PN',
                'countryName' => 'Pitcairn Islands',
                'currencyCode' => 'NZD',
                'isoAlpha3' => 'PCN',
            ),
            181 => 
            array (
                'id' => 182,
                'countryCode' => 'PR',
                'countryName' => 'Puerto Rico',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'PRI',
            ),
            182 => 
            array (
                'id' => 183,
                'countryCode' => 'PS',
                'countryName' => 'Palestine',
                'currencyCode' => 'ILS',
                'isoAlpha3' => 'PSE',
            ),
            183 => 
            array (
                'id' => 184,
                'countryCode' => 'PT',
                'countryName' => 'Portugal',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'PRT',
            ),
            184 => 
            array (
                'id' => 185,
                'countryCode' => 'PW',
                'countryName' => 'Palau',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'PLW',
            ),
            185 => 
            array (
                'id' => 186,
                'countryCode' => 'PY',
                'countryName' => 'Paraguay',
                'currencyCode' => 'PYG',
                'isoAlpha3' => 'PRY',
            ),
            186 => 
            array (
                'id' => 187,
                'countryCode' => 'QA',
                'countryName' => 'Qatar',
                'currencyCode' => 'QAR',
                'isoAlpha3' => 'QAT',
            ),
            187 => 
            array (
                'id' => 188,
                'countryCode' => 'RE',
                'countryName' => 'Réunion',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'REU',
            ),
            188 => 
            array (
                'id' => 189,
                'countryCode' => 'RO',
                'countryName' => 'Romania',
                'currencyCode' => 'RON',
                'isoAlpha3' => 'ROU',
            ),
            189 => 
            array (
                'id' => 190,
                'countryCode' => 'RS',
                'countryName' => 'Serbia',
                'currencyCode' => 'RSD',
                'isoAlpha3' => 'SRB',
            ),
            190 => 
            array (
                'id' => 191,
                'countryCode' => 'RU',
                'countryName' => 'Russia',
                'currencyCode' => 'RUB',
                'isoAlpha3' => 'RUS',
            ),
            191 => 
            array (
                'id' => 192,
                'countryCode' => 'RW',
                'countryName' => 'Rwanda',
                'currencyCode' => 'RWF',
                'isoAlpha3' => 'RWA',
            ),
            192 => 
            array (
                'id' => 193,
                'countryCode' => 'SA',
                'countryName' => 'Saudi Arabia',
                'currencyCode' => 'SAR',
                'isoAlpha3' => 'SAU',
            ),
            193 => 
            array (
                'id' => 194,
                'countryCode' => 'SB',
                'countryName' => 'Solomon Islands',
                'currencyCode' => 'SBD',
                'isoAlpha3' => 'SLB',
            ),
            194 => 
            array (
                'id' => 195,
                'countryCode' => 'SC',
                'countryName' => 'Seychelles',
                'currencyCode' => 'SCR',
                'isoAlpha3' => 'SYC',
            ),
            195 => 
            array (
                'id' => 196,
                'countryCode' => 'SD',
                'countryName' => 'Sudan',
                'currencyCode' => 'SDG',
                'isoAlpha3' => 'SDN',
            ),
            196 => 
            array (
                'id' => 197,
                'countryCode' => 'SE',
                'countryName' => 'Sweden',
                'currencyCode' => 'SEK',
                'isoAlpha3' => 'SWE',
            ),
            197 => 
            array (
                'id' => 198,
                'countryCode' => 'SG',
                'countryName' => 'Singapore',
                'currencyCode' => 'SGD',
                'isoAlpha3' => 'SGP',
            ),
            198 => 
            array (
                'id' => 199,
                'countryCode' => 'SH',
                'countryName' => 'Saint Helena',
                'currencyCode' => 'SHP',
                'isoAlpha3' => 'SHN',
            ),
            199 => 
            array (
                'id' => 200,
                'countryCode' => 'SI',
                'countryName' => 'Slovenia',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'SVN',
            ),
            200 => 
            array (
                'id' => 201,
                'countryCode' => 'SJ',
                'countryName' => 'Svalbard and Jan Mayen',
                'currencyCode' => 'NOK',
                'isoAlpha3' => 'SJM',
            ),
            201 => 
            array (
                'id' => 202,
                'countryCode' => 'SK',
                'countryName' => 'Slovakia',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'SVK',
            ),
            202 => 
            array (
                'id' => 203,
                'countryCode' => 'SL',
                'countryName' => 'Sierra Leone',
                'currencyCode' => 'SLL',
                'isoAlpha3' => 'SLE',
            ),
            203 => 
            array (
                'id' => 204,
                'countryCode' => 'SM',
                'countryName' => 'San Marino',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'SMR',
            ),
            204 => 
            array (
                'id' => 205,
                'countryCode' => 'SN',
                'countryName' => 'Senegal',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'SEN',
            ),
            205 => 
            array (
                'id' => 206,
                'countryCode' => 'SO',
                'countryName' => 'Somalia',
                'currencyCode' => 'SOS',
                'isoAlpha3' => 'SOM',
            ),
            206 => 
            array (
                'id' => 207,
                'countryCode' => 'SR',
                'countryName' => 'Suriname',
                'currencyCode' => 'SRD',
                'isoAlpha3' => 'SUR',
            ),
            207 => 
            array (
                'id' => 208,
                'countryCode' => 'SS',
                'countryName' => 'South Sudan',
                'currencyCode' => 'SSP',
                'isoAlpha3' => 'SSD',
            ),
            208 => 
            array (
                'id' => 209,
                'countryCode' => 'ST',
                'countryName' => 'São Tomé and Príncipe',
                'currencyCode' => 'STD',
                'isoAlpha3' => 'STP',
            ),
            209 => 
            array (
                'id' => 210,
                'countryCode' => 'SV',
                'countryName' => 'El Salvador',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'SLV',
            ),
            210 => 
            array (
                'id' => 211,
                'countryCode' => 'SX',
                'countryName' => 'Sint Maarten',
                'currencyCode' => 'ANG',
                'isoAlpha3' => 'SXM',
            ),
            211 => 
            array (
                'id' => 212,
                'countryCode' => 'SY',
                'countryName' => 'Syria',
                'currencyCode' => 'SYP',
                'isoAlpha3' => 'SYR',
            ),
            212 => 
            array (
                'id' => 213,
                'countryCode' => 'SZ',
                'countryName' => 'Swaziland',
                'currencyCode' => 'SZL',
                'isoAlpha3' => 'SWZ',
            ),
            213 => 
            array (
                'id' => 214,
                'countryCode' => 'TC',
                'countryName' => 'Turks and Caicos Islands',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'TCA',
            ),
            214 => 
            array (
                'id' => 215,
                'countryCode' => 'TD',
                'countryName' => 'Chad',
                'currencyCode' => 'XAF',
                'isoAlpha3' => 'TCD',
            ),
            215 => 
            array (
                'id' => 216,
                'countryCode' => 'TF',
                'countryName' => 'French Southern Territories',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'ATF',
            ),
            216 => 
            array (
                'id' => 217,
                'countryCode' => 'TG',
                'countryName' => 'Togo',
                'currencyCode' => 'XOF',
                'isoAlpha3' => 'TGO',
            ),
            217 => 
            array (
                'id' => 218,
                'countryCode' => 'TH',
                'countryName' => 'Thailand',
                'currencyCode' => 'THB',
                'isoAlpha3' => 'THA',
            ),
            218 => 
            array (
                'id' => 219,
                'countryCode' => 'TJ',
                'countryName' => 'Tajikistan',
                'currencyCode' => 'TJS',
                'isoAlpha3' => 'TJK',
            ),
            219 => 
            array (
                'id' => 220,
                'countryCode' => 'TK',
                'countryName' => 'Tokelau',
                'currencyCode' => 'NZD',
                'isoAlpha3' => 'TKL',
            ),
            220 => 
            array (
                'id' => 221,
                'countryCode' => 'TL',
                'countryName' => 'East Timor',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'TLS',
            ),
            221 => 
            array (
                'id' => 222,
                'countryCode' => 'TM',
                'countryName' => 'Turkmenistan',
                'currencyCode' => 'TMT',
                'isoAlpha3' => 'TKM',
            ),
            222 => 
            array (
                'id' => 223,
                'countryCode' => 'TN',
                'countryName' => 'Tunisia',
                'currencyCode' => 'TND',
                'isoAlpha3' => 'TUN',
            ),
            223 => 
            array (
                'id' => 224,
                'countryCode' => 'TO',
                'countryName' => 'Tonga',
                'currencyCode' => 'TOP',
                'isoAlpha3' => 'TON',
            ),
            224 => 
            array (
                'id' => 225,
                'countryCode' => 'TR',
                'countryName' => 'Turkey',
                'currencyCode' => 'TRY',
                'isoAlpha3' => 'TUR',
            ),
            225 => 
            array (
                'id' => 226,
                'countryCode' => 'TT',
                'countryName' => 'Trinidad and Tobago',
                'currencyCode' => 'TTD',
                'isoAlpha3' => 'TTO',
            ),
            226 => 
            array (
                'id' => 227,
                'countryCode' => 'TV',
                'countryName' => 'Tuvalu',
                'currencyCode' => 'AUD',
                'isoAlpha3' => 'TUV',
            ),
            227 => 
            array (
                'id' => 228,
                'countryCode' => 'TW',
                'countryName' => 'Taiwan',
                'currencyCode' => 'TWD',
                'isoAlpha3' => 'TWN',
            ),
            228 => 
            array (
                'id' => 229,
                'countryCode' => 'TZ',
                'countryName' => 'Tanzania',
                'currencyCode' => 'TZS',
                'isoAlpha3' => 'TZA',
            ),
            229 => 
            array (
                'id' => 230,
                'countryCode' => 'UA',
                'countryName' => 'Ukraine',
                'currencyCode' => 'UAH',
                'isoAlpha3' => 'UKR',
            ),
            230 => 
            array (
                'id' => 231,
                'countryCode' => 'UG',
                'countryName' => 'Uganda',
                'currencyCode' => 'UGX',
                'isoAlpha3' => 'UGA',
            ),
            231 => 
            array (
                'id' => 232,
                'countryCode' => 'UM',
                'countryName' => 'U.S. Minor Outlying Islands',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'UMI',
            ),
            232 => 
            array (
                'id' => 233,
                'countryCode' => 'US',
                'countryName' => 'United States',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'USA',
            ),
            233 => 
            array (
                'id' => 234,
                'countryCode' => 'UY',
                'countryName' => 'Uruguay',
                'currencyCode' => 'UYU',
                'isoAlpha3' => 'URY',
            ),
            234 => 
            array (
                'id' => 235,
                'countryCode' => 'UZ',
                'countryName' => 'Uzbekistan',
                'currencyCode' => 'UZS',
                'isoAlpha3' => 'UZB',
            ),
            235 => 
            array (
                'id' => 236,
                'countryCode' => 'VA',
                'countryName' => 'Vatican City',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'VAT',
            ),
            236 => 
            array (
                'id' => 237,
                'countryCode' => 'VC',
                'countryName' => 'Saint Vincent and the Grenadines',
                'currencyCode' => 'XCD',
                'isoAlpha3' => 'VCT',
            ),
            237 => 
            array (
                'id' => 238,
                'countryCode' => 'VE',
                'countryName' => 'Venezuela',
                'currencyCode' => 'VEF',
                'isoAlpha3' => 'VEN',
            ),
            238 => 
            array (
                'id' => 239,
                'countryCode' => 'VG',
                'countryName' => 'British Virgin Islands',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'VGB',
            ),
            239 => 
            array (
                'id' => 240,
                'countryCode' => 'VI',
                'countryName' => 'U.S. Virgin Islands',
                'currencyCode' => 'USD',
                'isoAlpha3' => 'VIR',
            ),
            240 => 
            array (
                'id' => 241,
                'countryCode' => 'VN',
                'countryName' => 'Vietnam',
                'currencyCode' => 'VND',
                'isoAlpha3' => 'VNM',
            ),
            241 => 
            array (
                'id' => 242,
                'countryCode' => 'VU',
                'countryName' => 'Vanuatu',
                'currencyCode' => 'VUV',
                'isoAlpha3' => 'VUT',
            ),
            242 => 
            array (
                'id' => 243,
                'countryCode' => 'WF',
                'countryName' => 'Wallis and Futuna',
                'currencyCode' => 'XPF',
                'isoAlpha3' => 'WLF',
            ),
            243 => 
            array (
                'id' => 244,
                'countryCode' => 'WS',
                'countryName' => 'Samoa',
                'currencyCode' => 'WST',
                'isoAlpha3' => 'WSM',
            ),
            244 => 
            array (
                'id' => 245,
                'countryCode' => 'XK',
                'countryName' => 'Kosovo',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'XKX',
            ),
            245 => 
            array (
                'id' => 246,
                'countryCode' => 'YE',
                'countryName' => 'Yemen',
                'currencyCode' => 'YER',
                'isoAlpha3' => 'YEM',
            ),
            246 => 
            array (
                'id' => 247,
                'countryCode' => 'YT',
                'countryName' => 'Mayotte',
                'currencyCode' => 'EUR',
                'isoAlpha3' => 'MYT',
            ),
            247 => 
            array (
                'id' => 248,
                'countryCode' => 'ZA',
                'countryName' => 'South Africa',
                'currencyCode' => 'ZAR',
                'isoAlpha3' => 'ZAF',
            ),
            248 => 
            array (
                'id' => 249,
                'countryCode' => 'ZM',
                'countryName' => 'Zambia',
                'currencyCode' => 'ZMW',
                'isoAlpha3' => 'ZMB',
            ),
            249 => 
            array (
                'id' => 250,
                'countryCode' => 'ZW',
                'countryName' => 'Zimbabwe',
                'currencyCode' => 'ZWL',
                'isoAlpha3' => 'ZWE',
            ),
        ));
        
        
    }
}
