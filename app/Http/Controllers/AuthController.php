<?php

namespace App\Http\Controllers;

use Invisnik\LaravelSteamAuth\SteamAuth;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class AuthController extends Controller
{

    /**
     * @var SteamAuth
     */
    private $steam;

    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function login()
    {
        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();
            if (!is_null($info)) {
               // die(var_dump($info));

                $user = User::where('steamid', $info->getSteamID64())->first();
                //$user = User::where('steamid', $info->getSteamID64());
                //die(var_dump($user));

                if (!is_null($user)) {
                    Auth::login($user, true);
                    return redirect('/'); // redirect to site
                } else {
                    $user = User::create([
                        'name' => $info->getName(),
                        'username' => $info->getNick(),
                        'avatar' => $info->getProfilePictureFull(),
                        'steamid' => $info->getSteamID64(),
                        'profileURL' => $info->getProfileURL(),
                        'countryCode' => $info->getCountryCode(),
                    ]);
                    Auth::login($user, true);
                    return redirect('/'); // redirect to site
                }
            }
        } else {
            return $this->steam->redirect(); // redirect to Steam login page
        }
    }

}