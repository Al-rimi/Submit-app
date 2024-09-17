<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Command: "php artisan db:seed --class=StudentsTableSeeder"
     */
    public function run()
    {
        // Wrap the student IDs in quotes to ensure they are treated as strings
        $students = [
            "202136020107" => "SIDKI ADAM",
            "202136020149" => "HASSANI OMAR",
            "202336020102" => "ERRAISS SARA",
            "202336020105" => "ABDULRIZAK SAID MAHAMUD",
            "202336020106" => "AHABCHAN AMINE",
            "202336020109" => "AL-AHMADI ABDULRAHMAN MOHAMMED HAMED",
            "202336020111" => "BERDIYEV YHLAS",
            "202336020112" => "CHAMANDOUR ALMANASSFI MOHAMAD KARAM",
            "202336020114" => "EL KETTANY ACHRAF",
            "202336020115" => "HAQUE MD NAZMUL",
            "202336020116" => "IKOUBOU NGAMPELE LLOYD CHRISTOPHER",
            "202336020117" => "JAWO MOHAMMED",
            "202336020118" => "KANTE HAMIDOU",
            "202336020120" => "MACHUKI JOASH OMWANDO",
            "202336020122" => "MUNGOLO TAONGA",
            "202336020123" => "NOKUTENDA MUSANGA",
            "202336020124" => "SEOLWANA MAREI IGNECIOUS",
            "202336020126" => "UDE RAPHAEL IKECHUKWU",
            "202336020129" => "YOUSEF ALAA MOSTAFA ABDELGHAFAR",
            "202336020201" => "BENDAHMAN CHAYMAE",
            "202336020202" => "DOVLETGELDIYEVA LEYLI",
            "202336020203" => "EL-FANI MARYEM",
            "202336020204" => "FATAHALLAH ZINEB",
            "202336020205" => "GELDIYEVA GULSHAT",
            "202336020206" => "HALLALA YASMINE",
            "202336020209" => "TABIRI AYA",
            "202336020210" => "AKMYRADOV EZIZ",
            "202336020211" => "AL RAIMI ABDULLAH",
            "202336020213" => "BEGENJOV YSLAM",
            "202336020215" => "CHANANE SOFIANE",
            "202336020221" => "MALIKGULYYEV DOVLETGULY",
            "202336020222" => "MHIRA ANASS",
            "202336020223" => "NASSIF MOUAD",
            "202336020224" => "NSHIMIRIMANA ORES-DEVY",
            "202336020225" => "OJAROV SULEYMAN",
            "202336020226" => "SEMEDO GOMES JORGE EMERSON",
            "202336020229" => "AMZIL FATIMA-ZOUHRA",
            "202336020230" => "DASH SHISHIR"
        ];

        foreach ($students as $studentID => $studentName) {
            Student::create([
                'student_id' => (string)$studentID,  // Explicitly cast to string
                'student_name' => $studentName,
                'submit_count' => 0, // Set to 0 as default
            ]);
        }
    }
}
