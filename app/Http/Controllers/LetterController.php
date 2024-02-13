<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    //
    public function save(Request $request)
    {
        $letterName = time() . '.' . $request->image->extension();
        $letterPath = $request->image->storeAs('public/imgs/letter_scans/', $letterName);

        Letter::create([
            'from' => $request->from,
            'image' => $letterName
        ]);

        return redirect()->route('home');
    }

    public function delete($id)
    {
        $oldFile = Letter::where('id', $id)->value('image');

        $filePath = 'public/imgs/letter_scans/' . $oldFile;

        Letter::where('id', $id)->delete();
        return redirect()->route('home');
    }
}
