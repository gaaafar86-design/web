<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Amenity;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\Header;
use App\Models\Location;
use App\Models\Message;
use App\Models\Plan;
use App\Models\PrivacyPolicy;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Subscriber;
use App\Models\Term;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\WhyChooseUs;
use App\Notifications\UserSelectedPlanNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FrontController extends Controller
{
    /**
     * الصفحة الرئيسية.
     */
    public function index(): View
    {
        $randomProperties = Property::where('status', 1)
            ->inRandomOrder()
            ->take(6)
            ->with('propertyType', 'location', 'agent')
            ->get();

        $popularLocations = Location::withCount([
            'properties' => function ($query) {
                $query->where('status', 1);
            },
        ])
            ->orderByDesc('properties_count')
            ->take(8)
            ->get();

        $agents = Agent::where('status', 1)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $header = Header::first();
        $whyChooseUsItems = WhyChooseUs::all();
        $testimonials = Testimonial::all();

        $posts = Blog::latest()
            ->take(3)
            ->get();

        $locations = Location::all();
        $propertyTypes = PropertyType::all();

        return view(
            'front.index',
            compact(
                'randomProperties',
                'popularLocations',
                'agents',
                'header',
                'whyChooseUsItems',
                'testimonials',
                'posts',
                'locations',
                'propertyTypes'
            )
        );
    }

    /**
     * صفحة اختيار نوع الحساب.
     */
    public function selectUser(): View
    {
        return view('front.pages.select_user');
    }

    /**
     * لوحة تحكم المستخدم.
     */
    public function userDashboard(): View
    {
        $user = Auth::guard('web')->user();

        $messageCount = Message::where(
            'user_id',
            $user->id
        )->count();

        $wishlistItems = Wishlist::where(
            'user_id',
            $user->id
        )
            ->with('property')
            ->latest()
            ->take(3)
            ->get();

        return view(
            'front.user.dashboard.index',
            compact(
                'user',
                'messageCount',
                'wishlistItems'
            )
        );
    }

    /**
     * لوحة تحكم الوكيل.
     */
    public function agentDashboard(): View
    {
        $agent = Auth::guard('agent')->user();

        $totalActiveProperties = $agent
            ->properties()
            ->where('status', 1)
            ->count();

        $totalPendingProperties = $agent
            ->properties()
            ->where('status', 0)
            ->count();

        $totalFeaturedProperties = $agent
            ->properties()
            ->where('is_featured', 1)
            ->count();

        $recentProperties = Property::where(
            'agent_id',
            $agent->id
        )
            ->orderByDesc('created_at')
            ->take(3)
            ->with('propertyType', 'location')
            ->get();

        return view(
            'front.agent.dashboard.index',
            compact(
                'agent',
                'totalActiveProperties',
                'totalPendingProperties',
                'totalFeaturedProperties',
                'recentProperties'
            )
        );
    }

    /**
     * صفحة العروض.
     */
    public function pricing(): View
    {
        $plans = Plan::all();

        return view(
            'front.pages.pricing',
            compact('plans')
        );
    }

    /**
     * إرسال طلب اختيار عرض من المستخدم إلى الأدمن.
     */
    public function selectPlan(
        Request $request,
        Plan $plan
    ): RedirectResponse {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()
                ->route('user.login')
                ->with(
                    'error',
                    'يرجى تسجيل الدخول أولاً.'
                );
        }

        $admins = Admin::all();

        foreach ($admins as $admin) {
            $admin->notify(
                new UserSelectedPlanNotification(
                    $user,
                    $plan
                )
            );
        }

        return back()->with(
            'success',
            'تم إرسال طلب اختيار العرض بنجاح، وسيتواصل معك المكتب قريباً.'
        );
    }

    /**
     * صفحة تفاصيل العقار.
     */
    public function property(Property $property): View
    {
        abort_unless(
            (int) $property->status === 1,
            404
        );

        $property->load(
            'photos',
            'videos',
            'agent',
            'location',
            'propertyType',
            'amenities'
        );

        $relatedProperties = Property::where(
            'property_type_id',
            $property->property_type_id
        )
            ->where('status', 1)
            ->where('id', '!=', $property->id)
            ->with(
                'location',
                'propertyType',
                'agent'
            )
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view(
            'front.pages.property',
            compact(
                'property',
                'relatedProperties'
            )
        );
    }

    /**
     * إرسال استفسار عن عقار.
     */
    public function inquirySubmit(
        Request $request,
        Property $property
    ): RedirectResponse {
        if (!Auth::guard('web')->check()) {
            return redirect()
                ->route('user.login')
                ->with(
                    'error',
                    'يرجى تسجيل الدخول للتواصل مع الوكيل.'
                );
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $user = Auth::guard('web')->user();
        $note = trim((string) $request->message);

        $body = "الاسم: {$user->name}\n"
            . "رقم الهاتف: {$user->phone}\n"
            . "العقار: {$property->name}\n"
            . 'رابط العقار: '
            . route(
                'property.detail',
                $property->slug
            );

        if ($note !== '') {
            $body .= "\n\nالرسالة:\n" . $note;
        }

        Message::create([
            'user_id' => $user->id,
            'agent_id' => $property->agent_id,
            'subject' => 'استفسار عن عقار: '
                . $property->name,
            'message' => $body,
        ]);

        return back()->with(
            'success',
            'تم إرسال رسالتك إلى الوكيل بنجاح.'
        );
    }

    /**
     * عرض العقارات مع البحث والتصفية.
     */
    public function properties(Request $request): View|RedirectResponse
    {
        if (
            $request->filled('min_price') &&
            $request->filled('max_price')
        ) {
            $minPrice = (float) $request->input('min_price');
            $maxPrice = (float) $request->input('max_price');

            if ($minPrice > $maxPrice) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'السعر الأدنى يجب ألا يتجاوز السعر الأعلى.'
                    );
            }
        }

        $properties = Property::where('status', 1)
            ->with(
                'propertyType',
                'location',
                'agent'
            )
            ->latest()
            ->search(
                word: $request->input('title'),
                locationId: $request->input('location_id'),
                propertyTypeId: $request->input('type_id'),
                purpose: $request->input('purpose'),
                amenity: $request->input(
                    'amenity',
                    []
                ),
                bedroom: $request->input('bedroom'),
                bathroom: $request->input('bathroom'),
                isFeatured: $request->input('is_featured'),
                minPrice: $request->filled('min_price')
                    ? (float) $request->input('min_price')
                    : null,
                maxPrice: $request->filled('max_price')
                    ? (float) $request->input('max_price')
                    : null
            )
            ->paginate(8)
            ->withQueryString();

        $locations = Location::all();
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();

        return view(
            'front.pages.properties',
            compact(
                'properties',
                'locations',
                'propertyTypes',
                'amenities'
            )
        );
    }

    /**
     * عقارات منطقة محددة.
     */
    public function location(Location $location): View
    {
        $properties = Property::where('status', 1)
            ->where(
                'location_id',
                $location->id
            )
            ->with(
                'propertyType',
                'location',
                'agent'
            )
            ->paginate(12);

        return view(
            'front.pages.location',
            compact(
                'properties',
                'location'
            )
        );
    }

    /**
     * جميع المناطق.
     */
    public function locations(): View
    {
        $locations = Location::withCount([
            'properties' => function ($query) {
                $query->where('status', 1);
            },
        ])
            ->orderByDesc('properties_count')
            ->paginate(16);

        return view(
            'front.pages.locations',
            compact('locations')
        );
    }

    /**
     * جميع الوكلاء.
     */
    public function agents(): View
    {
        $agents = Agent::where('status', 1)
            ->latest()
            ->paginate(15);

        return view(
            'front.pages.agents',
            compact('agents')
        );
    }

    /**
     * عقارات وكيل محدد.
     */
    public function agent(Agent $agent): View
    {
        $properties = Property::where('status', 1)
            ->where(
                'agent_id',
                $agent->id
            )
            ->latest()
            ->with(
                'propertyType',
                'location'
            )
            ->paginate(12);

        return view(
            'front.pages.agent',
            compact(
                'agent',
                'properties'
            )
        );
    }

    /**
     * صفحة المدونة.
     */
    public function blog(): View
    {
        $posts = Blog::latest()
            ->paginate(15);

        return view(
            'front.pages.blog',
            compact('posts')
        );
    }

    /**
     * تفاصيل المقال.
     */
    public function post(Blog $blog): View
    {
        return view(
            'front.pages.post',
            [
                'post' => $blog,
            ]
        );
    }

    /**
     * الأسئلة الشائعة.
     */
    public function faq(): View
    {
        $faqs = Faq::all();

        return view(
            'front.pages.faq',
            compact('faqs')
        );
    }

    /**
     * الاشتراك بالنشرة البريدية.
     */
    public function subscribe(
        Request $request
    ): JsonResponse {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => [
                    'required',
                    'email',
                    'unique:subscribers,email',
                ],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'code' => 0,
                'error_message' => $validator
                    ->errors()
                    ->toArray(),
            ]);
        }

        $token = Str::random(64);

        $subscriber = Subscriber::create([
            'email' => $request->email,
            'token' => $token,
        ]);

        try {
            Mail::send(
                'email.subscriber',
                [
                    'token' => $token,
                ],
                function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject(
                        'تأكيد الاشتراك'
                    );
                }
            );

            return response()->json([
                'code' => 1,
                'success_message' =>
                    'يرجى تفقد بريدك لتأكيد الاشتراك.',
            ]);
        } catch (\Exception $exception) {
            report($exception);

            $subscriber->delete();

            return response()->json([
                'code' => 0,
                'error_message' =>
                    'تعذر إرسال رسالة التحقق.',
            ]);
        }
    }

    /**
     * تفعيل الاشتراك.
     */
    public function subscribeVerify(
        string $token
    ): RedirectResponse {
        $subscriber = Subscriber::where(
            'token',
            $token
        )->first();

        if (!$subscriber) {
            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'رابط التحقق غير صالح.'
                );
        }

        $subscriber->update([
            'token' => '',
            'status' => 1,
        ]);

        return redirect()
            ->route('home')
            ->with(
                'success',
                'تم تأكيد الاشتراك بنجاح.'
            );
    }

    /**
     * صفحة التواصل.
     */
    public function contact(): View
    {
        return view('front.pages.contact');
    }

    /**
     * إرسال نموذج التواصل إلى الأدمن.
     */
    public function contactSubmit(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'min:6',
                'max:30',
            ],
            'message' => [
                'required',
                'string',
                'min:3',
                'max:3000',
            ],
        ], [
            'name.required' => 'يرجى كتابة الاسم.',
            'name.min' => 'الاسم قصير جداً.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'phone.required' => 'يرجى كتابة رقم الهاتف.',
            'phone.min' => 'رقم الهاتف قصير جداً.',
            'message.required' => 'يرجى كتابة الرسالة.',
            'message.min' =>
                'يجب أن تحتوي الرسالة على 3 أحرف على الأقل.',
        ]);

        $admin = Admin::first();

        if (!$admin || !$admin->email) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'لم يتم ضبط بريد الأدمن بعد.'
                );
        }

        try {
            Mail::send(
                'email.contact_us',
                [
                    'request' => $request,
                    'data' => $validated,
                ],
                function ($mail) use (
                    $admin,
                    $validated
                ) {
                    $mail->to($admin->email)
                        ->subject(
                            'رسالة تواصل جديدة من '
                            . $validated['name']
                        );

                    if (!empty($validated['email'])) {
                        $mail->replyTo(
                            $validated['email'],
                            $validated['name']
                        );
                    }
                }
            );

            return back()->with(
                'success',
                'تم إرسال رسالتك إلى الإدارة بنجاح.'
            );
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'تعذر إرسال الرسالة حالياً. '
                    . 'تأكد من إعدادات البريد الإلكتروني.'
                );
        }
    }

    /**
     * صفحة شروط الاستخدام.
     */
    public function terms(): View
    {
        $terms = Term::first();

        return view(
            'front.pages.terms',
            compact('terms')
        );
    }

    /**
     * صفحة سياسة الخصوصية.
     */
    public function privacy(): View
    {
        $policies = PrivacyPolicy::first();

        return view(
            'front.pages.privacy',
            compact('policies')
        );
    }
}
