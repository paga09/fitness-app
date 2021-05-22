<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserSettings(Request $request)
    {
        $userData = User::where('id', $request->user()->id)->get('settings')->first();
        return $userData->settings;
    }

    public function editUserSettings(Request $request)
    {
        $request->validate([
            'checkedSettings.protein' => 'required|boolean',
            'checkedSettings.carbs' => 'required|boolean',
            'checkedSettings.fat' => 'required|boolean',
            'checkedSettings.fiber' => 'required|boolean',
            'checkedSettings.kcal' => 'required|boolean',
        ]);
        $content = json_decode($request->getContent());
        $updateDetails = [
            "protein" => $content->checkedSettings->protein,
            "carbs" => $content->checkedSettings->carbs,
            "fat" => $content->checkedSettings->fat,
            "fiber" => $content->checkedSettings->fiber,
            "kcal" => $content->checkedSettings->kcal
        ];
        User::where('id', $request->user()->id)->update(['settings' => $updateDetails]);
        return $request->user()->id;
    }
}