<?php

namespace App\Http\Controllers\BasicData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Section;
use DB;

class SectionController extends Controller
{
    public $factory, $database, $schema;

    public function __construct()
    {
        session()->put('factory', '0228');

        if (session()->has('factory')) {
            session()->put('database', 'db_pci');
            session()->put('schema', 'pcagleg');

            $this->database = session()->get('database');
            $this->schema = session()->get('schema');
        }

    }

    public function index()
    {
        $section = new Section;

        return view('components/basic-data/section/list', [
            'data' => $section->setConnection($this->database)->setTable($this->schema.'.tl_sec')->get()
        ]);
    }

}
