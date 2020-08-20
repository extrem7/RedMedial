<?php

use App\Models\Rss\Country;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Api\Notifications\ResetPassword;

class UsersSeeder extends Seeder
{
    public function run()
    {

        if (User::find(1) === null) {
            $user = new User([
                'name' => env('INITIAL_USER_NAME'),
                'email' => env('INITIAL_USER_EMAIL'),
                'password' => env('INITIAL_USER_PASSWORDHASH'),
            ]);
            $user->save();
            $user->assignRole('admin');
            $user->information()->create([
                'country_id' => Country::whereSlug('chile')->first()->id,
                'bio' => 'Отец',
            ]);
        }

        $countriesMapping = require(database_path('old/countriesMapping.php'));
        $users = [
            [
                'name' => 'Alex Hi',
                'email' => 'extrem7ipad@gmail.com',
                'created_at' => '2019-06-04 13:08:49',
                'country_id' => 232,
                'bio' => 'Sector Gaza',
                'avatar' => 'https://redmedial.com/wp-content/uploads/2019/10/03_oyH2Jcp.jpg'
            ]
        ];

        $this->command->getOutput()->progressStart(count($users));

        foreach ($users as $data) {
            $password = Str::random(8);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'created_at' => $data['created_at'],
                'password' => Hash::make($password)
            ]);

            $user->information()->create([
                'country_id' => $countriesMapping[$data['country_id']],
                'bio' => $data['bio'],
            ]);

            $user->notifyNow(new ResetPassword($password));

            if ($avatar = $data['avatar'])
                $user->addMediaFromUrl($avatar)->toMediaCollection('avatar');

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
