<?php

namespace App\Http\Controllers;

use App\Models\PropertyAppraisal;
use App\Models\Appraiser; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AppraisalController extends Controller
{
    /**
     * Display the property estimation page with appraisers
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // For debugging: Log whenever this method is called
        Log::info('PropertyAppraisalController@index called');
        
        try {
            // استرجاع المخمنين من قاعدة البيانات
            $appraisers = Appraiser::with('user')->get();
            
            // تحويل البيانات إلى الشكل المطلوب
            $appraisers = $appraisers->map(function($appraiser) {
                return (object)[
                    'id' => $appraiser->id,
                    'name' => $appraiser->user->name,
                    'profile_image' => $appraiser->user->profile_image ?? null,
                    'rating' => $appraiser->rating,
                    'specialty' => $appraiser->specialty,
                    'bio' => $appraiser->user->bio ?? 'Professional appraiser with extensive experience.',
                    'certification' => $appraiser->license_number
                ];
            });
            
            Log::info('Retrieved ' . $appraisers->count() . ' appraisers from database');
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، استخدم البيانات الثابتة كاحتياط
            Log::error('Error getting appraisers: ' . $e->getMessage());
            $appraisers = $this->getSampleAppraisers();
        }
        
        return view('public.property-estimation', compact('appraisers'));
    }

    /**
     * Book a property appraisal appointment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appraiser_id' => 'required|integer',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'property_address' => 'required|string|max:500',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'required|email|max:255',
            'property_type' => 'nullable|string',
            'property_area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'additional_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $appraisal = PropertyAppraisal::create([
                'user_id' => Auth::id() ?? 1,  // استخدم معرف المستخدم الحالي أو 1 كافتراضي
                'appraiser_id' => $request->appraiser_id,
                'client_name' => $request->client_name,
                'client_email' => $request->client_email,
                'client_phone' => $request->client_phone,
                'property_address' => $request->property_address,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'property_type' => $request->property_type,
                'property_area' => $request->property_area,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'additional_notes' => $request->additional_notes,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully',
                'data' => $appraisal
            ]);

        } catch (\Exception $e) {
            Log::error('Appointment booking failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to book appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display user's appraisal appointments
     *
     * @return \Illuminate\View\View
     */
    public function myAppointments()
    {
        try {
            $appraisals = PropertyAppraisal::where('user_id', Auth::id())
                ->with('appraiser')
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
                
            // إضافة معلومات المخمن من جدول المستخدمين
            $appraisals->getCollection()->transform(function($appraisal) {
                if ($appraisal->appraiser && $appraisal->appraiser->user) {
                    $appraisal->appraiser->name = $appraisal->appraiser->user->name;
                    $appraisal->appraiser->profile_image = $appraisal->appraiser->user->profile_image;
                }
                return $appraisal;
            });
        } catch (\Exception $e) {
            Log::error('Error fetching appointments: ' . $e->getMessage());
            $appraisals = collect();
        }

        return view('public.my-appraisals', compact('appraisals'));
    }

    /**
     * Cancel an appointment
     *
     * @param  PropertyAppraisal  $appraisal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelAppointment(PropertyAppraisal $appraisal)
    {
        if ($appraisal->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        if ($appraisal->status === 'completed') {
            return redirect()->back()->with('error', 'Completed appointments cannot be cancelled');
        }

        $appraisal->update(['status' => 'cancelled']);

        return redirect()->route('property.appraisals.my')
            ->with('success', 'Appointment cancelled successfully');
    }

    /**
     * Get sample appraisers data as a fallback
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getSampleAppraisers()
    {
        Log::info('Using sample appraisers data as fallback');
        
        return collect([
            (object)[
                'id' => 1,
                'name' => 'Ahmad Expert',
                'profile_image' => null, 
                'rating' => 4.8,
                'specialty' => 'Residential Apartment Valuation',
                'bio' => 'Licensed real estate appraiser with 10 years of experience in the Jordanian market',
                'certification' => 'LIC-1234'
            ],
            (object)[
                'id' => 2,
                'name' => 'Sara Engineer',
                'profile_image' => null,
                'rating' => 4.7,
                'specialty' => 'Villas and Mansions Valuation',
                'bio' => 'Architect and real estate appraiser specializing in villas and mansions',
                'certification' => 'LIC-5678'
            ],
            (object)[
                'id' => 3,
                'name' => 'Mohammad RealEstate',
                'profile_image' => null,
                'rating' => 4.9,
                'specialty' => 'Land and Commercial Projects Valuation',
                'bio' => 'Land and commercial project valuation expert with over 12 years of experience',
                'certification' => 'LIC-9012'
            ],
            (object)[
                'id' => 4,
                'name' => 'Layla Expert',
                'profile_image' => null,
                'rating' => 4.6,
                'specialty' => 'Investment Apartments and Residential Complexes',
                'bio' => 'Real estate appraiser specializing in investment apartments and residential complexes',
                'certification' => 'LIC-3456'
            ]
        ]);
    }
}