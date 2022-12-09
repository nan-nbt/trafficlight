<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Section;

class SectionController extends Controller
{
    public $factory, $database, $schema, $level;

    public function __construct()
    {
        session()->put('factory', '0228');
        session()->put('level', 'S');

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
        if ($this->database == null && $this->schema == null || $this->level != 'S') {
            abort(403);
        }

        $section = new Section;

        return view('dashboard', [
            'data' => $section->setConnection($this->database)->setTable($this->schema.'.tl_sec')->get()
        ]);
    }
}
