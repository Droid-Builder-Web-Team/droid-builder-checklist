<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class BouncerSeeder extends Seeder
{
    public function run()
    {
        $bouncer = app(Bouncer::class);

        $bouncer->allow('superadmin')->everything();

        $bouncer->allow('admin')->everything();
        $bouncer->forbid('admin')->toManage(User::class);

        $bouncer->allow('moderator')->everything();
    }
}
