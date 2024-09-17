<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessStudentFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePaths;
    protected $folderName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student, $filePaths)
    {
        $this->filePaths = $filePaths;
        $this->folderName = $student->student_id . '_' . $student->student_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->filePaths as $path) {

            $fileName = $this->folderName . '-' . Str::random(4) . '.' . pathinfo($path, PATHINFO_EXTENSION);

            Storage::disk('public')->move($path, 'student_submissions/' . $this->folderName . '/' . $fileName);
        }
    }
}
