<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Factory;

class LogController extends Controller
{
    public $fact_no, $database, $schema, $level;

    public function index()
    {
        return view('components/content/log/login')->render();
    }

    public function login(Request $request)
    {
        # code...
    }

    public function directLogin(Request $request)
    {
        $this->fact_no = $request->input('guest_fact_no', true);

        if (isset($this->fact_no)) {
            if ($this->fact_no == '0228') {
                session()->put('database', 'db_pci');
                session()->put('schema', 'pcagleg');
            } elseif ($this->fact_no == 'B0CV') {
                session()->put('database', 'db_pgd');
                session()->put('schema', 'pgdleg');
            } elseif ($this->fact_no == 'B0EM') {
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

        $data_factory = $factory->setConnection($this->database)->setTable($this->schema.'.tl_factory')->where('fact_no', $this->fact_no)->get();

        if (count($data_factory) > 0) {
            foreach ($data_factory as $key => $fact) {
                if ($this->fact_no == $fact->fact_no) {
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
}
