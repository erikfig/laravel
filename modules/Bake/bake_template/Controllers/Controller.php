<?php

namespace Modules\{{plural-upper}}\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Modules\Components\Models\MyModel;

class {{plural-upper}}Controller extends Controller
{

    /**
    use \App\Http\Controllers\ApiControllerTrait; //for APIs
    use \App\Http\Controllers\CrudControllerTrait; //for dashboards

    protected $model;
    protected $path = '{{singular-upper}}::';
    protected $redirectPath = '{{plural-lower}}'; //delete it for ApiCrudControllerTrait
    protected $relationships = []; //delete if not using
    protected $rules = []; //validation rules, delete if not using
    protected $messages = []; //validation messages, delete if not using

    public function __construct(MyModel $model)
    {
        $this->model = $model;
    }
    **/

    public function index()
    {
        return view('{{singular-upper}}::index');
    }
}
