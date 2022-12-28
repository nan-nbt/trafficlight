<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Section;
use App\Models\Process;
use App\Models\Collection;

class DashboardController extends Controller
{
    public $factory, $database, $schema, $level;

    public function __construct()
    {
        if (session()->has('factory')) {
            if (session()->get('factory') == '0228') {
                session()->put('database', 'db_pci');
                session()->put('schema', 'pcagleg');
            } elseif (session()->get('factory') == 'B0CV') {
                session()->put('database', 'db_pgd');
                session()->put('schema', 'pgdleg');
            } elseif (session()->get('factory') == 'B0EM') {
                session()->put('database', 'db_pgs');
                session()->put('schema', 'pgsleg');
            }

            $this->database = session()->get('database');
            $this->schema = session()->get('schema');
        } else {
            $this->database = null;
            $this->schema = null;
        }

        $this->level = session()->get('level');
    }

    public function index()
    {
        if ($this->database == null && $this->schema == null || session()->get('factory') == null) {
            // abort(403);
            return redirect()->route('log');
        }

        $section = new Section;
        $process = new Process;
        $collection = new Collection;

        return view('dashboard', [
            'data' => $section->setConnection($this->database)->setTable($this->schema.'.tl_sec')->get(),
            'data' => $process->setConnection($this->database)->setTable($this->schema.'.tl_process')->get(),
            'data' => $collection->setConnection($this->database)->setTable($this->schema.'.tl_data_collection')->get(),
        ]);
    }
}
