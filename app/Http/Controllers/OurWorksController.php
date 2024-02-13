<?php

namespace App\Http\Controllers;

use App\Models\OurWorks;
use App\Models\OurWorksMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurWorksController extends Controller
{
    //

    public function getAll()
    {
        $ourWorks = OurWorks::get();

        return view('oworks.list', compact('ourWorks'));
    }

    public function checkWork(Request $request)
    {
        $data = OurWorks::find($request->id);

        return view('oworks.only', compact('data'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        function loadCover($img)
        {
            $coverName = time() . '.' . $img->extension();
            $coverPath = $img->storeAs('public/imgs/our_works/covers/', $coverName);

            return $coverName;
        }

        function loadMediaOW($imgs, $work_id)
        {
            $counter = 1;
            foreach ($imgs as $image) {
                $fileName = time() . '_' . $counter . '.' . $image->extension();
                $imagePath = $image->storeAs('public/imgs/our_works/mediafiles/', $fileName);
                OurWorksMedia::create([
                    'work_id' => $work_id,
                    'image' => $fileName
                ]);
                $counter++;
            }
        }

        function delCoverOW($oldCover)
        {
        }
        function delMediaOW($oldFiles, $work_id)
        {
            foreach ($oldFiles as $oldFile) {
                $filePath = 'public/imgs/our_works/mediafiles/' . $oldFile->image;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                OurWorksMedia::where('work_id', $work_id)->delete();
            }
        }

        if (!$request->work_id) {

            // Добавление 

            if ($request->hasFile('cover')) {
                $coverName = loadCover($request->cover);
            }

            $work_id = OurWorks::insertGetId([
                'name' => $request->name,
                'description' => $request->desc,
                'what_we_do' => $request->wedo,
                'year' => $request->year,
                'cover' => $coverName ?? 'default.png'
            ]);

            if ($request->hasFile('media') && is_array($request->file('media'))) {
                loadMediaOW($request->media, $work_id);
            }
        } else {

            // Обновление

            $update['updated_at'] = null;

            if ($request->hasFile('cover')) {
                $oldCover = OurWorks::select('cover')->find($request->work_id);
                delCoverOW($oldCover);

                $coverName = loadCover($request->cover);
                OurWorks::where('id', '=', $request->work_id)
                    ->update([
                        'cover' => $coverName
                    ]);
            }

            if ($request->hasFile('media') && is_array($request->file('media'))) {
                $oldFiles = OurWorksMedia::select('image')->where('work_id', $request->work_id)->get();

                delMediaOW($oldFiles, $request->work_id);

                loadMediaOW($request->media, $request->work_id);
            }

            $toUPD = $request->toArray();
            $OurWorks = OurWorks::find($request->work_id);
            // dd($toUPD);
            $testing = $OurWorks->toArray();

            // формирование массива обновленных данных на основе данных из базы и новых
            foreach ($testing as $key => $item) {
                switch ($key) {
                    case 'id':
                    case 'cover':
                    case 'created_at':
                    case 'updated_at':
                        break;
                    default:
                        if ($toUPD[$key] != $item) {
                            $update[$key] = $toUPD[$key];
                        }
                        break;
                }
            }

            // dd($update);

            $OurWorks->update($update);
            $work_id = $request->work_id;
        }

        return redirect()->route('OWview', ['id' => $work_id]);
    }

    public function editor(Request $request)
    {
        $data = OurWorks::find($request->id);

        // dd($data);

        return view("oworks.editor", compact('data'));
    }
    public function delete(Request $request)
    {
        $oldFiles = OurWorksMedia::select('image')->where('work_id', $request->id)->get();
        $oldCover = OurWorks::select('cover')->find($request->id);
        dd($oldCover);

        delCoverOW($oldCover);
        delMediaOW($oldFiles, $request->id);

        $OurWorks = OurWorks::where('id', $request->id)->delete();

        return redirect()->route("shop");
    }
}
