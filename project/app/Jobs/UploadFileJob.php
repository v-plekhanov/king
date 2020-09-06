<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class UploadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $task;
    private $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task, $file)
    {
        $this->task = $task;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mobileImage = Image::make($this->file);
        $mobilePath = public_path() . '/mobile/';
        $originalPath = public_path() . '/full/';
        $mobileImage->save($originalPath . time() . $this->file->getClientOriginalName());
        $mobileImage->resize(320, 320);
        $mobileImage->save($mobilePath . time() . $this->file->getClientOriginalName());

        $imagemodel = new ImageModel();
        $imagemodel->filename = time() . $this->file->getClientOriginalName();
        $imagemodel->task_id = $this->task->id;
        $imagemodel->save();
    }
}
