<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Factory;
use App\Models\Users;
use Exception;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak;

class LogController extends Controller
{
    public $user_fact_no, $database, $schema, $level, $guest_fact_no;

    public function index()
    {
        return view('components/content/log/login')->render();
    }

    public function login(Request $request)
    {
        $this->user_fact_no = $request->input('user_fact_no', true);
        $request->session()->put('factory', $this->user_fact_no);

        // redirect url to check session login using SSO V2.0
        return redirect()->route('log.loginauth');
    }

    public function loginAuth(Request $request)
    {
        $this->user_fact_no = $request->session()->get('factory');

        if (isset($this->user_fact_no)) {
            if ($this->user_fact_no == '0228') {
                $request->session()->put('database', 'db_pci');
                $request->session()->put('schema', 'pcagleg');
            } elseif ($this->user_fact_no == 'B0CV') {
                $request->session()->put('database', 'db_pgd');
                $request->session()->put('schema', 'pgdleg');
            } elseif ($this->user_fact_no == 'B0EM') {
                $request->session()->put('database', 'db_pgs');
                $request->session()->put('schema', 'pgsleg');
            }

            $this->database = $request->session()->get('database');
            $this->schema = $request->session()->get('schema');
        } else {
            $this->database = null;
            $this->schema = null;
        }

        /**
         * START
         *
         * Configuration script for using OAuth 2.0 and Open ID Connect
         * Provider: Keycloak
         * Single Sign On (SSO) v2.0
         */

         $provider = new Keycloak([
            'authServerUrl'         => 'https://iam.pouchen.com/auth',
            'realm'                 => 'pcg',
            'clientId'              => 'tls-server-5hugjyqx',
            'clientSecret'          => 'wTtfZDh3q075OFxh0beAJdBKQhsAStBU',
            'redirectUri'           => route('log.loginauth'),
            'encryptionAlgorithm'   => null,
            'encryptionKeyPath'     => null,
            'encryptionKey'         => null
        ]);

        $code = $request->code;
        $state = $request->state;

        session_start();

        if(!isset($code)){
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();

            header('Location: '.$authUrl);
            exit;

        // Check given state against previously stored one to mitigate CSRF attack
        }elseif(empty($state) || ($state !== $_SESSION['oauth2state'])){
            unset($_SESSION['oauth2state']);
            exit('Invalid state, make sure HTTP sessions are enabled.');

        }else{
            // Try to get an access token (using the authorization code grant)
            try{
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $code
                ]);
            }catch(Exception $e){
                exit('Failed to get access token: '.$e->getMessage());
            }

            // Optional: Now you have a token you can look up a users profile data
            try{
                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($token);

                // get user information from API server (array associative)
                $userinfo = $user->toArray();

                /**
                 * START
                 * login method to check user data
                 */

                $factoryModel = new Factory;
                $userModel = new Users;

                $data_factory = $factoryModel->setConnection($this->database)->setTable($this->schema.'.tl_factory')->where('fact_no', $this->user_fact_no)->get();
                $data_user = $userModel->setConnection($this->database)->setTable($this->schema.'.tl_users')->where(['fact_no' => $this->user_fact_no, 'pcc_id' => $userinfo['pccuid']])->get();

                if(count($data_factory) > 0 && count($data_user) > 0){
                    foreach($data_factory as $factory){
                        foreach($data_user as $users){
                            if($userinfo['pccuid'] == $users->pcc_id && $this->user_fact_no == $factory->fact_no && $users->fact_no == $factory->fact_no && $users->depart != 'HSE'){

                                session()->put('factory', $factory->fact_no);
                                session()->put('sap_factory', $factory->sap_fact_no);
                                session()->put('factory_name', $factory->fact_name);
                                session()->put('userno', $users->user_no);
                                session()->put('username', $userinfo['name']);
                                session()->put('level', $users->user_mk);

                                $userModel->setConnection($this->database)->setTable($this->schema.'.tl_users')->where(['fact_no' => $this->user_fact_no, 'user_no' => $users->user_no])->update(['l_login_time' => date('YmdHis')]);

                                // redirect url to dashboard traffic light system
                                return redirect()->route('dashboard');
                            }else{
                                return redirect()->route('log.logout')->with('warning', 'Incorrect user NO or password! please contact IT if you forget account!');
                            }
                        }
                    }
                }else{
                    return redirect()->route('log.logout')->with('warning', 'Account not found in '.$this->user_fact_no.' factory!');
                }
                /**
                 * END
                 * login method to check user data
                 */

            }catch(Exception $e){
                exit('Failed to get resource owner: '.$e->getMessage());
            }
        }
        /**
         * END
         *
         * Configuration script for using OAuth 2.0 and Open ID Connect
         * Provider: Keycloak
         * Single Sign On (SSO) v2.0
         */
    }

    public function directLogin(Request $request)
    {
        $this->guest_fact_no = $request->input('guest_fact_no', true);

        if (isset($this->guest_fact_no)) {
            if ($this->guest_fact_no == '0228') {
                session()->put('database', 'db_pci');
                session()->put('schema', 'pcagleg');
            } elseif ($this->guest_fact_no == 'B0CV') {
                session()->put('database', 'db_pgd');
                session()->put('schema', 'pgdleg');
            } elseif ($this->guest_fact_no == 'B0EM') {
                session()->put('database', 'db_pgs');
                session()->put('schema', 'pgsleg');
            }

            $this->database = session()->get('database');
            $this->schema = session()->get('schema');
        } else {
            $this->database = null;
            $this->schema = null;
        }

        $factory = new Factory;

        $data_factory = $factory->setConnection($this->database)->setTable($this->schema.'.tl_factory')->where('fact_no', $this->guest_fact_no)->get();

        if (count($data_factory) > 0) {
            foreach ($data_factory as $key => $fact) {
                if ($this->guest_fact_no == $fact->fact_no) {
                    session()->put('factory', $fact->fact_no);
                    session()->put('sap_factory', $fact->sap_fact_no);
                    session()->put('factory_name', $fact->fact_name);

                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('log')->with('warning', 'selected data factory not found!');
                }
            }
        } else {
            return redirect()->route('log')->with('warning', 'database connection not found for this factory!');
        }
    }

    public function logout()
    {
        if (session()->get('username') == null) {
            session()->forget('factory');
            session()->forget('sap_factory');
            session()->forget('factory_name');

            return redirect()->route('dashboard');
        } else {
            session()->forget('factory');
            session()->forget('sap_factory');
            session()->forget('factory_name');
            session()->forget('userno');
            session()->forget('username');
            session()->forget('level');

            return redirect('https://iam.pouchen.com/auth/realms/pcg/protocol/openid-connect/logout?post_logout_redirect_uri='.route('dashboard'));
        }

        session_destroy();
    }
}
