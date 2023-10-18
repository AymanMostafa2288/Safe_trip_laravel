<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('install_countries')->delete();

        $countries = array(

            array('iso' => 'AF', 'name_en' => 'Afghanistan', 'iso3' => 'AFG', 'numcode' => '4', 'code' => '93'),
            array('iso' => 'AL', 'name_en' => 'Albania', 'iso3' => 'ALB', 'numcode' => '8', 'code' => '355'),
            array('iso' => 'DZ', 'name_en' => 'Algeria', 'iso3' => 'DZA', 'numcode' => '12', 'code' => '213'),
            array('iso' => 'AS', 'name_en' => 'American Samoa', 'iso3' => 'ASM', 'numcode' => '16', 'code' => '1684'),
            array('iso' => 'AD', 'name_en' => 'Andorra', 'iso3' => 'AND', 'numcode' => '20', 'code' => '376'),
            array('iso' => 'AO', 'name_en' => 'Angola', 'iso3' => 'AGO', 'numcode' => '24', 'code' => '244'),
            array('iso' => 'AI', 'name_en' => 'Anguilla', 'iso3' => 'AIA', 'numcode' => '660', 'code' => '1264'),
            array('iso' => 'AQ', 'name_en' => 'Antarctica', 'iso3' => NULL,'numcode' => NULL,'code' => '0'),
            array('iso' => 'AG', 'name_en' => 'Antigua and Barbuda', 'iso3' => 'ATG', 'numcode' => '28', 'code' => '1268'),
            array('iso' => 'AR', 'name_en' => 'Argentina', 'iso3' => 'ARG', 'numcode' => '32', 'code' => '54'),
            array('iso' => 'AM', 'name_en' => 'Armenia', 'iso3' => 'ARM', 'numcode' => '51', 'code' => '374'),
            array('iso' => 'AW', 'name_en' => 'Aruba', 'iso3' => 'ABW', 'numcode' => '533', 'code' => '297'),
            array('iso' => 'AU', 'name_en' => 'Australia', 'iso3' => 'AUS', 'numcode' => '36', 'code' => '61'),
            array('iso' => 'AT', 'name_en' => 'Austria', 'iso3' => 'AUT', 'numcode' => '40', 'code' => '43'),
            array('iso' => 'AZ', 'name_en' => 'Azerbaijan', 'iso3' => 'AZE', 'numcode' => '31', 'code' => '994'),
            array('iso' => 'BS', 'name_en' => 'Bahamas', 'iso3' => 'BHS', 'numcode' => '44', 'code' => '1242'),
            array('iso' => 'BH', 'name_en' => 'Bahrain', 'iso3' => 'BHR', 'numcode' => '48', 'code' => '973'),
            array('iso' => 'BD', 'name_en' => 'Bangladesh', 'iso3' => 'BGD', 'numcode' => '50', 'code' => '880'),
            array('iso' => 'BB', 'name_en' => 'Barbados', 'iso3' => 'BRB', 'numcode' => '52', 'code' => '1246'),
            array('iso' => 'BY', 'name_en' => 'Belarus', 'iso3' => 'BLR', 'numcode' => '112', 'code' => '375'),
            array('iso' => 'BE', 'name_en' => 'Belgium', 'iso3' => 'BEL', 'numcode' => '56', 'code' => '32'),
            array('iso' => 'BZ', 'name_en' => 'Belize', 'iso3' => 'BLZ', 'numcode' => '84', 'code' => '501'),
            array('iso' => 'BJ', 'name_en' => 'Benin', 'iso3' => 'BEN', 'numcode' => '204', 'code' => '229'),
            array('iso' => 'BM', 'name_en' => 'Bermuda', 'iso3' => 'BMU', 'numcode' => '60', 'code' => '1441'),
            array('iso' => 'BT', 'name_en' => 'Bhutan', 'iso3' => 'BTN', 'numcode' => '64', 'code' => '975'),
            array('iso' => 'BO', 'name_en' => 'Bolivia', 'iso3' => 'BOL', 'numcode' => '68', 'code' => '591'),
            array('iso' => 'BA', 'name_en' => 'Bosnia and Herzegovina', 'iso3' => 'BIH', 'numcode' => '70', 'code' => '387'),
            array('iso' => 'BW', 'name_en' => 'Botswana', 'iso3' => 'BWA', 'numcode' => '72', 'code' => '267'),
            array('iso' => 'BV', 'name_en' => 'Bouvet Island', 'iso3' => NULL,'numcode' => NULL,'code' => '0'),
            array('iso' => 'BR', 'name_en' => 'Brazil', 'iso3' => 'BRA', 'numcode' => '76', 'code' => '55'),
            array('iso' => 'IO', 'name_en' => 'British Indian Ocean Territory', 'iso3' => NULL,'numcode' => NULL,'code' => '246'),
            array('iso' => 'BN', 'name_en' => 'Brunei Darussalam', 'iso3' => 'BRN', 'numcode' => '96', 'code' => '673'),
            array('iso' => 'BG', 'name_en' => 'Bulgaria', 'iso3' => 'BGR', 'numcode' => '100', 'code' => '359'),
            array('iso' => 'BF', 'name_en' => 'Burkina Faso', 'iso3' => 'BFA', 'numcode' => '854', 'code' => '226'),
            array('iso' => 'BI', 'name_en' => 'Burundi', 'iso3' => 'BDI', 'numcode' => '108', 'code' => '257'),
            array('iso' => 'KH', 'name_en' => 'Cambodia', 'iso3' => 'KHM', 'numcode' => '116', 'code' => '855'),
            array('iso' => 'CM', 'name_en' => 'Cameroon', 'iso3' => 'CMR', 'numcode' => '120', 'code' => '237'),
            array('iso' => 'CA', 'name_en' => 'Canada', 'iso3' => 'CAN', 'numcode' => '124', 'code' => '1'),
            array('iso' => 'CV', 'name_en' => 'Cape Verde', 'iso3' => 'CPV', 'numcode' => '132', 'code' => '238'),
            array('iso' => 'KY', 'name_en' => 'Cayman Islands', 'iso3' => 'CYM', 'numcode' => '136', 'code' => '1345'),
            array('iso' => 'CF', 'name_en' => 'Central African Republic', 'iso3' => 'CAF', 'numcode' => '140', 'code' => '236'),
            array('iso' => 'TD', 'name_en' => 'Chad', 'iso3' => 'TCD', 'numcode' => '148', 'code' => '235'),
            array('iso' => 'CL', 'name_en' => 'Chile', 'iso3' => 'CHL', 'numcode' => '152', 'code' => '56'),
            array('iso' => 'CN', 'name_en' => 'China', 'iso3' => 'CHN', 'numcode' => '156', 'code' => '86'),
            array('iso' => 'CX', 'name_en' => 'Christmas Island', 'iso3' => NULL,'numcode' => NULL,'code' => '61'),
            array('iso' => 'CC', 'name_en' => 'Cocos (Keeling) Islands', 'iso3' => NULL,'numcode' => NULL,'code' => '672'),
            array('iso' => 'CO', 'name_en' => 'Colombia', 'iso3' => 'COL', 'numcode' => '170', 'code' => '57'),
            array('iso' => 'KM', 'name_en' => 'Comoros', 'iso3' => 'COM', 'numcode' => '174', 'code' => '269'),
            array('iso' => 'CG', 'name_en' => 'Congo', 'iso3' => 'COG', 'numcode' => '178', 'code' => '242'),
            array('iso' => 'CD', 'name_en' => 'Congo, the Democratic Republic of the', 'iso3' => 'COD', 'numcode' => '180', 'code' => '242'),
            array('iso' => 'CK', 'name_en' => 'Cook Islands', 'iso3' => 'COK', 'numcode' => '184', 'code' => '682'),
            array('iso' => 'CR', 'name_en' => 'Costa Rica', 'iso3' => 'CRI', 'numcode' => '188', 'code' => '506'),
            array('iso' => 'CI', 'name_en' => 'Cote D\'Ivoire', 'iso3' => 'CIV', 'numcode' => '384', 'code' => '225'),
            array('iso' => 'HR', 'name_en' => 'Croatia', 'iso3' => 'HRV', 'numcode' => '191', 'code' => '385'),
            array('iso' => 'CU', 'name_en' => 'Cuba', 'iso3' => 'CUB', 'numcode' => '192', 'code' => '53'),
            array('iso' => 'CY', 'name_en' => 'Cyprus', 'iso3' => 'CYP', 'numcode' => '196', 'code' => '357'),
            array('iso' => 'CZ', 'name_en' => 'Czech Republic', 'iso3' => 'CZE', 'numcode' => '203', 'code' => '420'),
            array('iso' => 'DK', 'name_en' => 'Denmark', 'iso3' => 'DNK', 'numcode' => '208', 'code' => '45'),
            array('iso' => 'DJ', 'name_en' => 'Djibouti', 'iso3' => 'DJI', 'numcode' => '262', 'code' => '253'),
            array('iso' => 'DM', 'name_en' => 'Dominica', 'iso3' => 'DMA', 'numcode' => '212', 'code' => '1767'),
            array('iso' => 'DO', 'name_en' => 'Dominican Republic', 'iso3' => 'DOM', 'numcode' => '214', 'code' => '1809'),
            array('iso' => 'EC', 'name_en' => 'Ecuador', 'iso3' => 'ECU', 'numcode' => '218', 'code' => '593'),
            array('iso' => 'EG', 'name_en' => 'Egypt', 'iso3' => 'EGY', 'numcode' => '818', 'code' => '20'),
            array('iso' => 'SV', 'name_en' => 'El Salvador', 'iso3' => 'SLV', 'numcode' => '222', 'code' => '503'),
            array('iso' => 'GQ', 'name_en' => 'Equatorial Guinea', 'iso3' => 'GNQ', 'numcode' => '226', 'code' => '240'),
            array('iso' => 'ER', 'name_en' => 'Eritrea', 'iso3' => 'ERI', 'numcode' => '232', 'code' => '291'),
            array('iso' => 'EE', 'name_en' => 'Estonia', 'iso3' => 'EST', 'numcode' => '233', 'code' => '372'),
            array('iso' => 'ET', 'name_en' => 'Ethiopia', 'iso3' => 'ETH', 'numcode' => '231', 'code' => '251'),
            array('iso' => 'FK', 'name_en' => 'Falkland Islands (Malvinas)', 'iso3' => 'FLK', 'numcode' => '238', 'code' => '500'),
            array('iso' => 'FO', 'name_en' => 'Faroe Islands', 'iso3' => 'FRO', 'numcode' => '234', 'code' => '298'),
            array('iso' => 'FJ', 'name_en' => 'Fiji', 'iso3' => 'FJI', 'numcode' => '242', 'code' => '679'),
            array('iso' => 'FI', 'name_en' => 'Finland', 'iso3' => 'FIN', 'numcode' => '246', 'code' => '358'),
            array('iso' => 'FR', 'name_en' => 'France', 'iso3' => 'FRA', 'numcode' => '250', 'code' => '33'),
            array('iso' => 'GF', 'name_en' => 'French Guiana', 'iso3' => 'GUF', 'numcode' => '254', 'code' => '594'),
            array('iso' => 'PF', 'name_en' => 'French Polynesia', 'iso3' => 'PYF', 'numcode' => '258', 'code' => '689'),
            array('iso' => 'TF', 'name_en' => 'French Southern Territories', 'iso3' => NULL,'numcode' => NULL,'code' => '0'),
            array('iso' => 'GA', 'name_en' => 'Gabon', 'iso3' => 'GAB', 'numcode' => '266', 'code' => '241'),
            array('iso' => 'GM', 'name_en' => 'Gambia', 'iso3' => 'GMB', 'numcode' => '270', 'code' => '220'),
            array('iso' => 'GE', 'name_en' => 'Georgia', 'iso3' => 'GEO', 'numcode' => '268', 'code' => '995'),
            array('iso' => 'DE', 'name_en' => 'Germany', 'iso3' => 'DEU', 'numcode' => '276', 'code' => '49'),
            array('iso' => 'GH', 'name_en' => 'Ghana', 'iso3' => 'GHA', 'numcode' => '288', 'code' => '233'),
            array('iso' => 'GI', 'name_en' => 'Gibraltar', 'iso3' => 'GIB', 'numcode' => '292', 'code' => '350'),
            array('iso' => 'GR', 'name_en' => 'Greece', 'iso3' => 'GRC', 'numcode' => '300', 'code' => '30'),
            array('iso' => 'GL', 'name_en' => 'Greenland', 'iso3' => 'GRL', 'numcode' => '304', 'code' => '299'),
            array('iso' => 'GD', 'name_en' => 'Grenada', 'iso3' => 'GRD', 'numcode' => '308', 'code' => '1473'),
            array('iso' => 'GP', 'name_en' => 'Guadeloupe', 'iso3' => 'GLP', 'numcode' => '312', 'code' => '590'),
            array('iso' => 'GU', 'name_en' => 'Guam', 'iso3' => 'GUM', 'numcode' => '316', 'code' => '1671'),
            array('iso' => 'GT', 'name_en' => 'Guatemala', 'iso3' => 'GTM', 'numcode' => '320', 'code' => '502'),
            array('iso' => 'GN', 'name_en' => 'Guinea', 'iso3' => 'GIN', 'numcode' => '324', 'code' => '224'),
            array('iso' => 'GW', 'name_en' => 'Guinea-Bissau', 'iso3' => 'GNB', 'numcode' => '624', 'code' => '245'),
            array('iso' => 'GY', 'name_en' => 'Guyana', 'iso3' => 'GUY', 'numcode' => '328', 'code' => '592'),
            array('iso' => 'HT', 'name_en' => 'Haiti', 'iso3' => 'HTI', 'numcode' => '332', 'code' => '509'),
            array('iso' => 'HM', 'name_en' => 'Heard Island and Mcdonald Islands', 'iso3' => NULL,'numcode' => NULL,'code' => '0'),
            array('iso' => 'VA', 'name_en' => 'Holy See (Vatican City State)', 'iso3' => 'VAT', 'numcode' => '336', 'code' => '39'),
            array('iso' => 'HN', 'name_en' => 'Honduras', 'iso3' => 'HND', 'numcode' => '340', 'code' => '504'),
            array('iso' => 'HK', 'name_en' => 'Hong Kong', 'iso3' => 'HKG', 'numcode' => '344', 'code' => '852'),
            array('iso' => 'HU', 'name_en' => 'Hungary', 'iso3' => 'HUN', 'numcode' => '348', 'code' => '36'),
            array('iso' => 'IS', 'name_en' => 'Iceland', 'iso3' => 'ISL', 'numcode' => '352', 'code' => '354'),
            array('iso' => 'IN', 'name_en' => 'India', 'iso3' => 'IND', 'numcode' => '356', 'code' => '91'),



            array('iso' => 'ID', 'name_en' => 'Indonesia', 'iso3' => 'IDN', 'numcode' => '360', 'code' => '62'),
            array('iso' => 'IR', 'name_en' => 'Iran, Islamic Republic of', 'iso3' => 'IRN', 'numcode' => '364', 'code' => '98'),
            array('iso' => 'IQ', 'name_en' => 'Iraq', 'iso3' => 'IRQ', 'numcode' => '368', 'code' => '964'),
            array('iso' => 'IE', 'name_en' => 'Ireland', 'iso3' => 'IRL', 'numcode' => '372', 'code' => '353'),
            array('iso' => 'IL', 'name_en' => 'Israel', 'iso3' => 'ISR', 'numcode' => '376', 'code' => '972'),
            array('iso' => 'IT', 'name_en' => 'Italy', 'iso3' => 'ITA', 'numcode' => '380', 'code' => '39'),
            array('iso' => 'JM', 'name_en' => 'Jamaica', 'iso3' => 'JAM', 'numcode' => '388', 'code' => '1876'),
            array('iso' => 'JP', 'name_en' => 'Japan', 'iso3' => 'JPN', 'numcode' => '392', 'code' => '81'),
            array('iso' => 'JO', 'name_en' => 'Jordan', 'iso3' => 'JOR', 'numcode' => '400', 'code' => '962'),
            array('iso' => 'KZ', 'name_en' => 'Kazakhstan', 'iso3' => 'KAZ', 'numcode' => '398', 'code' => '7'),
            array('iso' => 'KE', 'name_en' => 'Kenya', 'iso3' => 'KEN', 'numcode' => '404', 'code' => '254'),
            array('iso' => 'KI', 'name_en' => 'Kiribati', 'iso3' => 'KIR', 'numcode' => '296', 'code' => '686'),
            array('iso' => 'KP', 'name_en' => 'Korea, Democratic People\'s Republic of', 'iso3' => 'PRK', 'numcode' => '408', 'code' => '850'),
            array('iso' => 'KR', 'name_en' => 'Korea, Republic of', 'iso3' => 'KOR', 'numcode' => '410', 'code' => '82'),
            array('iso' => 'KW', 'name_en' => 'Kuwait', 'iso3' => 'KWT', 'numcode' => '414', 'code' => '965'),
            array('iso' => 'KG', 'name_en' => 'Kyrgyzstan', 'iso3' => 'KGZ', 'numcode' => '417', 'code' => '996'),
            array('iso' => 'LA', 'name_en' => 'Lao People\'s Democratic Republic', 'iso3' => 'LAO', 'numcode' => '418', 'code' => '856'),
            array('iso' => 'LV', 'name_en' => 'Latvia', 'iso3' => 'LVA', 'numcode' => '428', 'code' => '371'),
            array('iso' => 'LB', 'name_en' => 'Lebanon', 'iso3' => 'LBN', 'numcode' => '422', 'code' => '961'),
            array('iso' => 'LS', 'name_en' => 'Lesotho', 'iso3' => 'LSO', 'numcode' => '426', 'code' => '266'),
            array('iso' => 'LR', 'name_en' => 'Liberia', 'iso3' => 'LBR', 'numcode' => '430', 'code' => '231'),
            array('iso' => 'LY', 'name_en' => 'Libyan Arab Jamahiriya', 'iso3' => 'LBY', 'numcode' => '434', 'code' => '218'),
            array('iso' => 'LI', 'name_en' => 'Liechtenstein', 'iso3' => 'LIE', 'numcode' => '438', 'code' => '423'),
            array('iso' => 'LT', 'name_en' => 'Lithuania', 'iso3' => 'LTU', 'numcode' => '440', 'code' => '370'),
            array('iso' => 'LU', 'name_en' => 'Luxembourg', 'iso3' => 'LUX', 'numcode' => '442', 'code' => '352'),
            array('iso' => 'MO', 'name_en' => 'Macao', 'iso3' => 'MAC', 'numcode' => '446', 'code' => '853'),
            array('iso' => 'MK', 'name_en' => 'Macedonia, the Former Yugoslav Republic of', 'iso3' => 'MKD', 'numcode' => '807', 'code' => '389'),
            array('iso' => 'MG', 'name_en' => 'Madagascar', 'iso3' => 'MDG', 'numcode' => '450', 'code' => '261'),
            array('iso' => 'MW', 'name_en' => 'Malawi', 'iso3' => 'MWI', 'numcode' => '454', 'code' => '265'),
            array('iso' => 'MY', 'name_en' => 'Malaysia', 'iso3' => 'MYS', 'numcode' => '458', 'code' => '60'),
            array('iso' => 'MV', 'name_en' => 'Maldives', 'iso3' => 'MDV', 'numcode' => '462', 'code' => '960'),
            array('iso' => 'ML', 'name_en' => 'Mali', 'iso3' => 'MLI', 'numcode' => '466', 'code' => '223'),
            array('iso' => 'MT', 'name_en' => 'Malta', 'iso3' => 'MLT', 'numcode' => '470', 'code' => '356'),
            array('iso' => 'MH', 'name_en' => 'Marshall Islands', 'iso3' => 'MHL', 'numcode' => '584', 'code' => '692'),
            array('iso' => 'MQ', 'name_en' => 'Martinique', 'iso3' => 'MTQ', 'numcode' => '474', 'code' => '596'),
            array('iso' => 'MR', 'name_en' => 'Mauritania', 'iso3' => 'MRT', 'numcode' => '478', 'code' => '222'),
            array('iso' => 'MU', 'name_en' => 'Mauritius', 'iso3' => 'MUS', 'numcode' => '480', 'code' => '230'),
            array('iso' => 'YT', 'name_en' => 'Mayotte', 'iso3' => NULL,'numcode' => NULL,'code' => '269'),
            array('iso' => 'MX', 'name_en' => 'Mexico', 'iso3' => 'MEX', 'numcode' => '484', 'code' => '52'),
            array('iso' => 'FM', 'name_en' => 'Micronesia, Federated States of', 'iso3' => 'FSM', 'numcode' => '583', 'code' => '691'),
            array('iso' => 'MD', 'name_en' => 'Moldova, Republic of', 'iso3' => 'MDA', 'numcode' => '498', 'code' => '373'),
            array('iso' => 'MC', 'name_en' => 'Monaco', 'iso3' => 'MCO', 'numcode' => '492', 'code' => '377'),
            array('iso' => 'MN', 'name_en' => 'Mongolia', 'iso3' => 'MNG', 'numcode' => '496', 'code' => '976'),
            array('iso' => 'MS', 'name_en' => 'Montserrat', 'iso3' => 'MSR', 'numcode' => '500', 'code' => '1664'),
            array('iso' => 'MA', 'name_en' => 'Morocco', 'iso3' => 'MAR', 'numcode' => '504', 'code' => '212'),
            array('iso' => 'MZ', 'name_en' => 'Mozambique', 'iso3' => 'MOZ', 'numcode' => '508', 'code' => '258'),
            array('iso' => 'MM', 'name_en' => 'Myanmar', 'iso3' => 'MMR', 'numcode' => '104', 'code' => '95'),
            array('iso' => 'NA', 'name_en' => 'Namibia', 'iso3' => 'NAM', 'numcode' => '516', 'code' => '264'),
            array('iso' => 'NR', 'name_en' => 'Nauru', 'iso3' => 'NRU', 'numcode' => '520', 'code' => '674'),
            array('iso' => 'NP', 'name_en' => 'Nepal', 'iso3' => 'NPL', 'numcode' => '524', 'code' => '977'),
            array('iso' => 'NL', 'name_en' => 'Netherlands', 'iso3' => 'NLD', 'numcode' => '528', 'code' => '31'),
            array('iso' => 'AN', 'name_en' => 'Netherlands Antilles', 'iso3' => 'ANT', 'numcode' => '530', 'code' => '599'),
            array('iso' => 'NC', 'name_en' => 'New Caledonia', 'iso3' => 'NCL', 'numcode' => '540', 'code' => '687'),
            array('iso' => 'NZ', 'name_en' => 'New Zealand', 'iso3' => 'NZL', 'numcode' => '554', 'code' => '64'),
            array('iso' => 'NI', 'name_en' => 'Nicaragua', 'iso3' => 'NIC', 'numcode' => '558', 'code' => '505'),
            array('iso' => 'NE', 'name_en' => 'Niger', 'iso3' => 'NER', 'numcode' => '562', 'code' => '227'),
            array('iso' => 'NG', 'name_en' => 'Nigeria', 'iso3' => 'NGA', 'numcode' => '566', 'code' => '234'),
            array('iso' => 'NU', 'name_en' => 'Niue', 'iso3' => 'NIU', 'numcode' => '570', 'code' => '683'),
            array('iso' => 'NF', 'name_en' => 'Norfolk Island', 'iso3' => 'NFK', 'numcode' => '574', 'code' => '672'),
            array('iso' => 'MP', 'name_en' => 'Northern Mariana Islands', 'iso3' => 'MNP', 'numcode' => '580', 'code' => '1670'),
            array('iso' => 'NO', 'name_en' => 'Norway', 'iso3' => 'NOR', 'numcode' => '578', 'code' => '47'),
            array('iso' => 'OM', 'name_en' => 'Oman', 'iso3' => 'OMN', 'numcode' => '512', 'code' => '968'),
            array('iso' => 'PK', 'name_en' => 'Pakistan', 'iso3' => 'PAK', 'numcode' => '586', 'code' => '92'),
            array('iso' => 'PW', 'name_en' => 'Palau', 'iso3' => 'PLW', 'numcode' => '585', 'code' => '680'),
            array('iso' => 'PS', 'name_en' => 'Palestinian Territory, Occupied', 'iso3' => NULL,'numcode' => NULL,'code' => '970'),
            array('iso' => 'PA', 'name_en' => 'Panama', 'iso3' => 'PAN', 'numcode' => '591', 'code' => '507'),
            array('iso' => 'PG', 'name_en' => 'Papua New Guinea', 'iso3' => 'PNG', 'numcode' => '598', 'code' => '675'),
            array('iso' => 'PY', 'name_en' => 'Paraguay', 'iso3' => 'PRY', 'numcode' => '600', 'code' => '595'),
            array('iso' => 'PE', 'name_en' => 'Peru', 'iso3' => 'PER', 'numcode' => '604', 'code' => '51'),
            array('iso' => 'PH', 'name_en' => 'Philippines', 'iso3' => 'PHL', 'numcode' => '608', 'code' => '63'),
            array('iso' => 'PN', 'name_en' => 'Pitcairn', 'iso3' => 'PCN', 'numcode' => '612', 'code' => '0'),
            array('iso' => 'PL', 'name_en' => 'Poland', 'iso3' => 'POL', 'numcode' => '616', 'code' => '48'),
            array('iso' => 'PT', 'name_en' => 'Portugal', 'iso3' => 'PRT', 'numcode' => '620', 'code' => '351'),
            array('iso' => 'PR', 'name_en' => 'Puerto Rico', 'iso3' => 'PRI', 'numcode' => '630', 'code' => '1787'),
            array('iso' => 'QA', 'name_en' => 'Qatar', 'iso3' => 'QAT', 'numcode' => '634', 'code' => '974'),
            array('iso' => 'RE', 'name_en' => 'Reunion', 'iso3' => 'REU', 'numcode' => '638', 'code' => '262'),
            array('iso' => 'RO', 'name_en' => 'Romania', 'iso3' => 'ROM', 'numcode' => '642', 'code' => '40'),
            array('iso' => 'RU', 'name_en' => 'Russian Federation', 'iso3' => 'RUS', 'numcode' => '643', 'code' => '70'),
            array('iso' => 'RW', 'name_en' => 'Rwanda', 'iso3' => 'RWA', 'numcode' => '646', 'code' => '250'),
            array('iso' => 'SH', 'name_en' => 'Saint Helena', 'iso3' => 'SHN', 'numcode' => '654', 'code' => '290'),
            array('iso' => 'KN', 'name_en' => 'Saint Kitts and Nevis', 'iso3' => 'KNA', 'numcode' => '659', 'code' => '1869'),
            array('iso' => 'LC', 'name_en' => 'Saint Lucia', 'iso3' => 'LCA', 'numcode' => '662', 'code' => '1758'),
            array('iso' => 'PM', 'name_en' => 'Saint Pierre and Miquelon', 'iso3' => 'SPM', 'numcode' => '666', 'code' => '508'),
            array('iso' => 'VC', 'name_en' => 'Saint Vincent and the Grenadines', 'iso3' => 'VCT', 'numcode' => '670', 'code' => '1784'),
            array('iso' => 'WS', 'name_en' => 'Samoa', 'iso3' => 'WSM', 'numcode' => '882', 'code' => '684'),
            array('iso' => 'SM', 'name_en' => 'San Marino', 'iso3' => 'SMR', 'numcode' => '674', 'code' => '378'),
            array('iso' => 'ST', 'name_en' => 'Sao Tome and Principe', 'iso3' => 'STP', 'numcode' => '678', 'code' => '239'),
            array('iso' => 'SA', 'name_en' => 'Saudi Arabia', 'iso3' => 'SAU', 'numcode' => '682', 'code' => '966'),
            array('iso' => 'SN', 'name_en' => 'Senegal', 'iso3' => 'SEN', 'numcode' => '686', 'code' => '221'),
            array('iso' => 'CS', 'name_en' => 'Serbia and Montenegro', 'iso3' => NULL,'numcode' => NULL,'code' => '381'),
            array('iso' => 'SC', 'name_en' => 'Seychelles', 'iso3' => 'SYC', 'numcode' => '690', 'code' => '248'),
            array('iso' => 'SL', 'name_en' => 'Sierra Leone', 'iso3' => 'SLE', 'numcode' => '694', 'code' => '232'),
            array('iso' => 'SG', 'name_en' => 'Singapore', 'iso3' => 'SGP', 'numcode' => '702', 'code' => '65'),
            array('iso' => 'SK', 'name_en' => 'Slovakia', 'iso3' => 'SVK', 'numcode' => '703', 'code' => '421'),
            array('iso' => 'SI', 'name_en' => 'Slovenia', 'iso3' => 'SVN', 'numcode' => '705', 'code' => '386'),
            array('iso' => 'SB', 'name_en' => 'Solomon Islands', 'iso3' => 'SLB', 'numcode' => '90', 'code' => '677'),
            array('iso' => 'SO', 'name_en' => 'Somalia', 'iso3' => 'SOM', 'numcode' => '706', 'code' => '252'),
            array('iso' => 'ZA', 'name_en' => 'South Africa', 'iso3' => 'ZAF', 'numcode' => '710', 'code' => '27'),
            array('iso' => 'GS', 'name_en' => 'South Georgia and the South Sandwich Islands', 'iso3' => NULL,'numcode' => NULL,'code' => '0'),
            array('iso' => 'ES', 'name_en' => 'Spain', 'iso3' => 'ESP', 'numcode' => '724', 'code' => '34'),


            array('iso' => 'LK', 'name_en' => 'Sri Lanka', 'iso3' => 'LKA', 'numcode' => '144', 'code' => '94'),
            array('iso' => 'SD', 'name_en' => 'Sudan', 'iso3' => 'SDN', 'numcode' => '736', 'code' => '249'),
            array('iso' => 'SR', 'name_en' => 'Suriname_en', 'iso3' => 'SUR', 'numcode' => '740', 'code' => '597'),
            array('iso' => 'SJ', 'name_en' => 'Svalbard and Jan Mayen', 'iso3' => 'SJM', 'numcode' => '744', 'code' => '47'),
            array('iso' => 'SZ', 'name_en' => 'Swaziland', 'iso3' => 'SWZ', 'numcode' => '748', 'code' => '268'),
            array('iso' => 'SE', 'name_en' => 'Sweden', 'iso3' => 'SWE', 'numcode' => '752', 'code' => '46'),
            array('iso' => 'CH', 'name_en' => 'Switzerland', 'iso3' => 'CHE', 'numcode' => '756', 'code' => '41'),
            array('iso' => 'SY', 'name_en' => 'Syrian Arab Republic', 'iso3' => 'SYR', 'numcode' => '760', 'code' => '963'),
            array('iso' => 'TW', 'name_en' => 'Taiwan, Province of China', 'iso3' => 'TWN', 'numcode' => '158', 'code' => '886'),
            array('iso' => 'TJ', 'name_en' => 'Tajikistan', 'iso3' => 'TJK', 'numcode' => '762', 'code' => '992'),
            array('iso' => 'TZ', 'name_en' => 'Tanzania, United Republic of', 'iso3' => 'TZA', 'numcode' => '834', 'code' => '255'),
            array('iso' => 'TH', 'name_en' => 'Thailand', 'iso3' => 'THA', 'numcode' => '764', 'code' => '66'),
            array('iso' => 'TL', 'name_en' => 'Timor-Leste', 'iso3' => NULL,'numcode' => NULL,'code' => '670'),
            array('iso' => 'TG', 'name_en' => 'Togo', 'iso3' => 'TGO', 'numcode' => '768', 'code' => '228'),
            array('iso' => 'TK', 'name_en' => 'Tokelau', 'iso3' => 'TKL', 'numcode' => '772', 'code' => '690'),
            array('iso' => 'TO', 'name_en' => 'Tonga', 'iso3' => 'TON', 'numcode' => '776', 'code' => '676'),
            array('iso' => 'TT', 'name_en' => 'Trinidad and Tobago', 'iso3' => 'TTO', 'numcode' => '780', 'code' => '1868'),
            array('iso' => 'TN', 'name_en' => 'Tunisia', 'iso3' => 'TUN', 'numcode' => '788', 'code' => '216'),
            array('iso' => 'TR', 'name_en' => 'Turkey', 'iso3' => 'TUR', 'numcode' => '792', 'code' => '90'),
            array('iso' => 'TM', 'name_en' => 'Turkmenistan', 'iso3' => 'TKM', 'numcode' => '795', 'code' => '7370'),
            array('iso' => 'TC', 'name_en' => 'Turks and Caicos Islands', 'iso3' => 'TCA', 'numcode' => '796', 'code' => '1649'),
            array('iso' => 'TV', 'name_en' => 'Tuvalu', 'iso3' => 'TUV', 'numcode' => '798', 'code' => '688'),
            array('iso' => 'UG', 'name_en' => 'Uganda', 'iso3' => 'UGA', 'numcode' => '800', 'code' => '256'),
            array('iso' => 'UA', 'name_en' => 'Ukraine', 'iso3' => 'UKR', 'numcode' => '804', 'code' => '380'),
            array('iso' => 'AE', 'name_en' => 'United Arab Emirates', 'iso3' => 'ARE', 'numcode' => '784', 'code' => '971'),
            array('iso' => 'GB', 'name_en' => 'United Kingdom', 'iso3' => 'GBR', 'numcode' => '826', 'code' => '44'),
            array('iso' => 'US', 'name_en' => 'United States', 'iso3' => 'USA', 'numcode' => '840', 'code' => '1'),
            array('iso' => 'UM', 'name_en' => 'United States Minor Outlying Islands', 'iso3' => NULL,'numcode' => NULL,'code' => '1'),
            array('iso' => 'UY', 'name_en' => 'Uruguay', 'iso3' => 'URY', 'numcode' => '858', 'code' => '598'),
            array('iso' => 'UZ', 'name_en' => 'Uzbekistan', 'iso3' => 'UZB', 'numcode' => '860', 'code' => '998'),
            array('iso' => 'VU', 'name_en' => 'Vanuatu', 'iso3' => 'VUT', 'numcode' => '548', 'code' => '678'),
            array('iso' => 'VE', 'name_en' => 'Venezuela', 'iso3' => 'VEN', 'numcode' => '862', 'code' => '58'),
            array('iso' => 'VN', 'name_en' => 'Viet Nam', 'iso3' => 'VNM', 'numcode' => '704', 'code' => '84'),
            array('iso' => 'VG', 'name_en' => 'Virgin Islands, British', 'iso3' => 'VGB', 'numcode' => '92', 'code' => '1284'),
            array('iso' => 'VI', 'name_en' => 'Virgin Islands, U.S.', 'iso3' => 'VIR', 'numcode' => '850', 'code' => '1340'),
            array('iso' => 'WF', 'name_en' => 'Wallis and Futuna', 'iso3' => 'WLF', 'numcode' => '876', 'code' => '681'),
            array('iso' => 'EH', 'name_en' => 'Western Sahara', 'iso3' => 'ESH', 'numcode' => '732', 'code' => '212'),
            array('iso' => 'YE', 'name_en' => 'Yemen', 'iso3' => 'YEM', 'numcode' => '887', 'code' => '967'),
            array('iso' => 'ZM', 'name_en' => 'Zambia', 'iso3' => 'ZMB', 'numcode' => '894', 'code' => '260'),
            array('iso' => 'ZW', 'name_en' => 'Zimbabwe', 'iso3' => 'ZWE', 'numcode' => '716', 'code' => '263'),
            array('iso' => 'RS', 'name_en' => 'Serbia', 'iso3' => 'SRB', 'numcode' => '688', 'code' => '381'),
            array('iso' => 'AP', 'name_en' => 'Asia / Pacific Region', 'iso3' => '0', 'numcode' => '0', 'code' => '0'),
            array('iso' => 'ME', 'name_en' => 'Montenegro', 'iso3' => 'MNE', 'numcode' => '499', 'code' => '382'),
            array('iso' => 'AX', 'name_en' => 'Aland Islands', 'iso3' => 'ALA', 'numcode' => '248', 'code' => '358'),
            array('iso' => 'BQ', 'name_en' => 'Bonaire, Sint Eustatius and Saba', 'iso3' => 'BES', 'numcode' => '535', 'code' => '599'),
            array('iso' => 'CW', 'name_en' => 'Curacao', 'iso3' => 'CUW', 'numcode' => '531', 'code' => '599'),
            array('iso' => 'GG', 'name_en' => 'Guernsey', 'iso3' => 'GGY', 'numcode' => '831', 'code' => '44'),
            array('iso' => 'IM', 'name_en' => 'Isle of Man', 'iso3' => 'IMN', 'numcode' => '833', 'code' => '44'),
            array('iso' => 'JE', 'name_en' => 'Jersey', 'iso3' => 'JEY', 'numcode' => '832', 'code' => '44'),
            array('iso' => 'XK', 'name_en' => 'Kosovo', 'iso3' => '---', 'numcode' => '0', 'code' => '381'),
            array('iso' => 'BL', 'name_en' => 'Saint Barthelemy', 'iso3' => 'BLM', 'numcode' => '652', 'code' => '590'),
            array('iso' => 'MF', 'name_en' => 'Saint Martin', 'iso3' => 'MAF', 'numcode' => '663', 'code' => '590'),
            array('iso' => 'SX', 'name_en' => 'Sint Maarten', 'iso3' => 'SXM', 'numcode' => '534', 'code' => '1'),
            array('iso' => 'SS', 'name_en' => 'South Sudan', 'iso3' => 'SSD', 'numcode' => '728', 'code' => '211')
        );
        foreach($countries as $country){
            Country::create($country);
        }

    }
}
