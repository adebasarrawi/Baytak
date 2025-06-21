<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * عرض صندوق الرسائل للمستخدم
     */
    public function index()
    {
        $user_id = Auth::id();
        
        // الحصول على المحادثات الفريدة (مجمعة حسب المستخدم الآخر)
        $conversations = Message::where('sender_id', $user_id)
            ->orWhere('receiver_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($user_id) {
                // تجميع حسب المستخدم الآخر (إما المرسل أو المستلم)
                return $message->sender_id == $user_id 
                    ? $message->receiver_id 
                    : $message->sender_id;
            });
            
        // تحضير بيانات المحادثات
        $inbox = [];
        
        foreach ($conversations as $user_id => $messages) {
            $otherUser = User::find($user_id);
            $lastMessage = $messages->sortByDesc('created_at')->first();
            
            $inbox[] = [
                'user' => $otherUser,
                'last_message' => $lastMessage,
                'unread_count' => $messages->where('is_read', false)
                                         ->where('receiver_id', Auth::id())
                                         ->count()
            ];
        }
        
        return view('messages.index', compact('inbox'));
    }

    /**
     * عرض محادثة معينة
     */
    public function show($user_id)
    {
        $otherUser = User::findOrFail($user_id);
        $currentUser = Auth::id();
        
        // الحصول على الرسائل بين المستخدمين
        $messages = Message::where(function ($query) use ($currentUser, $user_id) {
                $query->where('sender_id', $currentUser)
                      ->where('receiver_id', $user_id);
            })
            ->orWhere(function ($query) use ($currentUser, $user_id) {
                $query->where('sender_id', $user_id)
                      ->where('receiver_id', $currentUser);
            })
            ->orderBy('created_at', 'asc')
            ->get();
            
        // تحديث حالة قراءة الرسائل المستلمة
        Message::where('sender_id', $user_id)
            ->where('receiver_id', $currentUser)
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return view('messages.show', compact('messages', 'otherUser'));
    }

    /**
     * حفظ رسالة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'property_id' => 'nullable|exists:properties,id',
            'message' => 'required|string',
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'property_id' => $request->property_id,
            'message' => $request->message,
            'is_read' => false
        ]);
        
        // للطلبات AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }
        
        // التوجيه بعد الإرسال العادي
        // إذا جاء من صفحة العقار، عد إلى صفحة العقار مع رسالة نجاح
        if ($request->has('property_id')) {
            return redirect()->back()->with('success', 'Your message has been sent successfully to the agent.');
        }
        
        // وإلا، انتقل إلى المحادثة
        return redirect()->route('messages.show', $request->receiver_id)
            ->with('success', 'Message sent successfully.');
    }
}