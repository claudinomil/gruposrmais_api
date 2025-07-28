<?php

namespace App\Http\Controllers;

use App\Models\Submodulo;

class SubmoduloController extends Controller
{
    private $submodulo;

    public function __construct(Submodulo $submodulo)
    {
        $this->submodulo = $submodulo;
    }

    public function research($fieldSearch, $fieldValue, $fieldReturn)
    {
        $registros = $this->submodulo->where($fieldSearch, 'like', '%' . $fieldValue . '%')->get($fieldReturn);

        return $this->sendResponse('', 2000, '', $registros);
    }
}
