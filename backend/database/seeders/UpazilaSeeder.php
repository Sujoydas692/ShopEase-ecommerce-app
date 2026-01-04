<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpazilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $upazilas = [

            1 => ["Bagerhat Sadar", "Chitolmari", "Fakirhat", "Kachua", "Mollarhat", "Mongla", "Morolgonj", "Rampal", "Saron Khola"],

            2 => ["Bandarban Sadar", "Roang Chari", "Ruma", "Thanaanchi", "Lama", "Alikadam", "Naikhang Chari"],

            3 => ["Amtoli", "Bamna", "Borguna Sadar", "Betagi", "Pathorghata", "Taltoli"],

            4 => ["Agoil Jhora", "Babugonj", "Bakergonj", "Banaripara", "Gournadi", "Hijla", "Barishal Sadar", "Mehedigonj", "Muladi", "Ujirpur"],

            5 => ["Bhola Sadar", "Borhanuddin", "Charfassion", "Daulatkhan", "Lalmohon", "Monpura", "Tajumuddin"],

            6 => ["Adamdighi", "Bogra Sadar", "Dhunot", "Dupchachia", "Gabtoli", "Kahalu", "Nandigram", "Saria Kandi", "Shajahanpur", "Sherpur", "Shibgonj", "Sonatola"],

            7 => ["B. Baria Sadar", "Ashugonj", "Akhaura", "Bancharampur", "Bijoy Nagar", "Kosba", "Nabinagar", "Nasir Nagar", "Sarail"],

            8 => ["Chandpur Sadar", "Faridgonj", "Haimchar", "Hajigonj", "Kochua", "Matlab North", "Matlab South", "Shaharasti"],

            9 => ["Bholahat", "Gomostapur", "Nachol", "Nawabganj Sadar", "Shibgonj"],

            10 => ["Anwara", "Bash Khali", "Boalkhali", "Chanda Naish", "Fatik Chari", "Hathazari", "Lohagora", "Mirasharai", "Putia", "Rangunia", "Raujan", "Sandip", "Satkania", "Sitakundu", "Kotwali", "Panchlaish", "Chandgaon", "Bandor", "Pahartoli", "Double Muring"],

            11 => ["Alamdanga", "Chuadanga Sadar", "Damur Huda", "Jibon Nagar"],

            12 => ["Chokoria", "Cox’s Bazar Sadar", "Kutubdia", "Moheshkhali", "Pekua", "Ramu", "Teknaf", "Ukhia"],

            13 => ["Barura", "Brahman Para", "Buri Chang", "Chandina", "Choddo Gram", "Daoud Kandi", "Dabidar", "Homna", "Comilla Sadar Adarsho", "Comilla Sadar South", "Laksham", "Monohorgonj", "Meghna", "Muradnagar", "Nangolkot", "Titas"],

            14 => ["Kotwali", "Mohammadpur", "Lalbagh", "Sutrapur", "Motijheel", "Demra", "Sabujbagh", "Mirpur", "Gulshan", "Uttara", "Pallabi", "Cantonment", "Dhanmondi", "Tejgaon", "Ramna", "Dhamrai", "Dohar", "Keranigonj", "Nawabgonj", "Savar"],

            15 => ["Birampur", "Birgonj", "Berol", "Bochagonj", "Chirir Bandor", "Phulbari", "Ghoraghat", "Hakimpur", "Kaharol", "Khansama", "Dinajpur Sadar", "Nawabgonj", "Parbotipur"],

            16 => ["Alphadanga", "Bhanga", "Boalmari", "Char Bhadrashon", "Faridpur Sadar", "Madhukhali", "Nagarkanda", "Sadarpur", "Saltha"],

            17 => ["Sagalnaiya", "Dagon Bhuiyan", "Feni Sadar", "Fulgazi", "Porshuram", "Sonagazi"],

            18 => ["Phulchari", "Gaibandha Sadar", "Gobindagonj", "Palashbari", "Sadullapur", "Saghat", "Sundargonj"],

            19 => ["Gazipur Sadar", "Kaliakoir", "Kaligonj", "Kapashia", "Sreepur", "Tongi"],

            20 => ["Gopalgonj Sadar", "Kashiani", "Kotalipara", "Muksudpur", "Tungipara"],

            21 => ["Ajmirigonj", "Bahubal", "Benia Chang", "Chunarughat", "Hobigaonj Sadar", "Lakhai", "Madhabpur", "Nobigonj", "Shaistaganj"],

            22 => ["Bokshigonj", "Dewangonj", "Islampur", "Jamalpur Sadar", "Madargonj", "Melandaha", "Sarisha Bari"],

            23 => ["Avoynagar", "Bagharpara", "Chowgacha", "Jessore Sadar", "Jhikorgacha", "Keshobpur", "Monirampur", "Sharsha"],

            24 => ["Jhalokathi Sadar", "Kathalia", "Nalchiti", "Rajapur"],

            25 => ["Horinakundu", "Jhenaidah Sadar", "Kaligonj", "Kot Chandpur", "Moheshpur", "Shyola Kupa"],

            26 => ["Akkelpur", "Joypurhat Sadar", "Kalai", "Khetlal", "Panchbibi"],

            27 => ["Dighinala", "Khagrachari Sadar", "Laxmichari", "Mohalchari", "Manikchari", "Matiranga", "Panchari", "Ramgarh"],

            28 => ["Batiaghata", "Dakop", "Degholia", "Dumuria", "Khulna Sadar", "Koira", "Paikgacha", "Phultola", "Rupsha", "Terokhada", "Daulatpur", "Sonadanga"],

            29 => ["Austagram", "Bajitpur", "Bhairab", "Hossainpur", "Itna", "Karimgonj", "Kotiadi", "Kishoregonj Sadar", "Kuliar Char", "Mithamain", "Nikli", "Pakundia", "Tarail"],

            30 => ["Bhurungamari", "Rajibpur", "Chilmari", "Kurigram Sadar", "Nageshwori", "Phulbari", "Rajarhat", "Rowmari", "Ulipur"],

            31 => ["Bheramara", "Daulatpur", "Khoksha", "Kumarkhali", "Kushtia Sadar", "Mirpur"],

            32 => ["Kamalnagar", "Laxmipur Sadar", "Raipur", "Ramgonj", "Ramgoti"],

            33 => ["Aditmari", "Hatibandha", "Kaligonj", "Lalmonirhat Sadar", "Patgram"],

            34 => ["Kalkini", "Madaripur Sadar", "Rajoir", "Shibchar"],

            35 => ["Magura Sadar", "Mohammadpur", "Salikha", "Sreepur"],

            36 => ["Daulatpur", "Gheor", "Horirampur", "Manikgonj Sadar", "Saturia", "Shibaloy", "Singair"],

            37 => ["Gangni", "Meherpur Sadar", "Mujib Nagar"],

            38 => ["Boro Lekha", "Juri", "Komolgonj", "Kulaura", "Mowlovibazar Sadar", "Rajnagar", "Srimangal"],

            39 => ["Gazaria", "Louhagonj", "Munshigonj Sadar", "Sirajdikhan", "Sreenagar", "Tungibari"],

            40 => ["Bhaluka", "Dhobaura", "Phulbaria", "Goforgaon", "Gouripur", "Haluaghat", "Trishal", "Ishwargonj", "Mymensingh Sadar", "Muktagacha", "Nandail", "Phulpur", "Tarakanda"],

            41 => ["Atrai", "Badalgachi", "Manda", "Naogaon Sadar", "Niamatpur", "Potnitola", "Porsha", "Raninagar", "Sapahar", "Mohadebpur", "Dhamorhat"],

            42 => ["Kalia", "Lohagara", "Norail Sadar"],

            43 => ["Araihazar", "Bandor", "Narayanganj Sadar", "Rupgonj", "Sonargaon"],

            44 => ["Belabo", "Monohardi", "Narsingdi Sadar", "Palash", "Raipura", "Shibpur"],

            45 => ["Bagatipara", "Boraigram", "Gurudaspur", "Lalpur", "Natore Sadar", "Singra", "Naldanga"],

            46 => ["Atpara", "Barhatta", "Durgapur", "Kalmakanda", "Kendua", "Madan", "Mohongonj", "Netrokona Sadar", "Purbodhola", "Khalia Juri"],

            47 => ["Dimla", "Domar", "Jaldhaka", "Keshoregonj", "Nilphamari Sadar", "Saidpur"],

            48 => ["Begumgonj", "Chatkhil", "Companigonj", "Hatia", "Kabirhat", "Noakhali Sadar", "Shenbagh", "Sonaimuri", "Subarnachar"],

            49 => ["Atghoria", "Bera", "Bhangura", "Chatmohor", "Faridpur", "Ishwardi", "Pabna Sadar", "Santhia", "Sujanagar"],

            50 => ["Atwori", "Boda", "Debigonj", "Panchagarh Sadar", "Tetulia"],

            51 => ["Bauphal", "Dosmina", "Dumki", "Golachipa", "Kolapara", "Mirzagonj", "Patuakhali Sadar", "Rangabali"],

            52 => ["Bhandaria", "Indurkani", "Kaukhali", "Mothbaria", "Nazirpur", "Nesarabad", "Pirojpur Sadar"],

            53 => ["Baliakandi", "Goalondaghat", "Pangsha", "Kalukhali", "Rajbari Sadar"],

            54 => ["Bagha", "Baghmara", "Charghat", "Durgapur", "Godagri", "Mohonpur", "Poba", "Putia", "Tanor", "Rajpara", "Boalia"],

            55 => ["Baghaichari", "Barkal", "Kawkhali", "Belaichari", "Kaptai", "Longodu", "Naniarchar", "Rajasthali", "Jurachari", "Rangamati Sadar"],

            56 => ["Badargonj", "Gongachora", "Kaunia", "Mithapukur", "Pirgacha", "Pirgonj", "Rangpur Sadar", "Taragonj"],

            57 => ["Assasuni", "Debhata", "Kolaroa", "Kaligonj", "Satkhira Sadar", "Shyamnagar", "Tala"],

            58 => ["Vedorgonj", "Damudda", "Gosairhat", "Noria", "Shariatpur Sadar", "Jagira"],

            59 => ["Jhenaigati", "Nakla", "Nalitabari", "Sherpur Sadar", "Sribordi"],

            60 => ["Belkuchi", "Chowhali", "Kamarkhand", "Kazipur", "Roygonj", "Shahzadpur", "Sirajgonj Sadar", "Tarash", "Ullapara"],

            61 => ["Bishwambarpur", "Chatok", "Derai", "South Sunamgonj", "Dharampasha", "Jamalgonj", "Jagannathpur", "Sulla", "Sunamganj Sadar", "Tahirpur", "Deora Bazar"],

            62 => ["Balagonj", "Biwanibazar", "Bishwanath", "Companigonj", "Dakshin Surma", "Fenchugonj", "Golapgonj", "Gowainghat", "Jaintapur", "Kanaighat", "Sylhet Sadar", "Zakigonj"],

            63 => ["Bashail", "Bhuapur", "Delduar", "Ghatail", "Gopalpur", "Kalihati", "Madhupur", "Mirzapur", "Nagorpur", "Sokhipur", "Dhanbari", "Tangail Sadar"],

            64 => ["Baliadangi", "Horipur", "Pirgonj", "Ranisankail", "Thakurgaon Sadar"],

        ];

        foreach ($upazilas as $districtId => $items) {
            foreach ($items as $name) {
                DB::table('upazilas')->insert([
                    'district_id' => $districtId,
                    'name' => $name
                ]);
            }
        }
    }
}
