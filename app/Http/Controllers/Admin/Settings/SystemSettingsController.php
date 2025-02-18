<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Models\SystemSettings;
use App\Http\Controllers\Controller;
use App\Services\Utils\FileUploadService;
use Spatie\Permission\Models\Role;

class SystemSettingsController extends Controller
{
    public const FILE_STORE_PATH = 'settings';
    protected $fileUploadService;

    /**
     * __construct
     *
     * @param  mixed $model
     * @return void
     */
    public function __construct()
    {
        $this->fileUploadService = app(FileUploadService::class);

        $this->middleware(['permission:Site Settings'])->only(['edit']);
    }

    /**
     * edit
     *
     * @return void
     */
    public function edit()
    {
        $settings = [];
        $raw_settings = SystemSettings::all();
        $roles = Role::query()->pluck('name', 'id');

        foreach ($raw_settings as $s) {
            $settings[$s->settings_key] = $s->settings_value;
        }

        set_page_meta('System Settings');
        return view('admin.system_settings.edit', compact('settings', 'roles'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {
        $data = $request->except('_token');

        // Set site logo
        $data = $this->uploadImage($data, 'site_logo');
        // Set favicon
        $data = $this->uploadImage($data, 'favicon');
        // Set login background
        $data = $this->uploadImage($data, 'login_background');
        // Set login slider image
        $data = $this->uploadImage($data, 'login_slider_image_1');
        $data = $this->uploadImage($data, 'login_slider_image_2');
        $data = $this->uploadImage($data, 'login_slider_image_3');
        $data = $this->uploadImage($data, 'login_slider_image_m_1');
        $data = $this->uploadImage($data, 'login_slider_image_m_2');
        $data = $this->uploadImage($data, 'login_slider_image_m_3');


        $keys = array_keys($data);

        foreach ($keys as $key) {
            $settings = SystemSettings::where('settings_key', $key)->first();
            if (!$settings) $settings = new SystemSettings();

            $settings->settings_key = $key;
            $settings->settings_value = $data[$key];
            $settings->save();

        }

        if(array_key_exists('timezone', $data['general'])){
            envWrite('APP_TIMEZONE', $data['general']['timezone']);
        }

        flash('System settings updated successfully')->success();
        return redirect()->back();
    }


    /**
     * uploadImage
     *
     * @param  mixed $data
     * @param  mixed $field
     * @return void
     */
    public function uploadImage($data, $field)
    {
        // Get general settings
        $general = SystemSettings::where('settings_key', 'general')->first();
        // Upload image
        if (isset($data['general'][$field])) {
            if(isset($general['settings_value'][$field]) && $general['settings_value'][$field] != null){
                $array = explode('/', $general['settings_value'][$field]);
                $this->fileUploadService->delete('settings/'.$array[count($array) - 1]);
            }
            $this->fileUploadService->delete($data['general'][$field], self::FILE_STORE_PATH);
            $name = $this->fileUploadService->upload($data['general'][$field], self::FILE_STORE_PATH);
            $data['general'][$field] = getStorageImage(self::FILE_STORE_PATH, $name);
        } else {
            if (isset($general->settings_value[$field])) {
                $data['general'][$field] = $general->settings_value[$field];
            }
        }

        return $data;
    }
}
