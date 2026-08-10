<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations on Render deployment to update all lesson video URLs to Cloudinary.
     */
    public function up(): void
    {
        DB::table('lessons')
            ->where('title', 'LIKE', '%Course Introduction%')
            ->orWhere('title', 'LIKE', '%Lesson 1%')
            ->update([
                'video_url' => 'https://res.cloudinary.com/ayivfpud/video/upload/v1786345355/Full_Stack_Web_Development_Course_Introduction_720p60.mp4'
            ]);

        DB::table('lessons')
            ->where('title', 'LIKE', '%Backend Works%')
            ->orWhere('title', 'LIKE', '%Lesson 2%')
            ->update([
                'video_url' => 'https://res.cloudinary.com/ayivfpud/video/upload/v1786345351/How_The_Backend_Works_720p.mp4'
            ]);

        DB::table('lessons')
            ->where('title', 'LIKE', '%MVC%')
            ->orWhere('title', 'LIKE', '%Lesson 3%')
            ->update([
                'video_url' => 'https://res.cloudinary.com/ayivfpud/video/upload/v1786345352/MVC_Explained_in_4_Minutes_720p60.mp4'
            ]);

        DB::table('lessons')
            ->where('video_url', 'LIKE', 'storage/%')
            ->orWhere('video_url', 'LIKE', 'videos/%')
            ->update([
                'video_url' => 'https://res.cloudinary.com/ayivfpud/video/upload/v1786345355/Full_Stack_Web_Development_Course_Introduction_720p60.mp4'
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down migration needed
    }
};
