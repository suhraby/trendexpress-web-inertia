<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Section;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\SectionResource;
use App\Http\Resources\ContactInfoResource;

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
}
