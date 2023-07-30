<?php
namespace App\Http\Controllers\Web\Admin;

use App\Models\ClientModel;
use App\Models\ProjectModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

/**
 * Class ClientController
 * @package App\Http\Controllers\Web\Admin
 */
class ClientController
{


    /**
     * @param int $project_id
     * @return View
     */
    public function createForm(int $project_id)
    {
        $project = ProjectModel::query()->findOrFail($project_id);

        return view('admin.client.create_form')->with('project', $project);
    }

    /**
     * @param int $id
     * @return View
     */
    public function editForm(int $id)
    {
        $client = ClientModel::query()->findOrFail($id);

        return view('admin.client.edit_form')->with('client', $client);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function updateClient(int $id)
    {
        /** @var ClientModel $clientModel */
        $clientModel = ClientModel::query()->findOrFail($id);

        $clientModel->update(request()->only('name', 'is_active', 'oauth_client_type'));

        return redirect()->route('admin.client.list_project_clients', ['project_id' => $clientModel->project_id]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteClient(int $id)
    {
        $delete = ClientModel::query()->where('id', $id)->delete();

        return redirect()->back();
    }

    /**
     * @param int $project_id
     * @return View
     */
    public function listProjectClients(int $project_id)
    {
        $project = ProjectModel::query()->findOrFail($project_id);

        $clients = ClientModel::query()->where('project_id', $project_id)->paginate(request('per_page', 10));

        return view('admin.client.list_clients')->with('clients', $clients)->with('project', $project);
    }

    public function storeClient()
    {
        $data = request()->all();

        $data = array_merge($data, [
            'client_id' => Str::random(20),
            'client_secret' => Str::random(20),
            'redirect_urls' =>
                array_key_exists('redirect_urls', $data) ?
                    json_encode($data['redirect_urls']) :
                    json_encode([env('APP_URL')])
        ]);

        /** @var ClientModel $client */
        $client = ClientModel::query()->create($data);

        return redirect()->route('admin.client.list_project_clients', ['project_id' => $client->project_id ]);
    }


}
