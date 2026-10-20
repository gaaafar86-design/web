<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Plan;
use App\Models\Term;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Header;
use App\Models\Amenity;
use App\Models\Message;
use App\Models\Location;
use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\View\View;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\WhyChooseUs;
use Illuminate\Support\Str;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    /**
     * Display the front-facing homepage.
     *
     * @return View
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
            }
        ])->orderByDesc('properties_count')->take(8)->get();
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
                'propertyTypes',
            )
        );
    }

    /**
     * Show the user type selection page.
     *
     * @return View
     */
    public function selectUser(): View
    {
        return view('front.pages.select_user');
    }

    /**
     * Show user dashboard entry point.
     *
     * @return View
     */
    public function userDashboard(): View
    {
        $user = Auth::guard('web')->user();
        $messageCount = Message::where('user_id', $user->id)->count();
        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with('property')
            ->latest()
            ->take(3)
            ->get();
        return view('front.user.dashboard.index', compact('user', 'messageCount', 'wishlistItems'));
    }

    /**
     * Show agent dashboard entry point.
     *
     * @return View
     */
    public function agentDashboard(): View
    {
        $agent = Auth::guard('agent')->user();
        $totalActiveProperties = $agent->properties()->where('status', 1)->count();
        $totalPendingProperties = $agent->properties()->where('status', 0)->count();
        $totalFeaturedProperties = $agent->properties()->where('is_featured', 1)->count();
        $recentProperties = Property::where('agent_id', $agent->id)
            ->orderBy('created_at', 'desc')
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
                'recentProperties',
                )
        );
    }

    /**
     * Show pricing page.
     *
     * @return View
     */
    public function pricing(): View
    {
        $plans = Plan::all();
        return view('front.pages.pricing', compact('plans'));
    }

    /**
     * Display a single property detail page along with related properties.
     *
     * This method loads the full details of a given property, including its
     * associated photos, videos, agent, location, property type, and amenities.
     * It also fetches up to 4 related properties of the same type,
     * ensuring they are active and randomized for variety.
     *
     * @param Property $property
     * @return View
     */
    public function property(Property $property): View
    {
        abort_unless((int) $property->status === 1, 404);

        $property->load('photos', 'videos', 'agent', 'location', 'propertyType', 'amenities');
        $relatedProperties = Property::where('property_type_id', $property->property_type_id)
            ->where('status', 1)
            ->where('id', '!=', $property->id)
            ->with('location', 'propertyType', 'agent')
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view('front.pages.property', compact('property', 'relatedProperties'));
    }

    /**
     * Handle user inquiry submission for a specific property.
     *
     * Validates the inquiry form input, then sends an email to the property's agent
     * containing the user's message. If the email is successfully sent, a success
     * message is flashed to the session. Otherwise, an error message is returned.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     */
   public function inquirySubmit(Request $request, Property $property): RedirectResponse
{
    if (!Auth::guard('web')->check()) {
        return redirect()->route('user.login')
            ->with('error', 'يرجى تسجيل الدخول للتواصل مع الوكيل.');
    }

    $request->validate([
        'message' => 'nullable|string|max:1000',
    ]);

    $user = Auth::guard('web')->user();
    $note = trim((string) $request->message);

    $body = "الاسم: {$user->name}\n"
        . "رقم الهاتف: {$user->phone}\n"
        . "العقار: {$property->name}\n"
        . "رابط العقار: " . route('property.detail', $property->slug);

    if ($note !== '') {
        $body .= "\n\nالرسالة:\n" . $note;
    }

    Message::create([
        'user_id' => $user->id,
        'agent_id' => $property->agent_id,
        'subject' => 'استفسار عن عقار: ' . $property->name,
        'message' => $body,
    ]);

    return back()->with('success', 'تم إرسال رسالتك إلى الوكيل بنجاح.');
}

    /**
     * Display a filtered and paginated list of active properties based on user search criteria.
     *
     * Validates that the minimum price does not exceed the maximum price. Then applies dynamic filters
     * using the `scopeSearch()` method on the `Property` model. Filters include title, location, type,
     * purpose, amenities, bedroom/bathroom count, featured status, and price range.
     *
     * Eager loads related models: `propertyType`, `location`, and `agent` for each property.
     * Also retrieves all locations, property types, and amenities for use in the filter UI.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function properties(Request $request): View
{
    if ($request->filled('min_price') && $request->filled('max_price')) {
        $minPrice = (float) $request->input('min_price');
        $maxPrice = (float) $request->input('max_price');

        if ($minPrice > $maxPrice) {
            return back()
                ->withInput()
                ->with('error', 'Minimum price must be less than or equal to maximum price.');
        }
    }

    $properties = Property::where('status', 1)
        ->with('propertyType', 'location', 'agent')
        ->latest()
        ->search(
            word: $request->input('title'),
            locationId: $request->input('location_id'),
            propertyTypeId: $request->input('type_id'),
            purpose: $request->input('purpose'),
            amenity: $request->input('amenity', []),
            bedroom: $request->input('bedroom'),
            bathroom: $request->input('bathroom'),
            isFeatured: $request->input('is_featured'),
            minPrice: $request->filled('min_price')
                ? (float) $request->input('min_price')
                : null,
            maxPrice: $request->filled('max_price')
                ? (float) $request->input('max_price')
                : null,
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
            'amenities',
        )
    );
}


    /**
     * Display a paginated list of active properties for a given location.
     *
     * This method retrieves all properties with `status = 1` that belong to the specified location.
     * It eager loads related models for each property: property type, location, and agent,
     * and paginates the results to show 12 properties per page.
     *
     * @param Location $location
     * @return View
     */
    public function location(Location $location): View
    {
        $properties = Property::where('status', 1)
            ->where('location_id', $location->id)
            ->with('propertyType', 'location', 'agent')
            ->paginate(12);
        return view('front.pages.location', compact('properties', 'location'));
    }

    /**
     * Display a paginated list of locations ranked by active property count.
     *
     * This method retrieves all locations along with a count of their associated properties
     * where `status = 1`. The locations are sorted in descending order based on the number
     * of active properties and paginated to show 16 per page.
     *
     * @return View
     */
    public function locations(): View
    {
        $locations = Location::withCount([
            'properties' => function ($query) {
                $query->where('status', 1);
            }
        ])->orderByDesc('properties_count')->paginate(16);
        return view('front.pages.locations', compact('locations'));
    }

    /**
     * Display a paginated list of agents.
     *
     * This method retrieves all agents where `status = 1`.
     * The agents are sorted in descending order based on the creation date.
     *
     * @return View
     */
    public function agents(): View
    {
        $agents = Agent::where('status', 1)->latest()->paginate(15);
        return view('front.pages.agents', compact('agents'));
    }

    /**
     * Display a paginated list of active properties associated with a specific agent.
     *
     * This method retrieves all properties with `status = 1` that belong to the given agent.
     * It eager loads related models: `propertyType` and `location` for each property,
     * and paginates the results to show 12 properties per page.
     *
     * @param Agent $agent
     * @return View
     */
    public function agent(Agent $agent): View
    {
        $properties = Property::where('status', 1)
            ->where('agent_id', $agent->id)
            ->latest()
            ->with('propertyType', 'location')
            ->paginate(12);
        return view('front.pages.agent', compact('agent', 'properties'));
    }

    /**
     * Display a paginated list of posts.
     *
     * @return View
     */
    public function blog(): View
    {
        $posts = Blog::latest()->paginate(15);
        return view('front.pages.blog', compact('posts'));
    }

    /**
     * Display a single post detail page.
     *
     * @param Blog $blog
     * @return View
     */
    public function post(Blog $blog): View
    {
        return view('front.pages.post', ['post' => $blog]);
    }

    /**
     * Display the FAQ page with all published FAQs.
     *
     * Retrieves all FAQ records from the database and passes them to the
     * front.pages.faq Blade view for rendering.
     *
     * @return View
     */
    public function faq(): View
    {
        $faqs = Faq::all();
        return view('front.pages.faq', compact('faqs'));
    }

    /**
     * Handle AJAX subscription form submission.
     *
     * Validates the submitted email, ensures it's unique, and creates a new subscriber record
     * with a verification token. Sends a confirmation email to the user with a verification link.
     * If email sending fails, the subscriber record is rolled back.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'code'=> 0,
                    'error_message'=> $validator->errors()->toArray(),
                ]
            );
        }

        $token = Str::random(64);
        $subscriber = Subscriber::create([
            'email' => $request->email,
            'token' => $token,
        ]);

        try {
            Mail::send('email.subscriber', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Subscription Verification');
            });
            return response()->json(
                [
                    'code'=> 1,
                    'success_message'=> 'Please check your email to confirm subscription',
                ]
            );
        } catch (\Exception) {
            $subscriber->delete();
            return response()->json(
                [
                    'code'=> 0,
                    'error_message'=> 'Failed to send verification email. Please try again later.',
                ]
            );
        };
    }

    /**
     * Verify a subscriber using the provided token.
     *
     * Looks up the subscriber by token. If found, marks the subscription as verified
     * by clearing the token and setting the status to active. Redirects to the homepage
     * with a success or error message.
     *
     * @param string $token
     * @return RedirectResponse
     */
    public function subscribeVerify(string $token): RedirectResponse
    {
        $subscriber = Subscriber::where('token', $token)->first();
        if (!$subscriber) {
            return redirect()->route('home')->with('error', 'Subscription not Verified.');
        };

        $subscriber->update([
            'token' => '',
            'status' => 1
        ]);
        return redirect()->route('home')->with('success', 'Subscription Verified.');
    }

    /**
     * Display the contact us page.
     *
     * @return View
     */
    public function contact(): View
    {
        return view('front.pages.contact');
    }

    /**
     * Handle contact form submission.
     *
     * Validates the incoming request for name, email, and message fields.
     * Sends the message content to the admin's email using the contact_us Blade template.
     *
     * @param Request $request
     * @return RedirectResponse
     */
   public function contactSubmit(Request $request): RedirectResponse
{
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
        'message.min' => 'يجب أن تحتوي الرسالة على 3 أحرف على الأقل.',
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
            function ($mail) use ($admin, $validated) {
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
            'تم إرسال رسالتك إلى الإدارة بنجاح، وسنتواصل معك قريباً.'
        );
    } catch (\Throwable $e) {
        report($e);

        return back()
            ->withInput()
            ->with(
                'error',
                'تعذر إرسال الرسالة حالياً. تأكد من إعدادات البريد الإلكتروني.'
            );
    }
}

    /**
     * Display the Terms of Use page on the frontend.
     *
     * @return View
     */
    public function terms(): View
    {
        $terms = Term::first();
        return view('front.pages.terms', compact('terms'));
    }

    /**
     * Display the Privacy Policy page on the frontend.
     *
     * @return View
     */
    public function privacy(): View
    {
        $policies = PrivacyPolicy::first();
        return view('front.pages.privacy', compact('policies'));
    }
}
