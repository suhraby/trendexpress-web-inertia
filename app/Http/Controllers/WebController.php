<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactInfoResource;
use App\Http\Resources\SectionResource;
use App\Models\ContactInfo;
use App\Models\Message;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WebController extends Controller
{
    public function index()
    {
        $sections = Section::with('sectionable')->orderBy('sort_order')->get();
        $contacts = ContactInfo::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Index', [
            'canLogin' => Route::has('login'),
            'sections' => SectionResource::collection($sections),
            'contacts' => ContactInfoResource::collection($contacts),
            // 'canRegister' => Route::has('register'),
            // 'laravelVersion' => Application::VERSION,
            // 'phpVersion' => PHP_VERSION,
        ]);
    }

    public function storeMessage(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'body' => 'required',
        ]);

        $data['subject'] = 'Message from website';
        $data['ip'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        Message::create($request->all());

        return back()->with('success', __('Your message has been sent.'));
    }
}
