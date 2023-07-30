<?php
namespace App\Http\Controllers\Web\Admin;

use App\Constants\SettingConstants;
use App\Models\SettingModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class SettingController
 * @package App\Http\Controllers\Web\Admin
 */
class SettingController
{

    /**
     * @return View
     */
    public function createForm()
    {
        return view('admin.setting.create_form');
    }

    /**
     * @param int $id
     * @return View
     */
    public function editForm(int $id)
    {
        $setting = SettingModel::query()->findOrFail($id);

        return view('admin.setting.edit_form', ['setting' => $setting]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function updateSetting(int $id)
    {
        $setting = SettingModel::query()->where('id', $id)->update(request()->only('value'));

        return redirect()->route('admin.setting.list_settings');
    }

    public function publicPrivateKeyForm()
    {
        $keys = SettingModel::query()
            ->whereIn('key', [SettingConstants::OAUTH_PRIVATE_KEY, SettingConstants::OAUTH_PUBLIC_KEY])
            ->get();

        return view('admin.setting.form_public_private_keys')
            ->with('publicKey', $keys->where('key', SettingConstants::OAUTH_PUBLIC_KEY)->first())
            ->with('privateKey', $keys->where('key', SettingConstants::OAUTH_PRIVATE_KEY)->first());
    }

    /**
     * @return RedirectResponse
     */
    public function updatePublicPrivateKey()
    {
        SettingModel::query()
            ->where('key', SettingConstants::OAUTH_PUBLIC_KEY)
            ->update(['value' => request('public_key')]);

        SettingModel::query()
            ->where('key', SettingConstants::OAUTH_PRIVATE_KEY)
            ->update(['value' => request('private_key')]);

        return redirect()->route('admin.setting.list_settings');
    }

    /**
     * @return JsonResponse
     */
    public function generatePublicPrivateKeyPairs()
    {
        $config = [
            "digest_alg" => request('digest_alg', 'sha256'),
            "private_key_bits" => request('private_key_bits', 2048),
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        $res = openssl_pkey_new($config);

        openssl_pkey_export($res, $privateKey);
        $publicKey = openssl_pkey_get_details($res);
        $publicKey = $publicKey["key"];

        return response()->json([
            'public_key' => $publicKey,
            'private_key' => $privateKey
        ]);
    }

    /**
     * @return View
     */
    public function listSettings()
    {
        $settings = SettingModel::query()->paginate(request('per_page', 30));

        return view('admin.setting.list_settings', ['settings' => $settings]);
    }

    /**
     * @return View
     */
    public function listIcons()
    {
        return view('admin.setting.list_icons');
    }


    /**
     * @return RedirectResponse
     */
    public function uploadIcon()
    {
        $file_type = array_keys(request()->file())[0];

        $file_name = $file_type.".".request()->file($file_type)->getClientOriginalExtension();

        request()->file($file_type)->storeAs("/public/icons/", $file_name);

        return redirect()->back()->with(['success_message' => 'File uploaded successfully']);
    }

}
