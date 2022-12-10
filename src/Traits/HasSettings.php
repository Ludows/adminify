<?php

  namespace Ludows\Adminify\Traits;

  use App\Adminify\Models\Settings;

  trait HasSettings
  {
   public $prefix_settings = '_settings';
   public function getKeySetting($key) {

      $baseClass = get_class($this);
      $baseName = class_basename($baseClass);

      return $this->prefix_settings.'_'. lowercase($baseName).'_'.$key;
   }
   public function settingExists($key) {
    $settings = Settings::where(['type' => $this->getKeySetting($key)]);
    return $settings->exists() == true;
   }
   public function getSetting($key) {
    $setting = Settings::where(['type' => $this->getKeySetting($key)])->first();
    return $setting;
   }
   public function getGlobalSetting($key) {
    if(empty($key)) {
      return null;
    }
    return Settings::where(['type' => $key])->first();
   }
   public function createSetting($key, $data) {
      $settingsCreate = new Settings();
      $settingsCreate->type = $this->getKeySetting($key);
      $settingsCreate->data = $this->maybeEncodeData($data);
      $settingsCreate->save();
      return $settingsCreate;
   }
   public function updateSetting($key, $data) {
        $settings = Settings::where(['type' => $this->getKeySetting($key)]);

        if ($settings->exists()) {
            return $settings->first()->update(['data' => $this->maybeEncodeData($data)]);
        }

        return new Settings();
   }
   public function deleteSetting($key) {
      $settings = Settings::where(['type' => $this->getKeySetting($key)])->get();
      if ($settings->isNotEmpty()) {
        foreach ($settings as $settingKey => $setting) {
          # code...
          $settings->delete();
        }
      }
   }
   public function deleteSettingBy($attribute = 'type', $key) {
     $settings = Settings::where([$attribute => $key])->get();
     if ($settings->isNotEmpty()) {
        foreach ($settings as $settingKey => $setting) {
          # code...
          $settings->delete();
        }
      }
      return $settings;
   }
}
