<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEndpointRequest;
use App\Models\Endpoint;
use App\Models\Site;
use Illuminate\Http\Request;

class EndpointController extends Controller
{
    public function index(string $siteId)
    {
        $site = Site::with('endpoints.check')->find($siteId);

        if(!$site) {
            return back();
        }

        $endpoints = $site->endpoints;

        return view('admin/endpoints/index', compact('site', 'endpoints'));
    }

    public function create(string $siteId)
    {
        $site = Site::find($siteId);

        if(!$site) {
            return back();
        }

        return view('admin/endpoints/create', compact('site'));
    }

    public function store(StoreUpdateEndpointRequest $request, Site $site)
    {
        $site->endpoints()->create($request->all());        

        return redirect()
                ->route('endpoints.index', $site->id)
                ->with('message', 'Endpoint criado com sucesso');
    }

    public function edit(Site $site, Endpoint $endpoint)
    {
        return view('admin/endpoints/edit', compact('site', 'endpoint'));
    }

    public function update(StoreUpdateEndpointRequest $request, Site $site, Endpoint $endpoint)
    {
        $endpoint->update($request->validated());

        return redirect()
                ->route('endpoints.index', $site->id)
                ->with('message', 'Endpoint atualizado com sucesso');
    }

    public function destroy(Site $site, Endpoint $endpoint)
    {
        $endpoint->delete();

        return redirect()
                ->route('endpoints.index', $site->id)
                ->with('message', 'Endpoint excluído com sucesso');
    }
}
