<?php

namespace App\Http\Controllers;

use App\Models\PropertyAppraisal;
use App\Models\Appraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PropertyAppraisalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only bookAppointment requires authentication
        $this->middleware('auth', ['only' => ['bookAppointment', 'myAppointments']]);
    }

    /**
     * Display the property estimation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // سجّل بداية العملية
        Log::info('بدء استدعاء صفحة تقدير العقارات');
        
        // إنشاء مجموعة فارغة كقيمة افتراضية
        $appraisers = collect([]);
        
        // محاولة جلب المخمنين من قاعدة البيانات
        try {
            $appraisers = Appraiser::with('user')->get();
            
            // تسجيل عدد المخمنين الذي تم جلبهم
            Log::info('تم جلب المخمنين بنجاح', ['عدد' => $appraisers->count()]);
            
            // تحويل البيانات إلى الشكل المطلوب
            $appraisers = $appraisers->map(function($appraiser) {
                return (object)[
                    'id' => $appraiser->id,
                    'name' => $appraiser->user->name ?? 'غير معروف',
                    'profile_image' => $appraiser->user->profile_image ?? null,
                    'rating' => $appraiser->rating ?? 0,
                    'specialty' => $appraiser->specialty ?? '',
                    'bio' => $appraiser->user->bio ?? 'مخمن عقارات محترف',
                    'certification' => $appraiser->license_number ?? ''
                ];
            });
        } catch (\Exception $e) {
            // تسجيل الخطأ واستخدام بيانات نموذجية
            Log::error('خطأ في جلب المخمنين: ' . $e->getMessage());
            $appraisers = $this->getSampleAppraisers();
        }
        
        // تمرير متغير المخمنين إلى العرض
        return view('public.property-estimation', compact('appraisers'));
    }

    /**
     * Store a new appraisal appointment request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookAppointment(Request $request)
    {
        $validated = $request->validate([
            'appraiser_id' => 'required|integer',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'property_address' => 'required|string',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'additional_notes' => 'nullable|string',
        ]);

        // Add user_id if authenticated (should always be the case due to middleware)
        $validated['user_id'] = Auth::id();
         
        // Set initial status
        $validated['status'] = 'pending';

        // Create the appraisal record
        $appraisal = PropertyAppraisal::create($validated);

        // In a real application, you would send notifications here
        // - Email to the client
        // - Notification to the appraiser
        // - Internal notification to admin

        return response()->json([
            'success' => true,
            'message' => 'Your appointment request has been submitted successfully!',
            'appraisal' => $appraisal
        ]);
    }

    /**
     * List user's appraisal appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAppointments()
    {
        // جلب جميع المواعيد الخاصة بالمستخدم الحالي
        $appraisals = PropertyAppraisal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // إضافة التصفح للعرض
    
        // تمرير متغير $appraisals إلى العرض (بدلاً من $appointments)
        return view('public.my-appointments', compact('appraisals'));
    }

    public function cancelAppointment(PropertyAppraisal $appraisal)
{
    // تأكد من أن المستخدم الحالي هو صاحب الموعد
    if (Auth::id() !== $appraisal->user_id) {
        return redirect()->back()->with('error', 'غير مصرح لك بإلغاء هذا الموعد.');
    }

    // تغيير حالة الموعد إلى ملغي
    $appraisal->status = 'cancelled';
    $appraisal->save();

    return redirect()->route('public.my-appointments')->with('success', 'تم إلغاء الموعد بنجاح.');
}

    /**
     * جلب بيانات نموذجية للمخمنين
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getSampleAppraisers()
    {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'أحمد خبير',
                'profile_image' => null,
                'rating' => 4.8,
                'specialty' => 'تقييم الشقق السكنية',
                'bio' => 'مخمن عقارات مرخص بخبرة 10 سنوات في السوق الأردني',
                'certification' => 'LIC-1234'
            ],
            (object)[
                'id' => 2,
                'name' => 'سارة مهندس',
                'profile_image' => null,
                'rating' => 4.7,
                'specialty' => 'تقييم الفلل والقصور',
                'bio' => 'مهندسة معمارية ومخمنة عقارات متخصصة في الفلل والقصور',
                'certification' => 'LIC-5678'
            ],
            (object)[
                'id' => 3,
                'name' => 'محمد عقاري',
                'profile_image' => null,
                'rating' => 4.9,
                'specialty' => 'تقييم الأراضي والمشاريع التجارية',
                'bio' => 'خبير تقييم الأراضي والمشاريع التجارية بخبرة تزيد عن 12 عامًا',
                'certification' => 'LIC-9012'
            ],
            (object)[
                'id' => 4,
                'name' => 'ليلى خبيرة',
                'profile_image' => null,
                'rating' => 4.6,
                'specialty' => 'تقييم الشقق الاستثمارية والمجمعات السكنية',
                'bio' => 'مخمنة عقارات متخصصة في الشقق الاستثمارية والمجمعات السكنية',
                'certification' => 'LIC-3456'
            ]
        ]);
    }
}