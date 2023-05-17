<?php

namespace App\Http\Controllers\User;

use App\Models\NewsUpdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Controllers\UserActivityController;
use App\Http\Requests\News\EditNewsRequest;

class NewsController extends Controller
{
    public function create()
    {
        return view('user.news.create');
    }

    public function imageUpload(Request $request)
    {
        $origFile = $request->file('file');
        $newFile = $origFile->hashName();

        $fileName = explode('.', $newFile);
        $fileExt = $origFile->extension();

        $finalFileName = $fileName[0] . time() . '.' . $fileExt;

        $path = $request->file('file')->storeAs('news', $finalFileName, 'public');
        return response()->json(['location' => "/storage/$path"]);
    }

    private function hashImageFileName($image)
    {
        $hashedOrigFileName = $image->hashName();
        $newFileName = explode('.', $hashedOrigFileName);
        $fileExt = $image->extension();

        return $newFileName[0] . time() . '.' . $fileExt;
    }

    public function store(CreateNewsRequest $request)
    {
        if (auth()->user()->hasRole('administrator')) {
            $status = 'approved';
        } else {
            $status = 'pending';
        }

        $imageFileName = $this->hashImageFileName($request->file('image'));
        $image = $request->file('image')->storeAs('news', $imageFileName, 'public');

        $newsContent = [
            'image' => $image,
            'title' => $request->title,
            'content' => $request->content,
            'uri' => date('mdYhis') . time(),
            'status' => $status,
            'user_id' => auth()->user()->id,
            'mod_user_id' => auth()->user()->id,
        ];
        $que = NewsUpdate::create($newsContent);

        if ($que) {
            $log = [];
            $log['action'] = "Added News";
            $log['content'] = "Title: " . strip_tags($newsContent['title']) . ", Contents: " . strip_tags($newsContent['content']);
            $log['changes'] = "";
            UserActivityController::store($log);

            return Redirect::route('admin.news-page')->with('saved', 'success');
        } else {
            return back()->withErrors(['error' => 'failed']);
        }
    }

    public function edit($id)
    {
        try {
            NewsUpdate::findOrFail($id);
        } catch (\Throwable $th) {
            return back();
        }
        return view('user.news.edit', [
            'news' => $this->getNewsByID($id),
        ]);
    }

    private function getNewsByID($id)
    {
        return NewsUpdate::where('id', $id)->first();
    }

    public function update(EditNewsRequest $request)
    {
        $news = $this->getNewsByID($request->id);
        if (auth()->user()->hasRole('administrator')) {
            $status = 'approved';
        } else {
            $status = 'pending';
        }

        $newsContent = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'mod_user_id' => auth()->user()->id,
        ];
        $que = NewsUpdate::where('id', $request->id)->update($newsContent);

        if ($que) {
            $log = [];
            $log['action'] = "Updated News";
            $log['content'] = "Title: " . $news->title . ", Contents: " . strip_tags($news->content);
            $log['changes'] = "Title: " . $newsContent['title'] . ", Contents: " . strip_tags($newsContent['content']);
            UserActivityController::store($log);

            return Redirect::route('admin.news-page')->with('updated', 'success');
        } else {
            return back()->withErrors(['error' => 'failed']);
        }
    }
}
