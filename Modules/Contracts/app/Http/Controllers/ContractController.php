<?php

namespace Modules\Contracts\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Contracts\Http\Requests\StoreContractRequest;
use Modules\Contracts\Models\Contract;

class ContractController extends Controller
{
    public function index()
    {
        // TODO: view
        return Contract::all();
    }

    public function store(StoreContractRequest $request)
    {
        Contract::create($request->validated());
        return redirect()->route('hr.contracts.index');
    }

    // TODO: other resource methods
}
