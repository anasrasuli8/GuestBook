<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\Replies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MessagesController extends Controller
{
    public function getMessages(Request $request){
        return Messages::with('replies','user:id,name')->orderBy('created_at','desc')->paginate(25);
    }
    public function saveMessage(Request $request){
        $request->validate([
            'message' => 'required|string|max:1000',
            'img' => 'sometimes|image|mimes:jpg,png,jpeg|max:1000|dimensions:min_width=100,min_height=100'
        ]);
        $msg = $request->has('id') ? Messages::find($request->input('id')) : new Messages;
        $msg->text = $request->input('message');
        $msg->user_id = Auth::id();
        $img = $request->file('img');
        if ($img != null && $img->isValid()) {
            $uploadPath = 'user_images/';
            if($msg->img != null && Storage::disk('public')->exists($uploadPath.$msg->img)){
                Storage::disk('public')->delete($uploadPath.$msg->img);
            }
            $extension = $img->extension();
            $img_name = date('mdYHis') . uniqid().".".$extension;
            $img = Image::make($img->getRealPath());
            $ih = $img->height();
            $iw = $img->width();
            if( $ih > 500 || $iw > 500){
                $img = $img->resize($iw > $ih ? 500 : null, $ih > $iw ? 500 : null, function ($con){
                    $con->aspectRatio();
                });
            }
            Storage::disk('public')->put($uploadPath.$img_name, $img->encode($extension));
            $msg->img = $img_name;
        }
        return $msg->save();
    }
    public function saveReply(Request $request){
        $request->validate([
            'text' => 'required|string',
            'id' => 'required',
        ]);
        $reply = new Replies;
        $reply->text = $request->text;
        $reply->user_id = Auth::id();
        $reply->message_id = $request->id;
        $reply->save();
        $reply->user = Auth::user();
        return $reply;
    }
}
