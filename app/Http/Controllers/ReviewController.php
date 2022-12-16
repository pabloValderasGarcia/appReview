<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Image;
use Response;

class ReviewController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('index');
    }
    
    public function create() {
        return view('review.create');
    }
    
    public function createImagesReview($request, $review) {
        foreach($request->image as $otherImage) {
            if ($otherImage->isValid()) {
                $uniqueName = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
                $name = $uniqueName . '-' . $review->id . '.' . $otherImage->extension();
                
                $namePath = Storage::disk('local')
                    ->putFileAs('reviewImages', $otherImage, $name);
                    
                $imageModel = new Image();
                $imageModel->path = $name;
                $imageModel->idReview = $review->id;
                
                try {
                    $imageModel->save();
                } catch (\Exception $e) {}
            }
        }
    }
    
    public function createThumbnail($request, $review) {
        $image = $request->file('thumbnail');
        $path = $image->getRealPath();
        $image = file_get_contents($path);
        $review->thumbnail = base64_encode($image);
    }
    
    public function destroy(Review $review) {
        if ($review->deleteReview()) {
            return back()->with('message', "Review with id $review->id has been deleted successfully");
        } else {
            return back()->withErrors(
                    ['errorReview' => "Could not delete review with id $review->id"]
                );
        }
    }
    
    public function displayImages($name) {
        if (!Storage::exists('reviewImages/' . $name)) {
            return Response::make('File no found.', 404);
        }

        $file = Storage::get('reviewImages/' . $name);
        $type = Storage::mimeType('reviewImages/' . $name);
        $response = Response::make($file, 200)->header("Content-Type", $type);

        return $response;
    }
    
    public function edit(Review $review) {
        return view('review.edit', ['review' => $review]);
    }
    
    public function index(Request $request) {
        $type = $request->input('type');
        
        if ($type != null) {
            if ($type != 'movie' && $type != 'book' && $type != 'disc') {
                return view('errors.404');
            } else {
                $reviews = Review::where('type', $type)->orderBy('updated_at', 'desc')->get();
            }
        } else {
            $reviews = Review::orderBy('updated_at', 'desc')->get();
            $type = 'Welcome to';
        }
        
        return view('review.index', ['reviews' => $reviews, 'type' => $type]);
    }
    
    public function show(Review $review) {
        $images = DB::table('image')->where('idReview', $review->id)->get();
        return view('review.show', [
                'review' => $review, 
                'images' => $images
            ]);
    }
    
    public function store(Request $request) {
        $reviewData = $request->validate([
                'type' => 'required|in:movie,book,disc',
                'title' => 'required|min:2|max:40',
                'excerpt' => 'required|min:5|max:250',
                'message' => 'required'
            ]);
        
        $review = new Review($reviewData);
        $review->idUser = Auth::user()->id;
        
        if ($request->rate != null) {
            $review->rate = $request->rate;
        }

        if ($request->hasFile('thumbnail')) {
            $this->createThumbnail($request, $review);
            
            if ($review->storeReview()) {
                if ($request->hasFile('image')) {
                    $this->createImagesReview($request, $review);
                }
                
                $message = 'Review has been created.';
                return redirect('review')->with('message', $message);
            } else {
                return back()
                    ->withInput()
                    ->withErrors(['message' => 'An unexpected error occurred while creating review.']);
            }
        } else {
            return back()
                ->withInput()
                ->withErrors(['thumbnail' => 'Thumbnail weight more than expected']);
        }
    }
    
    public function update(Request $request, Review $review) {
        $reviewData = $request->validate([
                'type' => 'required|in:movie,book,disc',
                'title' => 'required|min:2|max:40',
                'excerpt' => 'required|min:5|max:250',
                'message' => 'required'
            ]);
        
        if ($request->rate != null) {
            $review->rate = $request->rate;
        }
        
        if ($request->hasFile('thumbnail')) {
            $this->createThumbnail($request, $review);
        }
        
        if ($review->updateReview($reviewData)) {
            if ($request->hasFile('image')) {
                $this->createImagesReview($request, $review);
            }
            
            $message = "Review with id $review->id has been updated.";
            return redirect('review')->with('message', $message);
        } else {
            return back()
                ->withInput()
                ->withErrors(['message' => 'An unexpected error occurred while updating review.']);
        }
    }
}